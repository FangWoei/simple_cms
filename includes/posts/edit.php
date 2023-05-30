<?php

if ( !isUserLoggedIn() ) {
    header("Location: /");
    exit;
  }

    $database = connectToDB();

    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = $_POST['status'];
    $id = $_POST['id'];


    if(empty($title) || empty($content) || empty($status)){
        $error = "Make sure all the fields are filled.";
    }
    
    if ( isset( $error ) ) {
        $_SESSION['error'] = $error;
        header("Location: /manage-posts-edit?id=$id");
        exit;
    }
    
    $sql = "UPDATE posts SET title = :title, content = :content, status = :status WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute([
        'title' => $title,
        'content' => $content,
        'status' => $status,
        'id' => $id
    ]);



    // set success message
    $_SESSION["success"] = "post has been edited.";
    $_SESSION['update_post'] = $title;
    
    // redirect
    header("Location: /manage-posts");
    exit;