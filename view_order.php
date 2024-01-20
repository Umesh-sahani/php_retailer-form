<?php
session_start();
require("database/dbcon.php");
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
require("config/config.php");
$query = "SELECT * FROM response ORDER BY id DESC";
$result = mysqli_query($con, $query);

// Check if there are records
if ($result) {
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $orders = [];
}

// Close the database connection
mysqli_close($con);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RETAILER DASHBOARD PAGE <?php echo $_SESSION["user_name"];  ?></title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <!-- website icon -->
    <link rel="shortcut icon" href="img/avatar.png" type="image/x-icon">
    <!-- sweet alert  -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Right navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <div class="navbar-nav pl-2">

            </div>

            <?php include("pages/top_nav.php") ?>


        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include("pages/sidebar.inc.php") ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid my-2">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h4>Order List</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="order_form.php" class="btn btn-primary btn-sm">New Order</a>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <form class="form-inline" id="date_filter_form">
                                <div class="form-group mb-2">
                                    <label for="from_date" class="sr-only col-form-label-sm">From : </label>
                                    <input type="text" class="form-control form-control-sm" id="from_date" placeholder="From Date">
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <label for="to_date" class="sr-only">To : </label>
                                    <input type="text" class="form-control form-control-sm" id="to_date" placeholder="To Date">
                                </div>
                                <div class="form-group mb-2">
                                    <button type="submit" class="btn btn-success btn-sm">Search</button>
                                </div>
                            </form>
                            <hr class="p-0 m-0 w-50">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="card-title">
                                    <button type="button" onclick="window.location.href='view_order.php'" class="btn btn-default btn-sm">Reset</button>
                                </div>
                                <div class="card-tools">

                                    <div class="input-group input-group">
                                        <input type="text" name="table_search" id="table_search" class="form-control" placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="card-body table-responsive p-0" style="height: 60vh;">
                            <table class="table table-hover text-nowrap table-bordered table-sm">
                                <thead style="position: sticky;">
                                    <tr>
                                        <th width="50">ID</th>
                                        <th width="70">DATE</th>
                                        <th>USER NAME</th>
                                        <th>WIDHT</th>
                                        <th>COLOR</th>
                                        <th>DESIGN NAME</th>
                                        <th width="60">QUANTITY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orders)) : ?>
                                        <?php foreach ($orders as $key => $order) : ?>
                                            <tr>
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo date('d-M-Y', strtotime($order["timestamp"])); ?></td>
                                                <td><?php echo $order['user_name']; ?></td>
                                                <td><?php echo $order['width']; ?></td>
                                                <td><?php echo $order['color']; ?></td>
                                                <td><?php echo $order['design_name']; ?></td>
                                                <td><?php echo $order['quantity']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <td colspan="6">No Record Found.</td>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="card-footer clearfix">
								<ul class="pagination pagination m-0 float-right">
								  <li class="page-item"><a class="page-link" href="#">«</a></li>
								  <li class="page-item"><a class="page-link" href="#">1</a></li>
								  <li class="page-item"><a class="page-link" href="#">2</a></li>
								  <li class="page-item"><a class="page-link" href="#">3</a></li>
								  <li class="page-item"><a class="page-link" href="#">»</a></li>
								</ul>
							</div> -->
                    </div>
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- include footer page -->
        <?php include("pages/footer.inc.php") ?>

    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="js/adminlte.min.js"></script>
    <!-- sweetalert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- include momnet.js -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            // Attach an input event listener to the search input
            $('#table_search').on('input', function() {
                // Get the entered search value
                var searchText = $(this).val().toLowerCase();
                // Iterate over each row in the table
                $('tbody tr').each(function() {
                    // Check if any of the row's cells contain the search text
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });


            $('#from_date, #to_date').datepicker({
                defaultViewDate: {
                    year: 2024,
                    month: 0,
                    day: 1
                }, // Set the default view date
                format: 'dd-M-yyyy', // Set the desired date format
                autoclose: true // Close the datepicker when a date is selected
            });
            // Set the default date using the 'setDate' option
            $('#from_date, #to_date').datepicker('setDate', '01-Jan-2024');
            $('#to_date').datepicker('setDate', new Date());

            $("#date_filter_form").on("submit", function(e) {
                e.preventDefault();
                const from_date_str = $("#from_date").val();
                const to_date_str = $("#to_date").val();
                // Parse from_date_str and to_date_str to Date objects
                const from_date = new Date(from_date_str);
                const to_date = new Date(to_date_str);
                if (from_date > to_date) {
                    Swal.fire({
                        title: 'Attention!',
                        text: 'From date greater than to date, Correct this.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                if (from_date != "" && to_date != "") {
                    if (!isNaN(from_date.getTime()) && !isNaN(to_date.getTime())) {
                        // Both from_date and to_date are valid dates

                        $('tbody tr').each(function() {
                            var rowDate = $(this).find('td:eq(1)').text();
                            var rowDateObj = new Date(rowDate);

                            // Check if the row's date is greater than or equal to from_date
                            // and less than or equal to to_date
                            if (rowDateObj >= from_date && rowDateObj <= to_date) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    }

                } else {
                    Swal.fire({
                        title: 'Attention!',
                        text: 'Fill Date field.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    })
                }

            });


        });
    </script>
</body>

</html>