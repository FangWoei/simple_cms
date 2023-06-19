<?php

class Post
{

    public static function getPublishPosts()
    {
            $database = new DB();
    
            return $database->fetchAll(
                "SELECT * FROM posts 
                WHERE status = 'publish'
                ORDER BY id DESC"
                );

    }

    public static function getPostsByUserRole()
    {
        $database = new DB();

    if ( Auth::isAdmin() || Auth::isEditor() ){
            return $database->fetchAll( 
            "SELECT 
                posts.id, 
                posts.title, 
                posts.status, 
                users.name AS user_name 
                FROM posts 
                JOIN users 
                ON posts.user_id = users.id",
                );
            }else{
            return $database->fetchAll( 
            "SELECT 
                posts.id, 
                posts.title, 
                posts.status, 
                users.name AS user_name 
                FROM posts 
                JOIN users 
                ON posts.user_id = users.id 
                where user_id = :user_id",
            [
                'user_id' => $_SESSION["user"]["id"]
            ]
            );
            }

    }

    public static function getPostByID()
    {
        if ( isset( $_GET['id'] ) ) {
            $database = new DB();

            return $database->fetch( 
            "SELECT 
            posts.*,
            users.name 
            FROM posts 
            JOIN users
            ON posts.modified_by = users.id
            WHERE posts.id = :id",
            [
             'id' => $_GET['id']
           ]);
          
          } else {
            header("Location: /manage-posts");
            exit;
          }
    }

    public static function add()
    {
        if ( !Auth::isUserLoggedIn() ) {
            header("Location: /");
            exit;
          }

          $database = new DB();

           $title = $_POST['title'];
           $content = $_POST['content'];
                
            // catch the image file
            $image = $_FILES['image'];
            // get image file name
            $image_name = $image['name'];

        // add image to the uploads folder
        if ( !empty( $image_name ) ) {
            // target the uploads folder
            $target_dir = "uploads/";
            // add the image name to the uploads folder
            $target_file = $target_dir . basename( $image_name ); // output: uploads/fs.jpg
            // move the file to the uploads folder
            move_uploaded_file( $image["tmp_name"], $target_file );
        }

            if ( empty( $title ) || empty($content) ) {
                $error = 'All fields are required';
            }
        
            if( isset ($error)){
                $_SESSION['error'] = $error;
                header("Location: /manage-posts-add");    
                exit;
            }

            
                $sql = "INSERT INTO posts (`title`, `content`, `image`, `user_id`)
                VALUES(:title, :content, :image, :user_id)";
               $database->insert($sql , [
                    'title' => $title,
                    'content' => $content,
                    'image' => ( !empty( $image_name ) ? $image_name : null ), // if there is an image, put it to db. If not, set null
                    'user_id' => $_SESSION["user"]["id"]
                ]);
        
                $_SESSION["success"] = "New posts has been created.";
                $_SESSION['new_post'] = $title;
                header("Location: /manage-posts");
                exit;
        
    }

    public static function edit()
    {
        if ( !Auth::isUserLoggedIn() ) {
            header("Location: /");
            exit;
          }
        
          $database = new DB();

        
            $title = $_POST['title'];
            $content = $_POST['content'];
            $status = $_POST['status'];
            $original_image = $_POST['original_image'];
            $id = $_POST['id'];

            // catch the image file
            $image = $_FILES['image'];
            // get image file name
            $image_name = $image['name'];

        // add image to the uploads folder
        if ( !empty( $image_name ) ) {
            // target the uploads folder
            $target_dir = "uploads/";
            // add the image name to the uploads folder
            $target_file = $target_dir . basename( $image_name ); // output: uploads/fs.jpg
            // move the file to the uploads folder
            move_uploaded_file( $image["tmp_name"], $target_file );
        }
        
        
            if(empty($title) || empty($content) || empty($status)){
                $error = "Make sure all the fields are filled.";
            }
            
            if ( isset( $error ) ) {
                $_SESSION['error'] = $error;
                header("Location: /manage-posts-edit?id=$id");
                exit;
            }
            
        

            $database->update(
                "UPDATE posts 
                SET title = :title, 
                content = :content,
                image = :image,
                status = :status, 
                modified_by = :modified_by
                 WHERE id = :id",
                [
                'title' => $title,
                'content' => $content,
                'image' => ( !empty( $image_name ) ? $image_name : ( !empty( $original_image ) ? $original_image : null ) ),
                'status' => $status,
                'id' => $id,
                'modified_by' => $_SESSION["user"]['id']
            ]);
        
        
            // set success message
            $_SESSION["success"] = "post has been edited.";
            $_SESSION['update_post'] = $title;
            
            // redirect
            header("Location: /manage-posts");
            exit;
    }

    public static function delete()
    {
        
    if ( !Auth::isUserLoggedIn() ) {
        header("Location: /");
        exit;
    }

    $database = new DB();


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
    $database->delete(
        "DELETE FROM posts WHERE id = :id",
        [
        'id' => $id
    ]);

    // set success message
    $_SESSION["success"] = "Post has been deleted.";

    // redirect
    header("Location: /manage-posts");
    exit;
    }
}