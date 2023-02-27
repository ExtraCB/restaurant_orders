<?php 
session_start();

include('./../../_system/database.php');

$db = new database();
$currentpage = basename(__FILE__);
$db -> secureCheck();

$userid = $_SESSION['userid'];
$db -> select("users","*"," id_user = $userid");
$myself = $db -> query -> fetch_assoc();


if(isset($_POST['edit_profile'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $file = $_FILES['file'];
    $fileold = $_POST['fileold'];
    
    if($file['name'] != ''){
        $fileNew = $db -> uploadFile($file);
    }else{
        $fileNew = $fileold;
    }
    
    $data = [
        'fname_user' => $fname,
        'lname_user' => $lname,
        'address_user' => $address,
        'tel_user' => $tel,
        'file_user' => $fileNew,
    ];

    $db -> update("users",$data," id_user = $userid");

    if($db -> query){
        $_SESSION['success'] = "Edit Success";
        header('location:'.$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['error'] = "Edit Error";
        header('location:'.$_SERVER['REQUEST_URI']);
        return;
    }
    
}



if(isset($_POST['edit_password'])){
    $pass_old = $_POST['password_old'];
    $pass_new = $_POST['password_new'];
    $pass_con = $_POST['password_confirm'];

    $data = ['password_user' => $pass_con];

    if($pass_new == $pass_con){
        $db -> update("users",$data," id_user = $userid AND password_user = $pass_old");
        if($db -> mysqli -> affected_rows > 0){
            $_SESSION['success'] = "Edit Success";
            header('location:'.$_SERVER['REQUEST_URI']);
            return;
        }else{
            $_SESSION['error'] = "Password Current is Wrong !";
            header('location:'.$_SERVER['REQUEST_URI']);
            return;
        }
    }else{
        $_SESSION['error'] = "Password and Password Confirm not match !";
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
    <script defer src="./../../style/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./../../style/css/bootstrap.css">
    <?php  
        if($_SESSION['type'] == 'admin'){ ?>
    <link rel="stylesheet" href="./../../style/css/admin_hp.css">
    <?php } ?>


</head>

<body>
    <!--Main Navigation-->
    <header>
        <?php  
        if($_SESSION['type'] == 'admin'){
            include('./../components/sidebar.php'); 
            
        }else{
            include('./../components/navbar_user.php'); 
        }
        ?>
    </header>
    <!--Main layout-->
    <main style="margin-top: 58px;">
        <div class="container pt-4">

            <div class="row">
                <?php 
                include("./../components/error.php");
                ?>
                <!-- tab controller -->
                <ul class="nav nav-tabs nav-fill mb-3" id="navtab1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#tabs1" class="nav-link active" id="tab1" data-bs-toggle="tab" role="tab"
                            aria-controls="tabs1" aria-selected="true">แก้ไขโปรไฟล์</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs2" class="nav-link " id="tab2" data-bs-toggle="tab" role="tab"
                            aria-controls="tabs2" aria-selected="true">
                            แก้ไขรหัสผ่าน
                        </a>
                    </li>
                </ul>

                <!-- tab1 -->
                <div class="tab-content" id="tab-content">
                    <div class="tab-pane fade show active" id="tabs1" role="tabpanel" aria-labelledby="tab1">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-6">
                                <!-- Default form login -->
                                <form class=" border border-light p-5" action="" method="post"
                                    enctype="multipart/form-data">

                                    <p class="h4 mb-4 text-center">Edit Profile</p>

                                    <!-- Firstname -->
                                    <label for="" class="form-label">Firstname</label>
                                    <input type="text" id="defaultLoginFormEmail" class="form-control mb-4" name="fname"
                                        placeholder="Firstname" value="<?= $myself['fname_user'] ?>">

                                    <!-- Lastname -->
                                    <label for="" class="form-label">Lastname</label>
                                    <input type="text" id="defaultLoginFormEmail" class="form-control mb-4" name="lname"
                                        placeholder="Lastname" value="<?= $myself['lname_user'] ?>">

                                    <!-- Tel -->
                                    <label for="" class="form-label">Tel</label>
                                    <input type="text" id="defaultLoginFormPassword" class="form-control mb-4"
                                        name="tel" placeholder="Tel" value="<?= $myself['tel_user'] ?>">

                                    <!-- Address -->
                                    <label for="" class="form-label">Address</label>
                                    <input type="text" id="defaultLoginFormPassword" class="form-control mb-4"
                                        name="address" placeholder="Address" value="<?= $myself['address_user'] ?>">

                                    <!-- Profile -->
                                    <label for="" class="form-label">Profile</label>
                                    <input type="file" id="defaultLoginFormPassword" class="form-control mb-4"
                                        name="file">

                                    <input type="hidden" name="fileold" value="<?= $myself['file_user'] ?>">

                                    <!-- Edit Profile -->
                                    <button class="btn btn-info btn-block my-4 text-white" name="edit_profile"
                                        type="submit">Edit</button>

                                </form>
                            </div>
                            <div class="col-3"></div>
                        </div>
                    </div>
                    <!-- tab2 -->
                    <div class="tab-pane fade" id="tabs2" role="tabpanel" aria-labelledby="tab2">
                        <div class="tab-pane fade show active" id="tabs1" role="tabpanel" aria-labelledby="tab1">
                            <div class="row">
                                <div class="col-3"></div>
                                <div class="col-6">
                                    <!-- Default form login -->
                                    <form class=" border border-light p-5" action="" method="post">

                                        <p class="h4 mb-4 text-center">Edit Password</p>

                                        <!-- Password -->
                                        <label for="" class="form-label">Password</label>
                                        <input type="text" id="defaultLoginFormEmail" class="form-control mb-4"
                                            name="password_old" placeholder="Password">

                                        <!-- Password-New -->
                                        <label for="" class="form-label">Password New</label>
                                        <input type="text" id="defaultLoginFormEmail" class="form-control mb-4"
                                            name="password_new" placeholder="Password New">

                                        <!-- Password-Confirm -->
                                        <label for="" class="form-label">Password Confirm</label>
                                        <input type="text" id="defaultLoginFormPassword" class="form-control mb-4"
                                            name="password_confirm" placeholder="Password Confirm">


                                        <!-- Edit Password -->
                                        <button class="btn btn-info btn-block my-4 text-white" name="edit_password"
                                            type="submit">Edit</button>

                                    </form>
                                </div>
                                <div class="col-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <!--Main layout-->
</body>


</html>