<?php
error_reporting(0);
include 'conn.php';
include 'auth.php';

$a = 3;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include "title.php"; ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include "topbar.php"; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "sidebar.php"; ?>

  <?php
  $edit = isset($_GET['edit']) ? $_GET['edit'] : '';

  if ($edit) {
    $resultt = mysqli_query($con, "SELECT * FROM income WHERE id=" . $edit);
    $roww = mysqli_fetch_array($resultt);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['publise'])) {
    $name = $_POST['name'];
    $Gender = $_POST['Gender'];
    $issue_date = $_POST['issue_date'];
    $issue_for = $_POST['issue_for'];
    $Income = $_POST['Income'];
    $aadhar = $_POST['aadhar'];

    $lis_img = $roww["img"];

    if ($_FILES['lis_img']['name'] !== '') {
      $lis_img = rand() . $_FILES['lis_img']['name'];
      move_uploaded_file($_FILES['lis_img']['tmp_name'], "images/income/" . $lis_img);
    }

    if (empty($edit)) {
      move_uploaded_file($tempname, $folder);

      $insertdata = mysqli_query($con, "INSERT INTO `income`(`name`, `Gender`, `issue_date`, `issue_for`, `Income`, `aadhar`, `img`)
      VALUES('$name', '$Gender', '$issue_date', '$issue_for', '$Income', '$aadhar', '$lis_img')");

      echo "<script>alert('Posted Successfully');</script>";
      echo "<script>window.location.href = 'add-income.php'</script>";
    } else {
      $insertdata = mysqli_query($con, "UPDATE income SET name='$name', Gender='$Gender', issue_date='$issue_date',
      issue_for='$issue_for', Income='$Income', aadhar='$aadhar', img='$lis_img' WHERE id=" . $edit);

      echo "<script>alert('Updated Successfully');</script>";
      echo "<script>window.location.href = 'add-income.php'</script>";
    }
  }
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Apply income</h1>
          </div>
          <div class="col-sm-6">
            <a href="view-income.php" class="btn btn-success">
              <i class="fa fa-eye" aria-hidden="true"></i> View income
            </a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          <form action="" method="post" enctype="multipart/form-data">
            <div class="card card-outline card-info">
              <div class="card-header">
                <div class="form-group">
                  <label>Enter name</label>
                  <input name="name" value="<?php echo isset($roww["name"]) ? $roww["name"] : ''; ?>" type="text" class="form-control" placeholder="Enter ...">
                </div>
              </div>

              <div class="card-body pad">
                <label>Gender</label>
                <div class="mb-3">
                  <input name="Gender" value="<?php echo isset($roww["Gender"]) ? $roww["Gender"] : ''; ?>" type="text" class="form-control" placeholder="Enter ...">
                </div>
              </div>

              <div class="card-body pad">
                <label>issue date</label>
                <div class="mb-3">
                  <input name="issue_date" value="<?php echo isset($roww["issue_date"]) ? $roww["issue_date"] : ''; ?>" type="date" class="form-control" placeholder="Enter ...">
                </div>
              </div>

              <div class="card-body pad">
                <label>issue for</label>
                <div class="mb-3">
                  <input name="issue_for" value="<?php echo isset($roww["issue_for"]) ? $roww["issue_for"] : ''; ?>" type="text" class="form-control" placeholder="Enter ...">
                </div>
              </div>

              <div class="card-body pad">
                <label>Income</label>
                <div class="mb-3">
                  <input name="Income" value="<?php echo isset($roww["Income"]) ? $roww["Income"] : ''; ?>" type="number" class="form-control" placeholder="Enter ...">
                </div>
              </div>

              <div class="card-body pad">
                <label>aadhar</label>
                <div class="mb-3">
                  <input name="aadhar" value="<?php echo isset($roww["aadhar"]) ? $roww["aadhar"] : ''; ?>" type="number" class="form-control" placeholder="Enter ...">
                </div>
              </div>

              <div class="card-header">
                <div class="form-group">
                  <label for="exampleInputFile">Select Img<span style="color:red;">(only compressed)</span></label>
                  <p style="color:red;">img size 800px x 500px</p>
                  <input name="lis_img" type="file" required>
                  <?php echo isset($roww["img"]) ? $roww["img"] : ''; ?>
                </div>
              </div>

              <div class="card-header">
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <button type="submit" name="publise" class="btn btn-block btn-warning btn-lg">Post</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include "footer.php"; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote();
  });
</script>
</body>
</html>
