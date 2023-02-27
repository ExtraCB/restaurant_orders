<?php if (isset($_SESSION['success'])) { ?>
<div class='alert alert-success py-2'>
    <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
    ?>
</div>
<?php } ?>
<?php if (isset($_SESSION['error'])) { ?>
<div class='alert alert-danger py-2'>
    <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
    ?>
</div>
<?php } ?>