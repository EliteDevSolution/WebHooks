<?php
    include_once 'dbconfig.php';
    include_once 'process.php';
    $res = getData($connection, "Select * From orders Order By id;") ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from coderthemes.com/ubold/layouts/default/tables-datatables.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Sep 2020 17:27:44 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Zakeke Web Hook Data Processor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Zakeke Web Hook Data Processor" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="./assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="./assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="./assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
    <!-- icons -->
    <link href="./assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <style>
        p {
          margin-bottom: 0px;  
        }
        a:hover {
            color: red;
        }
    </style>
</head>

<body>
<div class="row mt-3">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Web Hook Data Processor</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>OrderCode</th>
                        <th>DetailModelCode</th>
                        <th>OriginFileUrl</th>
                        <th>ServerFileUrl</th>
                        <th>OrderDate</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach($res as $row) {
                    ?>
                        <tr>
                            <td><?=$row['id']?></td>
                            <td><?=$row['order_code']?></td>
                            <td><?=$row['detail_model_code']?></td>
                            <td>
                                <?php foreach(unserialize($row['file_url'] ?? []) as $url) { ?>
                                    <p><a href="<?=$url?>" target="_blank"><?=$url?></a></p>
                                <?php } ?>
                            </td>
                            <td>
                                <?php foreach(unserialize($row['server_file_url'] ?? []) as $url) { ?>
                                    <p><a href="<?=$url?>" target="_blank"><?=$url?></a></p>
                                <?php } ?>
                            </td>
                            <td><?=$row['order_date']?></td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div>
    <div class="col-md-1"></div>
</div>
<script src="./assets/js/vendor.min.js"></script>

<!-- third party js -->
<script src="./assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="./assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- third party js ends -->

<!-- Datatables init -->
<script src="./assets/js/pages/datatables.init.js"></script>

<!-- App js -->
<script src="./assets/js/app.min.js"></script>

</body>
</html>