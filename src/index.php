<?php 
session_start();

require "request/postRequests.php"; 
require "includes/pdo.php"; 

$content = filter_input(INPUT_POST,'content');
$idToDelete = filter_input(INPUT_POST,'idToDelete');

if ($_SESSION['is_admin'] === 1) {

    $admin = 'Yup';
}
else {

    $admin = 'Nope :(';
} 

if(empty($_SESSION)) {

    header("Location: ./login.php");
}

if (isset($content)) {
    if($content !=="")
    {
        createPost($content,$_SESSION['user_id'], $pdo);
        header("Location: ./index.php");
    }
}

if (isset($idToDelete)) {

    deletePost($idToDelete, $pdo);
    unset($idToDelete);
}

$posts = $pdo->query("SELECT post.content, post.id, post.user_id, user.username, user.is_admin FROM post INNER JOIN user WHERE post.user_id = user.id")->fetchAll();
require "partials/header.php";

?>

<div class="post-container">
    <h1>Bienvenue <?=$_SESSION['username']?></h1>

    <h2>Posts</h2>

    <div class="posts">
        <?php 
        foreach ($posts as $post) {
        ?>

        <div class="post-box">
            <div class="post-infos">
                <strong class="user"> User : <?= $post["username"]?></strong>
                <p class="post-content"> Post : <?= $post['content']?>  </p>
            </div>
            <form method="post">
                <button value="<?= $post['id'] ?>" name="idToDelete" class="delete-button">X</button>
            </form>
        </div>

        <?php
        }
        ?>
    </div>


    <h2>Create Post</h2>

    <form method="POST" class="create-post-form">
        <label for="content"></label>
        <input type="text" name="content" class="input-form-field">
        <button type="submit" class="submit-form">Create</button>
    </form>

    <a href="./login.php">Log out</a>
</div>


<?php
require "partials/footer.php"; 
?>