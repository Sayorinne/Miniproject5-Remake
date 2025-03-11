<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow-y: auto;
        }

        .main {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 350px;
            text-align: center;
        }

        .main h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
            text-align: left;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        button[type="submit"] {
            padding: 15px;
            border-radius: 5px;
            border: none;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #4cae4c;
        }

        p {
            margin-top: 20px;
            color: #555;
        }

        a {
            color: #5cb85c;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="main">
        <h2>Registration Form</h2>
        <form id="signupForm" method="POST" action="signup.php" onsubmit="return validateForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="Username" required />

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />

            <label for="repassword">Re-type Password:</label>
            <input type="password" id="repassword" name="repassword" required />

            <label for="Tel">Telephone number:</label>
            <input type="text" id="Tel" name="Tel" required pattern="\d{10}"
                title="Enter a valid 10-digit phone number">
            <button type="submit">Register</button>
        </form>

        <p>มีบัญชีแล้วใช่ไหม?
            <a href="login.php">กลับสู่หน้า</a>
        </p>
        <p>เข้าแบบไม่ระบุตัวตน
            <a href="CustomerHomepage.php">ไปสู่หน้าหลัก</a>
        </p>
    </div>

    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const repassword = document.getElementById('repassword').value;
            const tel = document.getElementById('Tel').value;

            if (!/^\d{10}$/.test(tel)) {
                alert('Enter a valid 10-digit phone number.');
                return false;
            }

            if (!/^[a-zA-Z0-9]+$/.test(password)) {
                alert('Password must contain only alphabets and numbers.');
                return false;
            }

            if (password !== repassword) {
                alert('Passwords do not match.');
                return false;
            }

            return true;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status') && urlParams.get('status') === 'success') {
                document.body.style.overflow = 'hidden';
                Swal.fire({
                    title: 'Registration Successful!',
                    text: 'Your account has been created successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    allowOutsideClick: true
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.backdrop) {
                        window.location.href = 'Login.php';
                    }
                });
            }
        });
    </script>
</body>
</html>