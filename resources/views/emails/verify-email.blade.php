<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - VetCare</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f7fb;
    font-family: Arial, sans-serif;
">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 20px;">

                <!-- CARD -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="
                background:#ffffff;
                border-radius:18px;
                overflow:hidden;
                box-shadow:0 4px 20px rgba(0,0,0,0.08);
            ">

                    <!-- HEADER -->
                    <tr>
                        <td
                            style="
                        background:linear-gradient(135deg,#2563eb,#1e40af);
                        padding:35px;
                        text-align:center;
                        color:white;
                    ">

                            <h1
                                style="
                            margin:0;
                            font-size:28px;
                            font-weight:bold;
                        ">
                                🐾 VetCare
                            </h1>

                            <p
                                style="
                            margin-top:10px;
                            font-size:15px;
                            opacity:0.9;
                        ">
                                Veterinary Clinic Management System
                            </p>

                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:40px;">

                            <h2
                                style="
                            margin-top:0;
                            color:#1e293b;
                            font-size:24px;
                        ">
                                Hello {{ $user->fullname }} 👋
                            </h2>

                            <p
                                style="
                            color:#475569;
                            line-height:1.7;
                            font-size:15px;
                        ">
                                Thank you for registering with <strong>VetCare</strong>.
                                We're excited to have you join our veterinary management platform.
                            </p>

                            <p
                                style="
                            color:#475569;
                            line-height:1.7;
                            font-size:15px;
                        ">
                                To activate your account and gain access to the system,
                                please verify your email address by clicking the button below.
                            </p>

                            <!-- VERIFICATION BOX -->
                            <div
                                style="
                            background:#f8fafc;
                            border:1px solid #e2e8f0;
                            border-radius:12px;
                            padding:25px;
                            margin:30px 0;
                            text-align:center;
                        ">

                                <p
                                    style="
                                margin:0;
                                color:#64748b;
                                font-size:14px;
                            ">
                                    Click the button below to verify your email address.
                                </p>

                            </div>

                            <!-- BUTTON -->
                            <div style="text-align:center; margin-top:35px;">

                                <a href="{{ $url }}"
                                    style="
                                    background:#2563eb;
                                    color:white;
                                    text-decoration:none;
                                    padding:14px 30px;
                                    border-radius:10px;
                                    display:inline-block;
                                    font-weight:bold;
                                    font-size:15px;
                            ">
                                    Verify Email Address
                                </a>

                            </div>

                            <p
                                style="
                            color:#64748b;
                            font-size:14px;
                            line-height:1.6;
                            margin-top:30px;
                            text-align:center;
                        ">
                                ⚠️ This verification link will expire in <strong>1 hour</strong>.
                            </p>

                            <hr
                                style="
                            margin:30px 0;
                            border:none;
                            border-top:1px solid #e2e8f0;
                        ">

                            <p
                                style="
                            color:#94a3b8;
                            font-size:13px;
                            text-align:center;
                            line-height:1.6;
                        ">
                                If you did not create an account with VetCare,
                                you can safely ignore this email.
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td
                            style="
                        background:#f8fafc;
                        text-align:center;
                        padding:25px;
                        font-size:13px;
                        color:#94a3b8;
                    ">

                            © {{ date('Y') }} VetCare System <br>
                            All Rights Reserved

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>


</body>

</html>
