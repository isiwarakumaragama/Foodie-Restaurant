<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="signup.css">
  <title>SignUp Page</title>
</head>
<body>
  <div class="container">
    <form id="loginForm" action = "user_registration.php" method = "post">
      <h2>SignUp</h2>
      <label for="username">First Name:</label>
      <input type="text" id="username" name="firstname" required>

      <label for="username">Last Name:</label>
      <input type="text" id="username" name="lastname" >

      <label for="username">Address:</label>
      <input type="text" id="username" name="address" required>

      <label for="username">Phone Number:</label>
      <input type="text" id="username" name="phone_number" required>

      <label for="username">Email:</label>
      <input type="email" id="username" name="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
    <p id="errorMessage"></p>
  </div>

  
</body>
</html>
