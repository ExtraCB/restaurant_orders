<?php 
session_start();
include('./../../_system/database.php');

$db = new database();
$currentpage = basename(__FILE__);
$db -> secureCheck();
$db -> checkAdmin();
$userid = $_SESSION['userid'];


if(isset($_POST['create'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $file = $_FILES['file'];
    $fileNew = $db -> uploadFile($file);
    $type = $_POST['type'];

    $data = [
        'name_f' => $name,
        'price_f'=> $price,
        'file_f' => $fileNew,
        'type_f' => $type
    ];

    $db -> insert("foods",$data);

    if($db -> query){
        $_SESSION['success'] = "Food Successfully Added";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['error'] = "Food Error Added";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }
}

if(isset($_POST['edit'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $file = $_FILES['file'];
    $fileold = $_POST['fileold'];
    $type = $_POST['type'];
    $id_f = $_POST['id_f'];

    if($file['name'] == ''){
        $fileNew  = $fileold;
    }else{
        $fileNew = $db -> uploadFile($file);
    }

    $data = [
        'name_f' => $name,
        'price_f'=> $price,
        'file_f' => $fileNew,
        'type_f' => $type
    ];

    $db -> update("foods",$data," id_f = $id_f");
    if($db -> query){
        $_SESSION['success'] = "Food Successfully Edited";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['error'] = "Fodd Error Edited";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }
}

if(isset($_POST['delete'])){
    $id_f = $_POST['id_f'];

    $db -> delete("foods"," id_f = $id_f");
    if($db -> query){
        $_SESSION['success'] = "Food Successfully Deleted";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['error'] = "Food Error Deleted";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }
}

if(isset($_POST['disabled'])){
    $id_f = $_POST['id_f'];

    $db -> update("foods",['status_f' => 0],"id_f = $id_f");
    if($db -> query){
        $_SESSION['success'] = "Food Disabled Successfully";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['error'] = "Food Disabled Error ";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }
}

if(isset($_POST['active'])){
    $id_f = $_POST['id_f'];

    $db -> update("foods",['status_f' => 1],"id_f = $id_f");
    if($db -> query){
        $_SESSION['success'] = "Food Activated Successfully";
        header("location:".$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['error'] = "Food Activated Error ";
        header("location:".$_SERVER['REQUEST_URI']);
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
    <title>Admin Page</title>
    <link rel="stylesheet" href="./../../style/css/admin_hp.css">
    <script defer src="./../../style/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./../../style/css/bootstrap.css">


</head>

<body>
    <!--Main Navigation-->
    <header>
        <?php include('./../components/sidebar.php');?>
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main style="margin-top: 58px;">
        <div class="container pt-4">
            <div class="row">
                <h3> Food All</h3>
                <?php include('./../components/error.php'); ?>
                <?php include('./../components/modal_create_food.php');?>
            </div>
            <div class="row p-2 row-cols-1 row-cols-md-4 g-4">
                <?php 
                $db_2 = new database();
                $db_2 -> select("foods,type_foods","*","type_f = id_ftype");
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
                            <?php include('./../components/modal_edit_food.php'); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
    </main>
    <!--Main layout-->
</body>


</html>