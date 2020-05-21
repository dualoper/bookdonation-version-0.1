<?php
    session_start();
    include_once('../account/conn.php');
    $_SESSION['cart'] = 1;

    if(isset($_SESSION['book_id'])){
        $_GET['id'] = $_SESSION['book_id'];
    }

    if(!isset($_GET['id'])){
        header('location: ./?search=');
    }

    $bid = $_GET['id'];

    $sql = "SELECT * FROM `books` WHERE `book_id` = '".$bid."'";
?>

<?php include_once('../header.php') ?>

<?php
    if($result = mysqli_query($conn,$sql)){
        if($row = mysqli_fetch_assoc($result)){
            $user_sql = "SELECT `f_name` FROM `users` WHERE `user_id` = '".$row['user_id']."'";
            $user_result = mysqli_query($conn,$user_sql);
            $user_row = mysqli_fetch_assoc($user_result);
            $user = $user_row['f_name'];
            if(isset($_SESSION['book_id'])){
            echo '<div class="alert alert-success alert-dismissible fade show container" role="alert">
                    <strong>Hi '.ucwords($user).' !</strong> your book '.ucwords($row['book_name']).' is submitted, Please keep ready it to Pickup.
                    <br> <h2>**** Thank You ****</h2>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            }
            echo '<div class="container p-5">
                    <div class="row">
                        <img src="../links/path/books/'.$row['book_image'].'" alt="Book Image" class="img-fluid col-md-4 w3-hover-shadow">
                        <div class="col-md-6 p-5 w3-animate-left" style="height: 500px;">
                            <h1 class="font-weight-bold text-dark text-outline">'.ucwords($row['book_name']).'</h1>
                            <h3 class="font-weight-bold text-dark">'.$row['category'].' <small><sub>'.$row['year'].'</sub></small></h3>
                            <h3>'.$row['subject'].' '.$row['class'].'</h3>
                            <h5 class="text-warning">Donated By : '.ucwords($user).'</h5>
                            <p class="small">Available : '.$row['remains'].' | Book Condition : '.$row['book_condition'].' | Pages : '.$row['page'].'</p>';
                            if(isset($_SESSION['email'])){
                                if(isset($_SESSION['book_id'])){
                                    echo '<a href="../donate/" class="btn btn-success px-5 font-weight-bold w3-hover-shadow">Donate More Books</a>';
                                    unset($_SESSION['book_id']);
                                }
                                else{
                                    echo '<a href="../cart/?id='.$row['book_id'].'" class="btn btn-success px-5 font-weight-bold w3-hover-shadow">Add to Cart</a>';
                                }
                            }
                            else{
                                echo '<a href="../#dropdownMenu2" class="btn btn-outline-success w3-hover-shadow">Login to Order</a>';
                            }
                            echo '<p class="text-white">'.$row['description'].'</p>
                        </div>
                    </div>
                </div>';
        }
        else{
            echo '<div class="container m-5">
                    <h1>Book Not Found!</h1>
                </div>';
        }
    }
?>

<div class="container"><a href="./?search=<?php echo $row['category']?>" class="btn btn-outline-success m-5 w3-hover-shadow">Find More Books</a></div>

<?php include_once('../footer.php') ?>