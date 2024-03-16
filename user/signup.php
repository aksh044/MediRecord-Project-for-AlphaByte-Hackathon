<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ignup</title>

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
            width: 100%;
            padding: 10px;
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
    <?php 
    session_start();
    error_reporting(0);
    include('includes/dbconnection.php');
    if(isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $mobno = $_POST['mobno'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        
        $ret = "SELECT Email, MobileNumber FROM tbluser WHERE Email = :email OR MobileNumber = :mobno";
        $query = $dbh->prepare($ret);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobno', $mobno, PDO::PARAM_INT);
        
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() == 0) {
            $sql = "INSERT INTO tbluser(FullName, MobileNumber, Email, Password) VALUES (:fname, :mobno, :email, :password)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':mobno', $mobno, PDO::PARAM_INT);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId) {
                echo "<script>alert('You have successfully registered with us');</script>";
                echo "<script>window.location.href ='signin.php'</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again');</script>";
            }
        } else {
            echo "<script>alert('Email-id or Mobile Number is already exist. Please try again');</script>";
        }
    }
    ?>
    <div class="form-container">
        <form method="post">
            <label for="fname">Name</label>
            <input type="text" name="fname" id="fname" required>
            
            <label for="mobno">Mobile Number</label>
            <input type="text" name="mobno" id="mobno" required pattern="[0-9]+" maxlength="10">
            
            <label for="email">Email address</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit" name="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
