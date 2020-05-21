<?php
    session_start();
    include_once('../account/conn.php');

    if(!isset($_SESSION['access'])){
        header('location: ../');
    }
?>

<?php
                        // global variable
    $result = '';
    $forprint = '';

    $img = '';
                                        // dp for update 
    if(isset($_SESSION['img'])){
        $img = $_SESSION['img'];
        unset($_SESSION['img']);
    }

    
                                                // update 
    if(isset($_REQUEST['update']) && isset($_SESSION['edit'])){
                                                    
                                        // variable for update sql
        $uid = $_REQUEST['user_id'];
        $fn = $_REQUEST['f_name'];
        $ln = $_REQUEST['l_name'];
        $sex = $_REQUEST['gender'];
        $dob = $_REQUEST['dob'];
        $ph = $_REQUEST['phone'];
        $occ = $_REQUEST['occupation'];
        $add = $_REQUEST['address'];
        $st = $_REQUEST['state'];
        $pin = $_REQUEST['pin'];
        $email = $_REQUEST['email'];
        $pass = $_REQUEST['password'];
        $acs = $_REQUEST['access'];
                    
                                                // variable for dp
        $path = "../links/path/dp/";
        $file_tmp = '';
        $file_name = $_FILES['dp']['name'];
        $errors = array();

                                // if dp set 
        if($file_name != ''){
                        
                            // assigning dp variables
            
            $file_name = date("U")."_".$_FILES['dp']['name'];
            $file_size = $_FILES['dp']['size'];
            $file_tmp = $_FILES['dp']['tmp_name'];
            $file_type = $_FILES['dp']['type'];
            
            $extensions= array("image/jpeg","image/jpg","image/png","image/img");
            
                                // check image format
            
            if(in_array($file_type,$extensions)=== false){
                $errors[]="extension not allowed, please choose a correct file.";
            }
            
                                                // check dp size 
            if($file_size > 2097152*5) {
                $errors[]='File size must be less than 10 MB';
            }
        }
                    
                        // if dp not set 
        else{
            $file_name = $img;
        }
                    // for insert value into users
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,$path.$file_name);

            // sql query for update 
            
            $sqlupdate = "UPDATE `users` SET `f_name`='".$fn."', `l_name`='".$ln."', `email`='".$email."', `password`='".$pass."', `dp`='".$file_name."', `dob`='".$dob."', `gender`='".$sex."', `occupation`='".$occ."', `phone`='".$ph."', `address`='".$add."', `state`='".$st."', `pin`='".$pin."', `access`='".$acs."' WHERE `user_id` = '".$uid."'";
            
                                                        // if update 
            if(mysqli_query($conn,$sqlupdate)){
                $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">Records Updated Successfully!</h3>';
                unset($_SESSION['edit']);
            }
        }
    }
            

                                            // access 
    if(isset($_REQUEST['access'])){
        $uid = $_REQUEST['user_id'];
        $access = $_REQUEST['access'];
        $sql = "UPDATE `users` SET `access` = '".$access."' WHERE `user_id` = '".$uid."'";
        if(mysqli_query($conn,$sql)){
            $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">User '.$access.' Successfully!</h3>';
        }
    }

                                            // search user
    if(isset($_GET['search_user'])){
        $user = $_REQUEST['search_user'];
        $sql = "SELECT * FROM users WHERE `user_id` LIKE '%".$user."%' or `f_name` LIKE '%".$user."%' or `l_name` LIKE '%".$user."%' or `email` LIKE '%".$user."%' or `password`LIKE '%".$user."%' or `dob` LIKE '%".$user."%' or `gender` LIKE '%".$user."%' or `occupation` LIKE '%".$user."%' or `phone` LIKE '%".$user."%' or `address` LIKE '%".$user."%' or `state` LIKE '%".$user."%' or `pin` LIKE '%".$user."%' or `access` LIKE '%".$user."%'";

        $result = mysqli_query($conn,$sql);
        if(!$result){
            print_r($result);
        }       
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/bookdonation/links/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/bookdonation/links/css/w3s.css">
	<link rel="stylesheet" href="http://localhost/bookdonation/links/css/style.css">
    <title>Admin</title>
</head>
<body class="bg-orange px-3">
<a href="./users.php?search_user=" class="text-center text-white w3-hover-shadow"><h1>USERS</h1></a>

                                            <!-- search box -->
<div class="text-center container my-5">
    <div class="row">
        <form class="form-inline col-md-7 p-2 w3-hover-shadow" action="" method="get">
            <input class="form-control" type="search" name="search_user" placeholder="User" aria-label="Search" size="50">
            <button class="btn w3-hover-shadow" type="submit" name="search_user_button"><img src="http://localhost/bookdonation/links/image/search.png" alt=""></button>
        </form>
        <div class="col-md-5 row text-center">
            <a href="./?search_book=" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">BOOKS</h4>
            </a>
            <a href="./carts.php?search_cart=" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">CARTS</h4>
            </a>
            <a href="./bills.php?search_bill=" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">BILLS</h4>
            </a>
            <a href="../account/logout.php" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">Logout</h4>
            </a>
        </div>
    </div>
</div>


            <!-- edit or update form  -->
<?php

                                        // edit form
    if(isset($_REQUEST['edit'])){
        $uid = $_REQUEST['user_id'];

        // sql query for edit form select from user 

        $sqledit = "SELECT * FROM `users` WHERE `user_id` = '".$uid."'";
        if($resultedit = mysqli_query($conn,$sqledit)){
            if($rowedit = mysqli_fetch_assoc($resultedit)){
                $_SESSION['img'] = $rowedit['dp'];
                $_SESSION['edit'] = 1;
                echo '<div class="container">
                        <div class="row">
                            <form action="" method="post" class="col-md-7 my-5" enctype="multipart/form-data">
                                <!-- name -->
                                <div class="form-row">
                                    <div class="col-md mb-4 from-group">
                                        <input type="text" name="f_name" id="f_name" class="form-control col" placeholder="First Name" value="'.$rowedit['f_name'].'"required>
                                    </div>
                                    <div class="col-md mb-4 from-group">
                                        <input type="text" name="l_name" id="l_name" class="form-control col" placeholder="Last Name" value="'.$rowedit['l_name'].'" required>
                                    </div>
                                </div>
                
                                <!-- gender and dob -->
                                <div class="form-row font-weight-bold">
                                    <div class="col-md mb-4 from-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="male" name="gender" class="custom-control-input" checked value="'.$rowedit['gender'].'">
                                            <label class="custom-control-label" for="male">'.$rowedit['gender'].'</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="male" name="gender" class="custom-control-input" value="male">
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="female" name="gender" class="custom-control-input" value="female">
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="others" name="gender" class="custom-control-input" value="others">
                                            <label class="custom-control-label" for="others">Others</label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-4 from-group">
                                        <label for="dob">Date Of Birth</label>
                                        <input type="date" name="dob" id="dob" class="form-control col" placeholder="First Name" value="'.$rowedit['dob'].'">
                                    </div>
                                </div>
                
                                <!-- phone and occupation -->
                                <div class="form-row">
                                    <div class="col-md mb-4 from-group">
                                        <input type="text" name="phone" id="phone" onkeyup="checkphone(this.value)" class="form-control col" placeholder="Mobile NO." value="'.$rowedit['phone'].'" required>
                                        <span id="perr"></span>
                                    </div>
                                    <div class="col-md mb-4 from-group">
                                        <select class="form-control" id="occupation" name="occupation">
                                            <option>'.$rowedit['occupation'].'</option>
                                            <option>Student</option>
                                            <option>Teacher</option>
                                            <option>Social-Worker</option>
                                            <option>House-Wife</option>
                                            <option>Businessmen</option>
                                            <option>Working</option>
                                            <option>Others</option>
                                        </select>
                                    </div>
                                </div>
                
                                <!-- address -->
                                <input type="text" name="address" id="address" class="form-control mb-4" placeholder="Address" value="'.$rowedit['address'].'">
                
                                <!-- state and pin -->
                                <div class="form-row">
                                    <div class="col-md mb-4 from-group">
                                        <select class="form-control" id="state" name="state">
                                            <option>'.$rowedit['state'].'</option>
                                            <option>Andaman and Nicobar Islands</option>
                                            <option>Andhra Pradesh</option>
                                            <option>Arunachal Pradesh</option>
                                            <option>Assam</option>
                                            <option>Bihar</option>
                                            <option>Chandigarh</option>
                                            <option>Chhattisgarh</option>
                                            <option>Dadra and Nagar Haveli / Daman and Diu</option>
                                            <option>Delhi</option>
                                            <option>Goa</option>
                                            <option>Gujarat</option>
                                            <option>Haryana</option>
                                            <option>Himachal Pradesh</option>
                                            <option>Jammu and Kashmir</option>
                                            <option>Jharkhand</option>
                                            <option>Karnataka</option>
                                            <option>Kerala</option>
                                            <option>Ladakh</option>
                                            <option>Lakshadweep</option>
                                            <option>Madhya Pradesh</option>
                                            <option>Maharashtra</option>
                                            <option>Manipur</option>
                                            <option>Meghalaya</option>
                                            <option>Mizoram</option>
                                            <option>Nagaland</option>
                                            <option>Odisha</option>
                                            <option>Puducherry</option>
                                            <option>Punjab</option>
                                            <option>Rajasthan</option>
                                            <option>Sikkim</option>
                                            <option>Tamil Nadu</option>
                                            <option>Telangana</option>
                                            <option>Tripura</option>
                                            <option>Uttar Pradesh</option>
                                            <option>Uttarakhand</option>
                                            <option>Tamil Nadu</option>
                                        </select>
                                    </div>
                                    <div class="col-md mb-4 from-group">
                                        <input type="text" name="pin" id="pin" class="form-control col" placeholder="Pin No." value="'.$rowedit['pin'].'">
                                    </div>
                                </div>
                
                                <!-- email and password -->
                                <input type="email" name="email" id="email" onkeyup="checkemail(this.value)" class="form-control mb-4" placeholder="E-mail" value="'.$rowedit['email'].'" required>
                                <span id="emerr"></span>
                                <input type="text" name="password" id="password" class="form-control mb-4" placeholder="Password" value="'.$rowedit['password'].'" required>

                                
                                <select class="form-control mb-4" id="access" name="access">
                                    <option>'.$rowedit['access'].'</option>
                                    <option>Block</option>
                                    <option>Unblock</option>
                                    <option>Admin</option>
                                </select>
                                    
                
                                <!-- profile picture  -->
                                <div class="custom-file mb-4">
                                    <input type="file" class="custom-file-input" id="dp" name="dp">
                                    <label class="custom-file-label" for="customFile">Profile Picture</label>
                                </div>
                    
                                <!-- button  -->
                                <input type="hidden" name="user_id" value="'.$rowedit['user_id'].'">
                                <button type="submit" name="update" class="form-control w3-hover-shadow btn btn-lg btn-outline-dark font-weight-bold">UPDATE</button>
                
                            </form>
                            <div class="col-md-4 offset-1">
                                <img src="../links/path/dp/'.$rowedit['dp'].'" alt="book image" class="img-fluid w3-hover-shadow">
                            </div>
                        </div>
                    </div>';
            }
        }
    }

?>

            <!-- user table  -->
<?php 
    echo $forprint;
    if(mysqli_num_rows($result)>0) {
        $i = 1;

        // table and table head 

        echo '<table class="table table-dark table-striped table-sm table-responsive-lg w3-animate-top">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Profile</th>
                        <th>User</th>
                        <th>User Id</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Password</th>      
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

        // table body and row 

        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <th style="width:5%;">'.$i++.'</th>
                    <td style="width:7%;"><img src="../links/path/dp/'.$row['dp'].'" class="img-fluid"></td>
                    <td style="width:15%;">'.ucwords($row['f_name']).' '.ucwords($row['l_name']).' <br>Ph. '.$row['phone'].'</td>
                    <td>'.$row['user_id'].'</td>
                    <td>'.$row['gender'].'</td>
                    <td style="width:20%;">'.$row['address'].'<br>'.$row['state'].'<br>'.$row['pin'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['password'].'</td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="user_id" value="'.$row['user_id'].'">
                            <input type="submit" name="edit" value="Edit" class="btn btn-outline-danger btn-sm my-1 px-3 w3-hover-shadow">
                        </form>
                        <form action="" method="post">
                            <input type="hidden" name="user_id" value="'.$row['user_id'].'"><span class="blk d-none">'.$row['access'].'</span>
                            <input type="submit" name="access" value="" class="btn btn-outline-warning btn-sm my-1 px-2 w3-hover-shadow blkbtn">
                        </form>
                    </td>
                </tr>';
        }

        echo '</tbody>
        </table>
        <span class="d-none" id="lastUser">'.--$i.'</span>';
    } 
?>

    <script>
        var userLimit = document.getElementById("lastUser").innerHTML;
        var j, userValue;
        var blk = document.getElementsByClassName("blk");
        var blkbtn = document.getElementsByClassName("blkbtn");

        for(j=0; j<userLimit; j++){

            
            userValue = blk[j].innerHTML;
            if(userValue == "Block"){
                blkbtn[j].setAttribute("value","Unblock");
            }
            else{
                blkbtn[j].setAttribute("value","Block");
            }
        }
    </script>
    <script src="http://localhost/bookdonation/links/js/popper.min.js"></script>
    <script src="http://localhost/bookdonation/links/js/jquery.js"></script>
    <script src="http://localhost/bookdonation/links/js/bootstrap.min.js"></script>
    <script src="http://localhost/bookdonation/links/js/jscript.js"></script>
</body>
</html>