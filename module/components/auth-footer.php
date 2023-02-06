<?php ?>

<style>
    footer a.nav-link:hover{
        text-decoration: underline;
    }
    .footer-background {
      background-image: url("./../../../res/img/footer-bg.svg");
      background-repeat: no-repeat;
      background-size: cover;
      padding-top: 5.25rem;
      position: relative;
      width: 100%;
      z-index: 380;
    }
</style>

<footer class="p-5 text-white footer-background">
  <div class="row mt-5">
    <div class="text-center mt-5">
      <a href="index.php" class="d-flex text-decoration-none">
          <img src="./../../../res/img/logo.svg" class="red-life-logo m-auto" alt="red-life-logo">
        </a>  
      <h4><i>SAVE A LIFE, GIVE BLOOD</i></h4><br><br>
      <ul class="nav justify-content-center">
          <li class="nav-item">
              <a class="nav-link text-white" href="./../donate/index.php">Donate</a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-white" href="./../request/index.php">Request</a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-white" href="./../drives/index.php">Mobile Donation</a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-white" href="./../learn/index.php">Learn</a>
          </li>
      </ul>
    </div>
  </div>
  <br>
  <div class="text-center justify-content-between border-top">
    <div class="col-12 pt-5">
      <p>&copy; 2022  redLife.ph - Philippine Red Cross Cavite Branch - Dasmariñas Chapter. All rights reserved.</p>
    </div>
    <div class="col-12">
      <a href="https://www.facebook.com/redcrossdasma"><img class="contact-icon" src="./../../../res/img/fb-logo.png"></a>
      <a href="mailto:cavitedasmarinas@redcross.org.ph"><img class="contact-icon" src="./../../../res/img/email-logo.png"></a>
    </div>
  </div>
</footer>
