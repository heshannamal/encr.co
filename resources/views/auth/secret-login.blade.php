<!DOCTYPE html>
<html>
<head>
    <title>Admin Access</title>
</head>
<body>
    <h2>System Maintenance</h2>
    <p>The system is under maintenance. If you are an admin, enter password to continue.</p>

    <form method="POST" action="{{ route('secret.unlock') }}">
        @csrf
        <input type="password" name="password" placeholder="Admin Password" required>
        <button type="submit">Unlock</button>
    </form>

    @error('password')
        <p style="color:red">{{ $message }}</p>
    @enderror
</body>
</html>
