<!DOCTYPE html>
<html>

<head>
    <title>Upload</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata&display=swap" rel="stylesheet"> 
    <style>
        
    </style>
</head>

<body>
    <div class="container">
        <br>
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="form-group">

                    <p class="text-center" style="font-size:150%">New Folder</p>

                    <input class='form-control' type="text" name="foldername" />

                    <br>
                </div>

                <div class="form-group text-center">

                    <input class="btn btn-success" type="submit" name="folder" value="Create Folder" />

                </div>
                <br>
                <div class="form-group">

                    <p class="text-center" style="font-size:150%">Upload File</p>
                    <div class="form-group text-center">
                    
                        <input type="file" class="text-center btn btn-info" name="uploadedFile" />
    
                    </div>
                    

                   

                    <br>

                </div>

                <div class="form-group text-center">
                    
                    <input class="btn btn-success" type="submit" name="uploadBtn" value="Upload" />

                </div>
               
            
                
            </form>
    </div>

   

    <?php
        session_start();

        include 'address.php';
        include 'token.php';





        if(isset($_SESSION['id']) and strlen($_SESSION['id'])>5 and isset($_SESSION['user_token'])){
            if (isset($_GET['q'])) {

                $token = $_GET['q'];
                $address = getaddress($token, $conn_a);

            }


            if(isset($_POST['folder']) && $_POST['folder']=="Create Folder"){
                $foldername=$_POST['foldername'];
                $new_address=$address.'/'.$foldername;
                mkdir($new_address);
                $temp=gettoken($new_address,$conn_a);
                $message = 'File is successfully uploaded.';
                $link="http://$_SERVER[HTTP_HOST]/home.php?q=".$token;
                header("Location: $link");

            }
            $message = '';


            if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {


                if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {


                
                    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
                    $fileName = $_FILES['uploadedFile']['name'];
                    $fileSize = $_FILES['uploadedFile']['size'];
                    $fileType = $_FILES['uploadedFile']['type'];


                    $fileNameCmps = explode(".", $fileName);


                    $fileExtension = strtolower(end($fileNameCmps));

                    
                    $newFileName = $fileName;

                    
                    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc', 'pdf','docx','xlsx','pptx');

                    if (in_array($fileExtension, $allowedfileExtensions)) {

                        
                        $uploadFileDir = $address . '/';


                        $dest_path = $uploadFileDir . $newFileName;
                        

                        if (move_uploaded_file($fileTmpPath, $dest_path)) {

                            $new_token=gettoken($dest_path,$conn_a);

                            $message = 'File is successfully uploaded.';
                            $link="http://$_SERVER[HTTP_HOST]/home.php?q=".$token;
                            header("Location: $link");

                        } else {

                            $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                        
                        }
                    } 
                    else {

                        $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);

                    }
                } 
                else {

                    $message = 'There is some error in the file upload. Please check the following error.<br>';

                    $message .= 'Error:' . $_FILES['uploadedFile']['error'];

                }
            }
        }
        else{
            $link="http://$_SERVER[HTTP_HOST]/index.php";
                //echo $link;
            header('Location: '.$link);
        }
        


    ?>
</body>

</html>