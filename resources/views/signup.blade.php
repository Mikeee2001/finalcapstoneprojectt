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
                Create an account to manage appointments, pets, and clinic records in one platform.
            </p>

            <div class="features">
                <div><i class="fa-solid fa-user-plus"></i> Create Account</div>
                <div><i class="fa-solid fa-shield"></i> Secure Access</div>
                <div><i class="fa-solid fa-paw"></i> Pet Management</div>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="login-right">

        <div class="signup-card">

            <a href="{{ route('welcome') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>

            <div class="login-header">
                <h2>Create Account</h2>
                <p>Sign up to get started</p>
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

            <form action="{{ route('signup') }}" method="POST" id="signupForm">
                @csrf

                <!-- FULL NAME -->
                <div class="input-group-custom">
                    <label>Full Name</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="fullname" value="{{ old('fullname') }}"
                            placeholder="Enter your full name" required>

                        @error('fullname')
                            <small style="color:red;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <input type="hidden" name="status" value="inactive">

                <!-- EMAIL -->
                <div class="input-group-custom">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                            required>

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
                        <input type="password" name="password" id="password" placeholder="Enter password" required>

                        @error('password')
                            <small style="color:red;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="input-group-custom">
                    <label>Confirm Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Confirm password" required>

                        @error('password_confirmation')
                            <small style="color:red;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- BUTTON -->
                <button type="submit" class="login-btn" id="signupBtn">
                    <span id="btnText">Sign Up</span>
                    <span id="btnLoader" class="loader hidden"></span>
                </button>

            </form>

            <div class="signup-link">
                Already have an account?
                <a href="{{ route('signin') }}">Login</a>
            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('signupForm');
        const btn = document.getElementById('signupBtn');
        const text = document.getElementById('btnText');
        const loader = document.getElementById('btnLoader');

        form.addEventListener('submit', function() {
            btn.disabled = true;
            text.classList.add('hidden');
            loader.classList.remove('hidden');
        });
    });
</script>

<script src="{{ asset('/js/sweetalert2@11.min.js') }}"></script>
