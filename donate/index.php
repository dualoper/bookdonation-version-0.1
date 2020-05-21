<?php
	include_once('../account/conn.php');
	session_start();
	error_reporting(0);
										// if not logged in 
	if(!isset($_SESSION['email'])){
        header('location: http://localhost/bookdonation/#dropdownMenu2');
	}
										// if submit 
	if(isset($_POST['submit'])){
											// form variable for sql 
		$user = $_SESSION['user_id'];
		$book = $_REQUEST['book'];
		$auth = $_REQUEST['author'];
		$publi = $_REQUEST['publisher'];
		$condi = $_REQUEST['condition'];
		$yr = $_REQUEST['year'];
		$pg = $_REQUEST['page'];
		$qty = $_REQUEST['quantity'];
		$cat = $_REQUEST['category'];
		$cls = $_REQUEST['class'];
		$sub = $_REQUEST['subject'];
		$desc = $_REQUEST['description'];

		$errors = array();
		
												// image variable
		$path = "../links/path/books/";
		$file_tmp = '';
		$file_name = $_FILES['image']['name'];

									// if image is set 
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
			$file_name = 'book.png';
		}
									// for insert value into books 
		if(empty($errors)==true){
			move_uploaded_file($file_tmp,$path.$file_name);
			
			$sql = "INSERT INTO `books`(`user_id`, `book_name`, `author`, `publisher`, `book_condition`, `year`, `page`, `category`, `subject`, `class`, `description`, `quantity`, `book_image`) VALUES ('".$user."','".$book."','".$auth."','".$publi."','".$condi."','".$yr."','".$pg."','".$cat."','".$sub."','".$cls."','".$desc."','".$qty."','".$file_name."')";

			$result = mysqli_query($conn,$sql);

							// if inserted values in books
            if($result){
				$_SESSION['book_id'] = mysqli_insert_id($conn);
				header('location: ../search/book.php');
			}
						// if not inserted
			else{
				echo "Error: ".mysqli_error($conn);
			}
		}
	}
?>

<?php include_once('../header.php') ?>

<div class="container-fluid p-5" id="donateindx">
    
    <h1 class="text-center text-white font-weight-bold mb-5 display-4"></h1>

    <!-- donation form -->
    <div class="col-md-7 bg-orange shadow-blue p-5 my-5 trans-2 w3-animate-zoom" id="signupdiv">
        <h1 class="text-primary text-center mb-4">FILL THE FORM</h1>
        <form action="" method="post" class="" enctype="multipart/form-data" id="donateform">
            
            <!-- book -->
            <input type="text" name="book" id="book" class="form-control mb-4" placeholder="Book Name" required>

            <!-- author and publisher  -->
            <div class="form-row">
                <div class="col-md mb-4 from-group">
                    <input type="text" name="author" id="author" class="form-control col" placeholder="Author">
                </div>
                <div class="col-md mb-4 from-group">
                    <input type="text" name="publisher" id="publisher" class="form-control col" placeholder="Publisher">
                </div>
            </div>

            <!-- condition and year  -->
            <div class="form-row">
                <div class="col-md mb-4 from-group">
                    <select class="form-control" id="condition" name="condition">
                        <option value="">Condition</option>
                        <option>New</option>
                        <option>Good</option>
                        <option>Average</option>
                    </select>
                </div>
                <div class="col-md mb-4 from-group">
                    <select class="form-control" id="year" name="year">
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

            <!-- page and quantity  -->
            <div class="form-row">
                <div class="col-md-6 mb-4 from-group">
                    <select class="form-control" id="page" name="page" value="all">
                        <option value="">Page</option>
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
                    <input type="number" name="quantity" id="quantity" class="form-control col-4" min="1" max="50" value="1">
                </div>
            </div>
                
            <!-- category class and subject  -->
            <div class="form-row">

                <!-- category  -->
                <div class="col-md mb-4 from-group">
                    <select name="category" class="form-control" id="category" onchange="change_category()">
						<option value="">Category</option>
						<option>Education</option>
						<option>Novel</option>
						<option>Magazine</option>
						<option>Story Book</option>
						<option>Others</option>
					</select>
                </div>

                <!-- class  -->
                <div class="col-md mb-4 from-group d-none" id="class_div">
                    <select name="class" class="form-control" id="class">
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

                <!-- subject  -->
                <div class="col-md mb-4 from-group d-none" id="subject_div">
                    <select name="subject" class="form-control" id="subject" onchange="change_subject()">
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
			</div>
			
			<!-- image  -->
			<div class="custom-file mb-4">
                <input type="file" class="custom-file-input" id="image" name="image">
                <label class="custom-file-label" for="customFile">Book Image</label>
            </div>

            <!-- description  -->
            <div class="form-group">
				<textarea name="description" id="" class="form-control" rows="3" placeholder="Description"></textarea>
				<small class="text-warning">*description is under 200 characters</small>
			</div>

            <!-- button  -->
            <div class="form-row my-5">
                <div class="col-md">
                    <input type="reset" value="RESET" class="form-control shadow-lg btn btn-lg btn-outline-success font-weight-bold">
                </div>
                <div class="col-md">
                    <button type="submit" name="submit" class="form-control shadow-lg btn btn-lg btn-outline-success font-weight-bold">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>

</div>

<?php include_once('../footer.php')?>