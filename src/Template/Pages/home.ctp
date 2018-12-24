<?php if(isset($_SESSION['error']) && $_SESSION['error'] != ''): ?>
    <h2 style="color:#FF0000;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></h2>
<?php endif; ?>
<?php




