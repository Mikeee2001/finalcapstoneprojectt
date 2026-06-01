@extends('layout.app')

@section('content')
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">

                <div class="card shadow-sm border-0 rounded-4">

                    <!-- HEADER -->
                    <div class="card-header bg-primary text-white rounded-top-4 py-3">
                        <h4 class="mb-0">
                            <i class="fa-solid fa-calendar-plus me-2"></i>
                            Book Appointment
                        </h4>
                    </div>

                    <div class="card-body p-4">

                        <!-- GLOBAL ERRORS -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('user.appointment.store') }}" method="POST" id="appointmentForm">
                            @csrf

                            <div class="row g-3">

                                {{-- PET --}}
                                <div class="col-12 col-lg-6">
                                    <label class="form-label fw-semibold">Pet</label>

                                    <select name="pet_id" class="form-select @error('pet_id') is-invalid @enderror">

                                        <option value="">Select Pet</option>

                                        @foreach ($pets as $pet)
                                            <option value="{{ $pet->id }}"
                                                {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                                                {{ $pet->pet_name }}
                                                @if ($pet->breed)
                                                    - {{ $pet->breed->breed_name }}
                                                @endif
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('pet_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- SERVICE --}}
                                <div class="col-12 col-lg-6">
                                    <label class="form-label fw-semibold">Service</label>

                                    <select name="service_id" class="form-select @error('service_id') is-invalid @enderror">

                                        <option value="">Select Service</option>

                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->service_name }}
                                                - ₱{{ number_format($service->price, 2) }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- DATE --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">Appointment Date</label>

                                    <input type="date" name="requested_date"
                                        class="form-control @error('requested_date') is-invalid @enderror"
                                        min="{{ date('Y-m-d') }}" value="{{ old('requested_date') }}">

                                    @error('requested_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- TIME --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">Appointment Time</label>

                                    <select name="requested_time" id="requested_time"
                                        class="form-select @error('requested_time') is-invalid @enderror">

                                        <option value="">Select Time</option>

                                        @for ($hour = 8; $hour <= 17; $hour++)
                                            <option value="{{ sprintf('%02d:00', $hour) }}"
                                                {{ old('requested_time') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                                {{ date('g:i A', strtotime(sprintf('%02d:00', $hour))) }}
                                            </option>
                                        @endfor

                                    </select>

                                    @error('requested_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- NOTES --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Reason for Visit</label>

                                    <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
                                        placeholder="Describe your pet's symptoms or reason for visit...">{{ old('notes') }}</textarea>

                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <hr class="my-4">

                            <!-- SUBMIT -->
                            <div class="d-grid d-md-flex justify-content-md-end">

                                <button type="submit" class="btn btn-primary px-4" id="submitBtn">

                                    <span id="btnText">
                                        <i class="fa-solid fa-calendar-check me-2"></i>
                                        Book Appointment
                                    </span>

                                    <span id="btnLoading" class="d-none">
                                        <i class="fa-solid fa-spinner fa-spin me-2"></i>
                                        Submitting...
                                    </span>

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById("appointmentForm").addEventListener("submit", function() {

            const btn = document.getElementById("submitBtn");
            const text = document.getElementById("btnText");
            const loading = document.getElementById("btnLoading");

            btn.disabled = true;
            text.classList.add("d-none");
            loading.classList.remove("d-none");

        });
    </script>
    <script>
        document.getElementById('requested_time').addEventListener('change', function() {

            let selectedTime = this.value;

            if (selectedTime < '08:00' || selectedTime > '17:00') {

                alert('Appointments are only available from 8:00 AM to 5:00 PM.');

                this.value = '';
            }
        });
    </script>
    <script>
        $("#appointmentForm").submit(function(e) {

            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),

                success: function(response) {

                    if (response.status === 1) {

                        window.location.href = "{{ route('user.appointments.fetch') }}";
                    }
                },

                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>

@endsection
