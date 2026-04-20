<!DOCTYPE html>
<html class="no-js" lang="zxx">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>Volunteer with AIDF - Make a Difference</title>
      <meta name="author" content="Kleanix">
      <meta name="description" content="Join AIDF as a volunteer and contribute to community development projects in Tanzania">
      <meta name="keywords" content="AIDF Volunteer, Volunteer Tanzania, Community Development">
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
      <style>
         .mobile-logo img {
    width: 100px; /* adjust to your preferred size */
    height: auto;
         }
         .header-logo img {
    width: 100px;   /* adjust size here */
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
         .volunteer-opportunities {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 40px 0;
         }
         .opportunity-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
         }
         .opportunity-card:hover {
            transform: translateY(-10px);
         }
         .opportunity-card h4 {
            color: #00a651;
            margin-bottom: 15px;
         }
         .commitment {
            background: #e8f5e8;
            padding: 10px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 14px;
            margin-bottom: 15px;
         }
         .skills-needed {
            list-style: none;
            padding: 0;
         }
         .skills-needed li::before {
            content: "•";
            color: #00a651;
            font-weight: bold;
            margin-right: 10px;
         }
         .application-form {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
            margin-top: 40px;
         }
         .form-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
         }
         .form-section h4 {
            color: #00a651;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
         }
         .availability-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
         }
         .availability-option {
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
         }
         .availability-option:hover, .availability-option.active {
            border-color: #00a651;
            background: #f8f9fa;
         }
      </style>
   </head>
   <body>
      <?php include 'layout/mobile.php'; ?>
      <?php include 'layout/header.php'; ?>

      <!-- HERO -->
      <!-- <section class="hero-area" style="background-image: url('assets/img/project/p3.jpeg');">
         <div class="container">
            <span class="sub-title">Make a Difference</span>
            <h1>Volunteer with AIDF</h1>
            <p>Join our team of dedicated volunteers and help create positive change in communities across Tanzania</p>
         </div>
      </section> -->

      <!-- VOLUNTEER OPPORTUNITIES -->
      <section class="space">
         <div class="container">
            <h2 class="text-center mb-5">Current Volunteer Opportunities</h2>

            <div class="volunteer-opportunities">
               <div class="opportunity-card">
                  <h4><i class="fas fa-graduation-cap mr-2"></i>Education Support</h4>
                  <div class="commitment">2-4 hours/week</div>
                  <p>Help with literacy programs, tutoring, and educational workshops in underserved communities.</p>
                  <h6>Skills Needed:</h6>
                  <ul class="skills-needed">
                     <li>Teaching experience preferred</li>
                     <li>Patience and communication skills</li>
                     <li>Basic knowledge of local languages</li>
                  </ul>
               </div>

               <div class="opportunity-card">
                  <h4><i class="fas fa-heartbeat mr-2"></i>Health Outreach</h4>
                  <div class="commitment">Flexible hours</div>
                  <p>Assist in health education campaigns, vaccination drives, and community health awareness programs.</p>
                  <h6>Skills Needed:</h6>
                  <ul class="skills-needed">
                     <li>Healthcare background helpful</li>
                     <li>Public speaking skills</li>
                     <li>Basic first aid knowledge</li>
                  </ul>
               </div>

               <div class="opportunity-card">
                  <h4><i class="fas fa-leaf mr-2"></i>Environmental Projects</h4>
                  <div class="commitment">Weekends/weekdays</div>
                  <p>Participate in tree planting, clean-up campaigns, and environmental education initiatives.</p>
                  <h6>Skills Needed:</h6>
                  <ul class="skills-needed">
                     <li>Physical fitness</li>
                     <li>Environmental awareness</li>
                     <li>Team collaboration skills</li>
                  </ul>
               </div>

               <div class="opportunity-card">
                  <h4><i class="fas fa-users mr-2"></i>Community Development</h4>
                  <div class="commitment">3-6 hours/week</div>
                  <p>Support community organizing, skill-building workshops, and local development projects.</p>
                  <h6>Skills Needed:</h6>
                  <ul class="skills-needed">
                     <li>Project management experience</li>
                     <li>Community engagement skills</li>
                     <li>Problem-solving abilities</li>
                  </ul>
               </div>

               <div class="opportunity-card">
                  <h4><i class="fas fa-camera mr-2"></i>Communications</h4>
                  <div class="commitment">Flexible hours</div>
                  <p>Help document our work, create content for social media, and support communications efforts.</p>
                  <h6>Skills Needed:</h6>
                  <ul class="skills-needed">
                     <li>Photography/videography skills</li>
                     <li>Social media experience</li>
                     <li>Writing and editing skills</li>
                  </ul>
               </div>

               <div class="opportunity-card">
                  <h4><i class="fas fa-handshake mr-2"></i>Fundraising</h4>
                  <div class="commitment">2-4 hours/week</div>
                  <p>Assist with fundraising campaigns, donor relations, and grant writing support.</p>
                  <h6>Skills Needed:</h6>
                  <ul class="skills-needed">
                     <li>Marketing/sales experience</li>
                     <li>Writing skills</li>
                     <li>Relationship building</li>
                  </ul>
               </div>
            </div>
         </div>
      </section>

      <!-- APPLICATION FORM -->
      <section class="space bg-smoke">
         <div class="container">
            <div class="application-form">
               <!-- Success/Error Messages -->
               <?php if (isset($_GET['success'])): ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <i class="fas fa-check-circle"></i> Thank you for your volunteer application! Your application has been submitted successfully and is under review.
                     <?php if (isset($_GET['email_error'])): ?>
                        <br><small class="text-muted">Note: There was an issue sending the confirmation email, but your application was successfully recorded.</small>
                     <?php endif; ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>
               <?php elseif (isset($_GET['error'])): ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>
               <?php endif; ?>

               <h2 class="text-center mb-4">Volunteer Application Form</h2>
               <p class="text-center mb-5">Ready to make a difference? Fill out the form below to apply as a volunteer. We'll match you with opportunities that fit your skills and availability.</p>

               <form action="process_volunteer.php" method="post">
                  <!-- Personal Information -->
                  <div class="form-section">
                     <h4><i class="fas fa-user mr-2"></i>Personal Information</h4>
                     <div class="row g-3">
                        <div class="col-md-6">
                           <label for="full_name" class="form-label">Full Name *</label>
                           <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="col-md-6">
                           <label for="email" class="form-label">Email Address *</label>
                           <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                           <label for="phone" class="form-label">Phone Number *</label>
                           <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="col-md-6">
                           <label for="date_of_birth" class="form-label">Date of Birth *</label>
                           <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="col-md-6">
                           <label for="gender" class="form-label">Gender</label>
                           <select class="form-control" id="gender" name="gender">
                              <option value="">Select Gender</option>
                              <option value="male">Male</option>
                              <option value="female">Female</option>
                              <option value="other">Other</option>
                           </select>
                        </div>
                        <div class="col-md-6">
                           <label for="occupation" class="form-label">Occupation/Profession</label>
                           <input type="text" class="form-control" id="occupation" name="occupation">
                        </div>
                        <div class="col-12">
                           <label for="address" class="form-label">Address *</label>
                           <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                     </div>
                  </div>

                  <!-- Volunteer Preferences -->
                  <div class="form-section">
                     <h4><i class="fas fa-tasks mr-2"></i>Volunteer Preferences</h4>
                     <div class="row g-3">
                        <div class="col-12">
                           <label class="form-label">Areas of Interest (check all that apply) *</label>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="interests[]" value="education" id="vol-education">
                                    <label class="form-check-label" for="vol-education">Education Support</label>
                                 </div>
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="interests[]" value="health" id="vol-health">
                                    <label class="form-check-label" for="vol-health">Health Outreach</label>
                                 </div>
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="interests[]" value="environment" id="vol-environment">
                                    <label class="form-check-label" for="vol-environment">Environmental Projects</label>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="interests[]" value="community" id="vol-community">
                                    <label class="form-check-label" for="vol-community">Community Development</label>
                                 </div>
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="interests[]" value="communications" id="vol-communications">
                                    <label class="form-check-label" for="vol-communications">Communications</label>
                                 </div>
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="interests[]" value="fundraising" id="vol-fundraising">
                                    <label class="form-check-label" for="vol-fundraising">Fundraising</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-12">
                           <label class="form-label">Availability *</label>
                           <div class="availability-options">
                              <div class="availability-option" data-value="weekdays">
                                 <div><i class="fas fa-briefcase"></i></div>
                                 <div>Weekdays</div>
                              </div>
                              <div class="availability-option" data-value="weekends">
                                 <div><i class="fas fa-sun"></i></div>
                                 <div>Weekends</div>
                              </div>
                              <div class="availability-option" data-value="flexible">
                                 <div><i class="fas fa-calendar-alt"></i></div>
                                 <div>Flexible</div>
                              </div>
                           </div>
                           <input type="hidden" name="availability" id="availability" required>
                        </div>
                        <div class="col-12">
                           <label for="hours_per_week" class="form-label">Hours per week you can commit *</label>
                           <select class="form-control" id="hours_per_week" name="hours_per_week" required>
                              <option value="">Select commitment level</option>
                              <option value="1-2">1-2 hours</option>
                              <option value="3-5">3-5 hours</option>
                              <option value="6-10">6-10 hours</option>
                              <option value="10+">More than 10 hours</option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <!-- Skills and Experience -->
                  <div class="form-section">
                     <h4><i class="fas fa-star mr-2"></i>Skills & Experience</h4>
                     <div class="row g-3">
                        <div class="col-12">
                           <label for="skills" class="form-label">Relevant Skills and Experience *</label>
                           <textarea class="form-control" id="skills" name="skills" rows="4" required placeholder="Describe your relevant skills, experience, and why you want to volunteer with AIDF..."></textarea>
                        </div>
                        <div class="col-12">
                           <label for="previous_volunteer" class="form-label">Previous Volunteer Experience</label>
                           <textarea class="form-control" id="previous_volunteer" name="previous_volunteer" rows="3" placeholder="Tell us about any previous volunteer work you've done..."></textarea>
                        </div>
                        <div class="col-12">
                           <label for="emergency_contact" class="form-label">Emergency Contact (Name and Phone) *</label>
                           <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" required placeholder="e.g., John Doe - +255 123 456 789">
                        </div>
                     </div>
                  </div>

                  <!-- Terms and Submit -->
                  <div class="form-section">
                     <div class="row">
                        <div class="col-12">
                           <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                              <label class="form-check-label" for="terms">
                                 I agree to AIDF's volunteer terms and conditions, code of conduct, and privacy policy *
                              </label>
                           </div>
                           <div class="form-check mt-2">
                              <input class="form-check-input" type="checkbox" id="volunteer_policy_accepted" name="volunteer_policy_accepted" required>
                              <label class="form-check-label" for="volunteer_policy_accepted">
                                 I have read and accept the <a href="policies/volunteer-policy.pdf" target="_blank" rel="noopener" id="volunteerPolicyLink">Volunteer Policy (PDF)</a> *
                              </label>
                           </div>
                           <div class="form-check mt-2">
                              <input class="form-check-input" type="checkbox" id="background_check" name="background_check">
                              <label class="form-check-label" for="background_check">
                                 I consent to a background check if required for my volunteer role
                              </label>
                           </div>
                        </div>
                        <div class="col-12 text-center mt-4">
                           <button type="submit" class="th-btn star-btn btn-lg" id="volunteerSubmitBtn" disabled>Submit Application</button>
                           <p class="mt-2 mb-0 text-muted small" id="volunteerSubmitHint">Open the Volunteer Policy PDF and tick the acceptance checkbox to enable submit.</p>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </section>

      <?php include 'layout/footer.php'; ?>

      <script src="assets/js/app.min.js"></script>
      <script src="assets/js/main.js"></script>
      <script>
         // Availability selection
         const availabilityOptions = document.querySelectorAll('.availability-option');
         const availabilityInput = document.getElementById('availability');
         const volunteerPolicyLink = document.getElementById('volunteerPolicyLink');
         const volunteerPolicyAccepted = document.getElementById('volunteer_policy_accepted');
         const volunteerSubmitBtn = document.getElementById('volunteerSubmitBtn');
         const volunteerSubmitHint = document.getElementById('volunteerSubmitHint');
         let volunteerPolicyOpened = false;

         availabilityOptions.forEach(option => {
            option.addEventListener('click', function() {
               availabilityOptions.forEach(opt => opt.classList.remove('active'));
               this.classList.add('active');
               availabilityInput.value = this.dataset.value;
            });
         });

         function updateVolunteerSubmitState() {
            const canSubmit = volunteerPolicyOpened && volunteerPolicyAccepted.checked;
            volunteerSubmitBtn.disabled = !canSubmit;
            volunteerSubmitHint.textContent = canSubmit
               ? 'Policy requirement completed. You can submit now.'
               : 'Open the Volunteer Policy PDF and tick the acceptance checkbox to enable submit.';
         }

         volunteerPolicyLink.addEventListener('click', function() {
            volunteerPolicyOpened = true;
            updateVolunteerSubmitState();
         });

         volunteerPolicyAccepted.addEventListener('change', updateVolunteerSubmitState);
         updateVolunteerSubmitState();
      </script>
   </body>
</html>
