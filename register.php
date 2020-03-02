<!DOCTYPE html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata&display=swap" rel="stylesheet">
    <style>
        .form-control {
            width: 50%;
            margin-left: 25%;
            display: block;
        }

        .line {
            color: black;
            border: none;
            background-color: black;
            height: 1px;
            width: 100%;
        }

        .boxy {
            border: 1px solid black;
            width: 50%;
            display: block;
        }

        .codetext {
            font-family: 'Inconsolata', monospace;
        }
    </style>
</head>

<body>
    <div class="container">
        <br>
        <p class='text-center' style="font-size:200%">Register</p>
        <br>
        <div class="line"></div>
        <br>
        <form action="" method="POST">

            <div class="form-group">

                <p class="text-center" style="font-size:150%">Email</p>
                <input type="text" class='form-control' name="email" required>
                <br>

            </div>
            <div class="form-group">

                <p class="text-center" style="font-size:150%">Password</p>
                <input type="password" class='form-control' name="passwd" required>
                <br>
                <p class="text-center" style="font-size:150%">Re-Password</p>
                <input type="password" class='form-control' name="passwd1" required>
                <br>
                <br>

            </div>
            <div class="form-group text-center">

                <input class="btn btn-primary" type="submit" name="submit" value="Signup">

            </div>




            

        </form>
    </div>

    <?php
    include 'config.php';

    function insertdata($email, $passwd, $conn)
    {
        try {

            $sql = "select * from logindb where email = '" . $email . "';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 0) {

                $hashed = password_hash($passwd, PASSWORD_DEFAULT);

                while (1) {

                    $id = rand(1000, 9999);
                    $sql = "select * from logindb where id = '" . $id . "';";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) == 0) {

                        $sql = "insert into logindb values(null,'" . $id . "','" . $email . "','" . $hashed . "');";

                        $result = mysqli_query($conn, $sql);
                        mysqli_close($conn);
                        return $id;

                    }

                }
            } 
            else {

                return 0;

            }
        } catch (Exception $e) {
            echo $e;
        }
    }


    if (isset($_POST['submit'])) {

        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        $passwd1 = $_POST['passwd1'];

        if ($passwd == $passwd1) {

            $result = insertdata($email, $passwd, $conn);

            if ($result) {

                mkdir("data/" . $result);
                echo "<div class='container'>";
                echo "<br>";
                echo "<p class='text-center'>Registered Successfully</p>";
                echo "<p class='text-center'>Redirecting</p>";
                echo "</div>";

                $link = "http://$_SERVER[HTTP_HOST]/index.php";
                //echo $link;
                header('Location: '.$link);
            } else {

                echo "<script type='text/javascript'>alert('Email already exists');</script>";

            }
        } 
        else if (strlen($passwd) > 14) {

            echo "<script type='text/javascript'>alert('Password is greater than 14 characters');</script>";

        } 
        else if (strlen($passwd) < 6) {

            echo "<script type='text/javascript'>alert('Password is less than 6 characters');</script>";

        } 
        else {

            echo "<script type='text/javascript'>alert('Passwords are not the same');</script>";

        }
    }


    ?>


</body>

</html>