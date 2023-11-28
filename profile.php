<?php
$host = "localhost";
$user = "root";
$dp = "bcm_system";
$connection = mysqli_connect($host, $user, "", $dp);

session_start();
if (!(isset($_SESSION["email"]))) {
    header("location:index.php");
}
if (isset($_POST["logout"])) {
    session_destroy();
    header("location:index.php");
}
if (isset($_POST["update"])) {
    $ID = $_SESSION["ID"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $info = $_POST['info'];
    // UPDATE `users` SET `ID`='[value-1]',`username`='[value-2]',`phone`='[value-3]',
    // `address`='[value-4]',`email`='[value-5]',`password`='[value-6]' WHERE 1
    $update_data = " UPDATE users set username='$username',phone='$phone',address='$address',email='$email',info='$info' where 
    ID='$ID'";
    $update_data_qu = mysqli_query($connection, $update_data);
    if ($update_data_qu) {
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION["address"] = $address;
        $_SESSION["phone"] = $phone;
        $_SESSION['address'] =$address;
        $_SESSION['info'] = $info;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootsrap.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css" />
    <title>Document</title>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home.php">BCM System</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <!-- <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div> -->
        </form>
        <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <!-- <li><a class="dropdown-item" href="#!">Activity Log</a></li>
            <li>
                <hr class="dropdown-divider" />
            </li> -->
                        <form action="" method="post">
                            <li><input type="submit" class="dropdown-item" value="Logut" name="logout"></li>
                        </form>
                    </ul>
                </li>
            </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="home.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="profile.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Profile
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION["username"]; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <div class="container">
                <div class="main-body">

                    <!-- Breadcrumb -->
                    <!-- /Breadcrumb -->

                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                                        <div class="mt-3">
                                            <h4><?php echo $_SESSION["username"]; ?></h4>
                                            <p class="text-secondary mb-1"><?php echo $_SESSION["info"]; ?></p>
                                            <p class="text-muted font-size-sm"><?php echo $_SESSION["address"]; ?></p>
                                            <!-- <button class="btn btn-primary">Follow</button>
                                            <button class="btn btn-outline-primary">Message</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Full Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="username" value="<?php echo $_SESSION["username"]; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="email" value="<?php echo $_SESSION["email"]; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Phone</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="phone" value="<?php echo $_SESSION["phone"]; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Address</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="address" value="<?php echo $_SESSION["address"]; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Info</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="info" value="<?php echo $_SESSION["info"]; ?>">
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="submit" class="btn btn-primary px-4" name="update" value="Save Changes">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/scripts.js"></script>
        <script src="js/bootstap.js"></script>
</body>

</html>