
<div class="th-menu-wrapper">
   <div class="th-menu-area text-center">
      <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
      <div class="mobile-logo"><a href="index.php"><img src="assets/img/logo.png" alt="AIDF Organisation"></a></div>
      <div class="th-mobile-menu">
         <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li class="menu-item-has-children">
               <a href="#">Our Work</a>
               <ul class="sub-menu">
                  <li><a href="health.php">Public Health</a></li>
                  <li><a href="education.php">Education</a></li>
                  <li><a href="gender.php">Gender Equality</a></li>
                  <li><a href="environment.php">Environment</a></li>
               </ul>
            </li>
            <li><a href="aidf-care.php">AIDF Care</a></li>
            <li><a href="thematic.php">AIDF Impact</a></li>
            <li class="menu-item-has-children">
               <a href="#">Get Involved</a>
               <ul class="sub-menu">
                  <li><a href="membership.php">Become a Member</a></li>
                  <li><a href="volunteer.php">Volunteer</a></li>
               </ul>
            </li>
            <li><a href="contact.php">Contact</a></li>
         </ul>
      </div>
   </div>
</div>
<script>
   document.addEventListener('DOMContentLoaded', function () {
      const menuWrapper = document.querySelector('.th-menu-wrapper');

      if (!menuWrapper) return;

      const toggleButtons = document.querySelectorAll('.th-menu-toggle');
      const menuArea = menuWrapper.querySelector('.th-menu-area');
      const submenuParents = menuWrapper.querySelectorAll('.menu-item-has-children');

      const setMenuState = function (isOpen) {
         menuWrapper.classList.toggle('th-body-visible', isOpen);
      };

      toggleButtons.forEach(function (button) {
         button.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            setMenuState(!menuWrapper.classList.contains('th-body-visible'));
         });
      });

      if (menuArea) {
         menuArea.addEventListener('click', function (event) {
            event.stopPropagation();
         });
      }

      menuWrapper.addEventListener('click', function () {
         setMenuState(false);
      });

      submenuParents.forEach(function (item) {
         const children = Array.from(item.children);
         const trigger = children.find(function (child) {
            return child.tagName === 'A';
         });
         const submenu = children.find(function (child) {
            return child.tagName === 'UL';
         });

         if (!trigger || !submenu) return;

         submenu.style.display = 'none';

         trigger.addEventListener('click', function (event) {
            const href = trigger.getAttribute('href');

            if (href && href !== '#') return;

            event.preventDefault();
            item.classList.toggle('th-active');
            submenu.style.display = item.classList.contains('th-active') ? 'block' : 'none';
         });
      });
   });
</script>
