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
                                        // image for update 
    if(isset($_SESSION['img'])){
        $img = $_SESSION['img'];
        unset($_SESSION['img']);
    }

                                        // picked 
    if(isset($_REQUEST['picked'])){
        $bid = $_REQUEST['book_id'];
        $sql = "UPDATE `books` SET `pickedup` = '".$_REQUEST['picked']."', `remains` = `quantity` WHERE `book_id` = '".$bid."'";
        if(mysqli_query($conn,$sql)){
            $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">Updated Book Pick : '.$_REQUEST['picked'].'</h3>';
        }
    }

                                                // update 
    if(isset($_REQUEST['update']) && isset($_SESSION['edit'])){
                                                    
                                        // variable for update sql
        $bid = $_REQUEST['book_id'];
        $uid = $_REQUEST['user_id'];
        $bk = $_REQUEST['book'];
        $auth = $_REQUEST['author'];
        $publi = $_REQUEST['publisher'];
        $cond = $_REQUEST['condition'];
        $yr = $_REQUEST['year'];
        $pg = $_REQUEST['page'];
        $cat = $_REQUEST['category'];
        $sub = $_REQUEST['subject'];
        $cls = $_REQUEST['class'];
        $qty = $_REQUEST['quantity'];
        $rem = $_REQUEST['remains'];
        $pick = $_REQUEST['pickedup'];
        $desc = '';
                    
        if($_REQUEST['description'] != ''){
            $desc = $_REQUEST['description'];
        }
        else{
            $desc = $_SESSION['desc'];
        }
                                                // variable for image 
        $path = "../links/path/books/";
        $file_tmp = '';
        $file_name = $_FILES['image']['name'];
        $errors = array();

                                // if image set 
        if($file_name != ''){
                        
                            // assigning image variables
            
            $file_name = date("U")."_".$_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            
            $extensions= array("image/jpeg","image/jpg","image/png","image/img");
            
                                // check image format
            
            if(in_array($file_type,$extensions)=== false){
                $errors[]="extension not allowed, please choose a correct file.";
            }
            
                                                // check image size 
            if($file_size > 2097152*5) {
                $errors[]='File size must be less than 10 MB';
            }
        }
                    
                        // if image not set 
        else{
            $file_name = $img;
        }
                    // for insert value into books 
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,$path.$file_name);

            // sql query for update 
            
            $sqlupdate = "UPDATE `books` SET `user_id`='".$uid."',`book_name`='".$bk."',`author`='".$auth."',`publisher`='".$publi."',`book_condition`='".$cond."',`year`='".$yr."',`page`='".$pg."',`category`='".$cat."',`subject`='".$sub."',`class`='".$cls."',`description`='".$desc."',`quantity`='".$qty."',`remains`='".$rem."',`pickedup`='".$pick."',`book_image`='".$file_name."' WHERE `book_id` = '".$bid."'";
            
                                                        // if update 
            if(mysqli_query($conn,$sqlupdate)){
                $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">Records Updated Successfully!</h3>';
                unset($_SESSION['edit']);
            }
        }
    }
            

                                            // delete 
    if(isset($_REQUEST['delete'])){
        $bid = $_REQUEST['book_id'];
        $sql = "DELETE FROM `books` WHERE `book_id` = '".$bid."'";
        if(mysqli_query($conn,$sql)){
            $forprint = '<h3 style="color:white; text-shadow: 5px 5px 5px black;">Record Deleted Successfully!</h3>';
        }
    }

                                            // search book
    if(isset($_GET['search_book'])){
        $book = $_REQUEST['search_book'];
        $sql = "SELECT * FROM books WHERE `book_id` LIKE '%".$book."%' or `user_id` LIKE '%".$book."%' or `book_name` LIKE '%".$book."%' or `author` LIKE '%".$book."%' or `publisher`LIKE '%".$book."%' or `book_condition` LIKE '%".$book."%' or `year` LIKE '%".$book."%' or `page` LIKE '%".$book."%' or `category` LIKE '%".$book."%' or `subject` LIKE '%".$book."%' or `class` LIKE '%".$book."%' or `description` LIKE '%".$book."%' or `quantity` LIKE '%".$book."%' or `remains` LIKE '%".$book."%' or `pickedup` LIKE '%".$book."%' ORDER BY `pickedup` ASC, `book_id` ASC";

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
<a href="./?search_book=" class="text-center text-white w3-hover-shadow"><h1>BOOKS</h1></a>

<!-- search box -->
<div class="text-center container my-5">
    <div class="row">
        <form class="form-inline col-md-7 w3-hover-shadow p-2" action="" method="get">
            <input class="form-control" type="search" name="search_book" placeholder="Book" aria-label="Search" size="50">
            <button class="btn w3-hover-shadow" type="submit" name="search_book_button"><img src="http://localhost/bookdonation/links/image/search.png" alt=""></button>
        </form>
        <div class="col-md-5 row text-center">
            <a href="./users.php?search_user=" class="col-sm w3-hover-shadow" style="height: 3rem;">
                <h4 class="text-white">USERS</h4>
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
        $bid = $_REQUEST['book_id'];

        // sql query for edit form select from book 

        $sqledit = "SELECT * FROM `books` WHERE `book_id` = '".$bid."'";
        if($resultedit = mysqli_query($conn,$sqledit)){
            if($rowedit = mysqli_fetch_assoc($resultedit)){
                $_SESSION['img'] = $rowedit['book_image'];
                $_SESSION['edit'] = 1;
                $_SESSION['desc'] = $rowedit['description'];
                echo '<div class="container">
                        <div class="row">
                            <form action="" method="post" class="col-md-7 my-5" enctype="multipart/form-data">
                                <input type="text" name="book" id="book" class="form-control mb-4" placeholder="Book Name" value="'.$rowedit['book_name'].'" required>

                                <div class="form-row">
                                    <div class="col-md mb-4 from-group">
                                        <input type="text" name="author" id="author" class="form-control col" placeholder="Author" value="'.$rowedit['author'].'">
                                    </div>
                                    <div class="col-md mb-4 from-group">
                                        <input type="text" name="publisher" id="publisher" class="form-control col" placeholder="Publisher" value="'.$rowedit['publisher'].'">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md mb-4 from-group">
                                        <select class="form-control" id="condition" name="condition">
                                            <option>'.$rowedit['book_condition'].'</option>
                                            <option>New</option>
                                            <option>Good</option>
                                            <option>Average</option>
                                        </select>
                                    </div>
                                    <div class="col-md mb-4 from-group">
                                        <select class="form-control" id="year" name="year">
                                            <option>'.$rowedit['year'].'</option>
                                            <option>2020</option>
                                            <option>2019</option>
                                            <option>2018</option>
                                            <option>2017</option>
                                            <option>2016</option>
                                            <option>2015</option>
                                            <option>2014</option>
                                            <option>2013</option>
                                            <option>2012</option>
                                            <option>2011</option>
                                            <option>2010</option>
                                            <option>2009</option>
                                            <option>2008</option>
                                            <option>2007</option>
                                            <option>2006</option>
                                            <option>2005</option>
                                            <option>2004</option>
                                            <option>2003</option>
                                            <option>2002</option>
                                            <option>2001</option>
                                            <option>2000</option>
                                            <option>Before 2000</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-4 from-group">
                                        <select class="form-control" id="page" name="page">
                                            <option>'.$rowedit['page'].'</option>
                                            <option>all</option>
                                            <option>0-10</option>
                                            <option>10-20</option>
                                            <option>20-30</option>
                                            <option>30-50</option>
                                            <option>50-70</option>
                                            <option>70-100</option>
                                            <option>100-150</option>
                                            <option>150-200</option>
                                            <option>200-250</option>
                                            <option>250-300</option>
                                            <option>300-400</option>
                                            <option>400-500</option>
                                            <option>500-700</option>
                                            <option>700-1000</option>
                                            <option>Above 1000</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4 from-group row">
                                        <label for="quantity" class="col-6 offset-2 font-weight-bold">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control col-4" min="1" max="50" value="'.$rowedit['quantity'].'">
                                    </div>
                                </div>
                                    
                                <div class="form-row">
                                    <div class="col-md mb-4 from-group">
                                        <select name="category" class="form-control" id="category" onchange="change_category()">
                                            <option>'.$rowedit['category'].'</option>
                                            <option>Education</option>
                                            <option>Novel</option>
                                            <option>Magazine</option>
                                            <option>Story Book</option>
                                            <option>Others</option>
                                        </select>
                                    </div>

                                    <div class="col-md mb-4 from-group" id="class_div">
                                        <select name="class" class="form-control" id="class">
                                            <option>'.$rowedit['class'].'</option>
                                            <option value="">Null</option>
                                            <option>Nursery</option>
                                            <option>KG</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>							
                                            <option>Bachelor</option>							
                                            <option>Master</option>							
                                            <option>PHD</option>							
                                            <option>Others</option>							
                                        </select>
                                    </div>

                                    <div class="col-md mb-4 from-group" id="subject_div">
                                        <select name="subject" class="form-control" id="subject" onchange="change_subject()">
                                            <option>'.$rowedit['subject'].'</option>							
                                            <option value="">Null</option>							
                                            <option>Hindi</option>							
                                            <option>English</option>							
                                            <option>Science</option>							
                                            <option>Physics</option>
                                            <option>Chemistry</option>
                                            <option>Biology</option>
                                            <option>Computer</option>
                                            <option>Social Science</option>
                                            <option>Pol. Science</option>
                                            <option>History</option>
                                            <option>Geography</option>
                                            <option>Mathematics</option>
                                            <option>Account</option>
                                            <option>Economics</option>
                                            <option>Business</option>
                                            <option>Drawing</option>
                                            <option>Others</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="custom-file mb-4">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="customFile">Book Image</label>
                                </div>

                                <div class="form-group">
                                    <textarea name="description" id="" class="form-control" rows="3" placeholder="Description"></textarea>
                                    <small class="text-warning">*description is under 200 characters</small>
                                </div>

                                <h3 class="text-white">Other Details</h3>

                                <div class="form-row">
                                    <div class="col-md mb-4 from-group">
                                        <input type="number" name="user_id" id="user_id" class="form-control col" placeholder="User Id" value="'.$rowedit['user_id'].'">
                                    </div>
                                    <div class="col-md mb-4 from-group">
                                        <input type="number" name="remains" id="remains" class="form-control col" placeholder="Remains" value="'.$rowedit['remains'].'">
                                    </div>
                                    <div class="col-md mb-4 from-group">
                                        <input type="text" name="pickedup" id="pickedup" class="form-control col" placeholder="Picked Up" value="'.$rowedit['pickedup'].'">
                                    </div>
                                </div>
                                
                                <input type="hidden" name="book_id" value="'.$rowedit['book_id'].'">
                                <button type="submit" name="update" class="form-control w3-hover-shadow btn btn-lg btn-outline-dark font-weight-bold">UPDATE</button>
                                
                            </form>
                            <div class="col-md-4 offset-1">
                                <img src="../links/path/books/'.$rowedit['book_image'].'" alt="book image" class="img-fluid w3-hover-shadow">
                            </div>
                        </div>
                    </div>';
            }
        }
    }

?>

            <!-- book table  -->
<?php 
    echo $forprint;
    if(mysqli_num_rows($result)>0) {
        $i = 1;

        // table and table head 

        echo '<table class="table table-dark table-striped table-sm table-responsive-lg w3-animate-top">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Image</th>
                        <th>BOOK</th>
                        <th>Book Id</th>
                        <th>Category</th>
                        <th>Picked Up</th>
                        <th>Quantity</th>
                        <th>Remains</th>      
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

        // table body and row 

        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <th style="width:5%;">'.$i++.'</th>
                    <td style="width:7%;"><img src="../links/path/books/'.$row['book_image'].'" class="img-fluid"></td>
                    <td style="width:30%;">'.ucwords($row['book_name']).' <br>'.$row['class'].'<br>'.$row['subject'].'</td>
                    <td>'.$row['book_id'].'</td>
                    <td style="width:12%;">'.$row['category'].'</td>
                    <td>
                        <p class="pick">'.$row['pickedup'].'</p>
                        <form action="" method="post">
                            <input type="hidden" name="book_id" value="'.$row['book_id'].'">
                            <input type="submit" name="picked" value="" class="btn btn-outline-success w3-hover-shadow yesNoBtn">
                        </form>
                    </td>
                    <td>'.$row['quantity'].'</td>
                    <td>'.$row['remains'].'</td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="book_id" value="'.$row['book_id'].'">
                            <input type="submit" name="edit" value="Edit" class="btn btn-outline-danger btn-sm my-1 w3-hover-shadow">
                        </form>
                        <form action="" method="post">
                            <input type="hidden" name="book_id" value="'.$row['book_id'].'">
                            <input type="submit" name="delete" value="Delete" class="btn btn-outline-warning btn-sm my-1 w3-hover-shadow">
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