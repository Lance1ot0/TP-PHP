<?php 
session_start();
require "request/userRequests.php"; 
require "includes/pdo.php"; 

$username = filter_input(INPUT_POST,'username');
$password = filter_input(INPUT_POST,'password');
$isAdmin = filter_input(INPUT_POST,'is_admin');

if ($isAdmin === "on") {

    $isAdmin = 1;
} 
else {

    $isAdmin = 0;
}

if (isset($username) && isset($password)) {
    
    if ($username ==="" || $password ==="") {
        
        $errorMessage = 'All fields are required';
    }
    else {

        if (authenticateUsers($username, $password, $pdo)) {

            $errorMessage = "Already have an account, log in !";
        }
        else {

            createUser($username, $password, $isAdmin, $pdo);
            $data = $pdo->query("SELECT * FROM user")->fetchAll();
            foreach ($data as $row) {
    
                if ($row['username'] === $username && $row['password'] === $password) {
    
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['is_admin'] = $row['is_admin'];
                }
            }
            header("Location: ./index.php");
        }
        
    }
}

require "partials/header.php"; 
?>

<div class="container">
    <form method="post" class="login-form">
        <h1>Sign in</h1>
        <label for="name">Username :</label> 
        <input type="text" name="username" class="input-form-field">
        <label for="password">Password :</label>
        <input type="password" name="password" class="input-form-field">
        <div class="admin-field">
            <label for="password">Admin</label>
            <input type="checkbox" name="is_admin">
        </div>
        <input type="submit" value="Register" class="submit-form"/>
        <a href="./login.php">Log in</a>

        <?php if (isset($errorMessage)) { ?>

            <p style="color:red"><?= $errorMessage?></p>

        <?php } ?>
    </form>
</div>

<?php

require "partials/footer.php"; 

?>