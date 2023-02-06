<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">

	<link rel="icon" href="./res/img/arkanghel-logo.png">

    <link href="./res/bootstrap/css/bootstrap.min.css"  rel="stylesheet">
	<script src="./res/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="./res/jquery/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" media="screen" href="./res/font/font.css" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="./css/main/login.css">
    
    <title>AASCSI | Login</title>

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
        <header class="py-3 border-bottom text-center ">
			<a href="index.php" class="mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
				<img src="./res/img/arkanghel-logo.png" class="arkanghel-logo" alt="arkanghel-logo">
			</a>
        </header>
    </div>

	<div class="container col-xl-12 col-xxl-10 px-4 py-3">
		<div class="row align-items-center g-lg-5 py-4">
			<div class="col-lg-7 text-center text-lg-start">
				<h1 class="display-4 fw-bold lh-1 mb-3 text-primary">Arkanghel Systems</h1>
				<p class="col-lg-10 fs-4">Official AASCSI Student Management System</p>
				<p class="col-lg-10 fs-6">Version 1.0.1</p>
			</div>
			<div class="col-md-10 mx-auto col-lg-5">
				<form class="px-4 py-3 p-md-5 form-box rounded-3 shadow-lg bg-body" id="login-form">
					<div class="form-floating mb-3">
						<input type="username" class="form-control form-control-sm" id="username" name="username" autocomplete="off" placeholder="name@example.com" required>
						<label for="username">Username</label>
					</div>
					<div class="form-floating">
						<input type="password" class="form-control form-control-sm" id="password" name="password" autocomplete="off" placeholder="password" required>
						<label for="password">Password</label>
					</div>

					<div class="error-msg"><span class="text-danger" id="error-message"></span></div>
					<button class="w-100 btn btn-lg btn-primary btn-login" type="submit">Login</button>

					<hr class="mt-3">
					<p class="text-muted text-center fst-italic"><span class ="forgot-password-button">Forgot Password?</span>
						<a href="#forgot-password-modal">
							<i class="bi bi-plus-circle me-2 add-new-donation-button" style="font-size: 1rem;"></i>
						</a>
					</p>
					
                    
                  </p>
				</form>
			</div>

			<!-- Forgot Password Modal -->
			<div id="forgot-password-modal" class="modal" tabindex="-1">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title"></h5>
					<a href=""><button type="button" class="btn-close close-modal"></button></a>
					</div>
					<form id="new-donation-form">
					<div class="modal-body">
						<div class="container-fluid">
						<input type="hidden" name="method" id="method"/>
						<br>

						<div class="row" id="search-appointment-section">
							<div class="input-group mb-3">
							<input type="text" class="form-control" id="search-appointment-id" placeholder="Enter Appointment ID (Optional)">
							<button class="btn btn-primary" type="button" id="search-appointment">Search</button>
							</div>
							<em><span class="search_message"></span></em>
							<hr>
						</div>
						
						<div class="row" id="donation-section">
							<div class="row">
							<label for="id-donation" class="col-sm-4 col-form-label">Donation ID</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="id-donation" name="id_donation" readonly><br>
							</div>
							</div>

							<div class="row">
							<label for="id-donor" class="col-sm-4 col-form-label">Donor ID</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="id-donor" name="id_donor" readonly><br>
							</div>
							</div>
							<hr>
						</div>

						<input type="hidden" class="form-control" id="id-appointment" name="id_appointment" required><br>
						<h6 class="mb-3">Personal Information</h6>
						
						<div class="row">
							<label for="donor-name" class="col-sm-4 col-form-label">First Name</label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="first-name" name="first_name" required><br>
							</div>
						</div>

						<div class="row">
							<label for="donor-name" class="col-sm-4 col-form-label">Last Name</label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="last-name" name="last_name" required><br>
							</div>
						</div>

						<div class="row">
							<label for="birth-date" class="col-sm-4 col-form-label">Date of Birth</label> 
							<div class="col-sm-8">
							<input class="form-control" type="date" id="birth-date" name="birth_date" value="" min="1975-01-01" max="2004-12-31" required/><br>
							</div>
						</div>

						<div class="row">
							<label for="gender" class="col-sm-4 col-form-label">Gender</label>
							<div class="col-sm-8">
							<select class="form-select" id="gender" name="gender">
								<option selected hidden value="Select">Select</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select><br>
							</div>
						</div>

						<div class="row">
						<label for="phone-number" class="col-sm-4 col-form-label">Phone Number</label>
							<div class="col-sm-8">
							<input class="form-control" type="tel" id="phone-number" name="phone_number" placeholder="0912-345-6789" maxlenght="11" required><br>
							</div>
						</div>
						<hr>

						<h6 class="mb-3">Donation Details</h6>

						<div class="row">
							<label for="blood-type" class="col-sm-4 col-form-label">Blood Type</label>
							<div class="col-sm-8">
							<select class="form-select" id="blood-type" name="blood_type">
								<option selected hidden value="Select">Select</option>
								<option value="A+">A+</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B-">B-</option>
								<option value="O+">O+</option>
								<option value="O-">O-</option>
								<option value="AB+">AB+</option>
								<option value="AB-">AB-</option>
							</select><br>
							</div>
						</div>

						<div class="row">
							<label for="donation-type" class="col-sm-4 col-form-label">Donation Type</label>
							<div class="col-sm-8">
							<select class="form-select" id="donation-type" name="donation_type">
								<option selected hidden value="Select">Select</option>
								<option value="in-house">In-House Donation</option>
								<option value="donation-drive">Mobile Donation</option>
							</select><br>
							</div>
						</div>

						<div class="row">
							<label for="date-of-donation" class="col-sm-4 col-form-label">Date of Donation</label> 
							<div class="col-sm-8">
							<input class="form-control" type="date" id="donation-date" name="donation_date" value="" required/><br>
							</div>
						</div>

						<div class="row">
							<label for="donation-location" class="col-sm-4 col-form-label">Donation Location</label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="donation-location" name="donation_location" required><br>
							</div>
						</div>

						<div class="row">
							<label for="prc-personnel" class="col-sm-4 col-form-label">PRC Personnel</label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="prc-personnel" name="prc_personnel" required><br>
							</div>
						</div>

						<div class="row">
							<label for="donation-status" class="col-sm-4 col-form-label">Donation Status</label>
							<div class="col-sm-8">
							<select class="form-select" id="donation-status" name="donation_status">
								<option selected hidden value="Select">Select</option>
								<option value="Successful">Successful</option>
								<option value="Deferred">Deferred</option>
							</select><br>
							</div>
						</div>

						<div class="row" id="product-number-section" hidden>
							<label for="blood-product-number" class="col-sm-4 col-form-label">Blood Product Number</label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="blood-product-number" name="blood_product_number" required><br>
							</div>
						</div>
						
						<span class="fst-italic text-danger error-message"></span>
						</div>
					</div>
					<div class="modal-footer">
						<a href=""><button type="button" class="btn btn-outline-danger close-modal">Cancel</button></a>
						<input type="button" id="submit-form" class="btn btn-danger" value="Save">
					</div>
					</form>
				</div>
				</div>
			</div>
		</div>
  	</div>

	<?php
		include_once("./module/components/alert-modal.php");
    ?>

	<script src="./js/login.js" type="module"></script>
</body>
</html>