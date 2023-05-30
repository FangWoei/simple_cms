<?php
if ( !isUserLoggedIn() ) {
  header("Location: /");
  exit;
}
if ( isset( $_GET['id'] ) ) {
  $database = connectToDB();

  $sql = "SELECT * FROM posts WHERE id = :id";
  $query = $database->prepare( $sql );
  $query->execute([
    'id' => $_GET['id']
  ]);
  $posts = $query->fetch();



} else {
  header("Location: /manage-posts");
  exit;
}

  require "parts/header.php";

?>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Edit Post</h1>
      </div>
      <div class="card mb-2 p-4">
      <?php require "parts/error.php"; ?>
        <form
        method="POST"
        action="/posts/edit">
          <div class="mb-3">
            <label for="post-title" class="form-label">Title</label>
            <input
              type="text"
              class="form-control"
              id="post-title"
              name="title"
              value="<?= $posts['title']; ?>"
            />
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Content</label>
            <textarea class="form-control" id="post-content" rows="10" name="content"><?= $posts['content']; ?></textarea>
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Status</label>
            <select class="form-control" id="post-status" name="status">
              <option value="pending" <?= $posts['status'] === 'pending' ? 'selected' : ''; ?>>Pending for Review</option>
              <option value="publish" <?= $posts['status'] === 'publish' ? 'selected' : ''; ?>>Publish</option>
            </select>
          </div>
          <div class="text-end">
          <input type="hidden" name="id" value="<?= $posts['id']; ?>" />
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a href="/manage-posts" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Posts</a
        >
      </div>
    </div>

<?php

require "parts/footer.php";

?>