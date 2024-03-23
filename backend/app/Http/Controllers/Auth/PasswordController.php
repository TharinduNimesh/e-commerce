<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        $request->validated();

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
        $request->validated();

        $user = User::where('email', $request->email)->first();

        // trying to generate OTP
        $output = $this->generateOtp($user);
        if ($output['status'] == 'error') {
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
        $request->validated();

        $user = User::where('email', $request->email)->first();

        $otp_details = $user->otps()
            ->where('is_used', true)
            ->orderBy('id', 'desc')
            ->first();

        if (!$otp_details) {
            return response()->json([
                'message' => 'Failed to update password. Malicious activity detected.',
            ], 401);
        }

        if ($otp_details->expires_at < now()) {
            return response()->json([
                'message' => 'OTP has expired. Please request for a new one.',
            ], 400);
        }

        if ($otp_details->otp != $request->otp) {
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
        $request->validated();

        // Get user
        $user = User::where('email', $request->email)->first();

        // OTP requests
        $otp_details = $user->otps()->orderBy('id', 'desc')->first();

        // Check if OTP is expired
        if ($otp_details->expires_at < now()) {
            return response()->json([
                'message' => 'OTP has expired. Please request for a new one.',
            ], 400);
        }

        // Check if OTP has already been used
        if ($otp_details->is_used) {
            return response()->json([
                "message" => "This OTP has already been used.",
            ], 401);
        }

        // Check if OTP is valid
        if ($request->otp != $otp_details->otp) {
            return response()->json([
                "message" => "Invalid OTP",
            ], 401);
        }

        // Update OTP status
        $otp_details->update([
            "is_used" => true,
        ]);

        // Verify email if not verified
        if (!$user->email_verified_at) {
            $user->update([
                'email_verified_at' => now(),
            ]);
        }

        return response()->json([
            "message" => "OTP verified successfully.",
        ]);
    }

    private function generateOtp($user)
    {
        $max_request_per_day = 5;

        $today_requests = $user->otps()->where('created_at', '>', now()->subDay())->count();

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
        $user->otps()->create([
            'otp' => $otp,
            'expires_at' => now()->addMinutes(20),
        ]);

        return [
            'status' => 'success',
            'message' => 'OTP sent to your email. Please check your inbox.',
            'otp' => $otp,
            'pending_requests' => $max_request_per_day - $today_requests - 1,
        ];
    }
}
