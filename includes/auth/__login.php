<?php
    // replace connectTODB with new DB() class
    $database = new DB();

    $email = $_POST["email"];
    $password = $_POST["password"];

    // 1. make sure all fields are not empty
    if ( empty($email) || empty($password) ) {
        $error= 'All fields are required';
    } else {
        // retrieve the user based on the email provided
        // // recipe
        // $sql = "SELECT * FROM users where email = :email";
        // // prepare
        // $query = $database->prepare( $sql );
        // // execute
        // $query->execute([
        //     'email' => $email
        // ]);
        // fetch (eat)
        $user = $database->fetch(
            "SELECT * FROM users where email = :email",
            [
                'email' => $email
            ]
        ); // fetch() will only return one row of data

        // make sure the email provided is in the database
        if ( empty( $user ) ) {
            $error ="The email provided does not exists";
        } else {
            // make sure password is correct
            if ( password_verify( $password, $user["password"] ) ) {
                // if password is valid, set the user session
                $_SESSION["user"] = $user;

                header("Location: /dashboard");
                exit;
            } else {
                // if password is incorrect
                $error = "The password provided is not match";
            }
        }

    }

        // do error checking
        if ( isset( $error ) ) {
            // store the error message in session
            $_SESSION['error'] = $error;
            // redirect the user back to login.php
            header("Location: /login");
            exit;
        }