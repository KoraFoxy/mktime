<?php
    include 'connectDB.php';

    //Check that filds are not empty and have requested number of symbols
    if (empty($_POST['first_name']) || strlen($_POST['first_name']) < 2) {
        echo "Enter first name";
        exit();
    }
    if (empty($_POST['last_name']) || strlen($_POST['last_name']) < 2) {
        echo "Enter last name";
        exit();
    }
    if (empty($_POST['email']) || strlen($_POST['email']) < 6) {
        echo "Enter your email";
        exit();
    }
    if (empty($_POST['password']) || strlen($_POST['password']) < 8) {
        echo "Password should be at least 8 symbols";
        exit();
    }

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    
    //Check, that there is no this email in DB
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email);
    
    if ($result->num_rows > 0) {
        echo "Email already registered!";
        exit();
    }
    
    // hash password for secutity
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // DB insert data
    $sql = "INSERT INTO users (first_name, last_name, email, pass, reg_date) 
            VALUES ('$first_name', '$last_name', '$email', '$hashed_password', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        // Redirect to Login page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();

?>
