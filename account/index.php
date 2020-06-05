<?php
    session_start();
    include_once ('./conn.php');
                                        // if logged in 
    if(isset($_SESSION['email'])){
        header('location: ../');
    }
                        // variables 
    $done = '';
    $err['password'] = '';
    $err['email'] = '';

                                        // for sign up 
    if(isset($_POST['signup'])){

        $errors = array();
                                            // form variables for sql
        $f_name = $_REQUEST['f_name'];
        $l_name = $_REQUEST['l_name'];
        $sex = $_REQUEST['gender'];
        $dob = $_REQUEST['dob'];
        $ph = $_REQUEST['phone'];
        $occup = $_REQUEST['occupation'];
        $add = $_REQUEST['address'];
        $st = $_REQUEST['state'];
        $pin = $_REQUEST['pin'];
        $email = $_REQUEST['email'];
        $pass = $_REQUEST['password'];
        
                                            // image variables        
        $path = '../links/path/dp/';
        $file_tmp = '';
        $file_name = $_FILES['dp']['name'];
        
                                    // if image is set 
        if($file_name != ''){
                                                                // assigning variables for image 
            $file_name = date("U")."_".$_FILES['dp']['name'];
			$file_size = $_FILES['dp']['size'];
			$file_tmp = $_FILES['dp']['tmp_name'];
            $file_type = $_FILES['dp']['type'];
			
			$extensions= array("image/jpeg","image/jpg","image/png","image/img");
            
                                                                // format is incorrect 
			if(in_array($file_type,$extensions)=== false){
				$errors[]="extension not allowed, please choose a correct file.";
			}
                                                // size more than 5mb 
			if($file_size > 2097152*2.5) {
				$errors[]='File size must be less than 5 MB';
			}
        }
                        // else image is not set 
        else{
            $file_name = 'dp.png';
        }
                                        // inserting value in users
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,$path.$file_name);
            $sql = "INSERT INTO `users` (`f_name`, `l_name`, `email`, `password`, `dp`, `dob`, `gender`, `occupation`, `phone`, `address`, `state`, `pin`) VALUES ('".$f_name."','".$l_name."','".$email."','".$pass."','".$file_name."','".$dob."','".$sex."','".$occup."','".$ph."','".$add."','".$st."','".$pin."')";
            
            $result = mysqli_query($conn,$sql);

                                // if value inserted 
            if($result){
                $done = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Hi!'.$f_name.'</strong> your account is created, Now you can login to browse.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            }
                            // else error 
            else{
                echo "<script>alert('This email is taken by another account. Try another email id.')</script>";
            }
        }

                        // else error in values by user
        else{
            print_r($errors);
        }
    }
?>

<?php include_once('../header.php')?>

<div class="container-fluid p-5" id="accindx">
    <?php echo $done; ?>
    
    <!-- signup form -->
    <div class="col-md-7 bg-orange shadow-blue p-5 w3-animate-zoom" id="signupdiv">
        <h1 class="text-center text-white font-weight-bold mb-5">We are happy to have you here!</h1>
        <h1 class="text-primary text-center mb-4">CREATE ACCOUNT</h1>
        <form action="" method="post" class="" onsubmit="checkSpace()" id="signup" enctype="multipart/form-data">
            
            <!-- name -->
            <div class="form-row">
                <div class="col-md mb-4 from-group">
                    <input type="text" name="f_name" id="f_name" class="form-control col" placeholder="First Name" onkeyup="fName(this.value)" required>
                </div>
                <div class="col-md mb-4 from-group">
                    <input type="text" name="l_name" id="l_name" class="form-control col" placeholder="Last Name" onkeyup="lName(this.value)">
                </div>
            </div>

            <!-- gender and dob -->
            <div class="form-row font-weight-bold">
                <div class="col-md mb-4 from-group">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="male" name="gender" class="custom-control-input" checked value="male">
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
                    <input type="date" name="dob" id="dob" class="form-control col" min="1930-01-01" max="2010-12-31" placeholder="First Name">
                </div>
            </div>

            <!-- phone and occupation -->
            <div class="form-row">
                <div class="col-md mb-4 from-group">
                    <input type="text" name="phone" id="phone" pattern="[6-9]{1}[0-9]{9}" title="Enter Valid Mobile No." class="form-control col" placeholder="Mobile NO." required>
                </div>
                <div class="col-md mb-4 from-group">
                    <select class="form-control" id="occupation" name="occupation">
                        <option value="">Occupation</option>
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
            <input type="text" name="address" id="address" class="form-control mb-4" placeholder="Address">

            <!-- state and pin -->
            <div class="form-row">
                <div class="col-md mb-4 from-group">
                    <select class="form-control" id="state" name="state">
                        <option value="">State</option>
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
                    <input type="text" name="pin" id="pin" pattern="[0-9]{6}" title="Enter 6 digit pin no." class="form-control col" placeholder="Pin No.">
                </div>
            </div>

            <!-- email and password -->
            <input type="email" name="email" id="email" onkeyup="checkemail(this.value)" class="form-control mb-4" placeholder="E-mail" required>
            <input type="password" name="password" id="password" class="form-control mb-4" placeholder="Password" required>

            <!-- profile picture  -->
            <div class="custom-file mb-4">
                <input type="file" class="custom-file-input" id="dp" name="dp">
                <label class="custom-file-label" for="customFile">Profile Picture</label>
            </div>

            <!-- button  -->
            <div class="form-row">
                <div class="col-md">
                    <input type="reset" value="RESET" class="form-control shadow-lg btn btn-lg btn-outline-success font-weight-bold">
                </div>
                <div class="col-md">
                    <button type="submit" name="signup" class="form-control shadow-lg btn btn-lg btn-outline-success font-weight-bold">SIGN UP</button>
                </div>
            </div>

            <p class="text-center mt-5"><a href="#log_email" onclick="showLogin()">Already have an Account? / Log In</a></p>
        </form>
    </div>


    <!-- log in form  -->
    <div class="col-md-7 bg-orange shadow-blue p-5 w3-animate-zoom d-none my-5" id="logindiv" >
        <h1 class="text-center text-white font-weight-bold mb-5">We are happy to have you here!</h1>
        <h1 class="text-primary text-center mb-4">LOG IN</h1>
        <form action="" method="post" class="">
                
            <!-- email and password -->
            <input type="email" name="log_email" id="log_email" class="form-control mb-4" placeholder="E-mail" required>
            <?php 
                if($err['email']!=''){
                    echo $err['email'];
                }
            ?>
            <input type="password" name="log_pass" id="log_pass" class="form-control mb-4" placeholder="Password" required>
            <?php 
                if($err['password']!=''){
                    echo $err['password'];
                }
            ?>

            <!-- submit button  -->
            <button type="submit" name="login" class="form-control shadow-lg btn btn-lg btn-outline-success font-weight-bold" onclick="showLogin()">LOG IN</button>
            <p class="text-center mt-5"><a href="#f_name" onclick="showSignup()">Create an account to LogIn?</a></p>
        </form>
    </div> 

</div>

<?php include_once('../footer.php'); ?>

<script>
    function fName(str){
        document.getElementById("f_name").value = str.trim();
    }
    function lName(str){
        document.getElementById("l_name").value = str.trim();
    }
</script>