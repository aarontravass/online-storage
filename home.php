<!DOCTYPE html>

<head>
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata&display=swap" rel="stylesheet">
    <style>
        .boxy{
            border:1px solid black;
            width:100%;
            display:block;
        }
        .form-control{
            width:100%;
            display:block;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="" method="GET">
            

            <?php
            session_start();
            include 'address.php';
            include 'token.php';

            const l = 9;

            


            function uploadlink($token)
            {
                
                echo "<th scope='col'><a class='btn btn-info' style='float:right' href='http://$_SERVER[HTTP_HOST]/upload.php?q=" . $token . "'>New</a></th>";
                
            }




            function backbutton($address,$conn_a)
            {
                if(l==strlen($address)){
                    echo "<th scope='col'><button type='button' class='btn btn-primary' style='float:left' disabled>Back</button></th>";
                }
                else{
                    $pos = 0;
                    for ($i = strlen($address) - 1; $i >= 0; $i--) {
                        //echo $address[$i];
                        if ($address[$i] == '/') {
                            $pos = $i;
                            break;
                        }
                    }

                    $new_add = "";
                    for ($i = 0; $i < $pos; $i++) {
                        $new_add = $new_add . $address[$i];
                    }
                    
                    
                
                
                
                    
                    $new_token=gettoken($new_add,$conn_a);
                    echo "<th scope='col'><a class='btn btn-primary' style='float:left' href='http://$_SERVER[HTTP_HOST]/home.php?q=" . $new_token . "'>Back</a></th>";

                    
                }
                
                
                
                
            }
            function logoutbtn($user_token){


                echo "<th scope='col'>Drive</th>";

                echo "<th scope='col'><a class='btn btn-warning' style='float:right' href='http://$_SERVER[HTTP_HOST]/logout.php?token=".$user_token."'>Logout</a></th>";

            }

            if(isset($_SESSION['id']) and strlen($_SESSION['id'])>5 and isset($_SESSION['user_token'])){
                if (isset($_GET['q'])) {


                    $token = $_GET['q'];
                    $address = getaddress($token, $conn_a);
                    $user_token=$_SESSION['user_token'];


                    echo "<table class='table table-borderless'><thead><tr>";
                    logoutbtn($user_token);
                    echo "</tr></thead></table>";



                    echo "<table class='table  table-striped table-hover'><thead><tr>";
                    backbutton($address,$conn_a);
                    uploadlink($token);
                    echo "</tr></thead></table>";


                    echo "<div class='boxy container'>";
                    echo "<br>";
                    echo "<p><b>You are here</b><p>";
                    echo "<p style='word-wrap: break-word'>".$address."</p>";
                    echo "<br>";
                    echo "</div>";
                    echo "<br><br><table class='table  table-striped table-hover'><tbody>";
                    
                    
                    if ($address != '0') {
                        $a = scandir($address);
                        if(count($a)==2){
                            echo "<tr><td>Empty Directory</td></tr>";
                        }
                        else{
                            for ($i = 0; $i < count($a); $i++) {
                                if ($a[$i] != '.' && $a[$i] != '..') {
                                    echo "<tr>";
                                    if (strpos($a[$i], '.') != false) {
                                        $new_token = gettoken($address . '/' . $a[$i], $conn_a);
                                        
                                        echo "<td><a class='nav-link' href='http://$_SERVER[HTTP_HOST]/down.php?q=" . $new_token . "'>" . $a[$i] . "</a></td>";
                                        echo "<td><a class='btn btn-danger' style='float:right' href='http://$_SERVER[HTTP_HOST]/delete.php?q=" . $new_token . "' role='button'>Delete File</a></td>";
                                        
                                        
                                    } else {
                                        $new_token = gettoken($address . '/' . $a[$i], $conn_a);

                                        
                                        echo "<td><a class='nav-link' href='http://$_SERVER[HTTP_HOST]/home.php?q=" . $new_token . "'>" . $a[$i] . "</a></td>";
                                        echo "<td><a class='btn btn-danger' style='float:right' href='http://$_SERVER[HTTP_HOST]/delete.php?q=" . $new_token . "' role='button'>Delete Folder</a></td>";
                                        
                                        
                                    }

                                    echo "</tr>";
                                }
                            }
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('Account does not exist');</script>";
                    }
                }
            }
            else{
                $link="http://$_SERVER[HTTP_HOST]/index.php";
                //echo $link;
                header('Location: '.$link);
            }


            ?>
        </tbody>
        </table>
        </form>
    </div>

</body>

</html>