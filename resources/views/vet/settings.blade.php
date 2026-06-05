@extends('layout.app')

@section('content')
    <div class="row">

        @php
            $vet = auth()->user()->vet;
        @endphp

        <!-- LEFT PROFILE CARD -->
        <div class="col-lg-3 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body text-center">

                    @if ($vet && $vet->image)
                        <div class="d-flex justify-content-center mb-3">
                            <img src="{{ asset('storage/' . $vet->image) }}" class="rounded-circle border shadow-sm"
                                width="140" height="140" style="object-fit: cover;">
                        </div>
                    @else
                        <div class="d-flex justify-content-center mb-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                style="width:140px;height:140px;">
                                <i class="fa-solid fa-user-doctor fa-4x text-secondary"></i>
                            </div>
                        </div>
                    @endif

                    <h5 class="fw-bold mb-1">
                        {{ auth()->user()->fullname }}
                    </h5>

                    <p class="text-muted small mb-3">
                        {{ auth()->user()->email }}
                    </p>

                    @if ($vet)
                        <span class="badge bg-primary px-3 py-2">
                            {{ ucfirst($vet->status) }}
                        </span>
                    @endif

                </div>

            </div>

        </div>

        <!-- RIGHT SETTINGS -->
        <div class="col-lg-9">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <!-- TABS -->
                    <ul class="nav nav-tabs mb-4">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profileTab"
                                type="button">
                                <i class="fa-solid fa-user me-2"></i>
                                Profile
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#detailsTab" type="button">
                                <i class="fa-solid fa-circle-info me-2"></i>
                                Details
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#passwordTab" type="button">
                                <i class="fa-solid fa-lock me-2"></i>
                                Password
                            </button>
                        </li>

                    </ul>

                    <!-- TAB CONTENT -->
                    <div class="tab-content">

                        <!-- PROFILE TAB -->
                        <div class="tab-pane fade show active" id="profileTab">

                            <div class="card bg-light border-0">
                                <div class="card-body">

                                    <h5 class="fw-bold mb-4">
                                        Profile Information
                                    </h5>

                                    <form id="vetProfileForm">
                                        @csrf

                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">
                                                    Full Name
                                                </label>

                                                <input type="text" name="fullname" class="form-control"
                                                    value="{{ auth()->user()->fullname }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">
                                                    Email Address
                                                </label>

                                                <input type="email" name="email" class="form-control"
                                                    value="{{ auth()->user()->email }}">
                                            </div>

                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-floppy-disk me-2"></i>
                                            Update Profile
                                        </button>

                                    </form>

                                </div>
                            </div>

                        </div>

                        <!-- DETAILS TAB -->
                        <div class="tab-pane fade" id="detailsTab">

                            <h5 class="fw-bold mb-4">
                                Professional Details
                            </h5>

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <small class="text-muted">
                                                License Number
                                            </small>

                                            <h6 class="fw-bold mt-2 mb-0">
                                                {{ $vet->license_number ?? 'Not Set' }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <small class="text-muted">
                                                Hire Date
                                            </small>

                                            <h6 class="fw-bold mt-2 mb-0">
                                                {{ $vet && $vet->hire_date ? \Carbon\Carbon::parse($vet->hire_date)->format('F d, Y') : 'Not Set' }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- PASSWORD TAB -->
                        <div class="tab-pane fade" id="passwordTab">

                            <div class="card bg-light border-0">
                                <div class="card-body">

                                    <h5 class="fw-bold mb-4">
                                        Change Password
                                    </h5>

                                    <form id="passwordForm">
                                        @csrf

                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">
                                                    Current Password
                                                </label>

                                                <input type="password" name="current_password" class="form-control"
                                                    placeholder="Enter current password">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">
                                                    New Password
                                                </label>

                                                <input type="password" name="new_password" class="form-control"
                                                    placeholder="Enter new password">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">
                                                    Confirm Password
                                                </label>

                                                <input type="password" name="new_password_confirmation" class="form-control"
                                                    placeholder="Confirm password">
                                            </div>

                                        </div>

                                        <ul id="errorList" class="text-danger mt-2 d-none">
                                        </ul>

                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa-solid fa-key me-2"></i>
                                            Change Password
                                        </button>

                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- END TAB CONTENT -->

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
