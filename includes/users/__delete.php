<?php

    // check if the current user is an admin or not
    if ( !Auth::isAdmin() ) {
        // if current user is not an admin, redirect to dashboard
        header("Location: /dashboard");
        exit;
    }

    // load the database
    $database = connectToDB();

    // get all the $_POST data
    $id = $_POST["id"];

    /* 
        do error check
        - make sure the id is not empty
    */
    if (empty($id)){
        $error = "Error!";
    }

    // if error found, set error message & redirect back to the manage-users page
    if ( isset( $error ) ) {
        $_SESSION['error'] = $error;
        header("Location: /manage-users");
        exit;
    }

    // if no error found, delete the user
    $sql = "DELETE FROM users WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute([
        'id' => $id
    ]);

    // set success message
    $_SESSION["success"] = "user has been deleted.";

    // redirect
    header("Location: /manage-users");
    exit;