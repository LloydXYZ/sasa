// CaneDae ThirdHome Catering – Main JavaScript

document.addEventListener('DOMContentLoaded', function() {

  // Auto-dismiss flash alerts after 5 seconds
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(function(alert) {
    setTimeout(function() {
      alert.style.transition = 'opacity 0.5s';
      alert.style.opacity    = '0';
      setTimeout(function() { alert.remove(); }, 500);
    }, 5000);
  });

  // Mobile navbar toggle (if needed)
  const navToggle = document.getElementById('navToggle');
  const navMenu   = document.getElementById('navMenu');
  if(navToggle && navMenu) {
    navToggle.addEventListener('click', function() {
      navMenu.classList.toggle('open');
    });
  }

  // Upload area drag-and-drop highlight
  const uploadArea = document.querySelector('.upload-area');
  if(uploadArea) {
    ['dragenter','dragover'].forEach(function(evt) {
      uploadArea.addEventListener(evt, function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'var(--med-green)';
        uploadArea.style.background  = 'var(--linen)';
      });
    });
    ['dragleave','drop'].forEach(function(evt) {
      uploadArea.addEventListener(evt, function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '';
        uploadArea.style.background  = '';
      });
    });
    uploadArea.addEventListener('drop', function(e) {
      const files = e.dataTransfer.files;
      if(files.length > 0) {
        const input = document.getElementById('proofFile');
        if(input) {
          input.files = files;
          const fn = document.getElementById('fileName');
          if(fn) fn.textContent = '✓ ' + files[0].name;
        }
      }
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      const target = document.querySelector(this.getAttribute('href'));
      if(target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });

});
