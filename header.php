<?php
										// varrable for check error 
	$err['password']='';
	$err['email']='';

										// if for loging in 
    if(isset($_POST['login'])){

        									// login variable 
        $email = $_REQUEST['log_email'];
        $pass = $_REQUEST['log_pass'];
																				// mysql query
        $sql = "SELECT * FROM `users` WHERE `email` = '".$email."'";
        $result = mysqli_query($conn, $sql);
        										// email check 
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {

                													// check password 
                if($_REQUEST['log_pass'] === $row['password']) {

														// check user blocked or unblocked 
					if($row['access'] != "Block"){
																		// assigning session variable
						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['f_name'] = $row['f_name'];
						$_SESSION['phone'] = $row['phone'];
						$_SESSION['dp'] = $row['dp'];
																		//for check admin
						if($row['access'] === "Admin"){
							$_SESSION['access'] = $row['access'];
							header('location: http://localhost/bookdonation/admin/?search_book=');
							break;
						}

						header('location: http://localhost/bookdonation/');
					}
					else{
						echo "<script>alert('you are blocked')</script>";
					}
				}
							// password error 
                else{
					$err['password'] = '<span class="text-danger">Enter Correct Password</span>';
					echo "<script>alert('incorrect password')</script>";
                }
            }
		}
							// email error 
        else{
			$err['email'] = '<span class="text-danger">Invalid email</span>';
			echo "<script>alert('invalid email')</script>";
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
    <title>Book Donation System</title>
</head>
<body class="bg-orange">

	<!-- navbar  -->
	<nav class="navbar navbar-expand-lg shadow bg-dark font-weight-bold" style="position:sticky; top:0px; z-index: 2;">
	
		<!-- logo  -->
		<a class="navbar-brand w3-animate-top" href="http://localhost/bookdonation/"><img src="http://localhost/bookdonation/links/image/bd logo.png" alt="logo"></a>
		
		<!-- search -->
		<form class="form-inline" action="http://localhost/bookdonation/search/" method="get">
			<input class="form-control" type="search" name="search" placeholder="Book, Author or Category" id="search" <?php  if(isset($_GET['search'])) { echo $_GET['search'];} ?> aria-label="Search" size="50">
			<button class="btn" type="submit" name="submit"><img src="http://localhost/bookdonation/links/image/search.png" alt="" class="rounded w3-hover-shadow"></button>
		</form>
		

		<!-- toggler button for small screen (collapse) -->
		<button class="navbar-toggler btn btn-outline-danger btn-lg text-orange w3-hover-shadow" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			&#9776;
		</button>
		
		<!-- menu  -->
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto float-right text-right">
				<li class="nav-item"><a class="nav-link text-orange w3-hover-shadow" href="http://localhost/bookdonation/">HOME</a></li>
				<li class="nav-item"><a class="nav-link text-orange w3-hover-shadow" href="http://localhost/bookdonation/donate/#book">DONATE</a></li>
				<li class="nav-item"><a class="nav-link text-orange w3-hover-shadow" href="#about">ABOUT US</a></li>

				<!-- login logout  -->
				<?php

					// logged in 
					if(isset($_SESSION['email'])) {
						echo '<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<img src="http://localhost/bookdonation/links/path/dp/'.$_SESSION['dp'].'" class="rounded-circle w3-hover-shadow" height="54" width="54" alt="LOGGED IN">
								</a>
								<div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
									<span class="text-orange text-center ml-3">'.ucwords($_SESSION['f_name']).'</span>
									<a class="dropdown-item text-orange" href="http://localhost/bookdonation/donate/">DONATE</a>
									<a class="dropdown-item text-orange" href="http://localhost/bookdonation/account/profile.php">PROFILE</a>
									<div class="dropdown-divider bg-dark"></div>
									<a class="dropdown-item text-orange" href="http://localhost/bookdonation/account/logout.php">LOGOUT</a>
								</div>
							</li>';
					} 

					// logged out 
					else {
						echo '<li class="nav-item dropdown">
                				<a class="nav-link text-orange dropdown-toggle  w3-hover-shadow" href="#" id="dropdownMenu2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      				LOGIN / SIGNUP
								</a>
                    				<div class="dropdown-menu bg-dark px-2 pb-3" aria-labelledby="dropdownMenu2" style="width:250px";>
                        				<form action="" method="post">
                              				<input type="email" name="log_email" class="form-control my-2" id="exampleDropdownFormEmail1" placeholder="email@example.com">
											<input type="password" name="log_pass" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
											<a class="text-primary" href="#">Forgot password?</a>										
											<div class="form-check py-2 text-orange">
												<input type="checkbox" class="form-check-input" id="dropdownCheck">
												<label class="form-check-label" for="dropdownCheck">Remember</label>
												<button type="submit" class="btn btn-outline-danger text-orange shadow-lg font-weight-bold float-right" name="login">LOG IN</button>
                          					</div>                            					
										</form>
										<br>
										<a class="text-orange float-right" href="http://localhost/bookdonation/account/">SIGN UP / NEW ACCOUNT</a>	
                    				</div>
              				</li>';
					}
				?>

				<!-- cart  -->
				<li class="nav-item">
					<a class="nav-link" href="http://localhost/bookdonation/cart/">
						<img src="http://localhost/bookdonation/links/image/cart.png" width="50" alt="YOUR ORDER" class="w3-hover-shadow">
					</a>
				</li>
			</ul>
		</div>
	</nav>
