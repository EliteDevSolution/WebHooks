<?php
    include_once 'dbconfig.php';
    include_once 'process.php';
    $res = getData($connection, "SELECT * FROM orders AS T1 LEFT JOIN order_details AS T2 ON(T1.id = T2.order_id) ORDER BY order_id") ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from coderthemes.com/ubold/layouts/default/tables-datatables.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Sep 2020 17:27:44 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Printing Files – My Design List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Printing Files – My Design List" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://img.mydesignlist.com/pub/media/favicon/default/MOCKUP_02Sep17_1702_B35604_1.ico">

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
        #datatable
        {
            display: none;
        }
        p {
          margin-bottom: 0px;  
        }
        a:hover {
            color: red;
        }
        table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr[role=row]>th:first-child:before {
            top: 5.13rem !important;
        }
        td {
            vertical-align: middle !important;
        }
    </style>
</head>

<body>
<div class="row mt-3">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <?php if(!isset($_POST['password']) || $_POST['password'] !== $acesspd) {  ?>    
        <div>
            <form method="post">
                <div class="ml-0 row" style="margin-top:30vh;">    
                    <h4 class="col-md-5 text-right">You have to input Access password?</h4>
                    <input class="form-control col-3" type="password" id="password" name="password" autofocus require/>
                    <input class="btn btn-danger col-1" type="submit" value="Login" id="btn_submit"  />
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>
        <?php  } ?>
        <?php 
        if(isset($_POST['password']) && $_POST['password'] === $acesspd) {  ?>
        <div class="card">
            <div class="card-body">
                <h3 class="mb-3">Printing Files – My Design List</h3>
                <table id="datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>No.</th>    
                        <th>Order Number</th>
                        <th>SKU</th>
                        <th>Variant</th>
                        <th>Quantity</th>
                        <th>DetailZipUrl</th>
                        <th>DetailPreviewUrl</th>
                        <th>ServerZipUrl</th>
                        <th>ServerPreviewUrl</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $cnt = 0;
                        foreach($res as $row) {
                    ?>
                        <tr>
                            <td width="10%"><?=++$cnt?><img class="thumb-img" style="margin-left:10px;" src="<?=$row['preview_url']?>"  width="160"/></td>
                            <td><?=$row['order_code']?></td>
                            <td><?=$row['model_code']?></td>
                            <td><?=$row['variant_name']?></td>
                            <td><?=$row['quantity']?></td>
                            <td><a href="<?=$row['zip_url']?>" target="_blank"><?=$row['zip_url']?></a></td>
                            <td><a href="<?=$row['preview_url']?>" target="_blank"><?=$row['preview_url']?></a></td>
                            <td><a href="<?=$row['server_zip_url']?>" target="_blank"><?=$row['server_zip_url']?></a></td>
                            <td><a href="<?=$row['server_preview_url']?>" target="_blank"><?=$row['server_preview_url']?></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div> <!-- end card body-->
        </div> <!-- end card -->
        <?php  } ?>

    </div>
    <div class="col-md-1"></div>
</div>
<script src="./assets/js/vendor.min.js"></script>

<!-- third party js -->
<script src="./assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="./assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="./assets/libs/lazyload/lazyload.js"></script>
<!-- third party js ends -->

<!-- App js -->
<script src="./assets/js/app.min.js"></script>
<script>
    $(document).ready(function(){
        $('form').on('submit', function(evt){
            evt.preventDefault();
            if($('#password').val() == '')
            {
                alert('Input access password!!!');
                $('#password').focus();
            } else
            {
                $('form').unbind('submit').submit();
            }
        });

        $("#datatable").DataTable({
            language:{
                paginate:{ 
                    previous:"<i class='mdi mdi-chevron-left'>",
                    next:"<i class='mdi mdi-chevron-right'>"}
                },
                drawCallback:function(){
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                    $("img.thumb-img").lazyload();
                },
                initComplete: function(settings, json) {
                    $('#datatable').show();
                }
        });

    });

</script>


</body>
</html>