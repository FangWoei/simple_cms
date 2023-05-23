<?php if ( isset( $_SESSION['error'] ) ) : ?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION['error']; ?>
        <?php
            // once it's printed, you delete the session
            unset( $_SESSION['error'] );
        ?>
    </div>
<?php endif; ?>