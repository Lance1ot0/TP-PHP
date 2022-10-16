<?php
require "../request/postRequests.php";
require "./pdo.php";


$content = filter_input(INPUT_POST,'content');
if($content !=="") {
   
    createPost($content, $pdo);
} 



?>