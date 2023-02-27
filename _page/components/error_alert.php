<?php if(isset($_SESSION['alert'])){ ?>
<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertText"><?php 
        echo $_SESSION['alert']; 
        unset($_SESSION['alert']);
        ?>
            <br class="clear" /></span>
    </div>
</label>
<?php } ?>