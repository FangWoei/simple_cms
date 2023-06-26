<?php

$database = connectToDB();

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

$sql = "SELECT * FROM users where email = :email";
    $query = $database->prepare( $sql );
    $query->execute([
        'email' => $email
    ]);
    $user = $query->fetch();

if ( empty($name) || empty($email) || empty($password) || empty($confirm_password)){
    $error = 'PLease fill all the things (T_T)';
} else if ($password !== $confirm_password ) {
    $error = 'The password not match !!!!!!! (+__+)';
} else if ( strlen($password) <8){
    $error = 'need 8 characters (O_o) ';
} else if ( $user ){
    $error = 'The email already used, please try other (=_=)';
} else {
    $sql = "INSERT INTO users (`name`, `email`, `password` )
    VALUES(:name, :email, :password)";
    $query = $database->prepare( $sql );
    $query->execute([
        'name' => $name,
        'email' => $email,
        'password' => password_hash( $password, PASSWORD_DEFAULT)
    ]);

    // retrieve the newly signup user data
    $sql = "SELECT * FROM users where email = :email";
    // prepare
    $query = $database->prepare( $sql );
    // execute
    $query->execute([
        'email' => $email
        ]);
    // fetch (eat)
    $_SESSION["user"] = $user;
    $user = $query->fetch();


    header("Location: /dashboard");
    exit;
}
if (isset( $error ) ) {
    $_SESSION['error'] = $error;
    header("Location:/signup");
    exit;
}


