<?php

class User
{

    public static function getUsers()
    {
        $database = new DB();
        return $database->fetchAll(
            "SELECT * FROM users");
      
    }

    public static function getUserByID( $user_id )
    {
     // make sure the id parameter is available in the url
     if ( isset( $_GET['id'] ) ) {
        // load database
        $database = new DB();
  
        // load the user data based on the id
        return $database->fetch(
        "SELECT * FROM users WHERE id = :id",
          [
            'id' => $_GET['id']
          ]
          );
  
        // make sure user data is found in database
        if ( !Auth::isUserLoggedIn() ) {
          // if user don't exists, then we redirect back to manage-users
          header("Location: /manage-users");
          exit;
        }
  
      } else {
        // if $_GET['id'] is not available, then redirect the user back to manage-users
        header("Location: /manage-users");
        exit;
      }
    }

    public static function add()
    {

        // load database
       $db = new DB();

        // get all the POST data
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $role = $_POST["role"];
            
       $user = $db->fetch(
            "SELECT * FROM users WHERE email = :email",
        
            [
                'email'=>$email
            ]
        
        );

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
        } 
            
        // if no error found, process to account creation
        $sql = "INSERT INTO users (`name`, `email`, `password`,`role` )
        VALUES(:name, :email, :password, :role)";
        $db->insert($sql , [
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

    public static function edit()
    {
        $db = new DB();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $id = $_POST['id'];

        if(empty($name) || empty($email) || empty($role) || empty($id)){
            $error = "Please enter fields";
        }else{
            $sql = "SELECT * FROM users WHERE email = :email AND id != :id";
            $user = $db->fetch(
                $sql,
                [
                   'email' => $email,
                    'id' => $id 
                ]);

            if ($user){
                $error = "The email provided does not exists";
            }
        }
        if(isset($error)){
            $_SESSION['error'] = $error;
            header("Location: /manage-users-edit?id=$id");
            exit;
        }

        $sql = "UPDATE users set name = :name,email = :email,role = :role WHERE id = :id";
        $db->update(
            $sql,
            [
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'id' => $id
            ]);
        header("Location: /manage-users");
        exit;
    }

    public static function changepwd()
    {
        $db = new DB();

        $password = $_POST['password'];
        $confirm_password = $_POST["confirm_password"];
        $id  = $_POST['id'];
    
        if(empty($password) || empty($confirm_password) || empty($id)){
            $error = "Make sure all the fields are filled.";
        } else if ( $password !== $confirm_password ) {
            
            $error = 'The password is not match.';
        }else if ( strlen( $password ) < 8 ) {
            $error = "Your password must be at least 8 characters";
        }
    
        if ( isset( $error ) ) {
            $_SESSION['error'] = $error;
            header("Location: /manage-users-changepwd?id=$id");
            exit;
        }
    
        $db->update(
        "UPDATE users SET password = :password WHERE id = :id",
        [
            'password' => password_hash( $password, PASSWORD_DEFAULT ),
            'id' => $id
        ]
        );
    
    
        $_SESSION["success"] = "Password has been changed.";
    
        header("Location: /manage-users");
        exit;
    }


    public static function delete()
    {
        $db = new DB();

        $id = $_POST["id"];

        if (empty($id)){
            $error = "Error!";
        }
    
        if ( isset( $error ) ) {
            $_SESSION['error'] = $error;
            header("Location: /manage-users");
            exit;
        }
    
        $db->delete(
            "DELETE FROM users WHERE id = :id",
            [
                'id' => $id
            ]
            );
            
        $_SESSION["success"] = "user has been deleted.";
    
        header("Location: /manage-users");
        exit;
    }
}