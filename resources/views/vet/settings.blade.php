@extends('layout.app')

@section('content')
    <div class="container-fluid">

        <div class="card shadow border-0 rounded-4">

            <!-- HEADER -->
            <div class="card-header bg-success text-white py-3 rounded-top-4">

                <h4 class="mb-0 fw-bold">
                    <i class="fa-solid fa-user-doctor me-2"></i>
                    Vet Settings
                </h4>

            </div>

            <div class="card-body p-4">

                <!-- TABS -->
                <ul class="nav nav-pills mb-4">

                    <li class="nav-item me-2">

                        <button class="nav-link active rounded-pill px-4" data-bs-toggle="tab" data-bs-target="#profileTab">

                            <i class="fa-solid fa-user me-2"></i>
                            Profile

                        </button>

                    </li>

                    <li class="nav-item">

                        <button class="nav-link rounded-pill px-4" data-bs-toggle="tab" data-bs-target="#passwordTab">

                            <i class="fa-solid fa-lock me-2"></i>
                            Password

                        </button>

                    </li>

                </ul>

                <!-- TAB CONTENT -->
                <div class="tab-content">

                    <!-- ========================= -->
                    <!-- PROFILE TAB -->
                    <!-- ========================= -->

                    <div class="tab-pane fade show active" id="profileTab">

                        <form id="vetProfileForm">

                            @csrf

                            <div class="row">

                                <!-- FULLNAME -->
                                <div class="col-md-6 mb-3">

                                    <label class="fw-bold mb-2">
                                        Full Name
                                    </label>

                                    <input type="text" name="fullname" class="form-control rounded-pill"
                                        value="{{ auth()->user()->fullname }}">

                                </div>

                                <!-- EMAIL -->
                                <div class="col-md-6 mb-3">

                                    <label class="fw-bold mb-2">
                                        Email Address
                                    </label>

                                    <input type="email" name="email" class="form-control rounded-pill"
                                        value="{{ auth()->user()->email }}">

                                </div>

                            </div>

                            <button type="submit" class="btn btn-success rounded-pill px-5 py-2 mt-3">

                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                Update Profile

                            </button>

                        </form>

                    </div>

                    <!-- ========================= -->
                    <!-- PASSWORD TAB -->
                    <!-- ========================= -->

                    <div class="tab-pane fade" id="passwordTab">

                        <form id="passwordForm">

                            @csrf

                            <div class="row">

                                <!-- CURRENT PASSWORD -->
                                <div class="col-md-6 mb-3">

                                    <label class="fw-bold mb-2">
                                        Current Password
                                    </label>

                                    <input type="password" name="current_password" class="form-control rounded-pill"
                                        placeholder="Enter current password">

                                </div>

                                <!-- NEW PASSWORD -->
                                <div class="col-md-6 mb-3">

                                    <label class="fw-bold mb-2">
                                        New Password
                                    </label>

                                    <input type="password" name="new_password" class="form-control rounded-pill"
                                        placeholder="Enter new password">

                                </div>

                                <!-- CONFIRM PASSWORD -->
                                <div class="col-md-6 mb-3">

                                    <label class="fw-bold mb-2">
                                        Confirm Password
                                    </label>

                                    <input type="password" name="new_password_confirmation"
                                        class="form-control rounded-pill" placeholder="Confirm password">

                                </div>

                            </div>

                            <!-- ERROR LIST -->
                            <ul id="errorList" class="text-danger mt-2 d-none">
                            </ul>

                            <button type="submit" class="btn btn-danger rounded-pill px-5 py-2 mt-3">

                                <i class="fa-solid fa-key me-2"></i>
                                Change Password

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ========================= -->
    <!-- SCRIPT -->
    <!-- ========================= -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const csrfToken =
                document.querySelector('meta[name="csrf-token"]')
                .getAttribute('content');

            // =========================
            // UPDATE PROFILE
            // =========================

            document.getElementById('vetProfileForm')
                .addEventListener('submit', async function(e) {

                    e.preventDefault();

                    let formData = new FormData(this);

                    formData.append('type', 'profile');

                    try {

                        const response = await fetch(
                            "{{ route('vet.settings.update') }}", {

                                method: "POST",

                                headers: {
                                    "X-CSRF-TOKEN": csrfToken,
                                    "Accept": "application/json"
                                },

                                body: formData

                            });

                        const data = await response.json();

                        if (data.status == 1) {

                            Swal.fire(
                                'Success',
                                data.message,
                                'success'
                            );

                        } else {

                            Swal.fire(
                                'Info',
                                data.message,
                                'info'
                            );

                        }

                    } catch (error) {

                        console.log(error);

                        Swal.fire(
                            'Error',
                            'Something went wrong',
                            'error'
                        );

                    }

                });

            // =========================
            // CHANGE PASSWORD
            // =========================

            document.getElementById('passwordForm')
                .addEventListener('submit', async function(e) {

                    e.preventDefault();

                    let formData = new FormData(this);

                    try {

                        const response = await fetch(
                            "{{ route('vet.settings.change.password') }}", {

                                method: "POST",

                                headers: {
                                    "X-CSRF-TOKEN": csrfToken,
                                    "Accept": "application/json"
                                },

                                body: formData

                            });

                        const data = await response.json();

                        // VALIDATION ERROR
                        if (response.status === 422) {

                            let errorList =
                                document.getElementById('errorList');

                            errorList.classList.remove('d-none');

                            errorList.innerHTML = '';

                            if (data.errors) {

                                Object.values(data.errors)
                                    .forEach(err => {

                                        errorList.innerHTML += `
                            <li>${err[0]}</li>
                        `;

                                    });

                            } else {

                                errorList.innerHTML += `
                        <li>${data.message}</li>
                    `;

                            }

                            return;

                        }

                        // SUCCESS
                        this.reset();

                        document.getElementById('errorList')
                            .classList.add('d-none');

                        Swal.fire(
                            'Success',
                            data.message,
                            'success'
                        );

                    } catch (error) {

                        console.log(error);

                        Swal.fire(
                            'Error',
                            'Something went wrong',
                            'error'
                        );

                    }

                });

        });
    </script>
@endsection
