<?php

  if ( !isUserLoggedIn() ) {
    header("Location: /");
    exit;
  }
    $database = connectToDB();

    $id = $_POST["id"];

    if (empty($id)){
        $error = "Error!";
    }

    if ( isset( $error ) ) {
        $_SESSION['error'] = $error;
        header("Location: /manage-posts");
        exit;
    }

    // if no error found, delete the user
    $sql = "DELETE FROM posts WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute([
        'id' => $id
    ]);

    // set success message
    $_SESSION["success"] = "Post has been deleted.";

    // redirect
    header("Location: /manage-posts");
    exit;