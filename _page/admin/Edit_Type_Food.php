<?php 
session_start();
include('./../../_system/database.php');

$db = new database();
$currentpage = basename(__FILE__);
$db -> secureCheck();
$db -> checkAdmin();
$userid = $_SESSION['userid'];


if(isset($_POST['create_type'])){
    $name_type = $_POST['name_type'];

    $db -> insert("type_foods",['name_ftype' => $name_type]);

    if($db -> query){
        $_SESSION['success'] = "Type Successfully Added";
        header("location:".$_SERVER['REQUEST_URI']);
    }else{
        $_SESSION['error'] = "Type Error Added";
        header("location:".$_SERVER['REQUEST_URI']);
    }
}

if(isset($_POST['edit'])){
    $name_type = $_POST['name_type'];
    $id_type = $_POST['id_type'];

    $db -> update("type_foods",['name_ftype' => $name_type]," id_ftype = $id_type");
    if($db -> query){
        $_SESSION['success'] = "Type Successfully Edited";
        header("location:".$_SERVER['REQUEST_URI']);
    }else{
        $_SESSION['error'] = "Type Error Edited";
        header("location:".$_SERVER['REQUEST_URI']);
    }
}

if(isset($_POST['delete'])){
    $id_type = $_POST['id_type'];

    $db -> delete("type_foods"," id_ftype = $id_type");
    if($db -> query){
        $_SESSION['success'] = "Type Successfully Deleted";
        header("location:".$_SERVER['REQUEST_URI']);
    }else{
        $_SESSION['error'] = "Type Error Deleted";
        header("location:".$_SERVER['REQUEST_URI']);
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
                <?php include('./../components/error.php'); ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Type Name</label>
                        <input type="text" class="form-control" name="name_type" id="exampleInputEmail1"
                            aria-describedby="emailHelp" required>
                    </div>
                    <button type="submit" name="create_type" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="row mt-3">
                <h3>Type Food All</h3>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mange</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $db_new = new database();
                        $db_new -> select("type_foods","*");

                        while($type_food = $db_new -> query -> fetch_object()){
                        ?>
                        <tr>
                            <td><?= $type_food -> id_ftype ?></td>
                            <td><?= $type_food -> name_ftype ?></td>
                            <td><?php include("./../components/modal_edit_type.php") ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!--Main layout-->
</body>


</html>