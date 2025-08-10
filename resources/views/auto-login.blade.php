<!DOCTYPE html>
<html>
<head>
    <title>Auto Login</title>
</head>
<body>
    <h3>Auto Login untuk Testing</h3>
    <form action="{{ route('login') }}" method="POST" id="autoLoginForm">
        @csrf
        <input type="email" name="email" value="admin@g0campus.ac.id" style="display:none;">
        <input type="password" name="password" value="password" style="display:none;">
        <button type="submit">Login as Admin</button>
    </form>
    
    <script>
        // Auto submit after 2 seconds
        setTimeout(function() {
            document.getElementById('autoLoginForm').submit();
        }, 2000);
    </script>
    
    <p>Redirecting in 2 seconds...</p>
</body>
</html>
