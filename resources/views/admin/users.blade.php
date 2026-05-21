@extends('layout.app')

@section('content')
    <!-- PAGE CONTAINER -->
    <div class="container-fluid mt-4">

        <!-- CARD -->
        <div class="card border-0 shadow-lg rounded-4">

            <!-- CARD HEADER -->
            <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">

                <div>
                    <h3 class="mb-0 fw-bold text-dark">
                        User Management
                    </h3>

                    <small class="text-muted">
                        Manage all registered users
                    </small>
                </div>

                <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-toggle="modal" data-target="#createModal">

                    <i class="fas fa-plus-circle mr-2"></i>
                    Add User
                </button>

            </div>

            <!-- TABLE -->
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle table-hover" id="userTable">

                        <thead class="bg-light">
                            <tr>
                                <th>No.</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <!-- CREATE MODAL -->
    <div class="modal fade" id="createModal">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- HEADER -->
                <div class="modal-header bg-primary text-white border-0">

                    <h5 class="modal-title fw-bold">
                        Create New User
                    </h5>

                    <button class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <!-- BODY -->
                <div class="modal-body p-4">

                    <form id="createForm">

                        @csrf

                        <!-- FULLNAME -->
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Fullname
                            </label>

                            <input type="text" name="fullname" class="form-control rounded-pill"
                                placeholder="Enter fullname">
                        </div>

                        <!-- EMAIL -->
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Email
                            </label>

                            <input type="email" name="email" class="form-control rounded-pill"
                                placeholder="Enter email">
                        </div>

                        <!-- PASSWORD -->
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Password
                            </label>

                            <input type="password" name="password" class="form-control rounded-pill"
                                placeholder="Enter password">
                        </div>

                        <!-- ROLE -->
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Role
                            </label>

                            <select name="role" class="form-control rounded-pill">
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <!-- BUTTON -->
                        <button class="btn btn-primary btn-block rounded-pill py-2 shadow-sm">

                            <i class="fas fa-save mr-2"></i>
                            Save User

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- STYLES -->
    <style>
        body {
            background: #f4f6f9;
        }

        .card {
            border-radius: 20px;
        }

        .table thead th {
            border: none;
            font-size: 14px;
            font-weight: 600;
            color: #555;
        }

        .table tbody tr {
            transition: 0.2s ease;
        }

        .table tbody tr:hover {
            transform: scale(1.005);
            background: #f8f9fa;
        }

        .table td {
            vertical-align: middle;
            border-top: 1px solid #f1f1f1;
        }

        .btn-info {
            background: #17a2b8;
            border: none;
        }

        .btn-danger {
            border: none;
        }

        .modal-content {
            border-radius: 20px;
        }

        .form-control {
            height: 45px;
            border: 1px solid #e5e5e5;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #007bff;
        }
    </style>


    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            loadUsers();

            // LOAD USERS WITH PAGINATION
            function loadUsers() {

                // destroy existing table first
                if ($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().destroy();
                }

                $.get("/admin/users/fetch", function(users) {

                    let rows = "";

                    users.forEach(user => {

                        let badge =
                            user.role == 'admin' ?
                            `<span class="badge badge-primary px-3 py-2 rounded-pill">Admin</span>` :
                            `<span class="badge badge-secondary px-3 py-2 rounded-pill">User</span>`;

                        rows += `
                    <tr>

                        <td>#${user.id}</td>

                        <td>
                            <div class="font-weight-bold">
                                ${user.fullname}
                            </div>
                        </td>

                        <td>${user.email}</td>

                        <td>${badge}</td>

                        <td>

                            <button class="btn btn-info btn-sm rounded-pill px-3 viewBtn"
                                data-id="${user.id}">
                                View
                            </button>

                            <button class="btn btn-danger btn-sm rounded-pill px-3 deleteBtn"
                                data-id="${user.id}">
                                Delete
                            </button>

                        </td>

                    </tr>
                `;
                    });

                    $("#userTable tbody").html(rows);

                    // INITIALIZE DATATABLE
                    $('#userTable').DataTable({

                        responsive: true,

                        pageLength: 5,

                        lengthMenu: [
                            [5, 10, 25, 50, 100],
                            [5, 10, 25, 50, 100]
                        ],

                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search users...",
                        }

                    });

                });

            }

            // CREATE USER
            $("#createForm").submit(function(e) {

                e.preventDefault();

                $.ajax({

                    url: "/admin/create/user",
                    type: "POST",
                    data: $(this).serialize(),

                    success: function(res) {

                        if (res.status === 0) {

                            let errorMsg = "";

                            $.each(res.errors, function(key, value) {
                                errorMsg += value + "<br>";
                            });

                            Swal.fire({
                                icon: "error",
                                title: "Validation Error",
                                html: errorMsg
                            });

                            return;
                        }

                        $("#createModal").modal("hide");

                        $("#createForm")[0].reset();

                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        loadUsers();

                    },

                    error: function() {

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!"
                        });

                    }

                });

            });

            // DELETE USER
            $(document).on("click", ".deleteBtn", function() {

                let id = $(this).data("id");

                Swal.fire({
                    title: "Delete this user?",
                    text: "This action cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Yes, Delete"
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "/admin/users/delete/" + id,
                            type: "DELETE",

                            data: {
                                _token: "{{ csrf_token() }}"
                            },

                            success: function(res) {

                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted",
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                loadUsers();

                            }

                        });

                    }

                });

            });

            // VIEW USER
            $(document).on("click", ".viewBtn", function() {

                let id = $(this).data("id");

                $.get("/admin/users/show/" + id, function(user) {

                    Swal.fire({

                        title: "User Information",

                        html: `
                    <div class="text-left">

                        <p>
                            <strong>Fullname:</strong><br>
                            ${user.fullname}
                        </p>

                        <p>
                            <strong>Email:</strong><br>
                            ${user.email}
                        </p>

                        <p>
                            <strong>Role:</strong><br>
                            ${user.role}
                        </p>

                    </div>
                `
                    });

                });

            });

        });
    </script>
@endsection
