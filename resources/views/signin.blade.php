<header>
    <link rel="stylesheet" href="{{ asset('css/sign-in.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</header>

<section class="login-section">

    <!-- LEFT SIDE -->
    <div class="login-left">
        <div class="overlay"></div>

        <div class="left-content">
            <div class="brand">
                <i class="fa-solid fa-paw"></i>
                <h1>VetCare</h1>
            </div>

            <h2>Veterinary Clinic Management System</h2>

            <p>
                Manage appointments, medical records, laboratory results,
                and pet care services in one smart platform.
            </p>

            <div class="features">
                <div><i class="fa-solid fa-calendar-check"></i> Appointment Scheduling</div>
                <div><i class="fa-solid fa-notes-medical"></i> Medical Records</div>
                <div><i class="fa-solid fa-flask"></i> Laboratory Management</div>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="login-right">

        <div class="login-card">

            <a href="{{ route('welcome') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>

            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Login to continue to your account</p>
            </div>

            <!-- GLOBAL ERRORS -->
            @if ($errors->any())
                <div style="background:#fee2e2;padding:12px;border-radius:8px;margin-bottom:15px;">
                    <ul style="margin:0;padding-left:18px;color:#b91c1c;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('signin') }}" method="POST" id="loginForm">
                @csrf

                <!-- EMAIL -->
                <div class="input-group-custom">
                    <label>Email Address</label>

                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>

                        <input type="email" name="email" placeholder="Enter your email" required>

                        @error('email')
                            <small style="color:red;">{{ $message }}</small>
                        @enderror

                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="input-group-custom">
                    <label>Password</label>

                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>

                        <input type="password" name="password" id="password" placeholder="Enter your password"
                            required>
                        @error('password')
                            <small style="color:red;">{{ $message }}</small>
                        @enderror


                    </div>
                </div>

                <!-- LOGIN BUTTON -->
                <button type="submit" class="login-btn" id="loginBtn">
                    <span id="btnText">Login</span>
                    <span id="btnLoader" class="loader hidden"></span>
                </button>

            </form>

            <div class="signup-link">
                Don't have an account?
                <a href="{{ route('signup') }}">Sign Up</a>
            </div>

        </div>

    </div>

    <!-- SWEET ALERT -->
    <script src="{{ asset('/js/sweetalert2@11.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Try Again'
                });
            @endif

            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');

            loginForm.addEventListener('submit', function() {
                loginBtn.disabled = true;
                btnText.classList.add('hidden');
                btnLoader.classList.remove('hidden');
            });
        });

        // TOGGLE PASSWORD
        function togglePassword() {

            const password = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (password.type === "password") {
                password.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>

    <script src="{{ asset('/js/sweetalert2@11.min.js') }}"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2563eb'
            });
        @endif
    </script>


</section>
