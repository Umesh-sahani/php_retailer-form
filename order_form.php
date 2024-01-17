<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
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
                        <div class="col-sm-6">
                            <h4>Order Form</h4>
                        </div>
                        <!-- <div class="col-sm-6 text-right">
                            <a href="dashboard.php" class="btn btn-primary btn-sm">Back</a>
                        </div> -->
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="container-fluid p-0">
                    <form action="" method="post" id="submit_form" name="submit_form">
                        <div class="card p-0">
                            <div class="card-body p-1">
                                <div class="container">
                                    <input type="hidden" name="user_name" value="<?php echo $_SESSION["user_name"]; ?>">

                                    <div class="row">
                                        <div class="col-3">
                                            <label for="width">Width</label>
                                        </div>
                                        <div class="col-3">
                                            <label for="color">Color</label>
                                        </div>
                                        <div class="col-4">
                                            <label for="design_name">Design Name</label>
                                        </div>
                                        <div class="col-2">
                                            <label for="quantity">QTY</label>
                                        </div>
                                    </div>

                                    <div id="inputRows">
                                        <?php for ($i = 0; $i < 5; $i++) { ?>
                                            <div class="row mb-1">
                                                <div class="col-3">
                                                    <input type="text" name="width[]" class="form-control" placeholder="Width">
                                                </div>
                                                <div class="col-3">
                                                    <input type="text" name="color[]" class="form-control" placeholder="Color">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="design_name[]" class="form-control" placeholder="Design Name">
                                                </div>
                                                <div class="col-2">
                                                    <input type="text" name="quantity[]" class="form-control" placeholder="QTY" oninput="validateInput(this)">
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <button type="button" id="addRowBtn" class="btn btn-success btn-sm float-right mt-2">Add Row</button>
                                </div>
                            </div>

                        </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="submit">Create</button>
                    <a href="dashboard.php" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
                </form>

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
    <script>
        $(document).ready(function() {
            $("form").on("submit", async function(e) {
                e.preventDefault();
                var allFormData = [];
                // $("#submit").prop("disabled", true);
                // calling ajax to save record

                // let isValid = true;
                // formData.forEach(record => {
                //     if (record.value == "") {
                //         $(`#${record.name}`).addClass("is-invalid").siblings("p").addClass("invalid-feedback").html("Please Fill this filed.");
                //         isValid = false;
                //     } else {
                //         $(`#${record.name}`).removeClass("is-invalid").siblings("p").removeClass("invalid-feedback").html("");
                //     }
                // });
                // if (!isValid) {
                //     $("#submit").prop("disabled", false);
                //     return;
                // }

                $("#inputRows .input-row").each(function() {
                    var formData = {
                        width: $(this).find("input[name='width[]']").val(),
                        color: $(this).find("input[name='color[]']").val(),
                        design_name: $(this).find("input[name='design_name[]']").val(),
                        quantity: $(this).find("input[name='quantity[]']").val(),
                    };

                    allFormData.push(formData);
                });
                console.log(allFormData)


                try {
                    $.ajax({
                        url: "ajax/save_record.php",
                        type: "POST",
                        data: {
                            data: JSON.stringify(formData)
                        },
                        dataType: "json",
                        success: function(response) {
                            $("#submit").prop("disabled", false);
                            if (response.status == "success") {
                                // Reset the form
                                $("form")[0].reset();

                                // Display SweetAlert popup
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Data saved successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });

                } catch (error) {
                    console.log("Error : " + error);
                }

                console.log(formData)

            });



        });

        $("#addRowBtn").on("click", function() {
            // Clone the first row and append it to the container
            var newRow = $("#inputRows .row:first").clone();
            $("#inputRows").append(newRow);

            // Clear the input values in the new row
            newRow.find("input").val("");
        });



        function validateInput(input) {
            // Remove any non-numeric characters except periods
            let sanitizedInput = input.value.replace(/[^0-9.]/g, '');

            // Check if the input is a valid positive number
            if (/^\d*\.?\d*$/.test(sanitizedInput)) {
                // Update the input value with the sanitized content
                input.value = sanitizedInput;
            } else {
                // If not a valid number, reset the input value
                input.value = '';
            }
        }
    </script>
</body>

</html>