<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();

        // check if current password is valid
        $is_password_valid = Hash::check($request->current_password, $user->password);
        if (!$is_password_valid) {
            return response()->json([
                'message' => 'Invalid current password.',
            ], 401);
        }

        // update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Password changed successfully.',
            'user' => $user,
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        // trying to generate OTP
        $output = $this->generateOtp($user);
        if (isset($output['status']) && $output['status'] == 'error') {
            return response()->json([
                'message' => $output['message'],
            ], 429);
        }

        // send OTP to user's email
        MailController::forgotPassword([
            'email' => $request->email,
            'name' => "$user->first_name $user->last_name",
            'otp' => $output['otp'],
        ]);

        return response()->json([
            'message' => $output['message'],
            'pending_requests' => $output['pending_requests'],
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
         // Get user
         $user = User::where('email', $request->email)->first();

        if (!is_array($user->otps)) {
            return response()->json([
                'message' => 'Failed to update password. Malicious activity detected.',
            ], 401);
        }

         // Get last OTP
         $otp_details = array_reverse($user->otps)[0];

        if (!$otp_details) {
            return response()->json([
                'message' => 'Failed to update password. Malicious activity detected.',
            ], 401);
        }

        if (Carbon::parse($otp_details["expires_at"]) < now()) {
            return response()->json([
                'message' => 'OTP has expired. Please request for a new one.',
            ], 400);
        }

        if ($otp_details["otp"] != $request->otp) {
            return response()->json([
                'message' => 'Failed to update password. Malicious activity detected.',
            ], 401);
        }

        $user->update([
            'password' => $request->password
        ]);

        return response()->json([
            'message' => 'Password updated successfully.'
        ]);
    }

    public function verify(VerifyRequest $request)
    {
        // Get user
        $user = User::where('email', $request->email)->first();

        // Get last OTP
        $otp_details = array_reverse($user->otps)[0];

        // Check if OTP is expired
        if (Carbon::parse($otp_details["expires_at"])->isBefore(now())) {
            return response()->json([
                'message' => 'OTP has expired. Please request for a new one.',
            ], 400);
        }

        // Check if OTP has already been used
        if (isset($otp_details["is_used"]) && $otp_details["is_used"]) {
            return response()->json([
                "message" => "This OTP has already been used.",
            ], 401);
        }

        // Check if OTP is valid
        if ($request->otp != $otp_details["otp"]) {
            return response()->json([
                "message" => "Invalid OTP",
            ], 401);
        }

        // Update OTP status
        $user->raw()->updateOne(
            ['email' => $user->email],
            ['$set' => ['otps.$[elem].is_used' => true]],
            ['arrayFilters' => [['elem.id' => $otp_details["id"]]]]
        );

        // Verify email if not verified
        if (!$user->email_verified_at) {
            $user->update([
                'email_verified_at' => now(),
            ]);
        }

        return response()->json([
            "message" => "OTP verified successfully.",
            "otp" => $otp_details
        ]);
    }

    private function generateOtp($user)
    {
        $max_request_per_day = 5;

        $otps = $user->otps;
        $today_requests = 0;

        // Get today's requests
        if (is_array($otps)) {
            $today_requests = count(array_filter($otps, function ($otp) {
                return Carbon::parse($otp['created_at'])->isToday();
            }));
        } else {
            $otps = [];
        }

        // Send error message
        if ($today_requests >= $max_request_per_day) {
            return [
                'status' => 'error',
                'message' => 'You have exceeded the maximum number of OTP requests. Please try again after 24 hours.',
            ];
        }

        // Generate a random 6-digit number
        $otp = rand(100000, 999999);

        // Save the OTP to the database
        $user->push('otps', [
            'id' => count($otps) + 1,
            'otp' => $otp,
            'is_used' => false,
            'created_at' => now()->toString(),
            'expires_at' => now()->addMinutes(15)->toString(),
        ]);

        return [
            'status' => 'success',
            'message' => 'OTP sent to your email. Please check your inbox.',
            'otp' => $otp,
            'pending_requests' => $max_request_per_day - $today_requests - 1,
        ];
    }
}
