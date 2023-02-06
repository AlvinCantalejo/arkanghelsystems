<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">

	<link rel="icon" href="./res/img/favicon.svg">

    <link href="./res/bootstrap/css/bootstrap.min.css"  rel="stylesheet">
	<script src="./res/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="./res/jquery/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" media="screen" href="./res/font/font.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="./css/main/register.css">
    
    <title>redLife.ph | Registration</title>
	<style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
</head>
<body>
	<div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 border-bottom">
			<a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
				<img src="./res/img/redLifePhLogo.svg" class="red-life-logo" alt="red-life-logo">

			</a>
			<div class="col-md-3 text-end">
				<button type="button" class="btn btn-danger me-2 open-login-form">Login</button>
			</div>
        </header>
    </div>

	<div class="container col-xl-12 col-xxl-10 px-4 py-1">
		<div class="row align-items-center g-lg-5 py-5">
			<div class="col-lg-7 text-center text-lg-start">
				<h1 class="display-4 fw-bold lh-1 mb-3 text-danger">Welcome to redLife.ph!</h1>
				<p class="col-lg-10 fs-4">Start your journey with us by creating your own account. Register now!</p>
			</div>
			<div class="col-md-10 mx-auto col-lg-5">
				<form class="p-4 p-md-4 form-box rounded-3 shadow-lg bg-body" id="registration-form">
					<h4 class="fw-bold mb-3 mt-0 text-danger">Sign Up</h1>

					<div class="row mb-3">
						<div class="col">
							<input type="text" class="form-control" id="first-name" name="first_name" placeholder="First name" required>
						</div>
						
						<div class="col">
							<input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last name" required>
						</div>
					</div>

					<div class="mb-3">
						<input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" required>
					</div>

					<div class="mb-3">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
					</div>

					<div class="mb-3">
						<input type="password" class="form-control" id="repeat-password" name="repeat_password" placeholder="Repeat Password" autocomplete="off" required>	
					</div>

					<div class="row mb-3">
						<div class="col">
							<label for="birth-date">Date of Birth </label> 
							<input class="form-control" type="date" id="birth-date" name="birth_date" value="2003-12-31" min="1956-01-01" max="2003-12-31" required/>	
						</div>
						
						<div class="col">
							<label for="gender">Gender </label> 
							<select id="gender" name="gender" class="form-select">
								<option selected disabled>Select</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</div>

					</div>

					<div>
						<label for="phone-number">Phone Number</label>
						<input class="form-control" type="text" id="phone-number" name="phone_number" placeholder="0912-345-6789" required>
					</div>

					<div class="error-msg"><span class="text-danger" id="error-message"></span></div>
					<button class="w-100 btn btn-lg btn-danger btn-register" type="submit">Register</button>

					<hr class="mb-4 mt-0">
					<div class="agreement-msg">
						<span class="text-muted">By clicking Register, you agree to our
							<!-- Place it in modal form -->
							<a href="" id="terms-link" >Terms</a> and 
							<a href="" id="privacy-link" >Privacy Setting</a>.
						</span>
					</div>
				</form>
			</div>
		</div>
  	</div>

	<?php
		include_once("./module/components/alert-modal.php");
	?>

	<script src="./js/register.js" type="module"></script>

</body>
</html>