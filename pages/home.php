<?php

$database = connectToDB();

$sql = "SELECT * FROM posts where status = 'publish'";
  $query = $database->prepare($sql);
  $query->execute();
  $posts = $query->fetchAll();

  require "parts/header.php";

?>
    <div class="container mx-auto my-5" style="max-width: 500px;">
      <h1 class="h1 mb-4 text-center">My Blog</h1>
      <?php foreach ($posts as $post) : ?>
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title"><?= $post['title']; ?></h5>
          <p class="card-text">
          <?php 
            $excerpt = str_split( $post['content'], 5 );
            echo $excerpt[0] . "<strong>... read more</strong>"; 
          ?></p>
          </p>
          <div class="text-end">
            <a href="/post?id=<?= $post['id']; ?>" class="btn btn-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

      <div class="mt-4 d-flex justify-content-center gap-3">
      <?php if ( isset( $_SESSION["user"] ) ) { ?>
        <a href="/logout" class="btn btn-link btn-sm">Logout</a>
        <a href="/dashboard" class="btn btn-link btn-sm">dashboard</a>
        <?php } else { ?>
        <a href="/login" class="btn btn-link btn-sm">Login</a>
        <a href="/signup" class="btn btn-link btn-sm">Sign Up</a>
        <?php } ?>
      </div>
    </div>

<?php

require "parts/footer.php";