<?php 
session_start();
include('./../../_system/database.php');

$db = new database();
$currentpage = basename(__FILE__);
$db -> secureCheck();
$userid = $_SESSION['userid'];

if(isset($_POST['order'])){
    $id_f = $_POST['id_f'];
    $count = $_POST['count'];


    $db -> insert("order_detail",['f_ord' => $id_f,'own_ord' => $userid,'quantity_ord' => $count]);
    if($db -> query ){
        $_SESSION['success'] = "Order Successfully";
        header('location:'.$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['error'] = "Order Failed";
        header('location:'.$_SERVER['REQUEST_URI']);
        return;
    }
}
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
            <?php 
            $dbnew1 = new database();
            $dbnew1 -> select("type_foods","*");
            while($type_foods = $dbnew1 -> query -> fetch_object()){
                $type = $type_foods -> id_ftype;
            ?>
            <div class="row">
                <h3><?= $type_foods -> name_ftype ?></h3>
                <div class="row p-2 row-cols-1 row-cols-md-4 g-4">
                    <?php 
                $db_2 = new database();
                $db_2 -> select("foods,type_foods","*","type_f = $type AND type_f = id_ftype AND status_f != 0");
                while($fetch_food = $db_2 -> query -> fetch_object())
                {?>
                    <div class="col">
                        <div class="card">
                            <img src="./../../file/<?= $fetch_food -> file_f ?>" class="card-img-top"
                                alt="Hollywood Sign on The Hill" style="width:100%;height:200px" />
                            <div class="card-body">
                                <h5 class="card-title"><?= $fetch_food -> name_f  ?></h5>
                                <p class="card-text">Price : <?= $fetch_food -> price_f ?></p>
                                <p class="card-text">Type : <?= $fetch_food -> name_ftype ?></p>
                            </div>
                            <div class="card-footer">
                                <form action="" method="post">
                                    <div class="input-group mx-2">
                                        <input type="text" name="count" class="form-control" required>
                                        <input type="hidden" name="id_f" value="<?= $fetch_food -> id_f ?>">
                                        <button type="submit" name="order"
                                            class="btn btn-outline-warning">Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            <?php } ?>
        </div>
    </main>
</body>


</html>