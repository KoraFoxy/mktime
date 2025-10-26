<?php include 'header.php'; ?>

<h2 class="about-title">Register</h2>
<form action="register_action.php" method="POST">
  <div class="mb-3">
    <label for="firstname" class="form-label">First Name</label>
    <input type="text" class="form-control" id="firstname" name="first_name" required>
  </div>
  <div class="mb-3">
    <label for="lastname" class="form-label">Last Name</label>
    <input type="text" class="form-control" id="lastname" name="last_name" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <button type="submit" class="btn-register">Register</button>
  <p class="mt-4"> Already registred? <a href = "login.php">Log in</a></p>


</form>

<?php include 'footer.php'; ?>
