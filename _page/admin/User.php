<?php 
session_start();
include('./../../_system/database.php');

$db = new database();
$currentpage = basename(__FILE__);
$db -> secureCheck();
$db -> checkAdmin();
$userid = $_SESSION['userid'];


$countall = new database();
$countall -> select("users","COUNT(id_user) as sum","status_user = 1 AND type_user = 1");
$sum1 = $countall -> query -> fetch_assoc();

$countperson = new database();
$countperson -> select("users","COUNT(id_user) as sum","status_user = 0");
$sum2 = $countperson -> query -> fetch_assoc();


$countdept = new database();
$countdept -> select("users","COUNT(id_user) as sum","status_user = 3");
$sum3 = $countdept -> query -> fetch_assoc();


if(isset($_GET['notactive'])){
    $usrid = $_GET['id'];
    
    $db -> update("users",['status_user' => 3],"id_user = $usrid");

    if($db -> query){
        $_SESSION['success'] = "Deactiveted Successfully !";
        header('location:User.php');
    return;
    }else{
        $_SESSION['error'] = "Deactiveted Failed !";
        header('location:User.php');
    return;
    }
}

if(isset($_GET['active'])){
    $usrid = $_GET['id'];
    
    $db -> update("users",['status_user' => 1],"id_user = $usrid");

    if($db -> query){
        $_SESSION['success'] = "Activeted Successfully !";
        header('location:User.php');
        return;
    }else{
        $_SESSION['error'] = "Activeted Failed !";
        header('location:User.php');
        return;
    }
    return;
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
        <?php include('./../components/sidebar.php') ?>
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main style="margin-top: 58px;">
        <div class="container pt-4">

            <!-- card show stats -->
            <div class="row">
                <?php include('./../components/error.php') ?>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        ผู้ใช้งานทั้งหมดในระบบ </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum1['sum'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        ผู้ใช้งานที่รอการอนุมัติ</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum2['sum'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        ผู้ใช้งานที่ถูกยกเลิก</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum3['sum'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- tab controller -->
                <ul class="nav nav-tabs nav-fill mb-3" id="navtab1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#tabs1" class="nav-link active" id="tab1" data-bs-toggle="tab" role="tab"
                            aria-controls="tabs1" aria-selected="true">ผู้ใช้งานทั้งหมดในระบบ</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs2" class="nav-link " id="tab2" data-bs-toggle="tab" role="tab"
                            aria-controls="tabs2" aria-selected="true">
                            ผู้ใช้งานที่รอการอนุมัติ
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs3" class="nav-link " id="tab3" data-bs-toggle="tab" role="tab"
                            aria-controls="tabs3" aria-selected="true">
                            ผู้ใช้งานที่ถูกยกเลิก
                        </a>
                    </li>
                </ul>

                <!-- tab1 -->
                <div class="tab-content" id="tab-content">
                    <div class="tab-pane fade show active" id="tabs1" role="tabpanel" aria-labelledby="tab1">
                        <table class="table align-middle mb-0 bg-white">
                            <thead class="bg-light">
                                <tr>
                                    <th>ชื่อ</th>
                                    <th>วันที่สมัคร</th>
                                    <th>แผนก</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $db1 = new database();
                                $db1 -> select("users","*","status_user = 1 AND type_user = 1");
                                while($personactive = $db1 -> query -> fetch_object()){
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="./../../file/<?= $personactive -> file_user ?>" alt=""
                                                style="width: 45px; height: 45px" class="rounded-circle" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1"><?= $personactive -> username_user ?></p>
                                                <p class="text-muted mb-0">
                                                    <?= $personactive -> fname_user.'  '.$personactive -> lname_user ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1"><?= $personactive -> timestamp_user ?></p>
                                    </td>
                                    <td><a href="./User.php?id=<?= $personactive -> id_user?>&notactive=1"
                                            class="nav-link">Deactive</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- tab2 -->
                    <div class="tab-pane fade" id="tabs2" role="tabpanel" aria-labelledby="tab2">
                        <table class="table align-middle mb-0 bg-white">
                            <thead class="bg-light">
                                <tr>
                                    <th>ชื่อ</th>
                                    <th>วันที่สมัคร</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $db1 = new database();
                                $db1 -> select("users","*","status_user = 0 AND type_user = 1");
                                while($personwait = $db1 -> query -> fetch_object()){
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="./../../file/<?= $personwait -> file_user ?>" alt=""
                                                style="width: 45px; height: 45px" class="rounded-circle" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1"><?= $personwait -> username_user ?></p>
                                                <p class="text-muted mb-0">
                                                    <?= $personwait -> fname_user.'  '.$personwait -> lname_user ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1"><?= $personwait -> timestamp_user ?></p>
                                    </td>
                                    <td><a href="./User.php?id=<?= $personwait -> id_user?>&active=1"
                                            class="nav-link">Active</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- tab3 -->
                    <div class="tab-pane fade" id="tabs3" role="tabpanel" aria-labelledby="tab3">
                        <table class="table align-middle mb-0 bg-white">
                            <thead class="bg-light">
                                <tr>
                                    <th>ชื่อ</th>
                                    <th>วันที่สมัคร</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $db1 = new database();
                                $db1 -> select("users","*","status_user = 3 AND type_user = 1 ");
                                while($personnoactive = $db1 -> query -> fetch_object()){
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="./../../file/<?= $personnoactive -> file_user ?>" alt=""
                                                style="width: 45px; height: 45px" class="rounded-circle" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1"><?= $personnoactive -> username_user ?></p>
                                                <p class="text-muted mb-0">
                                                    <?= $personnoactive -> fname_user.'  '.$personnoactive -> lname_user ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1"><?= $personnoactive -> timestamp_user ?></p>
                                    </td>
                                    <td><a href="./User.php?id=<?= $personnoactive -> id_user?>&active=1"
                                            class="nav-link">active</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Main layout-->
</body>


</html>