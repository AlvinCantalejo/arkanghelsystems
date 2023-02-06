<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../../res/img/Arkanghel logo.png">
    
    <title>AASCSI | Admin</title>

    <link rel="stylesheet" href="../../res/bootstrap/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <link rel="stylesheet" media="screen" href="../../res/font/font.css" type="text/css"/>
    <script src="../../res/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./../../res/jquery/jquery-3.6.0.js"></script>

    <!-- Custom styles for this template -->
    <link rel = "stylesheet" type="text/css" href="../../css/admin/index.css">

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
    <header class="navbar navbar-dark navbar-expand-lg sticky-top px-4 py-2 shadow justify-content-between">
      <button class="navbar-toggler d-md-none collapsed" 
              style="color: white" 
              type="button" 
              data-bs-toggle="collapse" 
              data-bs-target="#sidebarMenu" 
              aria-controls="sidebarMenu" 
              aria-expanded="false">
        <i class="bi bi-list" style="font-size: 2rem;"></i>
      </button>        
      <img src="../../res/img/Arkanghel logo.png" class="arkanghel-logo" alt="arkanghel-logo">
      <div class="dropdown">
        <button class="d-flex order-3 p-2 profile" 
                type="button" 
                data-bs-toggle="dropdown" 
                data-bs-target="#profiledropdown" 
                aria-controls="profiledropdown" 
                aria-expanded="false">
          <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end text-small shadow profile-dropdown" aria-labelledby="profiledropdown">
          <div class="px-4 py-3">
            <div class="mb-4">
              <p class="fs-5"><b>Administrator</b></p>
              <span class="profileName" id="profile-name"></span>
              <p class="mb-2" id="email-address"></p>
            </div>  
            <hr>
            <a class="px-0 py-3" href="../../logout.php">Logout</a>
          </div>
        </div>
      </div>
    </header>

    <div class="container-fluid">
      <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
          <div class="position-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">
                  <i class="bi bi-bag-heart me-2" style="font-size: 1rem;"></i>
                  Registration
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="request.php">
                  <i class="bi bi-bell me-2" style="font-size: 1rem;"></i>
                  Records
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="drives.php">
                  <i class="bi bi-truck me-2" style="font-size: 1rem;"></i>
                  Manage 
                </a>
              </li>
            </ul>
          </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="pt-4 pb-2 mb-3">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" 
                    href="#donations" 
                    data-bs-toggle="tab">
                    Donations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"
                    href="#appointment" 
                    data-bs-toggle="tab">
                    Donation Appointment</a>
              </li>
            </ul>
          </div>

          <div class="tab-content">
            <!-- 1st Tab -->
            <div class="tab-pane fade active show" id="donations">
              <h1 class="h2">Manage All Donations</h1>
              

              <div class="row">
                <!-- Trigger/Open The Modal -->
                <div class="col-sm-12 text-end">
                  <p class="font-monospace"> <span class ="add-new-donation-button">Add New Donation</span>
                    <a href="#new-donation-modal">
                      <i class="bi bi-plus-circle me-2 add-new-donation-button" style="font-size: 1rem;"></i>
                    </a>
                  </p>
                </div>
              </div>

              <div class="row mx-0 p-2 border bg-light d-flex align-items-center">
                <div class="col-sm-1">
                  <h6 class="mb-0">FILTER</h6>
                </div>

                <div class="col-sm-3">
                  <select class="form-select form-select-sm" id="donation-type-dropdown">
                    <option selected disabled>Donation Type</option >
                    <option value="All" >All</option>
                    <option value="in-house">In-House Donation</option>
                    <option value="donation-drive">Mobile Donation</option>
                  </select>
                </div>
                
                <div class="col-sm-2">
                  <select class="form-select form-select-sm" id="donation-status-dropdown">
                    <option selected disabled>Status</option>
                    <option value="All">All</option>
                    <option value="Successful">Successful</option>
                    <option value="Deferred">Deferred</option>
                  </select>
                </div>

                <div class="col-sm-3">
                  <select class="form-select form-select-sm" id="donation-batch-dropdown">
                  </select>
                </div>

                <div class="col-sm-3 text-end">
                  <input type="button" id="donation-filter-button" class="btn btn-primary btn-sm" value="Apply Filter">
                  <a href="" id="donation-clear-filter"><span class="px-2">Clear Filter</span></a><br>
                </div>
              </div><br>

              <!-- CLEAR FILTER BUTTON -->
              <div class="row">
                <div class="col-sm-8">
                  <input class="form-control form-control-sm search" type="text" placeholder="Search"><br>
                </div> 
                <div class="col-sm-2 text-end" >
                    <button id="remind-donors"  class="btn btn-outline-warning btn-sm">
                      <i class="bi bi-bell"></i> Remind Donors
                    </button>
                </div> 
                <div class="col-sm-2" >
                    <button id="download-pdf" class="btn btn-outline-info btn-sm">
                      <i class="bi bi-filetype-pdf"></i> Download Report
                    </button>
                </div> 
              </div>

              <div class="table-responsive">
                <table class="table table-lg" id="donation-table">
                  <thead>
                    <tr>
                      <td><b>Donation Number</b></td>
                      <td><b>Donor Details</b></td>
                      <td><b>Donation Details</b></td>
                      <td><b>Blood Details</b></td>
                      <td><b>Status</b></td>
                      <td colspan='2' style="text-align: center"><b>Actions</b></td>
                    </tr>
                  </thead>
                  <tbody id="donation-table-body">
                    <tr></tr>
                  </tbody>
                </table>

                <table id="trimmed-donation-table" hidden></table>
              </div>

              <!-- ADD NEW DONATION & UPDATE DONOR'S INFORMATION -->
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div id="new-donation-modal" class="modal" tabindex="-1">
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
            <!-- 2nd Tab -->
            <div class="tab-pane fade" id="appointment">
              <h1 class="h2">Incoming Appointments</h1><br>

              <div class="row mx-0 p-2 border bg-light d-flex align-items-center">
                <div class="col-sm-1">
                  <h6 class="mb-0">FILTER</h6>
                </div>

                <div class="col-sm-2 pe-0">
                  <select class="form-select form-select-sm" id="appointment-type-dropdown" >
                    <option disabled>Appointment Type</option>
                    <option selected value="all">All</option>
                    <option value="in-house">In-House Donation</option>
                    <option value="donation-drive">Mobile Donation</option>
                  </select>
                </div>

                <div class="col-sm-2 pe-0">
                  <input class="form-control form-control-sm" type="date" name="filter_date" id="appointment-date-picker" value="" disabled/>
                </div>

                <div class="col-sm-2 pe-0">
                  <select class="form-select form-select-sm" id="appointment-time-dropdown" disabled>
                    <option  disabled>Time of Appointment</option>
                    <option selected value="all">All</option>
                    <option value="9:00AM">09:00 AM</option>
                    <option value="10:00AM">10:00 AM</option>
                    <option value="11:00AM">11:00 AM</option>
                    <option value="12:00PM">12:00 NN</option>
                    <option value="1:00PM">01:00 PM</option>
                    <option value="2:00PM">02:00 PM</option>
                  </select>
                </div>

                <div class="col-sm-2 pe-0">
                  <select class="form-select form-select-sm" id="appointment-status-dropdown">
                    <option disabled>Status</option>
                    <option value="all">All</option>
                    <option selected value="Active">Active</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Success">Success</option>
                  </select>
                </div>

                <div class="col-sm-3 text-end">
                  <input type="button" id="appointment-filter-button" class="btn btn-primary btn-sm" value="Apply Filter">
                  <a href="" id="appointment-clear-filter"><span class="px-2">Clear Filter</span></a><br>
                </div>
              </div><br>

              <!-- CLEAR FILTER BUTTON -->

              <div class="row">
                <div class="col-sm-5">
                  <input class="form-control form-control-sm search" type="text" placeholder="Search">
                </div>
              </div><br>

              <div class="table-responsive">
                <table class="table table-lg" id="appointment-table">
                  <thead>
                    <tr>
                      <td><b>Appointment ID</b></td>
                      <td><b>Donor Info</b></td>
                      <td><b>Appointment Details</b></td>
                      <td><b>Status</b></td>
                    </tr>
                  </thead>
                  <tbody id="appointment-table-body">
                    <tr></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- CONFIRMATION MODAL -->
          <?php include_once("../components/confirmation-modal.php"); ?>

          <!-- ALERT MODAL -->
          <?php include_once("../components/alert-modal.php"); ?>
        </main>
      </div>
    </div>
    <script src="../../js/admin/index.js" type="module"></script>
  </body>
</html>
