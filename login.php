<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
  {
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID,Email FROM tbldoctor WHERE Email=:email and Password=:password";
    $query=$dbh->prepare($sql);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
{
foreach ($results as $result) {
$_SESSION['damsid']=$result->ID;
$_SESSION['damsemailid']=$result->Email;

}
$_SESSION['login']=$_POST['email'];
echo "<script type='text/javascript'> document.location ='notes.php'; </script>";
} else{
echo "<script>alert('Invalid Details');</script>";
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .simple-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .simple-page-form {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .form-title {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .simple-page-footer {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="simple-page">
        <div class="simple-page-form">
            <h4 class="form-title m-b-xl">Sign In</h4>
            <form method="post" name="login">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Enter Registered Email ID" required="true" name="email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password" required="true">
                </div>
                <input type="submit" class="btn btn-primary" name="login" value="Sign IN">
            </form>
            <hr>
            <a href="signup.php">Signup/Registration</a>
        </div><!-- #login-form -->
    </div><!-- .simple-page -->
</body>
</html>
