<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="/../../res/img/arkanghel-logo.png">
    
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
      <img src="../../res/img/arkanghel-logo.png" class="arkanghel-logo" alt="arkanghel-logo">
      <h3 class="display-8 fw-bold lh-1 mb-1 text-primary">Arkanghel Systems</h3>
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
                  Learner Records
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="">
                  <i class="bi bi-filetype-pdf" style="font-size: 1rem;"></i>
                  Forms and Documents
                </a>
              </li>
            </ul>
          </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4"></br>
            <h2 class="tableTitle">Learner Records</h2> <br>
            <div class="row">
                <div class="col-sm-6 ">
                    <input class="form-control form-control-sm search" type="text" placeholder="Search">
                </div>

                <!-- Trigger/Open The Modal -->
                <div class="col-sm-6">
                    <p class="text-end font-monospace"> 
                      <span class ="add-new-learner-button">Add new Learner
                        <a href="#new-learner-modal">
                            <i class="bi bi-plus-circle me-2 add-new-item-button" style="font-size: 1rem;"></i>
                        </a>
                      </span>
                    </p>
                </div>
            </div> <br>

            <div class="table-responsive">
                <table class="table table-lg" id="learner-table">
                    <thead>
                        <tr>
                            <td><b>ULI Number</b></td>
                            <td><b>Personal Details</b></td>
                            <td><b>Added By</b></td>
                            <td style="text-align: center"><b>Date Added</b></td>
                            <td colspan='2' style="text-align: center"><b>Actions</b></td>

                        </tr>
                    </thead>
                    <tbody id="learner-table-body">
                        <tr></tr>
                    </tbody>
                </table>
            </div>
            <!--ADD and UPDATE LEARNER -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div id="new-learner-modal" class="modal" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                                <a href=""><button type="button" class="btn-close close-modal"></button></a>
                            </div>
                            <form method="post" id="learner-form">
                                <div class="modal-body">
                                    <div class="container-fluid">        

                                      <h5>Learner T2MIS</h5>
                                      <hr>
                                      <div class="row align-items-start">   
                                          <div class="col-8">
                                              <label for="uli-number" class="label-form">ULI Number</label>
                                              <input type="text" class="form-control" id="uli-number" name="uli_number" placeholder="XXXXXXXXXX-XXX" >
                                          </div>
                                          <div class="col-4">
                                            <label for="entry-date" class="label-form">Entry Date</label>
                                            <input type="date" class="form-control" id="entry-date" name="entry_date">
                                          </div>
                                      </div>

                                      <br><h5>Personal Information</h5>
                                      <hr>
                                      <div class="row align-items-start">   <!--row 1 -->

                                        <div class="col-4">
                                            <label class="label-form">Sex</label>
                                            <div class="row align-items-start">  

                                              <div class="col-3">
                                                <input class="form-check-input" type="radio" value="Male" name="sex_radio" id="sex-male">
                                                <label class="form-check-label" for="sex-male">
                                                  Male
                                                </label>
                                              </div>

                                              <div class="col-9">
                                                <input class="form-check-input" type="radio" value="Female"  name="sex_radio" id="sex-female">
                                                <label class="form-check-label" for="sex-female">
                                                  Female
                                                </label>
                                              </div>
                                          </div>
                                        </div>
                                          
                                        <div class="col-4">
                                            <label for="entry-date" class="label-form">Civil  Status</label>
                                            <select class="form-select form-select-sm" id ="civil-status-dropdown">
                                              <option selected disabled>Select</option>
                                              <option value="0">Single</option>
                                              <option value="1">Married</option>
                                              <option value="2">Widow/er</option>
                                              <option value="3">Separated</option>
                                              <option value="4">Solo Parent</option>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                          <label for="entry-date" class="label-form">Employment Status (before the training)</label>
                                          <select class="form-select form-select-sm" id ="employment-status-dropdown" name="employment_status">
                                            <option selected disabled>Select</option>
                                            <option value="0">Employed</option>
                                            <option value="1">Unemployed</option>
                                          </select>                                          
                                        </div>
                                      </div> <!--end row 1 -->
                                      
                                      <br>
                                      <div class="row align-items-start">   <!--row 2 -->

                                        <div class="col-3">
                                          <label for="entry-date" class="label-form">Birth Date</label>
                                          <input type="date" class="form-control" id="birth-date" name="birth_date">
                                        </div>

                                        <div class="col-1">
                                          <label for="entry-date" class="label-form">Age</label>
                                          <input type="text" class="form-control" id="age" name="age" readonly>
                                        </div>
                                          
                                        <div class="col-4">
                                            <label for="entry-date" class="label-form">Birth Place</label>
                                            <input type="text" class="form-control" id="birth-place" name="birth_place">
                                        </div>

                                        <div class="col-4">
                                          <label for="entry-date" class="label-form">Educational Attainment (before the training)</label>
                                          <select class="form-select form-select-sm" id ="educational-attainment-dropdown" name="educational_attainment" >
                                              <option selected disabled>Select</option>
                                              <option value="0">Pre-School (Nursery/Kinder/Prep)</option>
                                              <option value="1">No Grade Completed</option>
                                              <option value="2">Elementary Undergraduate</option>
                                              <option value="3">Elementary Graduate</option>
                                              <option value="4">High School Undergraduate</option>
                                              <option value="5">High School Graduate</option>
                                              <option value="6">Junior High School Graduate</option>
                                              <option value="7">Senior High School Graduate</option>
                                              <option value="8">Post Secondary Undergraduate</option>
                                              <option value="9">Post Secondary Graduate</option>
                                              <option value="10">College Undergraduate</option>
                                              <option value="11">College Graduate or Higher</option>
                                            </select>                                          
                                        </div>


                                      </div> <!-- end row 2 -->
                                    
                                    <div class="pt-3 text-center">
                                      <h1>Testing</h1>
                                      <span class="fst-italic text-danger error-message"></span>
                                    </div>
                                </div>
                            </form>
                            <div class="modal-footer">
                              <a href=""><button type="button" class="btn btn-outline-danger close-modal">Cancel</button></a>
                              <input type="button" id="submit-form" class="btn btn-danger" value="Save">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PARTICIPANTS TABLE MODAL -->
            <div class="d-grid gap-2 d-lg-flex justify-content-md-end">
                <div id="view-participants" class="modal" tabindex="-1">
                    <div class= "modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title">Pre-Registered Participants</h5>
                                <a href=""><button type="button" class="btn-close close-modal"></button></a>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-sm-9">
                                </div> 
                                <div class="col-sm-3 text-end">
                                    <button id="download-pdf" class="btn btn-outline-info btn-sm">
                                      <i class="bi bi-filetype-pdf"></i> Save as PDF
                                    </button>
                                </div> 
                              </div>
                                <div class="container-fluid">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                <td><b>Donor ID</b></td>
                                                <td><b>Name</b></td>
                                                <td><b>Date of Registration</b></td>  
                                                </tr>
                                            </thead>
                                            <tbody id="participants-table-body">
                                                <tr></tr>
                                            </tbody>
                                        </table>
                                        <table id="trimmed-participants-table" hidden></table>
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
    <script src="../../js/admin/index.js" type="module"></script>
  </body>
</html>
