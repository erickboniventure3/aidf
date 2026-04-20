<?php $isHomePage = basename($_SERVER['PHP_SELF']) === 'index.php'; ?>
<style>
   :root {
      --icon-font: "Font Awesome 6 Free";
   }
   .main-menu ul li.menu-item-has-children > a:after,
   .main-menu ul.sub-menu li.menu-item-has-children > a:after,
   .th-mobile-menu ul .menu-item-has-children > a:after,
   .th-mobile-menu ul .menu-item-has-children > a .th-mean-expand:before {
      font-family: "Font Awesome 6 Free" !important;
      font-weight: 900;
   }
</style>
<header class="th-header header-layout1<?php echo $isHomePage ? '' : ' header-inner-page'; ?>" id="siteHeader">
         <div class="header-top">
            <div class="container">
               <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                  <div class="col-auto d-none d-lg-block">
                     <div class="header-links">
                        <ul>
                           <li><i class="fa-regular fa-phone"></i> <a href="tel:+255 745 600 763 ">+255 745 600 763 </a></li>
                           <li><i class="fa-sharp fa-regular fa-envelope"></i> <a href="mailto:info@aidf.or.tz">info@aidf.or.tz</a></li>
                           <li><i class="fal fa-location-dot"></i> <a href="https://www.google.com/maps">Dar es Salaam, Tanzania</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-auto">
                     <div class="header-links">
                        <ul>
                           <li>
                              <div class="social-links"><span class="social-title">Follow Us:</span> <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a> 
                                 <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a> <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a> 
                                 </div>
                           </li>
                           <li class="d-none d-md-inline-block">
                              <div class="dropdown-link">
                                 <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/img/icon/english.png" alt="icon"> English</a>
                                 <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1" style="margin: 0px;">
                                    <li><a href="#">English</a> <a href="#">Swahili</a> <a href="#">French</a> <a href="#">Italian</a> <a href="#">Latvian</a></li>
                                 </ul>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="sticky-wrapper">
            <div class="menu-area">
               <div class="header-menu-left-shape" data-mask-src="assets/img/shape/header-menu-left-shape.png"></div>
               <div class="container">
                  <div class="row align-items-center justify-content-between">
                     <div class="col-auto">
                        <div class="header-logo"><a href="index.php"><img src="assets/img/logo.png" alt="AIDF"></a></div>
                     </div>
                     <div class="col-auto">
                        <div class="row align-items-center">
                           <div class="col-auto">
                              <nav class="main-menu d-none d-lg-inline-block">
                                 <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.php">About Us</a></li>
                                    <li class="menu-item-has-children">
                                       <a href="#">AIDF Impact</a>
                                       <ul class="sub-menu">
                                          <li><a href="health.php">Public Health</a></li>
                                          <li><a href="education.php">Education</a></li>
                                          <li><a href="gender.php">Gender Equality</a></li>
                                          <li><a href="environment.php">Environment</a></li>
                                       </ul>
                                    </li>
                                    <li><a href="aidf-care.php">AIDF Care</a></li>
                                    <!-- <li><a href="thematic.php">AIDF Impact</a></li> -->
                                    <li class="menu-item-has-children">
                                       <a href="#">Get Involved</a>
                                       <ul class="sub-menu">
                                          <li><a href="membership.php">Become a Member</a></li>
                                          <li><a href="volunteer.php">Volunteer</a></li>
                                       </ul>
                                    </li>
                                    <li><a href="contact.php">Contact</a></li>
                                 </ul>
                              </nav>
                              <button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>
                           </div>
                           <div class="col-auto d-none d-xl-block">
                              <div class="header-button">
                                 <button type="button" class="simple-icon searchBoxToggler"><i class="far fa-search"></i></button>
                                 <div class="header-info-box">
                                    <div class="header-info-box__icon"><i class="fa-sharp fa-light fa-phone"></i></div>
                                    <div class="header-info-box__content">
                                       <h4 class="header-info-box__title">Get Contact Now</h4>
                                       <p class="header-info-box__text"><a href="tel:+255 745 600 763" class="header-info-box__link">+255 745 600 763</a></p>
                                    </div>
                                 </div>
                                 <a href="donate.php" class="th-btn star-btn">Donate Now</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <div class="site-header-spacer" id="siteHeaderSpacer" aria-hidden="true"></div>
      <script>
         document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('siteHeader');
            const spacer = document.getElementById('siteHeaderSpacer');
            const topHeader = header ? header.querySelector('.header-top') : null;

            if (!header || !spacer || !topHeader) return;

            const syncHeaderSpacer = () => {
               spacer.style.height = Math.round(header.getBoundingClientRect().height) + 'px';
            };

            let lastScroll = window.pageYOffset;
            let topHidden = false;

            syncHeaderSpacer();
            window.addEventListener('resize', syncHeaderSpacer);
            window.addEventListener('load', syncHeaderSpacer);

            window.addEventListener('scroll', function() {
               const currentScroll = window.pageYOffset;

               if (currentScroll > 10) {
                  header.classList.add('is-scrolled');
               } else {
                  header.classList.remove('is-scrolled');
               }

               if (currentScroll > lastScroll && currentScroll > 120) {
                  if (!topHidden) {
                     topHeader.classList.add('hide-top');
                     topHidden = true;
                     requestAnimationFrame(syncHeaderSpacer);
                  }
               } else if (currentScroll < lastScroll) {
                  if (topHidden) {
                     topHeader.classList.remove('hide-top');
                     topHidden = false;
                     requestAnimationFrame(syncHeaderSpacer);
                  }
               }

               lastScroll = Math.max(currentScroll, 0);
            }, { passive: true });

            topHeader.addEventListener('transitionend', syncHeaderSpacer);
         });
      </script>
