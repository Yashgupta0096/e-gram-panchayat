<?php
// Include required files and set error reporting
error_reporting(E_ALL);
include 'conn.php';
include 'auth.php';

$a = 3;


$edit = isset($_GET['edit']) ? $_GET['edit'] : '';

if ($edit !== '') {
    $resultt = mysqli_query($con, "SELECT * FROM death WHERE id=" . $edit);
    $roww = mysqli_fetch_array($resultt);
}

if (isset($_POST['publise'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $dateofde = $_POST['dateofde'];

    // Process image upload
    if ($_FILES['lis_img']['name'] !== '') {
        $lis_img = rand() . $_FILES['lis_img']['name'];
        $tempname = $_FILES['lis_img']['tmp_name'];
        $folder = "images/death/" . $lis_img;
        move_uploaded_file($tempname, $folder);
    } else {
        $lis_img = $roww["img"];
    }

    

    if ($edit === '') {
        // Insert data into the database using prepared statement
        $stmt = $conn->prepare("INSERT INTO `death`( `name`, `dateofde`, `img`) VALUES (?, ?, ?)");
        $stmt = $conn->prepare("INSERT INTO `death`( `name`, `dateofde`, `img`) VALUES (?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $dateofde, $lis_img);
        $stmt->execute();
        $stmt->close();

        

        echo "<script>alert('Posted Successfully');</script>";
        echo "<script>window.location.href = 'add-death.php'</script>";
    } else {
        // Update data in the database using prepared statement
        $stmt = $conn->prepare("UPDATE death SET name=?, gender=?, dateofde=?, time=?, death=?, reason=?, img=? WHERE id=?");
        $stmt->bind_param("sssssssi", $name, $gender, $dateofde, $time, $age, $reason, $lis_img, $edit);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Updated Successfully');</script>";
        echo "<script>window.location.href = 'add-death.php'</script>";
    }

    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include"title.php"; ?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include"topbar.php"; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include"sidebar.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Apply death</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="view-death.php" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i> View death</a>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-8">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="card card-outline card-info">

                            <div class="card-header">
                                <div class="form-group">
                                    <label>Enter name</label>
                                    <input name="name" value="<?php echo htmlspecialchars($roww["name"]); ?>" type="text" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>

                            <div class="card-body pad">
                                <label>Date of death</label>
                                <div class="mb-3">
                                    <input name="dateofde" value="<?php echo htmlspecialchars($roww["dateofde"]); ?>" type="date" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>

                            <!-- Other card-body elements... -->

                            <div class="card-header">
                                <div class="form-group">
                                    <label for="exampleInputFile">Select Img<span style="color:red;">(only compressed)</span></label>
                                    <p style="color:red;">img size 800px x 500px</p>
                                    <input name="lis_img" type="file" required>
                                    <?php echo htmlspecialchars($roww["img"]); ?>
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

    <!-- Include footer and other scripts -->
    <?php include "footer.php"; ?>

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
        $('.textarea').summernote()
    })
</script>
</body>
</html>
