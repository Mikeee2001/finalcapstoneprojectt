@extends('layout.app')

@section('content')
    <div class="card shadow-lg border-0 rounded-4">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white rounded-top-4">
            <h5 class="mb-0">My Account</h5>
        </div>

        <div class="card-body">

            <!-- TABS -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <button class="nav-link active" type="button" data-bs-toggle="tab" data-bs-target="#profile">
                        Profile
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#settings">
                        Settings
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#password">
                        Password
                    </button>
                </li>
            </ul>

            <!-- TAB CONTENT -->
            <div class="tab-content">

                <!-- PROFILE -->
                <div class="tab-pane fade show active" id="profile">
                    <form id="profileForm">
                        @csrf
                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control"
                                value="{{ auth()->user()->fullname }}">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>

                <!-- SETTINGS -->
                <div class="tab-pane fade" id="settings">
                    <form id="settingsForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" class="form-control">
                                <option value="" disabled>Select role</option>
                                <option value="admin" {{ auth()->user()->role == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="user" {{ auth()->user()->role == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-secondary">Save Settings</button>
                    </form>
                </div>

                <!-- PASSWORD -->
                <div class="tab-pane fade" id="password">
                    <form id="passwordForm">
                        @csrf
                        <div class="mb-3">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-danger">Change Password</button>
                        <ul id="errorList" class="text-danger mt-2 d-none"></ul>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrfToken = document.querySelector('input[name="_token"]').value;

            // Helper: submit form via fetch
            async function submitForm(formId, type) {
                const form = document.getElementById(formId);
                const formData = new FormData(form);
                formData.append('type', type);

                try {
                    const response = await fetch("{{ route('admin.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.status === 1) {
                        Swal.fire('Success', data.message, 'success');
                    } else {
                        Swal.fire('Info', data.message, 'info');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            }

            // PROFILE
            document.getElementById('profileForm').addEventListener('submit', e => {
                e.preventDefault();
                submitForm('profileForm', 'profile');
            });

            // SETTINGS
            document.getElementById('settingsForm').addEventListener('submit', e => {
                e.preventDefault();
                submitForm('settingsForm', 'settings');
            });
        });
    </script>

    <script>
        document.getElementById('passwordForm').addEventListener('submit', async e => {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            try {
                const response = await fetch("{{ route('admin.update.password') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                if (response.status === 422) {
                    const errors = await response.json();
                    const errorList = document.getElementById('errorList');
                    errorList.classList.remove('d-none');
                    errorList.innerHTML = '';
                    Object.values(errors.errors).forEach(err => {
                        errorList.innerHTML += `<li>${err[0]}</li>`;
                    });
                    Swal.fire('Error', 'Fix the errors', 'error');
                    return;
                }

                const data = await response.json();
                form.reset();
                document.getElementById('errorList').classList.add('d-none');
                Swal.fire('Success', data.message, 'success');
            } catch (error) {
                Swal.fire('Error', 'Something went wrong', 'error');
            }
        });
    </script>
@endsection
