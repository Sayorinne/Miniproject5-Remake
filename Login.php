<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="JS/loginNotify.js"></script>
</head>

<body>
    <form action="signin.php" method="POST">
        <div class="main">
            <h1>FrameArt</h1>
            <form action="">
                <label for="first">
                    Username:
                </label>
                <input type="text" id="first" name="first" placeholder="Enter your Username" required>

                <label for="password">
                    Password:
                </label>
                <input type="password" id="password" name="password" placeholder="Enter your Password" required>

                <div class="wrap">
                    <button type="submit" onclick="solve()">
                        Login
                    </button>
                </div>
            </form>
            <p>ยังไม่มีบัญชีใช่ไหม?
                <a href="registration.php" style="text-decoration: none;">
                    สมัครสมาชิกเลย
                </a>
            </p>
        </div>
    </form>
</body>

</html>