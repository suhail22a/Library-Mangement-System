<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{   
    header('location:index.php');
}
else { 
    if(isset($_POST['change']))
    {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $email = $_SESSION['login'];
        $sql = "SELECT Password FROM tblstudents WHERE EmailId=:email and Password=:password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0)
        {
            $con = "UPDATE tblstudents SET Password=:newpassword WHERE EmailId=:email";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your Password has been successfully changed.";
        }
        else {
            $error = "Your current password is wrong.";  
        }
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
    <title>Online Library Management System | Change Password</title>
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
            background: url('./assets/img/b3.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navbar styles */
        .navbar {
            background: rgba(240, 248, 255, 0.8);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .navbar .navbar-brand,
        .navbar .navbar-nav .nav-link {
            color: #6a11cb !important;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #2575fc !important;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px);
            padding-top: 70px;
            padding-bottom: 70px;
        }

        .panel {
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #FF0080, #FF8C00, #FFD700, #00BFFF, #4B0082);
            background-size: 400% 400%; /* For animation */
            animation: gradient 15s ease infinite; /* Gradient animation */
            position: relative;
            overflow: hidden;
            transition: transform 0.5s; /* Animation on hover */
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .panel:hover {
            transform: scale(1.05); /* Scale up on hover */
        }

        .panel-heading {
            color: #fff;
            font-size: 24px;
            text-align: center;
            padding: 15px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .panel-body {
            padding: 40px;
            color: #fff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #fff;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .form-control:focus {
            border-color: #FF0080;
            box-shadow: 0 0 8px rgba(255, 0, 128, 0.5);
            outline: none;
        }

        .btn {
            background: #6a11cb;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn:hover {
            background: #FF0080;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .errorWrap,
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            border-radius: 5px;
            color: #fff;
            text-align: center;
            opacity: 0.9; /* Slightly transparent */
        }

        .errorWrap {
            background: #dd3d36;
        }

        .succWrap {
            background: #5cb85c;
        }

        @media (max-width: 768px) {
            .panel {
                margin: 20px;
            }

            .content-wrapper {
                padding-top: 30px;
                padding-bottom: 30px;
            }
        }
    </style>
</head>
<script type="text/javascript">
function valid() {
    if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("New Password and Confirm Password fields do not match!");
        document.chngpwd.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php');?>
    <!-- MENU SECTION END-->

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12 text-center">
                    <h4 class="header-line">User Change Password</h4>
                </div>
            </div>
            <?php if($error) { ?>
                <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
            <?php } else if($msg) { ?>
                <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
            <?php } ?>            
            <!-- LOGIN PANEL START -->           
            <div class="row">
                <div class="col-md-6 col-sm-8 col-xs-10 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">Change Password</div>
                        <div class="panel-body">
                            <form role="form" method="post" onSubmit="return valid();" name="chngpwd">
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input class="form-control" type="password" name="password" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Enter New Password</label>
                                    <input class="form-control" type="password" name="newpassword" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input class="form-control" type="password" name="confirmpassword" autocomplete="off" required />
                                </div>
                                <button type="submit" name="change" class="btn btn-info">Change</button> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>  
            <!-- LOGIN PANEL END -->            
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
