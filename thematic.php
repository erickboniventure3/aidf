<!doctype html>
<html class="no-js" lang="zxx">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>AIDF Organisation </title>
   <meta name="author" content="Kleanix">
   <meta name="description" content="AIDF Organisation ">
   <meta name="keywords" content="AIDF Organisation ">
   <meta name="robots" content="INDEX,FOLLOW">
   <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
   <link rel="apple-touch-icon" sizes="57x57" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="60x60" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="72x72" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logo.pngg">
   <link rel="apple-touch-icon" sizes="114x114" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="120x120" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="144x144" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="152x152" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="180x180" href="assets/img/logo.png">
   <link rel="icon" type="image/png" sizes="192x192" href="aassets/img/logo.png">
   <link rel="icon" type="image/png" sizes="32x32" href="assets/img/logo.png">
   <link rel="icon" type="image/png" sizes="96x96" href="assets/img/logo.png">
   <link rel="icon" type="image/png" sizes="16x16" href="assets/img/logo.png">
   <link rel="manifest" href="assets/img/favicons/manifest.json">
   <meta name="msapplication-TileColor" content="#ffffff">
   <meta name="msapplication-TileImage" content="assets/img/logo.png">
   <meta name="theme-color" content="#ffffff">
   <link rel="preconnect" href="https://fonts.googleapis.com/">
   <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&amp;family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&amp;display=swap" rel="stylesheet">
   <link rel="stylesheet" href="assets/css/app.min.css">
   <link rel="stylesheet" href="assets/css/fontawesome.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>
   .mobile-logo img {
      width: 100px;
      /* adjust to your preferred size */
      height: auto;
   }

   .header-logo img {
      width: 100px;
      /* adjust size here */
      height: 100px;
   }

   .th-hero-bg2 img {
      width: 100%;
      height: 100%;
      object-fit: cover;
   }

   .th-hero-bg2 {
      background-size: cover;
      background-position: center;
   }
</style>

<body>

   <div class="color-scheme">
      <button class="switchIcon"><i class="fa-solid fa-palette"></i></button>
      <h4 class="color-scheme-title"><i class="far fa-palette"></i> Color Switcher</h4>
      <p class="color-scheme-text">Check website with your color</p>
      <div class="color-switch-btns"><button data-color="#6240CF"><i class="fa-solid fa-droplet"></i></button>
         <button data-color="#068FFF"><i class="fa-solid fa-droplet"></i></button> <button data-color="#044DBC">
            <i class="fa-solid fa-droplet"></i></button> <button data-color="#FFAF00"><i class="fa-solid fa-droplet"></i></button>
         <button data-color="#F80000"><i class="fa-solid fa-droplet"></i></button> <button data-color="#231E7A"><i class="fa-solid fa-droplet"></i></button>
      </div>
      <p class="color-scheme-text">Or custom color..</p>
      <input type="color" id="thcolorpicker" value="#068FFF">
   </div>
   <div class="popup-search-box d-none d-lg-block">
      <button class="searchClose"><i class="fal fa-times"></i></button>
      <form action="#"><input type="text" placeholder="What are you looking for?"> <button type="submit"><i class="fal fa-search"></i></button></form>
   </div>





   <?php include 'layout/mobile.php'; ?>
   <?php include 'layout/header.php'; ?>


   <div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg.jpg">
      <div class="container">
         <div class="breadcumb-content">
            <h1 class="breadcumb-title">Thematic Areas</h1>
            <ul class="breadcumb-menu">
               <li><a href="index.php">Home</a></li>
               <li>Thematic Areas</li>
            </ul>
         </div>
      </div>
   </div>
   <section class="space">
      <div class="container">
         <div class="row">
            <div class="col-xl-12">
               <div class="title-area text-center">
                  <span class="sub-title">Our Focus Areas</span>
                  <h2 class="sec-title">Thematic Areas</h2>
                  <p>AIDF works across various thematic areas to address community needs and promote sustainable development.</p>
               </div>
            </div>
         </div>
         <div class="row gy-40">
            <div class="col-xl-4 col-md-6">
               <div class="service-card">
                  <div class="service-card_icon"><img src="assets/img/icon/service-icon_1-1.svg" alt="icon"></div>
                  <div class="service-card_content">
                     <h3 class="service-card_title"><a href="gender.php">Gender Equality</a></h3>
                     <p class="service-card_text">Promoting gender equality and women's empowerment in communities.</p>
                     <a href="gender.php" class="th-btn style4">Read More <i class="fas fa-arrow-right"></i></a>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-md-6">
               <div class="service-card">
                  <div class="service-card_icon"><img src="assets/img/icon/service-icon_1-2.svg" alt="icon"></div>
                  <div class="service-card_content">
                     <h3 class="service-card_title"><a href="health.php">Health</a></h3>
                     <p class="service-card_text">Improving healthcare access and health outcomes in underserved areas.</p>
                     <a href="health.php" class="th-btn style4">Read More <i class="fas fa-arrow-right"></i></a>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-md-6">
               <div class="service-card">
                  <div class="service-card_icon"><img src="assets/img/icon/service-icon_1-3.svg" alt="icon"></div>
                  <div class="service-card_content">
                     <h3 class="service-card_title"><a href="education.php">Education</a></h3>
                     <p class="service-card_text">Enhancing educational opportunities and literacy programs.</p>
                     <a href="education.php" class="th-btn style4">Read More <i class="fas fa-arrow-right"></i></a>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-md-6">
               <div class="service-card">
                  <div class="service-card_icon"><img src="assets/img/icon/service-icon_1-4.svg" alt="icon"></div>
                  <div class="service-card_content">
                     <h3 class="service-card_title"><a href="environmen.php">Environment</a></h3>
                     <p class="service-card_text">Protecting the environment and promoting sustainable practices.</p>
                     <a href="environmen.php" class="th-btn style4">Read More <i class="fas fa-arrow-right"></i></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>


   <?php include 'layout/footer.php'; ?>

   <div class="scroll-top"><svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
      </svg></div>
   <script src="assets/js/vendor/jquery-3.7.1.min.js"></script>
   <script src="assets/js/app.min.js"></script>
   <script src="assets/js/main.js"></script>
</body>

</html>