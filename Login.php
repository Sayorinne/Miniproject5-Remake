<!DOCTYPE html>
<html>
 
<head>
    <title>Login</title>
    <link rel="stylesheet"
          href="CSS/login.css">
</head>
 
<body>
    <form action="signin.php" method="POST">
    <div class="main">
        <h1>FeramArt</h1>
        <form action="">
            <label for="first">
                  Username:
              </label>
            <input type="text"
                   id="first"
                   name="first"
                   placeholder="Enter your Username" required>
 
            <label for="password">
                  Password:
              </label>
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="Enter your Password" required>
 
            <div class="wrap">
                <button type="submit"
                        onclick="solve()">
                    Login
                </button>
            </div>
        </form>
        <p>Not registered? 
              <a href="registration.php"
               style="text-decoration: none;">
                Create an account
            </a>
        </p>
        <p>Join as Guest
            <a href="Homepage.php"
            style="text-decoration:none;">
            Go to Homepage
            </a>
        </p>
    </div>
</form>
</body>
 
</html>