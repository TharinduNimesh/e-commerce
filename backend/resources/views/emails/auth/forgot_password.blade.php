<x-mail::message>
# Reset Your eShop Password

Dear {{ $data["name"] }},

We hope this message finds you well. It seems like you've forgotten your eShop password, but don't worry – we've got you covered! To help you regain access to your account, we've generated a one-time-use verification code (OTP) for you.

Your OTP Code Is: 

<div>
    <p style="text-align: center; font-size: 24px; font-weight: bold; color: #5d5d61; ">
        {{ $data["otp"] }}
    </p>
</div>

Please use this code to reset your password within the next 20 minutes. After this time, the code will expire for security reasons. To initiate the password reset process, simply follow these steps:

- Go to the eShop login page.
- Click on the "Forgot Password" link.
- Enter your email address associated with your eShop account.
- When prompted, input the OTP code provided above.
- Set a new password for your account.

If you did not request a password reset, please disregard this email, and your account will remain secure.

For security purposes, please do not share this OTP code with anyone. Our support team will never ask for your OTP code.

If you encounter any issues or have further questions, feel free to contact our support team at <a href="mail:support@eshop.com">support@eshop.com</a>.

Thank you for choosing eShop, and we appreciate your prompt attention to this matter.

Best regards,

The eShop Team
</x-mail::message>
