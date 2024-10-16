<?php
session_start();
error_reporting(0);
include('includes/config.php');

if ($_SESSION['login'] != '') {
    $_SESSION['login'] = '';
}

if (isset($_POST['login'])) {
    $email = $_POST['emailid'];
    $password = md5($_POST['password']);
    $sql = "SELECT FullName, EmailId, Password, StudentId, Status FROM tblstudents WHERE EmailId=:email and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['stdid'] = $result->StudentId;
            $_SESSION['username'] = $result->FullName;
            if ($result->Status == 1) {
                $_SESSION['login'] = $_POST['emailid'];
                echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
            } else {
                echo "<script>alert('Your Account Has been blocked. Please contact admin');</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | User Login</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style>
        body {
            background: url('./assets/img/background.jpg') no-repeat center center fixed; /* Background image */
            background-size: cover;
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navbar styles */
        .navbar {
            background: rgba(240, 248, 255, 0.8); /* Light color (AliceBlue) */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: slideIn 1s ease forwards; /* Navbar animation */
        }

        /* Animation for the navbar */
        @keyframes slideIn {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }

        .navbar .navbar-brand,
        .navbar .navbar-nav .nav-link {
            color: #6a11cb !important; /* Change to a more vibrant color */
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #2575fc !important; /* Lighter hover effect */
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px);
            padding-top: 70px;
            padding-bottom: 70px; /* Ensure padding at the bottom for mobile devices */
            color: #ffffff;
        }

        .panel {
            border-radius: 15px; /* More rounded corners */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            overflow: hidden; /* Prevents inner elements from overflowing */
            position: relative; /* Needed for the pseudo-elements */
            animation: float 3s ease-in-out infinite; /* Floating effect */
        }

        /* Floating animation */
        @keyframes float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }

        .panel:before,
        .panel:after {
            content: '';
            position: absolute;
            top: -50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border-radius: 50%;
            transition: transform 0.5s ease;
            z-index: 0; /* Send it to the background */
        }

        .panel:hover:before {
            transform: translate(-50%, -50%) scale(1.2); /* Scale on hover */
        }

        .panel-heading {
            position: relative;
            z-index: 1; /* Bring the heading to the front */
            color: #fff;
            font-size: 24px;
            text-align: center;
            padding: 15px;
        }

        .panel-body {
            position: relative;
            z-index: 1; /* Bring the body to the front */
            padding: 40px;
            border-radius: 0 0 15px 15px; /* Match panel corners */
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.3);
            outline: none;
        }

        .btn {
            background: #6a11cb; /* Solid button color */
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn:hover {
            background: #2575fc; /* Button hover color */
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .help-block {
            font-size: 14px;
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        @media (max-width: 768px) {
            .panel {
                margin: 20px; /* Ensure some margin on small screens */
            }

            .content-wrapper {
                padding-top: 30px;
                padding-bottom: 30px; /* Adjust padding for smaller screens */
            }
        }
    </style>
</head>

<body>
    <!-- MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12 text-center">
                    <h4 class="header-line">USER LOGIN FORM</h4>
                </div>
            </div>

            <!-- LOGIN PANEL START -->
            <div class="row">
                <div class="col-md-6 col-sm-8 col-xs-10 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">LOGIN FORM</div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Enter Email ID</label>
                                    <input class="form-control" type="text" name="emailid" required autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" required autocomplete="off" />
                                    <p class="help-block"><a href="user-forgot-password.php">Forgot Password?</a></p>
                                </div>

                                <button type="submit" name="login" class="btn btn-info">LOGIN</button>
                                <div class="text-center" style="margin-top: 10px;">
                                    <span>Not Registered Yet? <a href="signup.php">Sign Up</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- LOGIN PANEL END -->
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->

    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>
