<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>adminLogin</title>
    <link rel="stylesheet" href="./bootstrap.css">
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset ($_POST['email'],$_POST['password']))
    {
        include "connect.php";
        $sql = "SELECT * from sell.admin";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $x)
        {
            if ($_POST['email']==$x['email'] && $_POST['password']== $x['password'])
            {
                session_start();
                $_SESSION['isAdmin']= true;
                $_SESSION['id'] = $x['id'];
                header("location:admin.php");
                exit;
            }
        }
    }
    ?>
    <form action="adminLogin.php" method="post" class="col-8 m-auto my-5 shadow p-5">
        <h3 class="text-center">adminLogin</h3>
        <div>
            <label>email</label>
            <input type="text" name="email" class="form-control">
        </div>
        <div>
            <label>password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary d-block m-auto col-4 my-5">Login</button>
    </form>
</body>
</html>