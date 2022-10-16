<?php 
session_start();
require "includes/pdo.php"; 
require "request/userRequests.php"; 

$username = filter_input(INPUT_POST,'username');
$password = filter_input(INPUT_POST,'password');

if (isset($username) && isset($password)) {

    if ($username ==="" || $password ==="") {
        
        $errorMessage = 'All fields are required';
    }
    else {  

        if (authenticateUsers($username, $password, $pdo)) {

            $data = $pdo->query("SELECT * FROM user")->fetchAll();
            foreach ($data as $row) {
    
                if ($row['username'] === $username && $row['password'] === $password) {
    
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['is_admin'] = $row['is_admin'];
                }

            }
            header("Location: ../index.php");
        }
        else {

            $errorMessage = "Not registered";
        }
    }
} 

require "partials/header.php"; 
?>

<div class="container">
    <form method="post" class="login-form">
        <h1>Login</h1>
        <label for="name">Username</label> 
        <input type="text" name="username" class="input-form-field">
        <label for="password">Password</label>
        <input type="password" name="password" class="input-form-field">
        <input type="submit" value="Connexion" class="submit-form"/>
        <a href="./signIn.php">Sign in</a>

        <?php

            if (isset($errorMessage)) {
        ?>

            <p style="color:red"><?= $errorMessage?></p>

        <?php    
            }

        ?>
    </form>

</div>
    
<?php
require "partials/footer.php"; 

?>