<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) { 
    header('location:index.php');
} else { ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Online Library Management System | Admin Dashboard</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- GOOGLE FONT -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        /* Animated Gradient Background */
/* Animated Gradient Background */
body {
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    color: #fff;
    font-family: 'Open Sans', sans-serif;
}

/* Animation for Gradient */
@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Header Animation */
.header-line {
    color: #ffcc00;
    text-align: center;
    margin-bottom: 20px;
    animation: fadeIn 2s ease-in-out;
}

/* Widget (Card) Styling */
.back-widget-set {
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    border-radius: 15px;
    background: linear-gradient(145deg, #ffffff, #e6e6e6);
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2), -5px -5px 15px rgba(255, 255, 255, 0.4);
    margin: 15px 0;
    padding: 20px;
    position: relative;
    overflow: hidden;
    animation: cardEntry 1s ease-in-out;
}

/* Card Entry Animation */
@keyframes cardEntry {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover Effects for Cards */
.back-widget-set:hover {
    transform: translateY(-10px) rotateX(5deg) rotateY(5deg);
    box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.3), -10px -10px 30px rgba(255, 255, 255, 0.5);
}

/* Card Glow Effect on Hover */
.back-widget-set:before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%);
    transition: opacity 0.5s;
    opacity: 0;
    pointer-events: none;
}

.back-widget-set:hover:before {
    opacity: 1;
}

/* Icon Bounce Effect */
.back-widget-set i {
    animation: bounce 2s infinite;
    color: #333;
}

/* Bounce Animation */
@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Fade in for Header */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Carousel controls style */
.carousel-control {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
}

.carousel-control:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

/* Responsive Header */
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
                    <h4 class="header-line animate__animated animate__bounce">ADMIN DASHBOARD</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-success back-widget-set text-center">
                        <i class="fa fa-book fa-5x"></i>
                        <?php 
                        $sql = "SELECT id FROM tblbooks";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $listdbooks = $query->rowCount(); ?>
                        <h3><?php echo htmlentities($listdbooks); ?></h3>
                        Books Listed
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-info back-widget-set text-center">
                        <i class="fa fa-bars fa-5x"></i>
                        <?php 
                        $sql1 = "SELECT id FROM tblissuedbookdetails";
                        $query1 = $dbh->prepare($sql1);
                        $query1->execute();
                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                        $issuedbooks = $query1->rowCount(); ?>
                        <h3><?php echo htmlentities($issuedbooks); ?> </h3>
                        Times Book Issued
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-warning back-widget-set text-center">
                        <i class="fa fa-recycle fa-5x"></i>
                        <?php 
                        $status = 1;
                        $sql2 = "SELECT id FROM tblissuedbookdetails WHERE ReturnStatus = :status";
                        $query2 = $dbh->prepare($sql2);
                        $query2->bindParam(':status', $status, PDO::PARAM_STR);
                        $query2->execute();
                        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                        $returnedbooks = $query2->rowCount(); ?>
                        <h3><?php echo htmlentities($returnedbooks); ?></h3>
                        Times Books Returned
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-danger back-widget-set text-center">
                        <i class="fa fa-users fa-5x"></i>
                        <?php 
                        $sql3 = "SELECT id FROM tblstudents";
                        $query3 = $dbh->prepare($sql3);
                        $query3->execute();
                        $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                        $regstds = $query3->rowCount(); ?>
                        <h3><?php echo htmlentities($regstds); ?></h3>
                        Registered Users
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-success back-widget-set text-center">
                        <i class="fa fa-user fa-5x"></i>
                        <?php 
                        $sql4 = "SELECT id FROM tblauthors";
                        $query4 = $dbh->prepare($sql4);
                        $query4->execute();
                        $results4 = $query4->fetchAll(PDO::FETCH_OBJ);
                        $listdathrs = $query4->rowCount(); ?>
                        <h3><?php echo htmlentities($listdathrs); ?></h3>
                        Publications Listed
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-info back-widget-set text-center">
                        <i class="fa fa-file-archive-o fa-5x"></i>
                        <?php 
                        $sql5 = "SELECT id FROM tblcategory";
                        $query5 = $dbh->prepare($sql5);
                        $query5->execute();
                        $results5 = $query5->fetchAll(PDO::FETCH_OBJ);
                        $listdcats = $query5->rowCount(); ?>
                        <h3><?php echo htmlentities($listdcats); ?> </h3>
                        Listed Categories
                    </div>
                </div>   

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-info back-widget-set text-center">
                        <i class="fa fa-money fa-5x"></i>
                        <?php 
                        $ret = "SELECT * FROM tblfine WHERE 1";
                        $query = $dbh->prepare($ret);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if($query->rowCount() > 0) {
                            foreach($results as $result) {
                                $fine = $result->fine;    
                            }
                        } ?>
                        <h3><?php echo htmlentities($fine); ?> </h3>
                        Current Fine Per Day
                    </div>
                </div>     
            </div> 
    <!-- CONTENT-WRAPPER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
