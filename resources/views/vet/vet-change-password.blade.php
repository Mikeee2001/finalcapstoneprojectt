<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>

    <h2>Update Your Password</h2>

    @if(session('success'))
        <p style="color:green;">
            {{ session('success') }}
        </p>
    @endif

    <form action="{{ route('vet.settings.change.password', $vet->id) }}" method="POST">

        @csrf

        <input type="password"
               name="password"
               placeholder="New Password">

        <br><br>

        <input type="password"
               name="password_confirmation"
               placeholder="Confirm Password">

        <br><br>

        <button type="submit">
            Update Password
        </button>

    </form>

</body>
</html>
