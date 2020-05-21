<?php
    session_start();
    include_once('../account/conn.php');

    if(!isset($_SESSION['email'])){
        header('location: http://localhost/bookdonation/#dropdownMenu2');
    }
    if(!isset($_SESSION['order'])){
        header('location: http://localhost/bookdonation/');
    }

    $flag = 0;
    
    $uid = $_SESSION['user_id'];

    $sql = "SELECT * FROM `users` WHERE `user_id` = '".$uid."'";

    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);

    if(isset($_POST['submit'])){
        date_default_timezone_set('Asia/Kolkata');
        $cid = date("U");
        $sqlc = "UPDATE `carts` SET `cart_id` = '".$cid."', `bill_done` = 'yes' WHERE `user_id` = '".$uid."' AND `bill_done` = 'no'";
        if(mysqli_query($conn,$sqlc)){

            

                $date = date("y-m-d");
                $time = date("H-i");
                $ph = $_REQUEST['phone'];
                $add = $_REQUEST['address'];
                $st = $_REQUEST['state'];
                $pin = $_REQUEST['pin'];
                $desc = $_REQUEST['description'];
                $bk = $_SESSION['order'];

                $sqlb = "INSERT INTO `bills` (`cart_id`, `user_id`, `order_date`, `order_time`, `phone`, `address`, `state`, `pin`, `books`, `description`) VALUES ('".$cid."', '".$uid."', '".$date."', '".$time."', '".$ph."', '".$add."', '".$st."', '".$pin."', '".$bk."', '".$desc."')";

                if(mysqli_query($conn,$sqlb)){
                    $bno = mysqli_insert_id($conn);
                    echo 'Inserted bill';
                    unset($_SESSION['order']);
                    header('location: ../account/profile.php?bill_no='.$bno.'');
                    
                }
                else{
                    mysqli_error($conn);
                }
            
            
        }
        mysqli_error($conn);
    }
    
?>

<?php include_once('../header.php') ?>

<div class="container p-5">
    <!-- <h2 class="text-white my-5" style="text-shadow: 5px 5px 5px black"> -->
    <?php if(!isset($_POST['submit']))
        echo '<h2 class="text-white my-5" style="text-shadow: 5px 5px 5px black">
                Hi '.ucwords($row['f_name']).' ! Your order is ready please fill Details.
                </h2>
            <div class="row">
                <form action="" method="post" class="col-md-7 py-5">
                    <div class="form-row">
                        <div class="col-6 mb-4 from-group">
                            <input type="text" name="phone" id="phone" class="form-control col" placeholder="Mobile NO." value="'.$row['phone'].'">
                        </div>
                    </div>
                    <input type="text" name="address" id="address" class="form-control mb-4" placeholder="Address" value="'.$row['address'].'">
                    <div class="form-row">
                        <div class="col-md mb-4 from-group">
                            <select class="form-control" id="state" name="state">
                                <option value="'.$row['state'].'">'.$row['state'].'</option>
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
                    <div class="form-group">
                        <textarea name="description" id="" class="form-control" rows="3" placeholder="Description"></textarea>
                        <small class="text-warning">*description is under 200 characters</small>
                    </div>
                    <div class="form-row">
                        <div class="col-md">
                            <input type="reset" value="RESET" class="form-control shadow-lg btn btn-lg btn-outline-success font-weight-bold">
                        </div>
                        <div class="col-md">
                            <button type="submit" name="submit" class="form-control shadow-lg btn btn-lg btn-outline-success font-weight-bold">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>';
    ?>
</div>

<?php include_once('../footer.php') ?>