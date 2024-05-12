<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="../bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <style>
        #alert
        {
            display: none;
        }
    </style>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['email'],$_POST['password']))
    {
        include "connect.php";
        $sql = "SELECT * from sell.client";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $x)
        {
            if ($_POST['email']==$x['loginClient'] && $_POST['password']==$x['passwordClient'])
            {
                session_start();
                $_SESSION['isLoged'] = true;
                $_SESSION['id'] = $x['idClient'];
                break;
            }
        }
    }
    
    ?>
    <form action="login.php" method="post" class="col-8 m-auto my-5 shadow p-5">
        <h1 class="text-center">Login</h1>
        <div>
            <label><i class='bi bi-envelope-at-fill text-primary fs-4'></i> Email</label>
            <input type="text" name="email" class="form-control">
        </div>
        <div>
            <label><i class="bi bi-person-fill-lock text-primary fs-4"></i> Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary d-block m-auto my-5 mb-0 col-4" onclick="<?php if (isset($_SESSION['isLoged'])){header("location:articles.php");}?>">Login</button>
    </form>
    <script>
        var alert = document.getElementById("alert");
    </script>
</body>
</html>