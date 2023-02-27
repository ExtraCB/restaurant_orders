<?php 

$menu = ["Homepage","History_Order"];

$profile = new database();
$userid = $_SESSION['userid'];
$profile -> select("users","*"," id_user = $userid");
$myself = $profile -> query -> fetch_assoc();
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-2 mt-lg-0" href="#">
                Restaurant Management
            </a>
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                foreach($menu as $val) { 
                    $filename = $val.".php";
                    ?>
                <li class="nav-item ">
                    <a class="nav-link <?= ($currentpage == $filename) ? 'active' : '' ?>"
                        href="./../user/<?= $filename; ?>"><?= $val; ?></a>
                </li>
                <?php }
                ?>
            </ul>
            <!-- Left links -->
        </div>
        <!-- Collapsible wrapper -->

        <!-- Right elements -->
        <div class="d-flex align-items-center">
            <!-- Icon -->
            <a class="link-secondary me-3" href="#">
                <i class="fas fa-shopping-cart"></i>
            </a>
            <!-- Avatar -->
            <?php include('./../components/avartar.php') ?>
        </div>
        <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->