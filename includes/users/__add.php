<?php

    // check if the current user is an admin or not
    if ( !Auth::isAdmin() ) {
        // if current user is not an admin, redirect to dashboard
        header("Location: /dashboard");
        exit;
    }

    // load database
    $database = connectToDB();

    // get all the POST data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $role = $_POST["role"];
        
    // get user with the email entered
    $sql = "SELECT * FROM users WHERE email = :email";
    $query = $database->prepare($sql);
    $query->execute([
        'email'=>$email
    ]);
    $user = $query->fetch();

    // do error checking
    /*
        - make sure all fields are not empty
        - make sure the password is match
        - make sure the password is at least 8 characters
        - make sure email entered wasn't already exists in the database
    */
    if ( empty( $name ) || empty($email) || empty($password) || empty($confirm_password) || empty($role)  ) {
        $error = 'All fields are required';
    } else if ( $password !== $confirm_password ) {
        $error = 'The password is not match.';
    } else if ( strlen( $password ) < 8 ) {
        $error = "Your password must be at least 8 characters";
    } else if ( $user ) {
        $error = "The email you inserted has already been used by another user. Please insert another email.";
    }

    // if error found, set error message session
    if( isset ($error)){
        $_SESSION['error'] = $error;
        header("Location: /manage-users-add");    
    } else {
        // if no error found, process to account creation
        $sql = "INSERT INTO users (`name`, `email`, `password`,`role` )
        VALUES(:name, :email, :password, :role)";
        $query = $database->prepare( $sql );
        $query->execute([
            'name' => $name,
            'email' => $email,
            'password' => password_hash( $password, PASSWORD_DEFAULT),
            'role' => $role
        ]);

        // redirect the user back to manage-users page
        $_SESSION["success"] = "New user has been created.";
        $_SESSION['new_user_email'] = $email;
        header("Location: /manage-users");
        exit;

    }

