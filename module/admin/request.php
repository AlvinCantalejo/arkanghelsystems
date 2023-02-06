<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../../res/img/favicon.svg">
    
    <title>redLifePh | Admin - Request</title>

    <link rel="stylesheet" href="../../res/bootstrap/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <link rel="stylesheet" media="screen" href="../../res/font/font.css" type="text/css"/>
    <script src="../../res/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./../../res/jquery/jquery-3.6.0.js"></script>

    <!-- Custom styles for this template -->
    <link rel = "stylesheet" type="text/css" href="../../css/admin/request.css">

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
      <img src="../../res/img/logo.svg" class="red-life-logo" alt="red-life-logo">
      <div class="dropdown">
        <button class="d-flex order-3 p-2 profile" 
                type="button" 
                data-bs-toggle="dropdown" 
                data-bs-target="#profiledropdown" 
                aria-controls="profiledropdown" 
                aria-expanded="false">
          <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="profiledropdown">
          <div class="px-4 py-3">
            <div class="mb-4">
            <p class="fs-5"><b>Administrator</b></p>
              <span class="profileName" id="profile-name"></span>
              <p class="mb-2" id="email-address"></p>
            </div>  
            <hr>
            <a class="px-0 py-3"  href="../../logout.php">Logout</a>
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
                <a class="nav-link" href="index.php">
                  <i class="bi bi-bag-heart me-2" style="font-size: 1rem;"></i>
                  Manage Donations
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="request.php">
                  <i class="bi bi-bell me-2" style="font-size: 1rem;"></i>
                  Manage Requests
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="drives.php">
                  <i class="bi bi-truck me-2" style="font-size: 1rem;"></i>
                  Manage Mobile Donations
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4"></br>
            <h2 class="tableTitle">Manage Blood Request </h2> <br>
            <div class="row">
                <!-- Trigger/Open The Modal -->
                <div class="col-sm-12 text-end">
                    <p class="text-end font-monospace"> <span class ="add-new-request-button">Add New Request</span>
                        <a href="#request-modal">
                            <i class="bi bi-plus-circle me-2 add-new-request-button" style="font-size: 1rem;"></i>
                        </a>
                    </p>
                </div>
            </div> 
            
            <div class="row mx-0 p-2 border bg-light d-flex align-items-center">
                <div class="col-sm-1">
                  <h6 class="mb-0">FILTER</h6>
                </div>

                <div class="col-sm-3">
                  <select class="form-select form-select-sm" id ="request-status-dropdown">
                    <option selected disabled>Status</option>
                    <option value="All">All</option>
                    <option value="Processing">Processing</option>
                    <option value="Declined">Declined</option>
                    <option value="Available">Available</option>
                    <option value="Claimed">Claimed</option>
                  </select>
                </div>

                <div class="col-sm-4"></div>

                <div class="col-sm-4 text-end">
                  <input type="button" id="request-apply-filter" class="btn btn-primary btn-sm" value="Apply Filter">
                  <a href="" id="donation-clear-filter"><span class="px-2">Clear Filter</span></a><br>
                </div>
            </div><br>

              <!-- CLEAR FILTER BUTTON -->
              <div class="row">
                <div class="col-sm-8">
                  <input class="form-control form-control-sm search" type="text" placeholder="Search"><br>
                </div> 
                <div class="col-sm-4 text-end">
                    <button id="download-pdf" class="btn btn-outline-info btn-sm">
                      <i class="bi bi-filetype-pdf"></i> Download Report
                    </button>
                </div> 
              </div>
        
            <div class="table-responsive">
                <table class="table table-lg" id="request-table">
                    <thead>
                        <tr>
                            <td><b>Release Number</b></td>
                            <!-- Blood Product Info (Blood type, unit, blood product)-->
                            <td><b>Patient Info</b></td>
                            <td><b>Blood Product Info</b></td>
                            <td><b>Status</b></td>
                            <td colspan='2' style="text-align: center"><b>Actions</b></td>
                        </tr>
                    </thead>
                    <tbody id="request-table-body">
                        <tr></tr>
                    </tbody>
                </table>

                <table id="trimmed-request-table" hidden></table>
            </div>
            <!-- CREATE NEW REQUEST & UPDATE REQUEST -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div id="request-modal" class="modal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                                <a href=""><button type="button" class="btn-close close-modal"></button></a>
                            </div>
                            <form method="post" id="new-request-form">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <input type="hidden" name="id" id="id"/>
                                        <input type="hidden" name="method" id="method"/><br>
                                        
                                        <div class="row" id="release-number-section">
                                            <label for="release-number" class="col-sm-4 col-form-label">Release Number</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="release-number" name="release_number" required><br>
                                            </div>
                                        </div>
                                        <h6 class="mb-3">Patient's Information</h6>
                                        <div class="row">
                                            <label for="patient-name" class="col-sm-4 col-form-label">Patient Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="patient-name" name="patient_name" required><br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="phone-number" class="col-sm-4 col-form-label">Phone Number</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="tel" id="phone-number" name="phone_number" placeholder="0912-345-6789" maxlenght="11" required><br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="patient-location" class="col-sm-4 col-form-label">Clinic/Hospital</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="patient-clinic" name="clinic" required><br>
                                            </div>
                                        </div>
                                        <hr>

                                        <h6 class="mb-3">Request Details</h6>

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
                                            <label for="blood-unit" class="col-sm-4 col-form-label">Blood Unit</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="blood-unit" name="unit" required><br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="request-date" class="col-sm-4 col-form-label">Date of Request</label> 
                                            <div class="col-sm-8">
                                                <input class="form-control" type="date" id="request-date" name="request_date" value="" required/><br>
                                            </div>
                                        </div>

                                        
                                        <div class="row" id="update-status-section">
                                        <hr>
                                            <label for="request-status" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" id="request-status" name="request_status">
                                                <option selected hidden>Select</option>
                                                <option value="Processing">Processing</option>
                                                <option value="Available">Available</option>
                                                <option value="Declined">Declined</option>
                                                </select><br>
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

            <!-- PARTICIPANTS TABLE MODAL -->
            <div class="d-grid gap-2 d-lg-flex justify-content-md-end">
                <div id="view-participants" class="modal" tabindex="-1">
                    <div class= "modal-dialog modal-fullscreen modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pre-Registered Participants</h5>
                                <a href=""><button type="button" class="btn-close close-modal"></button></a>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                <td><b>Donor ID</b></td>
                                                <td><b>Name</b></td>
                                                <td><b>Eligibility</b></td>
                                                <td><b>Date of Registration</b></td> 
                                                <td style="text-align: center"><b>Examination</b></td> 
                                                </tr>
                                            </thead>
                                            <tbody id="participants-table-body">
                                                <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>          
                                </div>
                            </div>
                        </div>
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
    <script src="../../js/admin/request.js" type="module"></script>
  </body>
</html>
