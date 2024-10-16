<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {   
    header('location:index.php');
} else { 

    if(isset($_POST['issue'])) {
        $studentid = strtoupper($_POST['studentid']);
        $bookid = $_POST['bookdetails'];
        $sql = "INSERT INTO tblissuedbookdetails(StudentID, BookId) VALUES(:studentid, :bookid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            $_SESSION['msg'] = "Book issued successfully";

            $sql = "UPDATE tblbooks SET IssuedCopies = IssuedCopies + 1 WHERE id = :bookid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
            $query->execute();

            header('location:manage-issued-books.php');
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header('location:manage-issued-books.php');
        }
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Online Library Management System | Issue a New Book</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to get student name
        function getstudent() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "get_student.php",
                data: 'studentid=' + $("#studentid").val(),
                type: "POST",
                success: function(data) {
                    $("#get_student_name").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }

        // Function to get book details
        function getbook() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "get_book.php",
                data: 'bookid=' + $("#bookid").val(),
                type: "POST",
                success: function(data) {
                    $("#get_book_name").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script> 
    <style type="text/css">
        .others {
            color: red;
        }
        body {
            background-image: url('assets/img/background.jpg'); /* Adjust the image path */
            background-size: cover;
            font-family: 'Open Sans', sans-serif;
        }
        .panel {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
        }
        .panel:hover {
            transform: translateY(-5px);
        }
        .header-line {
            color: #ffcc00;
            text-align: center;
            margin-bottom: 20px;
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
                    <h4 class="header-line animate__animated animate__bounce">Issue a New Book</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Issue a New Book
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Student ID<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="studentid" id="studentid" onBlur="getstudent()" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <span id="get_student_name" style="font-size:16px;"></span> 
                                </div>
                                <div class="form-group">
                                    <label>Book ID<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="bookid" id="bookid" onBlur="getbook()" required />
                                </div>
                                <div class="form-group">
                                    <label>Book Title<span style="color:red;">*</span></label>
                                    <select class="form-control" name="bookdetails" id="get_book_name" readonly>
                                        <option value="">Select Book</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="issue" id="submit" class="btn btn-info">Issue Book</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE LOADING TIME -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
