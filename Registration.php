<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .main {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
        }

        .main h2 {
            color: #000000;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button[type="submit"] {
            padding: 15px;
            border-radius: 10px;
            border: none;
            background-color: #00b306;
            color: white;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
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

        <p>Have an account?
            <a href="login.php" style="text-decoration: none;">
                <span>Return to login</span>
            </a>
        </p>
        <p>Join as Guest
            <a href="Homepage.php" style="text-decoration:none;">
                Go to Homepage
            </a>
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
</body>

</html>