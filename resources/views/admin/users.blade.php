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

                <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#createModal">

                    <i class="fas fa-plus-circle me-2"></i>
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

    <!-- VETS TABLE -->
    <div class="card border-0 shadow-lg rounded-4 mt-4">

        <!-- HEADER -->
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">

            <div>
                <h3 class="mb-0 fw-bold text-dark">
                    Veterinarian Management
                </h3>

                <small class="text-muted">
                    Manage all veterinarians
                </small>
            </div>

            <button class="btn btn-success rounded-pill px-4 shadow-sm" data-bs-toggle="modal"
                data-bs-target="#createVetModal">

                <i class="fas fa-user-doctor mr-2"></i>
                Add Veterinarian

            </button>

        </div>

        <!-- BODY -->
        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle table-hover text-center" id="vetTable">

                    <thead class="bg-light">

                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Fullname</th>
                            <th>Specialization</th>
                            <th>License</th>
                            <th>Hired Date</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>

                    </thead>

                    <tbody></tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- CREATE VET MODAL -->
    <div class="modal fade" id="createVetModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- HEADER -->
                <div class="modal-header bg-success text-white border-0 py-3">

                    <h5 class="modal-title fw-bold">
                        <i class="fa-solid fa-user-doctor me-2"></i>
                        Create Veterinarian
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- BODY -->
                <div class="modal-body bg-light p-3">

                    <form id="createVetForm" enctype="multipart/form-data">

                        @csrf

                        <div class="row g-3">

                            <!-- LEFT SIDE -->
                            <div class="col-lg-4 text-center">

                                <div class="bg-white rounded-4 shadow-sm p-3 h-100">

                                    <label class="fw-bold mb-3 d-block">
                                        Veterinarian Photo
                                    </label>

                                    <!-- IMAGE PREVIEW -->
                                    <img id="previewImage" src="https://via.placeholder.com/200x200?text=Vet"
                                        class="rounded-4 border shadow-sm mb-3"
                                        style="
                                        width: 200px;
                                        height: 200px;
                                        object-fit: cover;
                                    ">

                                    <!-- FILE INPUT -->
                                    <input type="file" name="image" id="image" class="form-control rounded-pill">

                                    <small class="text-muted d-block mt-2">
                                        JPG, PNG, GIF (Max 2MB)
                                    </small>

                                    <!-- SPECIALIZATIONS -->
                                    <div class="mt-4 text-start">

                                        <label class="fw-bold mb-2">
                                            Select Specializations
                                        </label>

                                        <<select name="specializations[]" id="specializations" class="form-select rounded-4"
                                            multiple size="5">

                                            @foreach ($specializations as $specialization)
                                                <option value="{{ $specialization->id }}">

                                                    {{ $specialization->specialization_name }}

                                                </option>
                                            @endforeach

                                            </select>

                                            <small class="text-muted">
                                                Hold CTRL to select multiple.
                                            </small>

                                    </div>

                                </div>

                            </div>

                            <!-- RIGHT SIDE -->
                            <div class="col-lg-8">

                                <div class="bg-white rounded-4 shadow-sm p-4 h-100">

                                    <div class="row g-3">

                                        <!-- FULLNAME -->
                                        <div class="col-md-6">

                                            <label class="fw-bold mb-2">
                                                Fullname
                                            </label>

                                            <div class="input-group">

                                                <span
                                                    class="input-group-text bg-success text-white border-0 rounded-start-pill">
                                                    <i class="fa-solid fa-user"></i>
                                                </span>

                                                <input type="text" name="fullname"
                                                    class="form-control rounded-end-pill py-2" placeholder="Enter fullname">

                                            </div>

                                        </div>

                                        <!-- EMAIL -->
                                        <div class="col-md-6">

                                            <label class="fw-bold mb-2">
                                                Email Address
                                            </label>

                                            <div class="input-group">

                                                <span
                                                    class="input-group-text bg-success text-white border-0 rounded-start-pill">
                                                    <i class="fa-solid fa-envelope"></i>
                                                </span>

                                                <input type="email" name="email"
                                                    class="form-control rounded-end-pill py-2" placeholder="Enter email">

                                            </div>

                                        </div>

                                        <!-- LICENSE -->
                                        <div class="col-md-6">

                                            <label class="fw-bold mb-2">
                                                License Number
                                            </label>

                                            <div class="input-group">

                                                <span
                                                    class="input-group-text bg-success text-white border-0 rounded-start-pill">
                                                    <i class="fa-solid fa-id-card"></i>
                                                </span>

                                                <input type="text" name="license_number"
                                                    class="form-control rounded-end-pill py-2"
                                                    placeholder="Enter license number">

                                            </div>

                                        </div>

                                        <!-- HIRE DATE -->
                                        <div class="col-md-6">

                                            <label class="fw-bold mb-2">
                                                Hire Date
                                            </label>

                                            <div class="input-group">

                                                <span
                                                    class="input-group-text bg-success text-white border-0 rounded-start-pill">
                                                    <i class="fa-solid fa-calendar"></i>
                                                </span>

                                                <input type="date" name="hire_date"
                                                    class="form-control rounded-end-pill py-2">

                                            </div>

                                        </div>

                                        <!-- NEW SPECIALIZATION -->
                                        <div class="col-12 mt-3">

                                            <label class="fw-bold mb-2">
                                                Add New Specialization
                                            </label>

                                            <input type="text" name="new_specializations"
                                                class="form-control rounded-pill py-2"
                                                placeholder="Example: Surgery, Cardiology, Dentistry">

                                            <small class="text-muted">
                                                Separate multiple specializations with commas.
                                            </small>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- BUTTON -->
                        <div class="mt-4">

                            <button type="submit" class="btn btn-success w-100 rounded-pill py-3 fw-bold shadow-sm">

                                <i class="fas fa-save me-2"></i>
                                Save Veterinarian

                            </button>

                        </div>

                    </form>

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
                        <button class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">

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

        .form-select[multiple] {
            height: auto !important;
            min-height: 140px;
            border-radius: 15px;
            padding: 10px;
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
                            <strong>Role:</strong><br>
                            ${user.role}
                        </p>

                    </div>
                `
                    });

                });

            });

        });

        $(document).ready(function() {

            // ==========================
            // LOAD VETS
            // ==========================

            loadVets();

            function loadVets() {

                // DESTROY EXISTING DATATABLE
                if ($.fn.DataTable.isDataTable('#vetTable')) {
                    $('#vetTable').DataTable().destroy();
                }

                $.ajax({

                    url: "/admin/vets/fetch",
                    type: "GET",

                    success: function(vets) {

                        let rows = "";

                        vets.forEach(function(vet) {

                            rows += `
                                    <tr>

                                        <td>#${vet.id}</td>
                                         <td><img src="${vet.image}" alt="Vet Image" class="img-thumbnail" style="max-width: 100px;"></td>

                                        <td>
                                            <div class="font-weight-bold">
                                                ${vet.fullname}
                                            </div>
                                        </td>

                                        <td>${vet.specializations}</td>

                                        <td>${vet.license}</td>

                                        <td>${vet.hired}</td>

                                        <td>
                                            <span class="badge badge-success px-3 py-2 rounded-pill">
                                                ${vet.role}
                                            </span>
                                        </td>

                                       <td>
                                        <div class="form-check form-switch">

                                            <input
                                                class="form-check-input vetStatusToggle"
                                                type="checkbox"
                                                data-id="${vet.id}"
                                                ${vet.status === 'available' ? 'checked' : ''}>

                                            <label class="statusLabel fw-bold ms-2">

                                                ${vet.status === 'available'
                                                    ? '<span class="text-success">Available</span>'
                                                    : '<span class="text-danger">Not Available</span>'
                                                }

                                            </label>

                                         </div>
                                    </td>

                                        <td>

                                            <button class="btn btn-info btn-sm rounded-pill px-3 vetViewBtn"
                                                    data-id="${vet.id}">
                                                View
                                            </button>

                                            <button class="btn btn-danger btn-sm rounded-pill px-3 vetDeleteBtn"
                                                    data-id="${vet.id}">
                                                Delete
                                            </button>

                                        </td>

                                    </tr>
                                    `;
                        });

                        $("#vetTable tbody").html(rows);

                        // REINITIALIZE DATATABLE
                        $('#vetTable').DataTable({
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

                    },

                    error: function() {

                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Failed to load veterinarians."
                        });

                    }

                });

                $(document).on("change", ".vetStatusToggle", function() {

                    let vetId = $(this).data("id");

                    let status = $(this).is(":checked") ?
                        "available" :
                        "not_available";

                    let label = $(this).siblings(".statusLabel");

                    // CHANGE LABEL COLOR
                    if (status === "available") {

                        label.html(
                            '<span class="text-success">Available</span>'
                        );

                    } else {

                        label.html(
                            '<span class="text-danger">Not Available</span>'
                        );

                    }

                    $.ajax({

                        url: "/admin/vets/update-status",

                        type: "POST",

                        data: {

                            _token: "{{ csrf_token() }}",

                            vet_id: vetId,

                            status: status

                        }

                    });

                });


            }

            // ==========================
            // IMAGE PREVIEW
            // ==========================
            $("#image").change(function() {

                let reader = new FileReader();

                reader.onload = function(e) {

                    $("#previewImage").attr("src", e.target.result);

                };

                reader.readAsDataURL(this.files[0]);

            });


            // ==========================
            // CREATE VET
            // ==========================
            $("#createVetForm").submit(function(e) {

                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({

                    url: "/admin/create/vet",
                    type: "POST",

                    data: formData,

                    processData: false,
                    contentType: false,

                    beforeSend: function() {

                        $("#createVetForm button[type='submit']")
                            .prop("disabled", true)
                            .html("Saving...");

                    },

                    success: function(res) {

                        // CLOSE MODAL
                        $("#createVetModal").modal("hide");

                        // RESET FORM
                        $("#createVetForm")[0].reset();

                        // RESET IMAGE
                        $("#previewImage").attr(
                            "src",
                            "https://via.placeholder.com/200x200?text=Vet"
                        );

                        // ENABLE BUTTON
                        $("#createVetForm button[type='submit']")
                            .prop("disabled", false)
                            .html(`
                    <i class="fas fa-save me-2"></i>
                    Save Veterinarian
                `);

                        // SUCCESS MESSAGE
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // RELOAD TABLE
                        loadVets();

                    },

                    error: function(xhr) {

                        $("#createVetForm button[type='submit']")
                            .prop("disabled", false)
                            .html(`
                    <i class="fas fa-save me-2"></i>
                    Save Veterinarian
                `);

                        let errors = xhr.responseJSON.errors;

                        let errorMessage = "";

                        $.each(errors, function(key, value) {

                            errorMessage += value[0] + "<br>";

                        });

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: errorMessage
                        });

                    }

                });

            });

            // ==========================
            // DELETE VET
            // ==========================

            $(document).on("click", ".vetDeleteBtn", function() {

                let id = $(this).data("id");

                Swal.fire({

                    title: "Delete veterinarian?",
                    text: "This action cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Yes, Delete"

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "/admin/vets/delete/" + id,
                            type: "DELETE",

                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },

                            success: function(res) {

                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted",
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                loadVets();

                            },

                            error: function() {

                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: "Failed to delete veterinarian."
                                });

                            }

                        });

                    }

                });

            });


            // ==========================
            // VIEW VET
            // ==========================

            $(document).on("click", ".vetViewBtn", function() {

                let id = $(this).data("id");

                $.ajax({

                    url: "/admin/vets/show/" + id,
                    type: "GET",

                    success: function(vet) {

                        Swal.fire({

                            title: "Veterinarian Information",

                            html: `
                            <div class="text-left">
                                <div class="text-center mb-3">

                                ${
                                    vet.image
                                    ? `<img src="${vet.image}"
                                                    alt="Vet Image"
                                                    class="rounded-4 shadow"
                                                    width="140"
                                                    height="140"
                                                    style="object-fit: cover;">`
                                    : 'No image available'
                                }

                            </div>


                                <p>
                                    <strong>Fullname:</strong><br>
                                    ${vet.user.fullname}
                                </p>

                                <p>
                                    <strong>Email:</strong><br>
                                    ${vet.user.email}
                                </p>

                                <p>
                                    <strong>Specialization:</strong><br>
                                    ${vet.specializations.map(s => s.specialization_name).join(', ')}
                                </p>

                                <p>
                                    <strong>License:</strong><br>
                                    ${vet.license_number}
                                </p>
                                <p></p>
                                     <strong>Hire Date:</strong><br>
                                    ${vet.hire_date}
                                </p>

                            </div>
                            `

                        });

                    },

                    error: function() {

                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Failed to load veterinarian details."
                        });

                    }

                });

            });

        });
    </script>
@endsection
