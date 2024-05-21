
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="dashboard.php">Admin</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto mr-md-0 my-2 mr-md-3">
        <li class="nav-item dropdown my-2 mx-2">
            <a class="nav-link dropdown-toggle mt-2" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw pr-2"></i><?php
                    if(isset($_SESSION['id_admin'])){
                        echo ucwords($_SESSION['username_admin']);
                    }
                ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">Profil</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="index.php">Keluar</a>
            </div>
        </li>
    </ul>
</nav>