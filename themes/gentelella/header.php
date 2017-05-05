<?php 
session_start();
if(!isset($_SESSION['user_email']))
    header('location:admin/login_form.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MDS | MIC Database System</title>

        <!-- Bootstrap -->
        <link href="themes/gentelella/vendors/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="themes/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <link href="themes/gentelella/vendors/animate.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="themes/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link href="themes/gentelella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    	
        <!-- bootstrap-progressbar -->
        <link href="themes/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <!-- JQVMap -->
        <link href="themes/gentelella/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link href="themes/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <!-- Datatables bootstrap -->
        <link href="themes/gentelella/vendors/datatables.net/css/datatables.min.css" rel="stylesheet">
        <link href="themes/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="themes/gentelella/build/css/custom.css" rel="stylesheet">
        <!-- Select2 -->
        <link href="sources/select2-4.0.3/dist/css/select2.min.css" rel="stylesheet" />
         <!-- Datepicker -->
        <link href="sources/css/bootstrap-datepicker.min.css" rel="stylesheet" />
        <!-- X-editable -->
        <link href="sources/bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />

        <!-- Page Loader-->
        <style type="text/css">
            .loader {
                position: fixed;
                left: 50%;
                top: 40%;
                margin-top: -40px;
                margin-left: -100px;
                width: 400px;
                height: 300px;
                opacity: 0.5;
                background: url('sources/images/giphy.gif') ;
            }
        </style>
 

        <!-- jQuery ::: Select2 will not work, if you move this to footer.-->
        <script src="themes/gentelella/vendors/jquery/dist/jquery.min.js"></script>
	</head>
    <body class="nav-md">
       
    
    <div class="loader" style=""></div>
        <div class="container body">
            <div class="main_container">
	  	  
<?php
        	include ('sidemenu.php');
        	include ('topmenu.php');
?>