<?php
    session_start();
    include('./conn.php');

    if(!isset($_SESSION['email'])){
        header('location: http://localhost/bookdonation/#dropdownMenu2');
    }
    
    $uid = $_SESSION['user_id'];

    $img = '';
                                        // dp for update 
    if(isset($_SESSION['img'])){
        $img = $_SESSION['img'];
        unset($_SESSION['img']);
    }

    
                                                // update 
    if(isset($_REQUEST['update']) && isset($_SESSION['edit'])){
                                                    
                                        // variable for update sql
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
            
            $sqlupdate = "UPDATE `users` SET `f_name`='".$fn."', `l_name`='".$ln."', `email`='".$email."', `password`='".$pass."', `dp`='".$file_name."', `dob`='".$dob."', `gender`='".$sex."', `occupation`='".$occ."', `phone`='".$ph."', `address`='".$add."', `state`='".$st."', `pin`='".$pin."' WHERE `user_id` = '".$uid."'";
            
                                                        // if update 
            if(mysqli_query($conn,$sqlupdate)){
                unset($_SESSION['edit']);
            }
        }
    }

                // user detail query

    $sql = "SELECT * FROM `users` WHERE `user_id` = '".$uid."'";
    if($result = mysqli_query($conn,$sql)){
        $row = mysqli_fetch_assoc($result);
    }
                            // Order details function
    function bill($bid){
        include('./conn.php');
        $sql_bill = "SELECT * FROM `bills` WHERE `bill_id` = '".$bid."'";
        if($result_bill = mysqli_query($conn,$sql_bill)){
            $row_bill = mysqli_fetch_assoc($result_bill);
            echo '<div class="col-md-4 px-3 border border-dark offset-md-1 w3-hover-shadow">
                    <h1 class="text-center text-white">Order Details</h1>
                    <p>Date : <i>'.$row_bill['order_date'].'</i> Time : <i>'.$row_bill['order_time'].'</i></p>
                    <table>
                        <tr>
                            <th>Bill No.</th>
                            <td>:</td>
                            <td>'.$row_bill['bill_id'].'</td>
                        </tr>
                        <tr>
                            <th>Delivered</th>
                            <td>:</td>
                            <td>'.$row_bill['delivered'].'</td>
                        </tr>
                        <tr>
                            <th>Books</th>
                            <td>:</td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="bill_id" value="'.$row_bill['bill_id'].'">
                                    <input type="submit" name="books" value="'.$row_bill['books'].'" class="btn w3-hover-shadow">
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>Phone.</th>
                            <td>:</td>
                            <td>'.$row_bill['phone'].'</td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;">Address</th>
                            <td style="vertical-align: top;">:</td>
                            <td>
                                <i>'.$row_bill['address'].'</i>
                                <br>
                                '.$row_bill['state'].' '.$row_bill['pin'].'
                            </td>
                        </tr>
                    </table>
                </div>';
        }
    }
?>

<?php include_once('../header.php') ?>

                                    <!-- user and order detail  -->
<div class="container-fluid p-5">
    <div class="row">

                                                <!-- update detail / update form  -->
        <?php
                                                // update form 
            if(isset($_REQUEST['edit'])){
                $_SESSION['img'] = $row['dp'];
                $_SESSION['edit'] = 1;
                echo '<form action="" method="post" class="col-md-7 px-3 my-2" enctype="multipart/form-data">
                        <!-- name -->
                        <div class="form-row">
                            <div class="col-md mb-4 from-group">
                                <input type="text" name="f_name" id="f_name" class="form-control col" placeholder="First Name" value="'.$row['f_name'].'"required>
                            </div>
                            <div class="col-md mb-4 from-group">
                                <input type="text" name="l_name" id="l_name" class="form-control col" placeholder="Last Name" value="'.$row['l_name'].'">
                            </div>
                        </div>
                
                        <!-- gender and dob -->
                        <div class="form-row font-weight-bold">
                            <div class="col-md mb-4 from-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="male" name="gender" class="custom-control-input" value="male" checked>
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
                                <input type="date" name="dob" id="dob" class="form-control col" placeholder="First Name" value="'.$row['dob'].'">
                            </div>
                        </div>
                
                        <!-- phone and occupation -->
                        <div class="form-row">
                            <div class="col-md mb-4 from-group">
                                <input type="text" name="phone" id="phone" onkeyup="checkphone(this.value)" class="form-control col" placeholder="Mobile NO." value="'.$row['phone'].'" required>
                            </div>
                            <div class="col-md mb-4 from-group">
                                <select class="form-control" id="occupation" name="occupation">
                                    <option>'.$row['occupation'].'</option>
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
                        <input type="text" name="address" id="address" class="form-control mb-4" placeholder="Address" value="'.$row['address'].'">
                
                        <!-- state and pin -->
                        <div class="form-row">
                            <div class="col-md mb-4 from-group">
                                <select class="form-control" id="state" name="state">
                                    <option>'.$row['state'].'</option>
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
                                <input type="text" name="pin" id="pin" class="form-control col" placeholder="Pin No." value="'.$row['pin'].'">
                            </div>
                        </div>

                        <!-- email and Password-->
                        <div class="form-row">
                            <div class="col-md mb-4 from-group">
                                <input type="email" name="email" id="email" class="form-control col" placeholder="E-mail" value="'.$row['email'].'"required>
                            </div>
                            <div class="col-md mb-4 from-group">
                                <input type="password" name="password" id="password" class="form-control col" placeholder="New Password" value="'.$row['password'].'" required>
                            </div>
                        </div>
                
                        <!-- profile picture  -->
                        <div class="custom-file mb-4">
                            <input type="file" class="custom-file-input" id="dp" name="dp">
                            <label class="custom-file-label" for="customFile">Profile Picture</label>
                        </div>

                        <!-- button  -->
                        <input type="hidden" name="user_id" value="'.$row['user_id'].'">
                        <button type="submit" name="update" class="form-control w3-hover-shadow btn btn-lg btn-outline-dark font-weight-bold">UPDATE</button>
                    </form>';
            }

                        // user details
            else{
                echo '<div class="col-md-7 px-3 my-2 row">
                        <div class="col-sm-4">
                            <img src="../links/path/dp/'.$row['dp'].'" alt="" class="img-fluid rounded">
                        </div>
                        <div class="col-sm-8">
                            <h2 class="text-white">'.ucwords( $row['f_name']).' '.ucwords($row['l_name']).'</h2>
                            <h4 class="text-primary">'.$row['email'].'</h4>
                            <br>
                            <div class="rounded p-3 text-white">
                                <table>
                                    <tr>
                                        <th>Date of Birth </th>
                                        <td> : </td>
                                        <td>'.$row['dob'].'</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>:</td>
                                        <td>'.$row['gender'].'</td>
                                    </tr>
                                    <tr>
                                        <th>Occupation</th>
                                        <td>:</td>
                                        <td>'.$row['occupation'].'</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>:</td>
                                        <td>'.$row['phone'].'</td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top;">Address</th>
                                        <td style="vertical-align: top;">:</td>
                                        <td>'.$row['address'].'<br>'.$row['state'].'-'.$row['pin'].'
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <form action="" method="post">
                                    <input type="hidden" name="user_id" value="'.$row['user_id'].'">
                                    <input type="submit" name="edit" value="EDIT PROFILE" class="btn btn-outline-success w3-hover-shadow">
                                </form>
                                    
                            </div>
                        </div>
                    </div>';
            }
        ?>

                <!-- order details and image-->
        <?php
            if(isset($_GET['bill_no'])){
                bill($_GET['bill_no']);
            }
            else{
                echo '<div class="col-md-4 px-3 offset-md-1 text-center">
                        <img src="../links/image/carousel 1.jpg" class="img-fluid py-5 w3-animate-zoom">
                    </div>';
            }
        ?> 
    </div>
</div>

<div class="container px-5">

<?php
    if(isset($_REQUEST['books'])){
        $blid = $_REQUEST['bill_id'];
        $sqlbillcart = "SELECT `book_id` FROM `carts` WHERE `cart_id` = (SELECT `cart_id` FROM `bills` WHERE `bill_id` = '".$blid."')";
        if($resultbillcart=mysqli_query($conn,$sqlbillcart)){
            $i = 1;
                
                    // table and table head 

            echo '<h3 class="text-white">Books you ordered | Bill no. : '.$blid.'</h3>
                <table class="table table-dark table-striped table-sm table-responsive-sm w3-animate-top w-75 mx-5">
                    <thead>
                        <tr>
                            <td>Sr. No.</td>
                            <td></td>
                            <td>Book</td>
                        </tr>
                    </thead>
                    <tbody>';
            while($rowbillcart = mysqli_fetch_assoc($resultbillcart)){
                $bkid = $rowbillcart['book_id'];
                $sqlbk = "SELECT * FROM `books` WHERE `book_id` = '".$bkid."'";
                if($resultbk = mysqli_query($conn,$sqlbk)){
                    while($rowbk = mysqli_fetch_assoc($resultbk)){
                        echo '<tr>
                                <td style="width: 10%">'.$i++.'</td>
                                <td style="width: 10%"><img src="../links/path/books/'.$rowbk['book_image'].'" class="img-fluid"></td>
                                <td><a href="../search/book.php?id='.$rowbk['book_id'].'">'.ucwords($rowbk['book_name']).'</a></td>
                            </tr>';
                    }                        
                }
            }
            echo'</tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center">Total</td>
                        <td class="text-center">'.--$i.' Books</td>
                    </tr>
                </tfoot>
            </table>';
        }
    }
?>

</div>

                                        <!-- donation and order table  -->
<div class="container-fluid p-5">
    <div class="row">

                                    <!-- Donation table -->
        <div class="col-md-8">
            <h1 class="bg-dark text-white text-center border border-danger">Donations</h1>
            <?php 
            $sql_dbook = "SELECT * FROM `books` WHERE `user_id` = '".$uid."' ORDER BY `book_id` DESC";
            $result_dbook = mysqli_query($conn,$sql_dbook);
            if (mysqli_num_rows($result_dbook)>0){
                $i = 1;
                $sum = 0;

                    // table and table head 

                echo '<table class="table table-dark table-striped table-sm table-responsive-sm w3-animate-top">
                        <thead>
                            <tr>
                                <td>Sr. No.</td>
                                <td></td>
                                <td>Book</td>
                                <td class="text-center">Qunatity</td>
                            </tr>
                        </thead>
                        <tbody>';
                
                        // table body 
                
                while($row_dbook = mysqli_fetch_assoc($result_dbook)){
                    $sum = $sum + $row_dbook['quantity'];
                    echo '<tr>
                            <td style="width: 10%">'.$i++.'</td>
                            <td style="width: 10%"><img src="../links/path/books/'.$row_dbook['book_image'].'" class="img-fluid"></td>
                            <td><a href="../search/book.php?id='.$row_dbook['book_id'].'">'.ucwords($row_dbook['book_name']).'</a></td>
                            <td class="text-center">'.$row_dbook['quantity'].'</td>
                        </tr>';
                }

                            // table foot 
                echo'</tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center">Total</td>
                            <td class="text-center">'.$sum.'</td>
                        </tr>
                    </tfoot>
                </table>
                <h3 class="text-white">We are very grateful to you for your Contribution in Education!</h3>';
            }  
            ?>        
        </div>

                                    <!-- Order table -->
        <div class="col-md-4">
            <h1 class="bg-dark text-white text-center border border-danger">Orders</h1>
            <?php 
            $sql_order = "SELECT * FROM `bills` WHERE `user_id` = '".$uid."' ORDER BY `bill_id` DESC";
            $result_order = mysqli_query($conn,$sql_order);
            if (mysqli_num_rows($result_order)>0){
                $i = 1;

                // table and table head 

                echo '<table class="table table-dark table-striped table-sm table-responsive-sm w3-animate-top">
                        <thead>
                            <tr>
                                <td>Sr. No.</td>
                                <td>Bill No.</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody>';

                // table body 
                
                while($row_order = mysqli_fetch_assoc($result_order)){
                    echo '<tr>
                            <td style="width: 20%">'.$i++.'</td>
                            <td><a href="./profile.php?bill_no='.$row_order['bill_id'].'">'.$row_order['bill_id'].'</a></td>
                            <td style="width:30%;">'.$row_order['order_date'].'</td>
                        </tr>';
                }

                echo'</tbody>
                </table>';
            }  
            ?>
        </div>
    </div>
</div>

<?php include_once('../footer.php') ?>