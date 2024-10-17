<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-login.css">
  <title>Login Page</title>
</head>
<body>
  <div class="container">
    <form id="loginForm" action = "user_login.php" method = "post">
      <h2>Login</h2>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Signup</a></p>
    <p id="errorMessage"></p>
  </div>

  
</body>
</html>