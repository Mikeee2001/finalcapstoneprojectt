@extends('layout.app')

@section('content')
    <div class="container-fluid">

        <div class="row">

            <!-- LEFT SIDEBAR -->
            <div class="col-md-3">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white">
                        <i class="fa-solid fa-paw me-2"></i>
                        Assigned Pets
                    </div>

                    <div class="card-body">

                        <!-- SEARCH -->
                        <div class="input-group mb-3">

                            <span class="input-group-text">
                                <i class="fa-solid fa-search"></i>
                            </span>

                            <input type="text" id="searchPet" class="form-control" placeholder="Search pet...">

                            <button class="btn btn-outline-secondary" id="clearSearch">
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                        </div>

                        <!-- SEARCH LOADING -->
                        <div id="searchLoading" class="text-center py-3 d-none">

                            <div class="spinner-border spinner-border-sm text-primary"></div>

                            <div class="small text-muted mt-2">
                                Searching...
                            </div>

                        </div>

                        <!-- PET LIST -->
                        <div id="petList">

                            @forelse($pets as $pet)
                                <a href="#" class="list-group-item list-group-item-action pet-item mb-2 rounded"
                                    data-id="{{ $pet->id }}">

                                    <div class="d-flex align-items-center">

                                        <div class="me-2">

                                            @if ($pet->pet_image)
                                                <img src="{{ asset('pet_images/' . $pet->pet_image) }}" width="45"
                                                    height="45" class="rounded-circle" style="object-fit:cover;">
                                            @else
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width:45px;height:45px;">
                                                    <i class="fa-solid fa-paw"></i>
                                                </div>
                                            @endif

                                        </div>

                                        <div>
                                            <strong>{{ $pet->pet_name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                Owner: {{ $pet->user->fullname }}
                                            </small>
                                        </div>

                                    </div>

                                </a>

                            @empty

                                <div class="text-center py-4">

                                    <i class="fa-solid fa-dog fa-3x text-secondary mb-2"></i>

                                    <h6>No Pets Assigned</h6>

                                </div>
                            @endforelse

                        </div>

                        <!-- NO PET FOUND -->
                        <div id="noPetFound" class="text-center py-4 d-none">

                            <i class="fa-solid fa-dog fa-3x text-secondary mb-2"></i>

                            <h6>No Pet Found</h6>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT CONTENT -->
            <div class="col-md-9">

                <div id="petContent">

                    <div class="card shadow-sm border-0">

                        <div class="card-body text-center py-5">

                            <i class="fa-solid fa-paw fa-4x text-primary mb-3"></i>

                            <h4>Select a Pet</h4>

                            <p class="text-muted">
                                Choose a pet from the left panel to view medical records.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- LOADING TEMPLATE -->
    <div id="loadingTemplate" class="d-none">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="placeholder-glow">

                    <span class="placeholder col-6 mb-3"></span>

                    <span class="placeholder col-12 mb-2"></span>

                    <span class="placeholder col-10 mb-2"></span>

                    <span class="placeholder col-8 mb-2"></span>

                </div>

            </div>

        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- SCRIPTS --}}
    <script>
        $(document).ready(function() {

            $('#searchPet').on('keyup', function() {

                let keyword = $(this).val().toLowerCase();

                $('#searchLoading').removeClass('d-none');

                setTimeout(function() {

                    let found = false;

                    $('.pet-item').each(function() {

                        let text = $(this).text().toLowerCase();

                        if (text.includes(keyword)) {

                            $(this).show();
                            found = true;

                        } else {

                            $(this).hide();

                        }

                    });

                    $('#searchLoading').addClass('d-none');

                    if (found) {

                        $('#noPetFound').addClass('d-none');

                    } else {

                        $('#noPetFound').removeClass('d-none');

                    }

                }, 300);

            });

            $('#clearSearch').click(function() {

                $('#searchPet').val('');

                $('.pet-item').show();

                $('#noPetFound').addClass('d-none');

            });

            $(document).on('click', '.pet-item', function(e) {

                e.preventDefault();

                let petId = $(this).data('id');

                $('#petContent').html($('#loadingTemplate').html());

                $.ajax({

                    url: '/vet/pets/' + petId + '/records',

                    type: 'GET',

                    success: function(response) {

                        $('#petContent').html(response);

                    },

                    error: function() {

                        $('#petContent').html(`
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">

                            <i class="fa-solid fa-triangle-exclamation fa-4x text-danger mb-3"></i>

                            <h5>Unable to load records</h5>

                            <p class="text-muted">
                                Please try again.
                            </p>

                        </div>
                    </div>
                `);

                    }

                });

            });

        });
    </script>
@endsection
