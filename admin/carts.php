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
                                                            // update 
    if(isset($_REQUEST['update']) && isset($_SESSION['edit'])){
                                                    
                                        // variable for update sql
        $sid = $_REQUEST['serial_no'];
        $cid = $_REQUEST['cart_id'];
        $uid = $_REQUEST['user_id'];
        $bid = $_REQUEST['book_id'];
        $bd = $_REQUEST['bill_done'];

            // sql query for update 
            
        $sqlupdate = "UPDATE `carts` SET `cart_id`='".$cid."', `user_id`='".$uid."', `book_id`='".$bid."', `bill_done`='".$bd."' WHERE `serial_no` = '".$sid."'";
            
                                                        // if update 
        if(mysqli_query($conn,$sqlupdate)){
            $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">Records Updated Successfully!</h3>';
            unset($_SESSION['edit']);
        }
    }
            

                                            // delete
    if(isset($_REQUEST['delete'])){
        $sid = $_REQUEST['serial_no'];
        $sql = "DELETE FROM `carts` WHERE `serial_no` = '".$sid."'";
        if(mysqli_query($conn,$sql)){
            $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">Cart Deleted Successfully!</h3>';
        }
    }

                                            // search cart
    if(isset($_GET['search_cart'])){
        $cart = $_REQUEST['search_cart'];
        $sql = "SELECT * FROM carts WHERE `serial_no` LIKE '%".$cart."%' or `cart_id` LIKE '%".$cart."%' or `user_id` LIKE '%".$cart."%' or `book_id` LIKE '%".$cart."%' or `bill_done` LIKE '%".$cart."%'";

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

<a href="./carts.php?search_cart=" class="text-center text-white w3-hover-shadow"><h1>CARTS</h1></a>

                                            <!-- search box -->
<div class="text-center container my-5">
    <div class="row">
        <form class="form-inline col-md-7 p-2 w3-hover-shadow" action="" method="get">
            <input class="form-control" type="search" name="search_cart" placeholder="Cart" aria-label="Search" size="50">
            <button class="btn w3-hover-shadow" type="submit" name="search_cart_button"><img src="http://localhost/bookdonation/links/image/search.png" alt=""></button>
        </form>
        <div class="col-md-5 row text-center">
            <a href="./?search_book=" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">BOOKS</h4>
            </a>
            <a href="./users.php?search_user=" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">USERS</h4>
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

<?php

    if(isset($_REQUEST['edit'])){
        $sid = $_REQUEST['serial_no'];

        // sql query for edit form select from cart 

        $sqledit = "SELECT * FROM `carts` WHERE `serial_no` = '".$sid."'";
        if($resultedit = mysqli_query($conn,$sqledit)){
            if($rowedit = mysqli_fetch_assoc($resultedit)){  
                $_SESSION['edit'] = 1;    
                echo '<div class="container">  
                        <form action="" class="form-inline" method="post">
                            <input type="number" name="cart_id" id="cart_id" class="form-control m-2" placeholder="Cart Id" value="'.$rowedit['cart_id'].'">
                            <input type="number" name="user_id" id="user_id" class="form-control m-2" placeholder="User Id" value="'.$rowedit['user_id'].'">
                            <input type="number" name="book_id" id="book_id" class="form-control m-2" placeholder="Book Id" value="'.$rowedit['book_id'].'">
                            <select class="form-control" id="bill_done" name="bill_done">
                                <option>'.$rowedit['bill_done'].'</option>
                                <option>yes</option>
                                <option>no</option>
                            </select>
                            <input type="hidden" name="serial_no" value="'.$rowedit['serial_no'].'">
                            <button type="submit" name="update" class="form-control w3-hover-shadow btn btn-outline-dark font-weight-bold m-2">UPDATE</button>
                        </form>
                    </div>';
            }
        }
    }
?>

            <!-- cart table  -->
<?php 
    echo $forprint;
    if(mysqli_num_rows($result)>0) {
        $i = 1;

        // table and table head 

        echo '<table class="table table-dark table-striped table-sm table-responsive-lg w3-animate-top container">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Cart S. No.</th>
                        <th>Cart Id</th>
                        <th>User Id</th>
                        <th>Book Id</th>
                        <th>Bill Done</th>      
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

        // table body and row 

        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <th>'.$i++.'</th>
                    <td style="width:10%;">'.$row['serial_no'].'</td>
                    <td style="width:30%;">'.$row['cart_id'].'</td>
                    <td>'.$row['user_id'].'</td>
                    <td>'.$row['book_id'].'</td>
                    <td>'.$row['bill_done'].'</td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="serial_no" value="'.$row['serial_no'].'">
                            <input type="submit" name="edit" value="Edit" class="btn btn-outline-danger btn-sm my-1 px-3 w3-hover-shadow">
                        </form>
                        <form action="" method="post">
                            <input type="hidden" name="serial_no" value="'.$row['serial_no'].'">
                            <input type="submit" name="delete" value="Delete" class="btn btn-outline-warning btn-sm my-1 px-2 w3-hover-shadow">
                        </form>
                    </td>
                </tr>';
        }

        echo '</tbody>
        </table>';
    } 
?>

    <script src="http://localhost/bookdonation/links/js/popper.min.js"></script>
    <script src="http://localhost/bookdonation/links/js/jquery.js"></script>
    <script src="http://localhost/bookdonation/links/js/bootstrap.min.js"></script>
    <script src="http://localhost/bookdonation/links/js/jscript.js"></script>
</body>
</html>