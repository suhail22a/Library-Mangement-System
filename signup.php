<?php 
session_start();
include('includes/config.php');
error_reporting(0);

if (isset($_POST['signup'])) {
    // Code for generating Student ID
    $count_my_page = ("studentid.txt");
    $hits = file($count_my_page);
    $hits[0]++;
    $fp = fopen($count_my_page, "w");
    fputs($fp, "$hits[0]");
    fclose($fp);
    $StudentId = $hits[0];
    $fname = $_POST['fullname'];
    $mobileno = $_POST['mobileno'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $status = 1;
    $sql = "INSERT INTO tblstudents(StudentId, FullName, MobileNumber, EmailId, Password, Status) 
            VALUES(:StudentId, :fname, :mobileno, :email, :password, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':StudentId', $StudentId, PDO::PARAM_STR);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        echo '<script>alert("Your Registration was successful! Your student ID is '.$StudentId.'")</script>';
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Online Library Management System | Student Signup</title>
    <!-- BOOTSTRAP CORE STYLE -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- FONT AWESOME STYLE -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!-- CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- CUSTOM CSS -->
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
        }
        .content-wrapper {
            margin-top: 50px;
        }
        .panel {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .panel-heading {
            text-align: center;
            font-weight: bold;
            font-size: 1.5em;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 10px 0;
            border-radius: 15px 15px 0 0;
        }
        .form-control {
            border-radius: 10px;
            padding: 15px;
            font-size: 1em;
        }
        .btn-danger {
            background: linear-gradient(to right, #ff6a00, #ee0979);
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 1.2em;
            color: #fff;
            transition: transform 0.3s ease;
        }
        .btn-danger:hover {
            transform: scale(1.05);
        }
        .form-group label {
            font-weight: bold;
            font-size: 1.1em;
        }
        .form-group input[type="text"], 
        .form-group input[type="email"], 
        .form-group input[type="password"] {
            transition: box-shadow 0.3s ease;
        }
        .form-group input[type="text"]:focus, 
        .form-group input[type="email"]:focus, 
        .form-group input[type="password"]:focus {
            box-shadow: 0 0 10px #667eea;
        }
    </style>
    
    <script type="text/javascript">
    function valid() {
        if (document.signup.password.value != document.signup.confirmpassword.value) {
            alert("Password and Confirm Password Field do not match!");
            document.signup.confirmpassword.focus();
            return false;
        }
        return true;
    }
    </script>

    <script>
    function checkAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data: 'emailid=' + $("#emailid").val(),
            type: "POST",
            success: function(data) {
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
    </script>
</head>
<body>

<!-- MENU SECTION START -->
<?php include('includes/header.php'); ?>
<!-- MENU SECTION END -->

<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">User Signup</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        SIGNUP FORM
                    </div>
                    <div class="panel-body">
                        <form name="signup" method="post" onSubmit="return valid();">
                            <div class="form-group">
                                <label>Enter Full Name</label>
                                <input class="form-control" type="text" name="fullname" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Mobile Number :</label>
                                <input class="form-control" type="text" name="mobileno" maxlength="10" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Enter Email</label>
                                <input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()" autocomplete="off" required>
                                <span id="user-availability-status" style="font-size:12px;"></span>
                            </div>
                            <div class="form-group">
                                <label>Enter Password</label>
                                <input class="form-control" type="password" name="password" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input class="form-control" type="password" name="confirmpassword" autocomplete="off" required>
                            </div>
                            <button type="submit" name="signup" class="btn btn-danger" id="submit">Register Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTENT-WRAPPER SECTION END -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
