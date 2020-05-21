<?php
    session_start();
    include('../account/conn.php');

    $search = $_POST['srch'];
    $cat = $_POST['cat'];
    $clss = $_POST['cls'];
    $subject = $_POST['sub'];
    $year = $_POST['yr'];

    $sql = "SELECT * FROM `books` WHERE (`category` LIKE '%".$cat."%') AND (`class` LIKE '%".$clss."%') AND (`subject` LIKE '%".$subject."%') AND (`year` LIKE '%".$year."%') AND (`book_name` LIKE '%".$search."%' OR `author` LIKE '%".$search."%' OR `publisher` LIKE '%".$search."%' OR `book_condition` LIKE '%".$search."%' OR `page` LIKE '%".$search."%' OR `description` LIKE '%".$search."%')";
    $result = mysqli_query($conn,$sql);
    if(!$result) {
        echo "Error:- ".mysqli_error($conn);
    }
    while($row = mysqli_fetch_assoc($result)){
        echo '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 bookrow">
                <a href="./book.php?id='.$row['book_id'].'">
                    <div class="card bg-dark border-warning w3-hover-shadow my-4">
                        <img src="../links/path/books/'.$row['book_image'].'" alt="j" class="card-img-top" height="160">
                        <small class="px-2 bg-danger text-white bg-success" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; position: absolute;right: -5px; top:2px;">'.$row['category'].'</small>
                        <h6 class="card-title text-warning text-truncate mx-1">'.ucwords($row['book_name']).'</h6>  ';
                        if(isset($_SESSION['email'])){
                            echo '<a href="../cart/?id='.$row['book_id'].'" class="btn btn-success btn-sm">Add to Cart</a>';
                        }
                        else{
                            echo '<a href="../#dropdownMenu2" class="btn btn-outline-danger btn-sm">Login to Order</a>';
                        }
                echo '</div>
                </a>
            </div>';
    }

?>