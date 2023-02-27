<?php 
session_start();
include('./../../_system/database.php');

$db = new database();
$currentpage = basename(__FILE__);
$db -> secureCheck();
$userid = $_SESSION['userid'];



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <script defer src="./../../style/js/bootstrap.bundle.js"></script>
    <script src="./../../style/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./../../style/css/bootstrap.css">


</head>

<body>
    <!--Main Navigation-->
    <header>
        <?php  include('./../components/navbar_user.php'); ?>
    </header>
    <!--Main layout-->
    <main style="margin-top: 58px;">
        <div class="container pt-4">
            <div class="row">
                <?php  include('./../components/error.php'); ?>

            </div>
            <div class="row row-cols-1">
                <?php 
                $db -> select("order_detail,foods,users","*","own_ord = $userid AND f_ord = id_f");
                while($fetch_history = $db -> query -> fetch_object()){
                ?>
                <div class="col">
                    <div class="card mb-3">
                        <img src="./../../file/<?= $fetch_history -> file_f ?>" class="card-img-top" alt="..."
                            style="height:250px;width:100%;object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $fetch_history -> name_f ?></h5>
                            <p class="card-text">Quantity : <?=  $fetch_history -> quantity_ord ?></p>
                            <p class="card-text">Price :
                                <?= $fetch_history -> price_f * $fetch_history -> quantity_ord ?></p>
                            <p class="card-text"><small class="text-muted">Date :
                                    <?= $fetch_history -> timestamp_ord ?></small></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>
</body>


</html>