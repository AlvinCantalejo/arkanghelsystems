<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../../res/img/favicon.svg">
    
    <title>redLifePh | Admin - Mobile Donation</title>

    <link rel="stylesheet" href="../../res/bootstrap/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <link rel="stylesheet" media="screen" href="../../res/font/font.css" type="text/css"/>
    <script src="../../res/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./../../res/jquery/jquery-3.6.0.js"></script>

    <!-- Custom styles for this template -->
    <link rel = "stylesheet" type="text/css" href="../../css/admin/drives.css">

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
                <a class="nav-link" href="request.php">
                  <i class="bi bi-bell me-2" style="font-size: 1rem;"></i>
                  Manage Requests
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="drives.php">
                  <i class="bi bi-truck me-2" style="font-size: 1rem;"></i>
                  Manage Mobile Donations
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4"></br>
            <h2 class="tableTitle">Mobile Blood Donation </h2> <br>
            <div class="row">
                <div class="col-sm-6 ">
                    <input class="form-control form-control-sm search" type="text" placeholder="Search">
                </div>

                <!-- Trigger/Open The Modal -->
                <div class="col-sm-6">
                    <p class="text-end font-monospace"> <span class ="add-new-item-button">Create New Donation Drive</span>
                        <a href="#donation-drive-modal">
                            <i class="bi bi-plus-circle me-2 add-new-item-button" style="font-size: 1rem;"></i>
                        </a>
                    </p>
                </div>
            </div> <br>

            <div class="table-responsive">
                <table class="table table-lg" id="donation-drive-table">
                    <thead>
                        <tr>
                            <td><b>ID</b></td>
                            <td>
                                <b>Donation Drive Details</b>
                            </td>
                            <td><b>Posted By</b></td>
                            <td><b>Date Posted</b></td>
                            <td  style="text-align: center"><b>Pre-registered</br>Participants</b></td>
                            <td colspan='2' style="text-align: center"><b>Actions</b></td>

                        </tr>
                    </thead>
                    <tbody id="donation-drive-table-body">
                        <tr></tr>
                    </tbody>
                </table>
            </div>
            <!-- CREATE NEW CAMPAIGN & UPDATE CAMPAIGN -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div id="donation-drive-modal" class="modal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                                <a href=""><button type="button" class="btn-close close-modal"></button></a>
                            </div>
                            <form method="post" id="donation-drive-form">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <input type="hidden" name="id" id="id" />
                                        <input type="hidden" name="method" id="method" />
                                        <input type="hidden" name="photo_file" id="photo-file" />
                                        <div class="text-center">
                                            <img id="drive-photo-view" class="rounded mb-4 border border-dark">
                                        </div>
                                        
                                        <div class="row align-items-start">   
                                            <div class="col">
                                                <label for="event-title">Event Title</label>
                                                <input type="text" class="form-control" id="event-title" name="event_title" placeholder="Blood Letting Activity 2022" >
                                            </div>
                                            <div class="col">
                                                <label class="event-photo" for="event-photo">Event Photo</label>
                                                <input type="file" accept="image/*" class="form-control event-photo" id="event-photo" name ="photo_filename">
                                            </div>
                                        </div>

                                        <div class="row align-items-start">   
                                            <div class="col align-self-start">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="event-date">Date</label>
                                                        <input type="date" class="form-control" id="event-date" name="event_date">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="event-time">Time</label>
                                                        <input type="text" class="form-control" id="event-time" name="event_time" placeholder="eg. 9:00AM - 3:00PM">
                                                    </div>
                                                </div>
                                                <label for="event-location">Location</label>
                                                <input type="text" class="form-control" id="event-location" name="event_location" placeholder="De La Salle University - Dasma" >
                                            </div>
                                            <div class="col">
                                                <label for="event-details">Details</label>
                                                <textarea class="form-control" id="event-details" name ="event_details" placeholder="Write a brief description about the event."></textarea>
                                                <span class="remaining"></span>
                                            </div>
                                        </div>
                                        <div class="pt-3 text-center">
                                            <span class="fst-italic text-danger error-message"></span>
                                        </div>
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
    <script src="../../js/admin/drives.js" type="module"></script>
  </body>
</html>
