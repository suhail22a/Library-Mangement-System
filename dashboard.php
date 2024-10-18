<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else { ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | User Dash Board</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- GOOGLE FONT -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        body {
            background: url('./assets/img/b1.jpg') no-repeat center center fixed; 
            background-size: cover;
            font-family: 'Open Sans', sans-serif;
            color: #fff;
            padding-top: 50px;
        }
        .header-line {
            font-size: 30px;
            text-align: center;
            margin-bottom: 40px;
            color: #ffcc00;
            animation: fadeInDown 1s ease-in-out;
        }
        .back-widget-set {
            background-color: #ffffff;
            color: #333;
            transition: transform 0.4s, box-shadow 0.4s;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            background: linear-gradient(135deg, #FF0080, #FF8C00, #FFD700, #00BFFF, #4B0082);
            background-size: 400% 400%; 
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .back-widget-set:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .back-widget-set i {
            animation: bounce 2s infinite;
            color: #333;
        }
        .alert h3 {
            font-size: 24px;
            font-weight: bold;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 768px) {
            .header-line {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line animate__animated animate__fadeInDown">User DASHBOARD</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-info back-widget-set text-center">
                        <i class="fa fa-bars fa-5x"></i>
                        <?php 
                        $sid=$_SESSION['stdid'];
                        $sql1 ="SELECT id from tblissuedbookdetails where StudentID=:sid";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->bindParam(':sid',$sid,PDO::PARAM_STR);
                        $query1->execute();
                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                        $issuedbooks=$query1->rowCount();
                        ?>
                        <h3><?php echo htmlentities($issuedbooks); ?> </h3>
                        Book Issued
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-warning back-widget-set text-center">
                        <i class="fa fa-recycle fa-5x"></i>
                        <?php 
                        $rsts=0;
                        $sql2 ="SELECT id from tblissuedbookdetails where StudentID=:sid and ReturnStatus=:rsts";
                        $query2 = $dbh -> prepare($sql2);
                        $query2->bindParam(':sid',$sid,PDO::PARAM_STR);
                        $query2->bindParam(':rsts',$rsts,PDO::PARAM_STR);
                        $query2->execute();
                        $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                        $returnedbooks=$query2->rowCount();
                        ?>
                        <h3><?php echo htmlentities($returnedbooks); ?></h3>
                        Books Not Returned Yet
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE LOADING TIME -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
