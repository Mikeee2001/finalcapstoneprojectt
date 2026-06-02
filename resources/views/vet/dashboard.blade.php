@extends('layout.app')

@section('content')
    <div class="dashboard-content p-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-5">

            <div>

                <h1 class="fw-bold text-dark">
                    Welcome Sir. {{ auth()->user()->fullname }}
                </h1>

                <p class="text-muted fs-5 mb-0">
                    Veterinary Dashboard Overview
                </p>

            </div>

        </div>
    </div>
@endsection
