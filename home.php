<?php
session_start();
if (!(isset($_SESSION["email"]))) {
  header("location:index.php");
}
if (isset($_POST["logout"])) {
  session_destroy();
  header("location:index.php");
}
$host = "localhost";
$user = "root";
$dp = "bcm_system";
$connection = mysqli_connect($host, $user, "", $dp);

// $getdata = "SELECT * FROM users";
// $get_qu = mysqli_query($connection, $getdata);


if (isset($_GET["delete"])) {
  $cont_ID = $_GET["delete"];
  $delete_cont = "DELETE FROM cont WHERE cont_id='$cont_ID'";
  $delete_cont_qu = mysqli_query($connection, $delete_cont);
  if ($delete_cont_qu) {
    header("location:home.php");
  }
}
if(isset($_POST["search"])){
  $ID = $_SESSION["ID"];
  $searching_word = $_POST["word"];
  $cont_data = "SELECT * FROM cont WHERE user_id ='$ID' AND cont_name LIKE '%$searching_word%'";
  $cont_data_qu = mysqli_query($connection, $cont_data);

}
else{
  $ID = $_SESSION["ID"];
  $cont_data = "SELECT cont_id, cont_num, cont_name, cont_img, cont_email
  FROM cont WHERE user_id ='$ID'";
  $cont_data_qu = mysqli_query($connection, $cont_data);
  
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
  <script src="js/scripts.js"></script>
  <script src="js/bootstap.js"></script>


  <title>Document</title>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="home.php">BCM System</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form method="post" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" >
      <div class="input-group">
        <input class="form-control" type="text" name="word" placeholder="Search by contact name" aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" id="btnNavbarSearch" type="submit" name="search"><i class="fas fa-search"></i></button>
      </div>
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
      <main>

        <div class="container-fluid px-4">
          <a href="user.php" class="btn btn-primary"> Add new contact</a>
          <table class="table mb-5">
            <thead>
              <tr>
                <th scope="col">No.</th>
                <th scope="col">image</th>
                <th scope="col">Name</th>
                <th scope="col">Number</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>

            <tbody>

              <pre>

              <?php

                // print_r($cont_data_qu);
                ?>
              </pre>
<?php
              if(mysqli_num_rows($cont_data_qu)==0){
                 ?>
                <tr >
                   <td colspan="6"> <p class="text-center"> There are no contacts. </p> </td>
                  </tr>
             <?php die(); }
            //  
              foreach ($cont_data_qu as $row) { ?>
                <tr>

                  <th scope="row">
                    <?php echo $row["cont_id"]; ?>
                  </th>
                  <td>
                    <?php $filePath = $row['cont_img'];
                    echo "<img src='$filePath' width=70px height=70px >";
                    ?>
                  </td>
                  <td><?php echo $row["cont_name"]; ?></td>
                  <td><?php echo $row["cont_num"]; ?></td>
                  <td><?php echo $row["cont_email"]; ?></td>
                  <td>
                    <a class="btn btn-danger" href="home.php?delete=<?php echo $row["cont_id"]; ?>"><button type="submit" class="btn btn-danger">DELETE</button></a>
                    <a class="btn btn-info" href="user.php?edit=<?php echo $row["cont_id"]; ?>"><button type="submit" class="btn btn-info">EDIT</button></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

</body>

</html>