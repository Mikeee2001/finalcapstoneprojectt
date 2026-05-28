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

                        <div class="card border-0 shadow-sm rounded-4 h-100 pet-card">

                            <div class="card-body">

                                <!-- ICON -->
                                <div class="pet-icon mb-3">
                                    <i class="fa-solid fa-paw"></i>
                                </div>

                                <!-- PET NAME -->
                                <h5 class="fw-bold mb-3">
                                    {{ $pet->pet_name }}
                                </h5>

                                <!-- DETAILS -->
                                <div class="pet-details">

                                    <p class="mb-2">
                                        <strong>Species:</strong>
                                        {{ $pet->species->species_name ?? 'N/A' }}
                                    </p>

                                    <p class="mb-2">
                                        <strong>Breed:</strong>
                                        {{ $pet->breed->breed_name ?? 'N/A' }}
                                    </p>

                                    <p class="mb-0">
                                        <strong>Age:</strong>
                                        {{ $pet->age }} years old
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="card border-0 shadow-sm rounded-4">

                            <div class="card-body text-center py-5">

                                <i class="fa-solid fa-paw fa-3x text-muted mb-3"></i>

                                <h5>No pets found</h5>

                                <p class="text-muted">
                                    Add your first pet to get started.
                                </p>

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

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 rounded-4">

                <!-- HEADER -->
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">
                        Add New Pet
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- FORM -->
                <form id="addPetForm" action="{{ route('user.pets.add') }}" method="POST">

                    @csrf

                    <div class="modal-body">

                        <!-- PET NAME -->
                        <div class="mb-3">

                            <label class="form-label">
                                Pet Name
                            </label>

                            <input type="text" name="pet_name" class="form-control" placeholder="Enter pet name"
                                required>

                        </div>

                        <!-- SPECIES -->
                        <div class="mb-3">

                            <label class="form-label">
                                Species
                            </label>

                            <input type="text" name="species_name" placeholder="Enter species" id="species_name"
                                class="form-control" autocomplete="off" required>

                        </div>

                        <!-- BREED -->
                        <div class="mb-3">

                            <label class="form-label">
                                Breed
                            </label>

                            <input type="text" name="breed_name" id="breed_name" placeholder="Enter breed"
                                class="form-control" autocomplete="off" required>


                        </div>

                        <!-- GENDER -->
                        <div class="mb-3">

                            <label class="form-label">
                                Gender
                            </label>

                            <select name="gender" class="form-control" required>

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

                        <!-- AGE -->
                        <div class="mb-3">

                            <label class="form-label">
                                Age
                            </label>

                            <input type="number" name="age" class="form-control" min="0" placeholder="Enter age"
                                required>

                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit" class="btn btn-primary">

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

                $.ajax({

                    url: form.attr('action'),
                    type: "POST",
                    data: form.serialize(),

                    beforeSend: function() {

                        form.find("button[type='submit']")
                            .prop('disabled', true)
                            .html('Saving...');

                    },

                    success: function(response) {

                        // SUCCESS TOAST
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });

                        // CLOSE MODAL
                        $('#createPetModal').modal('hide');

                        // RESET FORM
                        form[0].reset();

                        // ENABLE BUTTON
                        form.find("button[type='submit']")
                            .prop('disabled', false)
                            .html('Save Pet');

                        // RELOAD PAGE
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

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

                        // ENABLE BUTTON
                        form.find("button[type='submit']")
                            .prop('disabled', false)
                            .html('Save Pet');
                    }

                });

            });

        });
    </script>
@endsection
