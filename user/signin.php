<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) {
    $emailormobnum = $_POST['emailormobnum'];
    $password = md5($_POST['password']);
    $sql = "SELECT Email,MobileNumber,Password,ID FROM tbluser WHERE (Email=:emailormobnum || MobileNumber=:emailormobnum) and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':emailormobnum', $emailormobnum, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['ocasuid'] = $result->ID;
        }
        $_SESSION['login'] = $_POST['emailormobnum'];
        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signin</title>
    <style>
        body {
            font-family: 'Heebo', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .form-container input {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .form-container label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .form-container button {
            width: 70%;
            padding: 10px;
            margin-left: 50px;
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form method="post">
            <label for="emailormobnum">Email or Mobile Number</label>
            <input type="text" name="emailormobnum" id="emailormobnum" required>
            
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            
           
            
            <button type="submit" name="login">Sign In</button>
        </form>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="../index.php">Home</a>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="signup.php">Create an account</a>
        </div>
    </div>
</body>
</html>
