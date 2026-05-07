<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Donate to AIDF - Support Our Mission</title>
   <meta name="author" content="Kleanix">
   <meta name="description" content="Make a donation to AIDF and help us empower communities through sustainable development initiatives in Tanzania">
   <meta name="keywords" content="AIDF Donate, Support AIDF, Tanzania Development">
   <meta name="robots" content="INDEX,FOLLOW">
   <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
   <link rel="apple-touch-icon" sizes="57x57" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="60x60" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="72x72" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="114x114" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="120x120" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="144x144" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="152x152" href="assets/img/logo.png">
   <link rel="apple-touch-icon" sizes="180x180" href="assets/img/logo.png">
   <link rel="icon" type="image/png" sizes="192x192" href="assets/img/logo.png">
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

      .hero-area {
         display: flex;
         align-items: center;
         justify-content: center;
         text-align: center;
         color: white;
         height: 60vh;
         background-size: cover;
         background-position: center;
      }

      .hero-area h1 {
         font-size: 48px;
         font-weight: 700;
         margin-bottom: 20px;
      }

      .donation-amounts {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
         gap: 15px;
         margin: 30px 0;
      }

      .amount-btn {
         padding: 20px;
         border: 2px solid #ddd;
         border-radius: 10px;
         text-align: center;
         cursor: pointer;
         transition: all 0.3s;
         background: white;
      }

      .amount-btn:hover,
      .amount-btn.active {
         border-color: #00a651;
         background: #f8f9fa;
      }

      .amount-btn .price {
         font-size: 24px;
         font-weight: bold;
         color: #00a651;
      }

      .custom-amount {
         margin: 20px 0;
      }

      .custom-amount input {
         width: 100%;
         padding: 15px;
         border: 2px solid #ddd;
         border-radius: 5px;
         font-size: 18px;
      }

      .payment-methods {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
         gap: 20px;
         margin: 30px 0;
      }

      .payment-method {
         padding: 20px;
         border: 2px solid #ddd;
         border-radius: 10px;
         text-align: center;
         cursor: pointer;
         transition: all 0.3s;
      }

      .payment-method:hover,
      .payment-method.active {
         border-color: #00a651;
         background: #f8f9fa;
      }

      .payment-method i {
         font-size: 30px;
         color: #00a651;
         margin-bottom: 10px;
      }

      .impact-preview {
         background: #f8f9fa;
         padding: 30px;
         border-radius: 15px;
         margin: 30px 0;
      }

      .payment-details-box {
         background: #ffffff;
         border: 1px solid #e7efe9;
         border-left: 4px solid #00a651;
         padding: 24px;
         border-radius: 14px;
         box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
      }

      .payment-detail-item {
         margin-bottom: 16px;
      }

      .payment-detail-item:last-child {
         margin-bottom: 0;
      }

      .payment-detail-item strong {
         display: block;
         color: #111;
         margin-bottom: 6px;
      }

      .payment-detail-item span {
         display: block;
         color: #555;
         line-height: 1.7;
         word-break: break-word;
      }

      .impact-item {
         display: flex;
         align-items: center;
         margin-bottom: 15px;
      }

      .impact-item i {
         color: #00a651;
         margin-right: 15px;
         font-size: 20px;
      }
   </style>
</head>

<body>
   <?php include 'layout/mobile.php'; ?>
   <?php include 'layout/header.php'; ?>

   <!-- HERO -->
   <!-- <section class="hero-area" style="background-image: url('assets/img/project/p1.jpeg');">
         <div class="container">
            <span class="sub-title">Support Our Mission</span>
            <h1>Make a Donation Today</h1>
            <p>Your generosity helps us empower communities and create sustainable development across Tanzania</p>
         </div>
      </section> -->

   <!-- DONATION FORM -->
   <section class="space">
      <div class="container">
         <!-- Success/Error Messages -->
         <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
               <i class="fas fa-check-circle"></i> Thank you for your donation! Your contribution has been recorded and you will receive a confirmation email shortly.
               <?php if (isset($_GET['email_error'])): ?>
                  <br><small class="text-muted">Note: There was an issue sending the confirmation email, but your donation was successfully recorded.</small>
               <?php endif; ?>
               <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
         <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
               <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
         <?php endif; ?>

         <div class="row">
            <div class="col-lg-8">
               <h2 class="mb-4">Choose Your Donation Amount</h2>

               <form action="process_donation.php" method="post" id="donationForm">
                  <!-- Amount Selection -->
                  <div class="donation-amounts">
                     <div class="amount-btn" data-amount="50000">
                        <div class="price">TZS 50,000</div>
                        <div>≈ $20 USD</div>
                     </div>
                     <div class="amount-btn" data-amount="100000">
                        <div class="price">TZS 100,000</div>
                        <div>≈ $40 USD</div>
                     </div>
                     <div class="amount-btn" data-amount="250000">
                        <div class="price">TZS 250,000</div>
                        <div>≈ $100 USD</div>
                     </div>
                     <div class="amount-btn" data-amount="500000">
                        <div class="price">TZS 500,000</div>
                        <div>≈ $200 USD</div>
                     </div>
                  </div>

                  <div class="custom-amount">
                     <label for="customAmount">Or enter a custom amount (TZS):</label>
                     <input type="number" id="customAmount" name="amount" min="1000" placeholder="Enter amount" required>
                  </div>

                  <!-- Donation Type -->
                  <div class="mb-4">
                     <h4>Donation Type</h4>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="donation_type" id="one-time" value="one-time" checked>
                        <label class="form-check-label" for="one-time">One-time Donation</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="donation_type" id="monthly" value="monthly">
                        <label class="form-check-label" for="monthly">Monthly</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="donation_type" id="yearly" value="yearly">
                        <label class="form-check-label" for="yearly">Yearly</label>
                     </div>
                  </div>

                  <!-- Payment Method -->
                  <div class="mb-4">
                     <h4>Payment Method</h4>
                     <div class="payment-methods">
                        <div class="payment-method" data-method="card">
                           <i class="fas fa-credit-card"></i>
                           <div>Credit/Debit Card</div>
                        </div>
                        <div class="payment-method" data-method="bank">
                           <i class="fas fa-university"></i>
                           <div>Bank Transfer</div>
                        </div>
                        <div class="payment-method" data-method="mobile">
                           <i class="fas fa-mobile-alt"></i>
                           <div>Mobile Money</div>
                        </div>
                     </div>
                     <input type="hidden" name="payment_method" id="paymentMethod" value="card">
                  </div>

                  <!-- Donor Information -->
                  <div class="row g-3">
                     <div class="col-md-6">
                        <input type="text" name="donor_name" class="form-control" placeholder="Full Name" required>
                     </div>
                     <div class="col-md-6">
                        <input type="email" name="donor_email" class="form-control" placeholder="Email Address" required>
                     </div>
                     <div class="col-md-6">
                        <input type="tel" name="donor_phone" class="form-control" placeholder="Phone Number" required>
                     </div>
                     <div class="col-md-6">
                        <select name="cause" class="form-control">
                           <option value="">Select Cause (Optional)</option>
                           <option value="health">Public Health</option>
                           <option value="education">Education</option>
                           <option value="gender">Gender Equality</option>
                           <option value="environment">Environment</option>
                           <option value="general">General Support</option>
                        </select>
                     </div>
                     <div class="col-12">
                        <textarea name="message" class="form-control" rows="4" placeholder="Leave a message (Optional)"></textarea>
                     </div>
                     <div class="col-12">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" id="anonymous" name="anonymous">
                           <label class="form-check-label" for="anonymous">
                              Make this donation anonymous
                           </label>
                        </div>
                     </div>
                     <div class="col-12">
                        <button type="submit" class="th-btn star-btn btn-lg">Complete Donation</button>
                     </div>
                  </div>
               </form>
            </div>

            <div class="col-lg-4">
               <div class="impact-preview">
                  <h4>Your Impact</h4>
                  <div class="impact-item">
                     <i class="fas fa-heart"></i>
                     <span>Help provide healthcare to underserved communities</span>
                  </div>
                  <div class="impact-item">
                     <i class="fas fa-graduation-cap"></i>
                     <span>Support education and skill development programs</span>
                  </div>
                  <div class="impact-item">
                     <i class="fas fa-users"></i>
                     <span>Empower women and youth for sustainable development</span>
                  </div>
                  <div class="impact-item">
                     <i class="fas fa-leaf"></i>
                     <span>Protect our environment and promote sustainability</span>
                  </div>
               </div>

               <div class="payment-details-box">
                  <h5 class="mb-3">Alternative Payment Details</h5>
                  <div class="payment-detail-item">
                     <strong>NBC Bank</strong>
                     <span>Account Number: 097172000124</span>
                     <span>Lipa Namba: 350201843</span>
                  </div>
                  <div class="payment-detail-item">
                     <strong>MPesa</strong>
                     <span>0745600763</span>
                     <span>Account Name: AFRICA INITIATIVE DEVELOPMENT FOUNDATION-AIDF</span>
                  </div>
               </div>

               <div class="mt-4">
                  <h5>Tax Information</h5>
                  <p class="small text-muted">AIDF is a registered non-profit organization. Your donation may be tax-deductible. Please consult your tax advisor for specific information.</p>
               </div>
            </div>
         </div>
      </div>
   </section>

   <?php include 'layout/footer.php'; ?>

   <script src="assets/js/vendor/jquery-3.7.1.min.js"></script>
   <script src="assets/js/app.min.js"></script>
   <script src="assets/js/main.js"></script>
   <script>
      // Amount selection
      const amountBtns = document.querySelectorAll('.amount-btn');
      const customAmount = document.getElementById('customAmount');

      amountBtns.forEach(btn => {
         btn.addEventListener('click', function() {
            amountBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            customAmount.value = this.dataset.amount;
         });
      });

      // Payment method selection
      const paymentMethods = document.querySelectorAll('.payment-method');
      const paymentMethodInput = document.getElementById('paymentMethod');

      paymentMethods.forEach(method => {
         method.addEventListener('click', function() {
            paymentMethods.forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            paymentMethodInput.value = this.dataset.method;
         });
      });

      // Set default payment method
      document.querySelector('.payment-method[data-method="card"]').classList.add('active');
   </script>
</body>

</html>
