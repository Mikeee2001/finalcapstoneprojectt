<div class="card shadow-sm border-0">

    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            {{ $pet->pet_name }}
        </h5>
    </div>

    <div class="card-body">

        <ul class="nav nav-tabs mb-3">

            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview">
                    Overview
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#records">
                    Records
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#labs">
                    Lab Tests
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rx">
                    Prescriptions
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#vaccines">
                    Vaccinations
                </button>
            </li>

        </ul>

        <div class="tab-content">

            <div class="tab-pane fade show active" id="overview">
                @include('vet.tabs.overview')
            </div>

            <div class="tab-pane fade" id="records">
                @include('vet.tabs.records')
            </div>

            <div class="tab-pane fade" id="labs">
                @include('vet.tabs.lab-tests')
            </div>

            <div class="tab-pane fade" id="rx">
                @include('vet.tabs.prescriptions')
            </div>

            <div class="tab-pane fade" id="vaccines">
                @include('vet.tabs.vaccinations')
            </div>

        </div>

    </div>

</div>
