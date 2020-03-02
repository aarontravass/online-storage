<!DOCTYPE html>
<head>
    <title>IDE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata&display=swap" rel="stylesheet"> 
    <style>
        .form-control{
            width:50%;
            margin-left: 25%;
            display:block;
        }
        .line{
            color:black;
            border:none;
            background-color:black;
            height:1px;
            width:100%;
        }
        .boxy{
            border:1px solid black;
            width:50%;
            display:block;
        }
        .codetext{
            font-family: 'Inconsolata', monospace;
        }
        
    </style>
</head>
<body>
    <div class="container">
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
                    <br>
                </div>
                <div class="form-group text-center">
                    <input class="btn btn-primary" type="submit" name="submit" value="Login">
                </div>
               
                <div class="form-group text-center">
                    <a class="nav-link text-center" href='register.php'>Sign Up</a>
                </div>


                <div class="form-group">
                    
                    
                </div>
                
            </form>
    </div>
    
    <?php
        session_start();

        include 'config.php';
        include 'config-address.php';

        function checkdata($email,$passwd,$conn,$conn_a){
            try{
                
                $sql="select * from logindb where email ='".$email."';";
                $result=mysqli_query($conn,$sql);
                
                $row = mysqli_fetch_assoc($result);
                $hash=array('0','0');
                $hash[0]=$row['passwd'];
                
                if(password_verify($passwd,$hash[0]))
                {
                    $id='data/'.$row['id'];
                    

                    $hash_id=password_hash($id,PASSWORD_DEFAULT);
                    $sql="insert into addressdb values(null,'".$id."','".$hash_id."');";
                    $result=mysqli_query($conn_a,$sql);
                    mysqli_close($conn);
                    mysqli_close($conn_a);
                    $hash[1]=$hash_id;
                    return $hash;
                    
                    
                }
                else{
                    return 0;
                }
                
            }
            catch(Exception $e){
                echo $e;
            }
        }

        if(isset($_POST['submit'])){
            $email=$_POST['email'];
            $passwd=$_POST['passwd'];
            $result=checkdata($email,$passwd,$conn,$conn_a);
            if(count($result)==2){
                $_SESSION['id']=$result[0];
                
                if(isset($_SESSION['id'])){
                    $userToken = bin2hex(openssl_random_pseudo_bytes(24));
                    $_SESSION['user_token'] = $userToken;
                    $link = "http://$_SERVER[HTTP_HOST]/home.php?q=".$result[1];
                        //echo $link;
                    header('Location: '.$link);
                }
            }
            else{
                echo "<script type='text/javascript'>alert('Wrong Password or Account does not exist');</script>";
            }
            
            
        }


    ?>
    

</body>

</html>
