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
    <div class="modal fade" id="createVetModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-3">

                <!-- HEADER -->
                <div class="modal-header bg-success text-white py-2">
                    <h5 class="modal-title fw-semibold fs-6">
                        <i class="fa-solid fa-user-doctor fa-sm me-1"></i>
                        Create Veterinarian
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>
                </div>

                <!-- BODY -->
                <div class="modal-body p-2 bg-light">

                    <form id="createVetForm" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-2">

                            <!-- PHOTO -->
                            <div class="col-md-2">
                                <div class="bg-white p-2 rounded-3 shadow-sm text-center h-100">

                                    <label class="fw-semibold small mb-2 d-block">
                                        Photo
                                    </label>

                                    <img id="previewImage" src="https://via.placeholder.com/90x90?text=Vet"
                                        class="rounded border mb-2" style="width:90px;height:90px;object-fit:cover;">

                                    <input type="file" name="image" id="image"
                                        class="form-control form-control-sm">

                                    <small class="text-muted">
                                        JPG, PNG
                                    </small>
                                </div>
                            </div>

                            <!-- FORM -->
                            <div class="col-md-10">
                                <div class="bg-white p-3 rounded-3 shadow-sm">

                                    <div class="row g-2">

                                        <!-- FULLNAME -->
                                        <div class="col-md-4">
                                            <label class="fw-semibold small">
                                                Fullname
                                            </label>

                                            <input type="text" name="fullname" class="form-control form-control-sm"
                                                placeholder="Fullname">
                                        </div>

                                        <!-- EMAIL -->
                                        <div class="col-md-4">
                                            <label class="fw-semibold small">
                                                Email
                                            </label>

                                            <input type="email" name="email" class="form-control form-control-sm"
                                                placeholder="Email">
                                        </div>

                                        <!-- LICENSE -->
                                        <div class="col-md-4">
                                            <label class="fw-semibold small">
                                                License No.
                                            </label>

                                            <input type="text" name="license_number" class="form-control form-control-sm"
                                                placeholder="License Number">
                                        </div>

                                        <!-- HIRE DATE -->
                                        <div class="col-md-4">
                                            <label class="fw-semibold small">
                                                Hire Date
                                            </label>

                                            <input type="date" name="hire_date" class="form-control form-control-sm">
                                        </div>

                                        <!-- SPECIALIZATIONS -->
                                        <div class="col-md-8">
                                            <label class="fw-semibold small">
                                                Specializations
                                            </label>

                                            <select name="specializations[]" id="specializations"
                                                class="form-select form-select-sm" multiple size="2">

                                                @foreach ($specializations as $specialization)
                                                    <option value="{{ $specialization->id }}">
                                                        {{ $specialization->specialization_name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            <small class="text-muted">
                                                Hold CTRL to select multiple
                                            </small>
                                        </div>

                                        <!-- NEW SPECIALIZATION -->
                                        <div class="col-12">
                                            <label class="fw-semibold small">
                                                Add New Specialization
                                            </label>

                                            <input type="text" name="new_specializations"
                                                class="form-control form-control-sm"
                                                placeholder="Surgery, Cardiology, Dentistry">

                                            <small class="text-muted">
                                                Separate multiple values with commas.
                                            </small>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- SAVE BUTTON -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-success btn-sm w-100">

                                <i class="fas fa-save fa-sm me-1"></i>
                                Save Veterinarian
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    
    <!-- CREATE USER MODAL -->
    <div class="modal fade" id="createModal">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- HEADER -->
                <div class="modal-header bg-primary text-white border-0">

                    <h5 class="modal-title fw-bold">
                        Create New User
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
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
                                <option value="staff">Staff</option>
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

    <!-- EDIT VET MODAL -->
    <div class="modal fade" id="editVetModal" tabindex="-1">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Veterinarian</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <form id="updateVetForm" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" id="vet_id" name="vet_id">

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-4 text-center">

                                <img id="editPreviewImage" src="" class="img-fluid rounded-circle border mb-3"
                                    style="width:150px;height:150px;object-fit:cover;">

                                <input type="file" name="image" id="editImage" class="form-control">

                            </div>

                            <div class="col-md-8">

                                <div class="mb-3">
                                    <label>Full Name</label>

                                    <input type="text" name="fullname" id="fullname" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>

                                    <input type="email" name="email" id="email" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>License Number</label>

                                    <input type="text" name="license_number" id="license_number"
                                        class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Hire Date</label>

                                    <input type="date" name="hire_date" id="hire_date" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Status</label>

                                    <select name="status" id="status" class="form-control">

                                        <option value="available">
                                            Available
                                        </option>

                                        <option value="unavailable">
                                            Unavailable
                                        </option>

                                    </select>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Update Vet
                        </button>

                    </div>

                </form>

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
                        `<span class="badge badge-success px-3 py-2 rounded-pill">Staff</span>`;


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

                                            <button class="btn btn-warning btn-sm rounded-pill px-3 vetEditBtn"
                                                    data-id="${vet.id}">
                                                Edit
                                            </button>

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

            // ==========================
            // EDIT VET
            // ==========================
            $(document).on("click", ".vetEditBtn", function() {

                let id = $(this).data("id");

                $.ajax({

                    url: "/admin/vets/show/" + id,
                    type: "GET",

                    success: function(vet) {

                        $("#vet_id").val(vet.id);

                        $("#fullname").val(vet.user.fullname);

                        $("#email").val(vet.user.email);

                        $("#license_number").val(vet.license_number);

                        $("#hire_date").val(vet.hire_date);

                        $("#status").val(vet.status);

                        $("#editPreviewImage").attr(
                            "src",
                            vet.image ? vet.image :
                            "https://via.placeholder.com/150x150?text=Vet"
                        );

                        $("#editVetModal").modal("show");
                    }

                });

            });

            // ==========================
            // EDIT IMAGE PREVIEW
            // ==========================
            $("#editImage").change(function() {

                let reader = new FileReader();

                reader.onload = function(e) {

                    $("#editPreviewImage").attr(
                        "src",
                        e.target.result
                    );

                };

                reader.readAsDataURL(this.files[0]);

            });

            // ==========================
            // UPDATE VET
            // ==========================
            $("#updateVetForm").submit(function(e) {

                e.preventDefault();

                let id = $("#vet_id").val();

                let formData = new FormData(this);

                formData.append("_method", "PUT"); // Spoofing PUT method for Laravel

                $.ajax({

                    url: "/admin/vets/update/" + id,

                    type: "POST",

                    data: formData,

                    processData: false,
                    contentType: false,

                    beforeSend: function() {

                        $("#updateVetForm button[type='submit']")
                            .prop("disabled", true)
                            .html("Updating...");

                    },

                    success: function(res) {

                        $("#updateVetForm button[type='submit']")
                            .prop("disabled", false)
                            .html("Update Vet");

                        $("#editVetModal").modal("hide");

                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        loadVets();

                    },

                    error: function(xhr) {

                        $("#updateVetForm button[type='submit']")
                            .prop("disabled", false)
                            .html("Update Vet");

                        let msg = "";

                        if (xhr.responseJSON?.errors) {

                            $.each(xhr.responseJSON.errors, function(key, value) {
                                msg += value[0] + "<br>";
                            });

                        } else {

                            msg = "Something went wrong.";

                        }

                        Swal.fire({
                            icon: "error",
                            title: "Validation Error",
                            html: msg
                        });

                    }

                });

            });

        });
    </script>
@endsection
