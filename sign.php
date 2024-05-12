<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="../bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <style>
        #firstnameAlert,#firstnameAlert1,#lastnameAlert,#lastnameAlert1,#adressAlert,#phoneAlert,#phoneAlert1,#emailAlert1,#emailAlert2,#emailAlert3,#passwordAlert,#confirmAlert
        {
            display: none;
        }
    </style>
</head>
<body>
<?php
    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
        include "connect.php";
        $sql = "SELECT loginClient from sell.client";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $emails = $statement->fetchAll(PDO::FETCH_ASSOC);
        $exist = 0;
        foreach ($emails as $x)
        {
            if ($x['loginClient']== $_POST['email'])
            {
                $exist++;
            }
        }
        if ($exist == 1)
        {
            echo "<script>
            emailAlert3.style.display = 'inline';
            </script>";
        }
        else
        {
        $name = $_POST['lastname']." ".$_POST['firstname'];
        $phone = $_POST['phone1'].$_POST['phone2'];
        $sql = "INSERT into sell.client values(null,:name,:adress,:city,:phone,:email,:password)";
        $statement = $connection->prepare($sql);
        $statement->bindParam("name",$name);
        $statement->bindParam("adress",$_POST['adress']);
        $statement->bindParam("city",$_POST['city']);
        $statement->bindParam("phone",$phone);
        $statement->bindParam("email",$_POST['email']);
        $statement->bindParam("password",$_POST['password']);
        $statement->execute();
        header("location:login.php");
        }   
    }
    ?>
    <form action="sign.php" method="post" class="col-8 m-auto my-5" id="form">
        <h1 class="text-center">Sign In</h1>
        <div>
            <label><i class="bi bi-person-vcard-fill text-primary fs-4"></i> Lastname</label>
            <input type="text" name="lastname" id="lastname" class="form-control">
            <p class="text-danger" id="lastnameAlert">lastname most be in (3-20) characters</p>
            <p class="text-danger" id="lastnameAlert1">please delete numbers</p>
        </div>
        <div>
            <label><i class="bi bi-person-lines-fill text-primary fs-4"></i> Firstname</label>
            <input type="text" name="firstname" id="firstname" class="form-control">
            <p class="text-danger" id="firstnameAlert">firstname most be in (3-20)</p>
            <p class="text-danger" id="firstnameAlert1">please delete numbers</p>
        </div>
        <div>
            <label><i class="bi bi-geo-alt-fill text-primary fs-4"></i> Adress</label>
            <input type="text" name="adress" id="adress" class="form-control">
            <p class="text-danger" id="adressAlert">lastname most be in (3-20)</p>
        </div>
        <div>
            <label><i class="bi bi-map-fill text-primary fs-4"></i> City</label>
            <select name="city" class="form-select" required>
                <option value="">city</option>
                <option value="casa">casa</option>
                <option value="marrakech">marrakech</option>
                <option value="rabat">rabat</option>
                <option value="tanger">tanger</option>
                <option value="agadir">agadir</option>
                <option value="dakhla">dakhla</option>
                <option value="oujda">oujda</option>
                <option value="ouarzazate">ouarzazate</option>
                <option value="titouan">titouan</option>
                <option value="fas">fas</option>
            </select>
        </div>
        <label><i class="bi bi-telephone-fill text-primary fs-4"></i> Phone</label>
        <div class="d-flex">
            <select name="phone1" class="form-select w-25" id="phone1">
                <option value="06" selected>06</option>
                <option value="07">07</option>
                <option value="05">05</option>
            </select>
            <input type="text" name="phone2" id="phone2" class="form-control" maxlength="8">
            <p class="text-danger" id="phoneAlert">please enter 8 numbers</p>
            <p class="text-danger" id="phoneAlert1">phone number most be in [0-9]</p>
        </div>
        <div>
            <label><i class="bi bi-envelope-at-fill text-primary fs-4"></i> Email</label>
            <input type="text" name="email" id="email" class="form-control">
            <p class="text-danger" id="emailAlert1">this field is rquired!</p>
            <p class="text-danger" id="emailAlert2">please enter valid email <span class="text-success">example@gmail.com</span></p>
            <p class="text-danger" id="emailAlert3">email already exist !</p>
        </div>
        <div>
            <label><i class="bi bi-person-fill-lock text-primary fs-4"></i> Password</label>
            <input type="password" name="password" id="password" class="form-control">
            <p class="text-danger" id="passwordAlert">password most be in (8-20)</p>
        </div>
        <div>
            <label><i class="bi bi-person-fill-check text-primary fs-4"></i> Confirm Password</label>
            <input type="password" name="confirm" id="confirm" class="form-control">
            <p class="text-danger" id="confirmAlert">wrong password confirm!</p>
        </div>
        <button class='btn btn-primary d-block m-auto col-4 my-2'>Login</button>
    </form>
    <script>
        var lastname = document.getElementById("lastname");
        var firstname = document.getElementById("firstname");
        var adress = document.getElementById("adress");
        var phone1 = document.getElementById("phone1");
        var phone2 = document.getElementById("phone2");
        var email = document.getElementById("email");
        var password = document.getElementById("password");
        var confirmP = document.getElementById("confirm");
        var form = document.getElementById("form");

        var lastnameAlert = document.getElementById("lastnameAlert");
        var lastnameAlert1 = document.getElementById("lastnameAlert1");
        var firstnameAlert = document.getElementById("firstnameAlert");
        var firstnameAlert1 = document.getElementById("firstnameAlert1");
        var adressAlert = document.getElementById("adressAlert");
        var phoneAlert = document.getElementById("phoneAlert");
        var phoneAlert1 = document.getElementById("phoneAlert1");
        var emailAlert = document.getElementById("emailAlert");
        var emailAler3 = document.getElementById("emailAlert3");
        var passwordAlert = document.getElementById("passwordAlert");
        var confirmAlert = document.getElementById("confirmAlert");
        var form = document.getElementById("form");

        form.addEventListener("submit",check);
        function checkPhone()
        {
            var validPhone = true;
            for (const x of phone2.value.trim())
            {
                if (x!=0 && x!=1 && x!=2 && x!=3 && x!=4 && x!=5 && x!=6 && x!=7 && x!=8 && x!=9)
                {
                    validPhone = false;
                }
            }
            return validPhone;
        }
        function checkname(value)
        {
            var validName = true;
            for (const x of value)
            {
                if (x==0 ||x==1 ||x==2 ||x==3 ||x==4 ||x==5 ||x==6 ||x==7 ||x==8 ||x==9)
                {
                    validName = false;
                    break;
                }
            }
            return validName;
        }
        
        function check()
        {
            var isValid = true;
            if (lastname.value.trim() == "")
            {
                lastname.classList.add("is-invalid");
                lastnameAlert.style.display = "inline";
                lastnameAlert1.style.display = "none";
                isValid = false;
            }
            else if (!checkname(lastname.value.trim()))
            {
                lastname.classList.add("is-invalid");
                lastnameAlert1.style.display = "inline";
                lastnameAlert.style.display = "none";
                isValid = false;
            }
            else
            {
                lastname.classList.remove("is-invalid");
                lastname.classList.add("is-valid");
                lastnameAlert1.style.display = "none";
                lastnameAlert.style.display = "none";
            }

            if (firstname.value.trim() == "")
            {
                firstname.classList.add("is-invalid");
                firstnameAlert.style.display = "inline";
                firstnameAlert1.style.display = "none";
                isValid = false;
            }
            else if (!checkname(firstname.value.trim()))
            {
                firstname.classList.add("is-invalid");
                firstnameAlert1.style.display = "inline";
                firstnameAlert.style.display = "none";
                isValid = false;
            }
            else
            {
                firstname.classList.add("is-valid");
                firstname.classList.remove("is-invalid");
                firstnameAlert1.style.display = "none";
                firstnameAlert.style.display = "none";
            }
            if (adress.value.trim() == "")
            {
                adress.classList.add("is-invalid");
                adressAlert.style.display = "inline";
                isValid = false;
            }
            else
            {
                adress.classList.remove("is-invalid");
                adress.classList.add("is-valid");
                adressAlert.style.display = "none";
            }
            if (phone2.value.trim().length != 8)
            {
                phone2.classList.add("is-invalid");
                phoneAlert.style.display = "inline";
                phoneAlert1.style.display = "none";
                isValid = false;
            }
            else if (!checkPhone())
            {
                phone2.classList.add("is-invalid");
                phoneAlert1.style.display = "inline";
                phoneAlert.style.display = "none";
                isValid = false;
            }
            else
            {
                phone2.classList.remove("is-invalid");
                phone2.classList.add("is-valid");
                phoneAlert.style.display = "none";
                phoneAlert1.style.display = "none";
            }
            if (email.value.trim() == "")
            {
                email.classList.add("is-invalid");
                emailAlert1.style.display = "inline";
                emailAlert2.style.display = "none";
                isValid = false;
            }
            else if (!/\w+\@\w+\.\w+/.test(email.value.trim()))
            {
                email.classList.add("is-invalid");
                emailAlert2.style.display = "inline";
                emailAlert1.style.display = "none";
                isValid = false;
            }
            else
            {
                email.classList.add("is-valid");
                email.classList.remove("is-invalid");
                emailAlert2.style.display = "none";
                emailAlert1.style.display = "none";
            }
            if (password.value.trim().length < 8)
            {
                password.classList.add("is-invalid");
                passwordAlert.style.display = "inline";
                isValid = false;
            }
            else
            {
                password.classList.remove("is-invalid");
                password.classList.add("is-valid");
                passwordAlert.style.display = "none";
            }
            if (confirmP.value.trim() == "")
            {
                confirmP.classList.add("is-invalid");
                confirmP.classList.remove("is-valid");
                confirmAlert.style.display = "inline";
                isValid = false;
            }
            else if (confirmP.value.trim() != password.value.trim())
            {
                confirmP.classList.remove("is-valid");
                confirmP.classList.add("is-invalid");
                confirmAlert.style.display = "inline";
                isValid = false;
            }
            else
            {
                confirmP.classList.remove("is-invalid");
                confirmP.classList.add("is-valid");
                confirmAlert.style.display = "none";
            }

            if (!isValid)
            {
                event.preventDefault();
            }
        }
    </script>
   
</body>
</html>