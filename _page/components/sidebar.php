<?php 
$menu = ["Homepage","User","Edit_Type_Food","Add_Food"];
?>
<!-- Sidebar -->
<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
            <?php foreach($menu as $val){ 
                $filename = $val.".php";
                ?>
            <a href="./../admin/<?= $filename ?>"
                class="list-group-item list-group-item-action py-2 ripple <?= ($currentpage == $filename) ? "active" : "" ?>">
                <i class=""></i><span><?= $val ?></span>
            </a>
            <?php } ?>
        </div>
    </div>
</nav>
<!-- Sidebar -->

<!-- Navbar -->
<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
            aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand" href="#">
            Restaurant
        </a>
        <!-- Search form -->
        <form class="d-none d-md-flex input-group w-auto my-auto">
            <input autocomplete="off" type="search" class="form-control rounded"
                placeholder='Search (ctrl + "/" to focus)' style="min-width: 225px;" />
            <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
        </form>

        <!-- Right links -->
        <ul class="navbar-nav ms-auto d-flex flex-row">

            <!-- Avatar -->
            <?php include('./../components/avartar.php') ?>
        </ul>
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->