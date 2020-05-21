<?php
    session_start();
    include_once('../account/conn.php');

                                        // if not logged in 
    if(!isset($_SESSION['email'])){
        header('location: http://localhost/bookdonation/#dropdownMenu2');
    }
                                        // assigning user id in variable 
    $uid = $_SESSION['user_id'];

                                // if id contained value 
    if(isset($_GET['id']) && isset($_SESSION['cart'])){
                                // query for insert values in carts 
        $bid = $_GET['id'];
        $sql = "INSERT INTO `carts` (`user_id`, `book_id`) VALUES('".$uid."', '".$bid."')";
        if(mysqli_query($conn,$sql)){
            unset($_SESSION['cart']);
        }
    }

    if(isset($_REQUEST['remove'])){
        $bid = $_REQUEST['book_id'];
        $sql = "DELETE FROM `carts` WHERE `book_id` = '".$bid."' AND `user_id` = '".$uid."' AND `bill_done` = 'no'";
        if(mysqli_query($conn,$sql)){
            
        }
    }
                                                                                                    // query for displaying books 
    $sql = "SELECT `book_id` FROM `carts` WHERE `user_id` = '".$uid."' AND `bill_done` = 'no'";
    $result = mysqli_query($conn,$sql);

?>

<?php include_once('../header.php') ?>

<div class="container py-5">

    <?php 
                                                // if result more than 0
        if(mysqli_num_rows($result)>0){
            $i = 1;
            echo '<table class="table table-dark table-striped table-sm table-responsive-lg text-center">
                    <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Image</th>
                            <th>Book</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                                                                // result assign in row 
            while($row = mysqli_fetch_assoc($result)){
                $book_id = $row['book_id'];
                                                                                        // sql query for books 
                $sqlbook = "SELECT * FROM `books` WHERE `book_id` = '".$book_id."'";
                if($resultbook = mysqli_query($conn,$sqlbook)){
                   
                    while($rowbook = mysqli_fetch_assoc($resultbook)){
                        
                                        // echo table body for books 
                        echo '<tr>
                                <th style="width: 8%;">'.$i++.'</th>
                                <td style="width: 8%;"><img src="../links/path/books/'.$rowbook['book_image'].'" alt="book" class="img-fluid"> </td>
                                <td>'.ucwords($rowbook['book_name']).'<br>'.$rowbook['class'].'<br>'.$rowbook['subject'].'</td>
                                <td style="width: 15%;">'.$rowbook['category'].'</td>
                                <td style="width: 10%;">
                                    <form action="" method="post">
                                        <input type="hidden" name="book_id" value="'.$rowbook['book_id'].'">
                                        <input type="submit" name="remove" value="Remove" class="btn btn-outline-danger">
                                    </form>
                                </td>
                            </tr>';
                    }
                }
            }
                                // buttons and end table 
            echo '</tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">TOTAL</th>
                        <th colspan="3" id="total">'.--$i.' Books</th>
                    </tr>
                </tfoot>
                </table>
            <h2>Your Cart is Ready <a href="./order.php" class="btn btn-primary float-right">Proceed to Order</a></h2>';

            $_SESSION['order'] = $i;
        }

                    // if cart is empty 
        else{
            echo "Your cart is empty";
        }
    ?>
    <a href="../search/?search=" class="btn btn-primary"> Add Books</a>
</div>

<?php include_once('../footer.php') ?>