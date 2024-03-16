<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['submit']))
  {
    $fname=$_POST['fname'];
    $mobno=$_POST['mobno'];
    $email=$_POST['email'];
    $sid=$_POST['specializationid'];
    $password=md5($_POST['password']);
    $ret="select Email from tbldoctor where Email=:email";
    $query= $dbh -> prepare($ret);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() == 0)
{
$sql="Insert Into tbldoctor(FullName,MobileNumber,Email,Specialization,Password)Values(:fname,:mobno,:email,:sid,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobno',$mobno,PDO::PARAM_INT);
$query->bindParam(':sid',$sid,PDO::PARAM_INT);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

echo "<script>alert('You have signup  Successfully');</script>";
}
else
{

echo "<script>alert('Something went wrong.Please try again');</script>";
}
}
 else
{

echo "<script>alert('Email-id already exist. Please try again');</script>";
}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
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
        .simple-page-footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body class="simple-page">
    <div class="simple-page-wrap">
        <div class="simple-page-form">
            <h4 class="form-title m-b-xl">Sign Up</h4>
            <form action="" method="post">
                <div class="form-group">
                    <input id="fname" type="text" class="form-control" placeholder="Full Name" name="fname" required="true">
                </div>
                <div class="form-group">
                    <input id="email" type="email" class="form-control" placeholder="Email" name="email" required="true">
                </div>
                <div class="form-group">
                    <input id="mobno" type="text" class="form-control" placeholder="Mobile" name="mobno" maxlength="10" pattern="[0-9]+" required="true">
                </div>
                <div class="form-group">
                    <select class="form-control" name="specializationid">
                        <option value="">Choose Specialization</option>
                        <?php
                        include('includes/dbconnection.php');
                        $sql = "SELECT * FROM tblspecialization";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $result = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            echo "<option value='" . $row['ID'] . "'>" . $row['Specialization'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control" placeholder="Password" name="password" required="true">
                </div>
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </form>
        
        </div><!-- #login-form -->
        <div class="simple-page-footer">
            <p>
                <small>Do you have an account ?</small>
                <a href="login.php">SIGN IN</a>
            </p>
        </div>
    </div><!-- .simple-page-wrap -->
</body>
</html>
