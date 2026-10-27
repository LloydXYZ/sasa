<?php
// includes/footer.php – Shared footer
?>
  <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
  <?php if(isset($extra_js)): foreach($extra_js as $js): ?>
  <script src="<?php echo BASE_URL . $js; ?>"></script>
  <?php endforeach; endif; ?>
</body>
</html>
