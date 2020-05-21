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
    $desc = '';
                                                            // update 
    if(isset($_REQUEST['update']) && isset($_SESSION['edit'])){
                                                    
                                        // variable for update sql
        $bid = $_REQUEST['bill_id'];
        $cid = $_REQUEST['cart_id'];
        $uid = $_REQUEST['user_id'];
        $od = $_REQUEST['order_date'];
        $ot = $_REQUEST['order_time'];
        $ph = $_REQUEST['phone'];
        $add = $_REQUEST['address'];
        $st = $_REQUEST['state'];
        $pin = $_REQUEST['pin'];
        $bk = $_REQUEST['books'];
        $dl = $_REQUEST['delivered'];
        if($_REQUEST['description'] != ''){
            $desc = $_REQUEST['description'];
        }
        else{
            $desc = $_SESSION['desc'];
        }

            // sql query for update 
            
        $sqlupdate = "UPDATE `bills` SET `cart_id`='".$cid."', `user_id`='".$uid."', `order_date`='".$od."', `order_time`='".$ot."', `phone`='".$ph."', `address`='".$add."', `state`='".$st."', `pin`='".$pin."', `books`='".$bk."', `delivered`='".$dl."', `description`='".$desc."' WHERE `bill_id` = '".$bid."'";
            
                                                        // if update 
        if(mysqli_query($conn,$sqlupdate)){
            $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">Records Updated Successfully!</h3>';
            unset($_SESSION['edit']);
        }
    }
            
                                        // delivered 
    if(isset($_REQUEST['deliver'])){
        $bid = $_REQUEST['bill_id'];
        $sql = "UPDATE `bills` SET `delivered` = '".$_REQUEST['deliver']."' WHERE `bill_id` = '".$bid."'";
        if(mysqli_query($conn,$sql)){
            $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">Updated Book Deliver : '.$_REQUEST['deliver'].'</h3>';
        }
    }
                                            // delete
    if(isset($_REQUEST['delete'])){
        $bid = $_REQUEST['bill_id'];
        $sql = "DELETE FROM `bills` WHERE `serial_no` = '".$bid."'";
        if(mysqli_query($conn,$sql)){
            $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">Bill Deleted Successfully!</h3>';
        }
    }

                                            // search bill
    if(isset($_GET['search_bill'])){
        $bill = $_REQUEST['search_bill'];
        $sql = "SELECT * FROM bills WHERE `bill_id` LIKE '%".$bill."%' or `cart_id` LIKE '%".$bill."%' or `user_id` LIKE '%".$bill."%' or `order_date` LIKE '%".$bill."%' or `order_time` LIKE '%".$bill."%' or `phone` LIKE '%".$bill."%' or `phone` LIKE '%".$bill."%' or `address` LIKE '%".$bill."%' or `state` LIKE '%".$bill."%' or `pin` LIKE '%".$bill."%' or `books` LIKE '%".$bill."%' or `description` LIKE '%".$bill."%'";

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

<a href="./bills.php?search_bill=" class="text-center text-white w3-hover-shadow"><h1>BILLS</h1></a>

                                            <!-- search box -->
<div class="text-center container my-5">
    <div class="row">
        <form class="form-inline col-md-7 p-2 w3-hover-shadow" action="" method="get">
            <input class="form-control" type="search" name="search_bill" placeholder="Bill" aria-label="Search" size="50">
            <button class="btn w3-hover-shadow" type="submit" name="search_bill_button"><img src="http://localhost/bookdonation/links/image/search.png" alt=""></button>
        </form>
        <div class="col-md-5 row text-center">
            <a href="./?search_book=" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">BOOKS</h4>
            </a>
            <a href="./users.php?search_user=" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">USERS</h4>
            </a>
            <a href="./carts.php?search_cart=" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">CARTS</h4>
            </a>
            <a href="../account/logout.php" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">Logout</h4>
            </a>
        </div>
    </div>
</div>

            <!-- edit or update form  -->
<?php

    if(isset($_REQUEST['edit'])){
        $bid = $_REQUEST['bill_id'];

        // sql query for edit form select from cart 

        $sqledit = "SELECT * FROM `bills` WHERE `bill_id` = '".$bid."'";
        if($resultedit = mysqli_query($conn,$sqledit)){
            if($rowedit = mysqli_fetch_assoc($resultedit)){  
                $_SESSION['edit'] = 1;
                $_SESSION['desc'] = $rowedit['description'];    
                echo '<div class="container">  
                        <form action="" class="form" method="post">
                            <div class="form-row">
                                <div class="col-md mb-4 from-group">
                                    <input type="number" name="cart_id" id="cart_id" class="form-control col" placeholder="Cart Id" value="'.$rowedit['cart_id'].'"required>
                                </div>
                                <div class="col-md mb-4 from-group">
                                    <input type="number" name="user_id" id="user_id" class="form-control col" placeholder="User Id" value="'.$rowedit['user_id'].'" required>
                                </div>
                                <div class="col-md mb-4 from-group">
                                    <input type="date" name="order_date" id="order_date" class="form-control col" placeholder="Order Date" value="'.$rowedit['order_date'].'"required>
                                </div>
                                <div class="col-md mb-4 from-group">
                                    <input type="text" name="order_time" id="order_time" class="form-control col" placeholder="Order Time" value="'.$rowedit['order_time'].'" required>
                                </div>
                            </div>
                            <input type="text" name="address" id="address" class="form-control mb-4" placeholder="Address" value="'.$rowedit['address'].'">
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
                                    <input type="number" name="pin" id="pin" class="form-control col" placeholder="PIN" value="'.$rowedit['pin'].'" required>
                                </div>
                                <div class="col-md mb-4 from-group">
                                    <input type="text" name="phone" id="phone" class="form-control col" placeholder="Phone" value="'.$rowedit['phone'].'"required>
                                </div>
                                <div class="col-md mb-4 from-group">
                                    <input type="number" name="books" id="books" class="form-control col" placeholder="Books" value="'.$rowedit['books'].'" required>
                                </div>
                                <div class="col-md mb-4 from-group">
                                    <select class="form-control" id="delivered" name="delivered">
                                        <option>'.$rowedit['delivered'].'</option>
                                        <option>yes</option>
                                        <option>no</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <textarea name="description" id="" class="form-control" rows="3" placeholder="Description"></textarea>
                                <small class="text-warning">*description is under 200 characters</small>
                            </div>
                            <input type="hidden" name="bill_id" value="'.$rowedit['bill_id'].'">
                            <button type="submit" name="update" class="form-control w3-hover-shadow btn btn-outline-dark font-weight-bold mb-4">UPDATE</button>
                        </form>
                    </div>';
            }
        }
    }
?>

            <!-- Bill table  -->
<?php 
    echo $forprint;
    if(mysqli_num_rows($result)>0) {
        $i = 1;

        // table and table head 

        echo '<table class="table table-dark table-striped table-sm table-responsive-lg w3-animate-top">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Bill Id</th>
                        <th>Cart/User</th>
                        <th>Date</th>
                        <th>Address</th>
                        <th>Deliverd</th>
                        <th>Phone</th>      
                        <th>Books</th>      
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

        // table body and row 

        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <th>'.$i++.'</th>
                    <td style="">'.$row['bill_id'].'</td>
                    <td style="">'.$row['cart_id'].'<br>'.$row['user_id'].'</td>
                    <td>'.$row['order_date'].'<br>'.$row['order_time'].'</td>
                    <td>'.$row['address'].'<br>'.$row['state'].', '.$row['pin'].'</td>
                    <td>
                        <p class="pick">'.$row['delivered'].'</p>
                        <form action="" method="post">
                            <input type="hidden" name="bill_id" value="'.$row['bill_id'].'">
                            <input type="submit" name="deliver" value="" class="btn btn-outline-success w3-hover-shadow yesNoBtn">
                        </form>
                    </td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['books'].'</td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="bill_id" value="'.$row['bill_id'].'">
                            <input type="submit" name="edit" value="Edit" class="btn btn-outline-danger btn-sm my-1 px-3 w3-hover-shadow">
                        </form>
                        <form action="" method="post">
                            <input type="hidden" name="bill_id" value="'.$row['bill_id'].'">
                            <input type="submit" name="delete" value="Delete" class="btn btn-outline-warning btn-sm my-1 px-2 w3-hover-shadow">
                        </form>
                    </td>
                </tr>';
        }

        echo '</tbody>
        </table>
        <span class="d-none" id="last">'.--$i.'</span>';
    } 
?>

    <script>
        var limit = document.getElementById("last").innerHTML;
        var i, value;
        var pick = document.getElementsByClassName("pick");
        var yesNoBtn = document.getElementsByClassName("yesNoBtn");

        for(i=0; i<limit; i++){

            value = pick[i].innerHTML;
            if(value == "no"){
                yesNoBtn[i].setAttribute("value","yes");
            }
            else {
                yesNoBtn[i].setAttribute("value","no");
            }
        }
    </script>
    <script src="http://localhost/bookdonation/links/js/popper.min.js"></script>
    <script src="http://localhost/bookdonation/links/js/jquery.js"></script>
    <script src="http://localhost/bookdonation/links/js/bootstrap.min.js"></script>
    <script src="http://localhost/bookdonation/links/js/jscript.js"></script>
</body>
</html>