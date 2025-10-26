<?php
    session_start();
    include 'connectDB.php';

    //Check that filds are not empty and have requested number of symbols
    if (empty($_POST['email']) || strlen($_POST['email']) < 6) {
        echo "Please enter your email.";
        exit();
    }
    if (empty($_POST['password']) || strlen($_POST['password']) < 8) {
        echo "Please enter your password.";
        exit();
    }
    //get email
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $sql_email = "SELECT * FROM users WHERE email='$email'"; // check this email with DB
    $result_email = $conn->query($sql_email);

    //if email wasn't found - show error
    if ($result_email->num_rows == 0) {
        echo "No account found with that email.";
        exit();
    }

    //Get user
    $user = $result_email->fetch_assoc();

    //Check user's password - show error if not
    if (!password_verify($password, $user['pass'])) {
        echo "Incorrect password.";
        exit();
    };

    //Create session if User password and email is matched
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_email'] = $user['email'];

    header("Location: index.php");
    exit();

?>
