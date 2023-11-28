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
if (isset($_POST["add_contact"])) {
    $user_ID = $_SESSION["ID"];
    $cont_name = $_POST["cont_name"];
    $cont_email = $_POST["cont_email"];
    $cont_num = $_POST["cont_num"];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    $add_cont = "INSERT INTO cont values(null,'$cont_num','$cont_name','$targetFile','$cont_email','$user_ID')";
    $add_cont_qu = mysqli_query($connection, $add_cont);
    if ($add_cont_qu) {
        header("location:home.php");
    }
}

if (isset($_GET["edit"])) {
    global $ID;
    $ID = $_GET["edit"];
    $get_cont = "SELECT * FROM cont WHERE cont_id='$ID'";
    $get_cont_qu = mysqli_query($connection, $get_cont);
}

if (isset($_POST["update_contact"])) {
    // $user_ID=$_SESSION["ID"];
    $cont_ID = $ID;
    $cont_name = $_POST["cont_name"];
    $cont_email = $_POST["cont_email"];
    $cont_num = $_POST["cont_num"];
    // echo $_POST["image"];
    // echo "<pre>";
    // print_r($_FILES["image"]);
    // echo "</pre>";
    if (!empty($_FILES["cont_img"]["name"])) {
        // $image = $_POST["cont_img"];
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["cont_img"]["name"]);
        move_uploaded_file($_FILES["cont_img"]["tmp_name"], $targetFile);
        $update_cont = "UPDATE cont SET cont_name='$cont_name',cont_num='$cont_num',cont_email='$cont_email',
        cont_img='$targetFile' WHERE cont_id='$cont_ID'";
        $update_cont_qu = mysqli_query($connection, $update_cont);
        if ($update_cont_qu) {
            header("location:home.php");
        }
    } else {
        $update_cont = "UPDATE cont SET cont_name='$cont_name',cont_num='$cont_num',cont_email='$cont_email'
        WHERE cont_id='$cont_ID'";
        $update_cont_qu = mysqli_query($connection, $update_cont);
        if ($update_cont_qu) {
            header("location:home.php");
        }
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
                <input class="form-control" type="text" placeholder="Search by contact name" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div> -->
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
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
                    <?php
                    if (isset($_GET["edit"])) { ?>
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Update contact</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" enctype="multipart/form-data">
                                            <?php foreach ($get_cont_qu as $row) { ?>
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" value="<?php echo $row['cont_name'] ?>" id="inputName" type="text" name="cont_name" placeholder="Contact Name" />
                                                    <label for="inputName">Contact Name</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" value="<?php echo $row['cont_num'] ?>" id="inputNum" type="text" name="cont_num" placeholder="Contact Number" />
                                                    <label for="inputNum">Contact Number</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" value="<?php echo $row['cont_email'] ?>" id="inputEmail" type="email" name="cont_email" placeholder="name@example.com" />
                                                    <label for="inputEmail">Email address</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <!-- <label for="inputImage">Profile Image</label> -->
                                                    <?php $filePath = $row['cont_img'];
                                                    echo "<img src='$filePath' width=70px height=70px >";
                                                    ?>
                                                    <input class="form" type="file" name="cont_img" id="inputImage">
                                                    <!-- <input class="form-control" id="inputEmail" type="" placeholder="name@example.com" /> -->
                                                </div>
                                                <div class="mt-4 mb-0">
                                                    <!-- <div class="d-grid"><a class="btn btn-primary" href="user.php?update=><input type="submit" name="update_contact" hidden>Update Contact</a> -->
                                                    <!-- <input type="submit" name="update_contact" class="btn btn-primary btn-block" value="Create Contact"></div> -->
                                                    <div class="d-grid"><input type="submit" name="update_contact" class="btn btn-primary btn-block" value="Update Contact"></div>

                                                </div>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else {
                    ?>

                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Create contact</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputName" type="text" name="cont_name" placeholder="Contact Name" />
                                                <label for="inputName">Contact Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputNum" type="text" name="cont_num" placeholder="Contact Number" />
                                                <label for="inputNum">Contact Number</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="cont_email" placeholder="name@example.com" />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <!-- <label for="inputImage">Profile Image</label> -->
                                                <input class="form" type="file" name="cont_img" id="inputImage">
                                                <!-- <input class="form-control" id="inputEmail" type="" placeholder="name@example.com" /> -->
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><input type="submit" name="add_contact" class="btn btn-primary btn-block" value="Create Contact"></div>
                                                <!-- <div class="d-grid"><a class="btn btn-primary btn-block" >Create Contact</a></div> -->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <script src="js/scripts.js"></script>
        <script src="js/bootstap.js"></script>
</body>

</html>