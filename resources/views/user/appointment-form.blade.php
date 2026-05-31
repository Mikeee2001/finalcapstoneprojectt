@extends('layout.app')

@section('content')
    <div class="container-fluid">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-primary text-white rounded-top-4 py-3">

                <h4 class="mb-0">
                    <i class="fa-solid fa-calendar-plus me-2"></i>
                    Book Appointment
                </h4>

            </div>

            <div class="card-body p-4">

                <form action="{{ route('user.appointment.store') }}" method="POST">

                    @csrf

                    <div class="row g-4">

                        {{-- Pet --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Pet
                            </label>

                            <select name="pet_id" class="form-select">

                                <option value="">
                                    Select Pet
                                </option>

                                @foreach ($pets as $pet)
                                    <option value="{{ $pet->id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>

                                        {{ $pet->pet_name }}

                                        @if ($pet->breed)
                                            - {{ $pet->breed->breed_name }}
                                        @endif

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Service --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Service
                            </label>

                            <select name="service_id" class="form-select">

                                <option value="">
                                    Select Service
                                </option>

                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ old('service_id') == $service->id ? 'selected' : '' }}>

                                        {{ $service->service_name }}
                                        - ₱{{ number_format($service->price, 2) }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Date --}}
                        <div class="col-md-3">

                            <label class="form-label fw-semibold">
                                Appointment Date
                            </label>

                            <input type="date" name="requested_date" class="form-control" min="{{ date('Y-m-d') }}"
                                value="{{ old('requested_date') }}">

                        </div>

                        {{-- Time --}}
                        <div class="col-md-3">

                            <label class="form-label fw-semibold">
                                Appointment Time
                            </label>

                            <input type="time" name="requested_time" class="form-control"
                                value="{{ old('requested_time') }}">

                        </div>

                        {{-- Notes --}}
                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Reason for Visit
                            </label>

                            <textarea name="notes" rows="5" class="form-control"
                                placeholder="Describe your pet's symptoms or reason for visit...">{{ old('notes') }}</textarea>

                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end">

                        <button type="submit" class="btn btn-primary btn-lg px-4 rounded-3">

                            <i class="fa-solid fa-calendar-check me-2"></i>

                            Book Appointment

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
