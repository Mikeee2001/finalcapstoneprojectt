@extends('layout.app')

@section('content')

<div class="dashboard-container">

    <!-- PAGE TITLE -->
    <div class="page-header">
        <div>
            <h1>Admin Dashboard</h1>
            <p>Welcome back, Administrator 👋</p>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="stats-grid">

        <div class="stats-card">
            <div class="card-icon blue">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="card-info">
                <h3>120</h3>
                <p>Total Users</p>
            </div>
        </div>

        <div class="stats-card">
            <div class="card-icon green">
                <i class="fa-solid fa-calendar-check"></i>
            </div>

            <div class="card-info">
                <h3>45</h3>
                <p>Appointments</p>
            </div>
        </div>

        <div class="stats-card">
            <div class="card-icon orange">
                <i class="fa-solid fa-paw"></i>
            </div>

            <div class="card-info">
                <h3>89</h3>
                <p>Registered Pets</p>
            </div>
        </div>

        <div class="stats-card">
            <div class="card-icon red">
                <i class="fa-solid fa-user-doctor"></i>
            </div>

            <div class="card-info">
                <h3>8</h3>
                <p>Veterinarians</p>
            </div>
        </div>

    </div>

    <!-- RECENT ACTIVITY -->
    <div class="dashboard-box">

        <div class="box-header">
            <h2>Recent Activity</h2>
        </div>

        <div class="activity-list">

            <div class="activity-item">
                <i class="fa-solid fa-circle-check success"></i>
                <p>New appointment booked by John Doe</p>
            </div>

            <div class="activity-item">
                <i class="fa-solid fa-circle-check success"></i>
                <p>Pet vaccination record updated</p>
            </div>

            <div class="activity-item">
                <i class="fa-solid fa-circle-check success"></i>
                <p>New user account registered</p>
            </div>

        </div>

    </div>

</div>

@endsection
