<?php
    session_start();
    include('../account/conn.php');
    $_SESSION['cart'] = 1;

    $sql = '';

    if(isset($_REQUEST['category'])){
        echo "hello";
    }

    $val = '';
    if(isset($_GET['search'])){
        $val = $_GET['search'];
        $book = $_GET['search'];
        $sql = "SELECT * FROM books WHERE (`book_name` LIKE '%".$book."%' or `author` LIKE '%".$book."%' or `publisher`LIKE '%".$book."%' or `book_condition` LIKE '%".$book."%' or `year` LIKE '%".$book."%' or `page` LIKE '%".$book."%' or `category` LIKE '%".$book."%' or `subject` LIKE '%".$book."%' or `class` LIKE '%".$book."%' or `description` LIKE '%".$book."%') AND (`pickedup` = 'yes') AND (`remains` > 0) ORDER BY `book_id` DESC";
    }
?>


<?php include_once('../header.php') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <select name="category" id="category" class="form-control" onchange="changeHandler()">
                <option value="">Category</option>
                <option>Education</option>
                <option>Novel</option>
                <option>Magazine</option>
                <option>Story Book</option>
                <option>Others</option>
            </select>
        </div>

        <div class="col-md">
            <select name="class" id="class" class="form-control" onchange="changeHandler()"">
                <option value="">Class</option>
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

        <div class="col-md">
            <select name="subject" class="form-control" id="subject" onchange="changeHandler()">
				<option value="">Subject</option>							
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

        <div class="col-md">
            <select class="form-control" id="year" name="year" onchange="changeHandler()">
                <option value="">Year</option>
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
</div>
<span class="d-none" id="srch"><?php echo $val ?></span>

<?php
    if($result = mysqli_query($conn,$sql)){
        $total = mysqli_num_rows($result);
        echo '<img src="../links/image/fall books.gif" alt="books" class="img-fluid ml-5" width="30">';
        
        echo '<div class="container px-5 w3-animate-zoom">
                <div class="row" id="bookdiv">';
        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 bookrow">
                    <a href="./book.php?id='.$row['book_id'].'">
                        <div class="card bg-dark border-warning w3-hover-shadow my-4 border border-dark">
                            <img src="../links/path/books/'.$row['book_image'].'" alt="j" class="card-img-top" height="160">
                            <small class="px-2 bg-danger text-white bg-success" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; position: absolute;right: -5px; top:2px;">'.$row['category'].'</small>
                            <h6 class="card-title text-warning text-truncate mx-1">'.ucwords($row['book_name']).'</h6>';
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
        echo '</div>
            </div>';
    }

?>

<script type="text/javascript">
    function changeHandler(){
        const search = $('#srch').text();
        const clss = $('#class').val();
        const subject = $('#subject').val();
        const year = $('#year').val();
        const category = $('#category').val();
        $.ajax({
            url: 'filter.php',
            type: 'POST',
            data: {cat : category, cls:clss, sub:subject, yr:year, srch:search },

            success: function(result){
                $('#bookdiv').html(result);
            }
        })
    }
</script>

<?php include_once('../footer.php') ?>