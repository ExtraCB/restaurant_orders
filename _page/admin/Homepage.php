<?php 
session_start();
include('./../../_system/database.php');

$db = new database();
$currentpage = basename(__FILE__);
$db -> secureCheck();
$db -> checkAdmin();
$userid = $_SESSION['userid'];


$datecurrent = date("Y-m-d");
$monthcurrent = date("Y-m");

$dbsum = new database();
$dbsum -> select("order_detail,foods","SUM(quantity_ord * price_f) as sum","f_ord = id_f");
$fetchsum = $dbsum -> query -> fetch_assoc();

$dbsum2 = new database();
$dbsum2 -> select("order_detail,foods","SUM(quantity_ord * price_f) as sum","f_ord = id_f AND timestamp_ord LIKE '%$datecurrent%'");
$fetchsum2 = $dbsum2 -> query -> fetch_assoc();

$dbsum3 = new database();
$dbsum3 -> select("order_detail,foods","SUM(quantity_ord * price_f) as sum","f_ord = id_f AND timestamp_ord LIKE '%$monthcurrent%'");
$fetchsum3 = $dbsum3 -> query -> fetch_assoc();





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

            <!-- card show stats -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        ยอดขายทั้งหมด </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $fetchsum['sum'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        ยอดขายวันนี้</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $fetchsum2['sum'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        ยอดขายในเดือนนี้</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $fetchsum3['sum'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Food All -->
            <div class="row">
                <?php 
                $dbdate = new database();
                $dbdate -> selectgb("order_detail","timestamp_ord as date","ORDER BY (timestamp_ord)");

                while($fetch_date = $dbdate -> query ->fetch_object()){
                    $date = $fetch_date -> date;
                ?>
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne<?=$date ?>" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                                <?= $date ?>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne<?=$date ?>" class="accordion-collapse collapse"
                            aria-labelledby="headingOne">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Food</th>
                                            <th>Customer</th>
                                            <th>Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $dborder = new database();
                                        $dborder -> select("order_detail,foods,users,type_foods","id_ord,file_f,name_f,price_f,file_user,username_user,fname_user,lname_user,name_ftype,SUM(price_f * quantity_ord) as sum","f_ord = id_f AND type_f = id_ftype AND own_ord = id_user AND timestamp_ord LIKE '%$date%'");
                                        while($fetch_order = $dborder -> query -> fetch_object()){
                                        ?>
                                        <tr>
                                            <td><?= $fetch_order->id_ord ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="./../../file/<?= $fetch_order -> file_f ?>" alt=""
                                                        style="width: 45px; height: 45px" class="rounded-circle" />
                                                    <div class="ms-3">
                                                        <p class="fw-bold mb-1"><?= $fetch_order -> name_f ?></p>
                                                        <p class="text-muted mb-0">
                                                            <?= $fetch_order -> name_ftype ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="./../../file/<?= $fetch_order -> file_user ?>" alt=""
                                                        style="width: 45px; height: 45px" class="rounded-circle" />
                                                    <div class="ms-3">
                                                        <p class="fw-bold mb-1"><?= $fetch_order -> username_user ?></p>
                                                        <p class="text-muted mb-0">
                                                            <?= $fetch_order -> fname_user.'  '.$fetch_order -> lname_user ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?= $fetch_order -> sum ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </main>
    <!--Main layout-->
</body>


</html>