@extends('layout.app')

@section('content')
    <div class="container-fluid">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">My Pets</h3>
                <p class="text-muted mb-0">Manage your pets information</p>
            </div>

            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPetModal">

                    Add Pet

                </button>
            </div>

        </div>

        <!-- PETS GRID -->
        <div id="pets-container">
            <div class="row">

                @forelse($pets as $pet)
                    <div class="col-md-6 col-lg-4 mb-4">

                        <div class="card pet-card border-0 shadow-sm rounded-4 h-100">

                            <div class="card-body p-4">

                                <!-- TOP -->
                                <div class="d-flex justify-content-end mb-3">

                                    <span class="badge bg-primary px-3 py-2 rounded-pill">
                                        {{ $pet->gender }}
                                    </span>

                                </div>

                                <div class="pet-icon mb-3">

                                    @if ($pet->pet_image)
                                        <img src="{{ asset('pet_images/' . $pet->pet_image) }}" class="pet-img">
                                    @else
                                        <i class="fa-solid fa-paw"></i>
                                    @endif

                                </div>

                                <!-- PET NAME -->
                                <h4 class="fw-bold text-dark mb-3">
                                    {{ $pet->pet_name }}
                                </h4>

                                <!-- DETAILS -->
                                <div class="pet-details">

                                    <div class="detail-item">
                                        <span class="detail-label">Species</span>
                                        <span class="detail-value">
                                            {{ $pet->species->species_name ?? 'N/A' }}
                                        </span>
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Breed</span>
                                        <span class="detail-value">
                                            {{ $pet->breed->breed_name ?? 'N/A' }}
                                        </span>
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Age</span>
                                        <span class="detail-value">
                                            {{ $pet->age }} {{ $pet->age_type }}
                                        </span>
                                    </div>

                                </div>

                                <!-- ACTIONS -->
                                <div class="d-flex gap-2 mt-4">

                                    {{-- <button class="btn btn-primary btn-sm flex-fill rounded-pill">
                                        <i class="fa-solid fa-eye me-1"></i>
                                        View
                                    </button> --}}

                                    <button class="btn btn-outline-danger btn-sm flex-fill rounded-pill deleteBtn"
                                        data-id="{{ $pet->id }}">

                                        <i class="fa-solid fa-trash me-1"></i>
                                        Delete

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="card border-0 shadow-sm rounded-4">

                            <div class="card-body text-center py-5">

                                <div class="empty-icon mb-3">
                                    <i class="fa-solid fa-paw"></i>
                                </div>

                                <h4 class="fw-bold">
                                    No Pets Found
                                </h4>

                                <p class="text-muted mb-4">
                                    Add your first pet to get started.
                                </p>

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createPetModal">
                                    <i class="fa-solid fa-plus me-2"></i>
                                    Add Pet
                                </button>

                            </div>

                        </div>

                    </div>
                @endforelse

            </div>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mt-4">
            {{ $pets->links() }}
        </div>


    </div>


    <!-- ADD PET MODAL -->
    <div class="modal fade" id="createPetModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 rounded-4 shadow-lg">

                <!-- HEADER -->
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title fw-bold">
                        Add New Pet
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- FORM -->
                <form id="addPetForm" action="{{ route('user.pets.add') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body p-4">

                        <div class="row g-4">

                            <!-- LEFT SIDE -->
                            <div class="col-lg-5">

                                <!-- PET IMAGE -->
                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        Pet Image
                                    </label>

                                    <input type="file" name="pet_image" class="form-control" accept="image/*">

                                </div>

                                <!-- PET NAME -->
                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        Pet Name
                                    </label>

                                    <input type="text" name="pet_name" class="form-control" placeholder="Enter pet name"
                                        required>

                                </div>

                                <!-- GENDER -->
                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        Gender
                                    </label>

                                    <select name="gender" class="form-select" required>

                                        <option value="">
                                            Select Gender
                                        </option>

                                        <option value="Male">
                                            Male
                                        </option>

                                        <option value="Female">
                                            Female
                                        </option>

                                    </select>

                                </div>

                            </div>

                            <!-- RIGHT SIDE -->
                            <div class="col-lg-7">

                                <!-- SPECIES -->
                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        Species
                                    </label>

                                    <input type="text" name="species_name" id="species_name" class="form-control"
                                        placeholder="Enter species" autocomplete="off" required>

                                </div>

                                <!-- BREED -->
                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        Breed
                                    </label>

                                    <input type="text" name="breed_name" id="breed_name" class="form-control"
                                        placeholder="Enter breed" autocomplete="off" required>

                                </div>

                                <!-- AGE -->
                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        Age
                                    </label>

                                    <div class="row g-2">

                                        <div class="col-md-6">

                                            <input type="number" name="age" class="form-control" min="0"
                                                placeholder="Enter age" required>

                                        </div>

                                        <div class="col-md-6">

                                            <select name="age_type" class="form-select" required>

                                                <option value="months">
                                                    Months
                                                </option>

                                                <option value="years">
                                                    Years
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer px-4 pb-4 border-0">

                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit" class="btn btn-primary px-4">

                            Save Pet

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- Bootstrap CSS (already included in your layout probably) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle (required for modals, dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> <!-- jQuery UI JS -->
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <style>
        .pet-card {
            transition: 0.2s ease;
        }

        .pet-card:hover {
            transform: translateY(-4px);
        }

        .pet-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: #e8f0ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 22px;
        }

        .pet-details p {
            font-size: 14px;
            color: #555;
        }

        /* AUTOCOMPLETE DROPDOWN FIX */
        .ui-autocomplete {
            z-index: 9999 !important;
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            background: white;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .ui-menu-item-wrapper {
            padding: 8px 12px;
            cursor: pointer;
        }

        .ui-menu-item-wrapper:hover {
            background: #2563eb;
            color: white;
            border-radius: 5px;
        }
    </style>

    <script>
        $(document).ready(function() {

            // =========================
            // AUTOCOMPLETE DATA
            // =========================

            let species = [
                @foreach ($species->unique('species_name') as $item)
                    "{{ $item->species_name }}",
                @endforeach
            ];

            let breeds = [
                @foreach ($breeds->unique('breed_name') as $breed)
                    "{{ $breed->breed_name }}",
                @endforeach
            ];

            // =========================
            // SPECIES AUTOCOMPLETE
            // =========================

            $("#species_name").autocomplete({
                source: species,
                minLength: 1
            });

            // =========================
            // BREED AUTOCOMPLETE
            // =========================

            $("#breed_name").autocomplete({
                source: breeds,
                minLength: 1
            });

            // =========================
            // AJAX SUBMIT
            // =========================

            $("#addPetForm").submit(function(e) {

                e.preventDefault();

                let form = $(this);

                let formData = new FormData(this);

                $.ajax({

                    url: form.attr('action'),
                    type: "POST",
                    data: formData,

                    processData: false,
                    contentType: false,

                    beforeSend: function() {

                        form.find("button[type='submit']")
                            .prop('disabled', true)
                            .html('Saving...');

                    },

                    success: function(response) {

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });

                        // CLOSE MODAL
                        $('#createPetModal').modal('hide');

                        // RESET FORM
                        form[0].reset();

                        // ENABLE BUTTON
                        form.find("button[type='submit']")
                            .prop('disabled', false)
                            .html('Save Pet');

                        // RELOAD PET LIST ONLY
                        $("#pets-container").load(
                            location.href + " #pets-container > *",
                            function() {

                                // OPTIONAL LOADER HIDE
                                $("#pageLoader").fadeOut(200);

                            }
                        );

                    },

                    error: function(xhr) {

                        let errorMessage = "Something went wrong.";

                        if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: errorMessage,
                            showConfirmButton: false,
                            timer: 2500
                        });

                        form.find("button[type='submit']")
                            .prop('disabled', false)
                            .html('Save Pet');
                    }

                });

            });

        });
    </script>
    <script>
        $(document).on("click", ".deleteBtn", function() {

            let id = $(this).data("id");

            Swal.fire({
                title: "Delete this pet?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {

                if (result.isConfirmed) {

                    $("#pageLoader")
                        .css("display", "flex")
                        .hide()
                        .fadeIn(200);

                    $.ajax({

                        url: "/user/pets/delete/" + id,
                        type: "DELETE",

                        data: {
                            _token: "{{ csrf_token() }}"
                        },

                        success: function(res) {

                            $("#pageLoader").fadeOut(200);

                            Swal.fire({
                                icon: "success",
                                title: "Deleted",
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // RELOAD PETS ONLY
                            $("#pets-container").load(
                                location.href + " #pets-container > *"
                            );

                        },

                        error: function() {

                            $("#pageLoader").fadeOut(200);

                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Failed to delete pet."
                            });

                        }

                    });

                }

            });

        });
    </script>
@endsection
