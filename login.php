<?php include 'header.php'; ?>

<h2 class="about-title">Login</h2>
<form action="login_action.php" method="POST">
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <button type="submit" class="btn-login">Login</button>
  <p class="mt-4"> I don't remember my password</p>
</form>
<p class="mt-4"> Don't have an account? <a href = "register.php">Register</a> now</p>

<?php include 'footer.php'; ?>
