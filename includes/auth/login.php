<?php
    $database = connectToDB();


    $email = $_POST["email"];
    $password = $_POST["password"];

    
    if ( empty($email) || empty($password) ) {
        $error = 'PLease fill all the things (T_T)';
    } else {
        $sql = "SELECT * FROM users where email = :email";
        $query = $database->prepare( $sql );
        $query->execute([
            'email' => $email
        ]);
        $user = $query->fetch();
        if ( empty( $user ) ) {
            $error = "The email provided does not exists (z_z)";
        } else {
            if ( password_verify( $password, $user["password"] ) ) {
                $_SESSION["user"] = $user;

                header("Location: /dashboard");
                exit;
            } else {
                $error = "Something Wrong !!!!!! (*\O/*) ";
            }
        }

    }
    if ( isset( $error ) ) {
        $_SESSION['error'] = $error;
        header("Location: /login");
        exit;
    }