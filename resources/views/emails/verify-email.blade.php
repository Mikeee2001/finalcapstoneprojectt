<!-- HEADER -->
<div style="background:linear-gradient(135deg,#2563eb,#1e40af);padding:25px;text-align:center;color:#fff;">
    <h1 style="margin:0;font-size:22px;">🐾 VetCare</h1>
    <p style="margin:5px 0 0;font-size:14px;opacity:0.9;">Veterinary Clinic Management System</p>
</div> <!-- BODY -->
<div style="padding:30px;text-align:center;">
    <h2 style="color:#111827;margin-bottom:10px;"> Hello {{ $user->fullname }} 👋 </h2>
    <p style="color:#6b7280;font-size:14px;line-height:1.6;"> Thank you for registering at <strong>VetCare</strong>.<br>
        We’re excited to have you onboard! </p>
    <p style="color:#6b7280;font-size:14px;line-height:1.6;margin-top:10px;"> Please verify your email address to
        activate your account and start using our system. </p> <!-- BUTTON -->
    <div style="margin:30px 0;"> <a href="{{ $url }}"
            style="background:#2563eb;color:#ffffff;padding:14px 28px; text-decoration:none;border-radius:8px; display:inline-block;font-weight:bold;">
            Verify Email Address </a> </div>
    <p style="font-size:12px;color:#9ca3af;"> ⚠️ This verification link will expire in 1 hour. </p>
    <hr style="margin:25px 0;border:none;border-top:1px solid #eee;">
    <p style="font-size:12px;color:#9ca3af;"> If you did not create this account, you can safely ignore this email. </p>
</div> <!-- FOOTER -->
<div style="background:#f9fafb;padding:15px;text-align:center;font-size:12px;color:#9ca3af;"> © {{ date('Y') }}
    VetCare. All rights reserved. </div>
</div>
</body>

</html>
