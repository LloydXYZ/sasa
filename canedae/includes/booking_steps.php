<?php
// includes/booking_steps.php – Step indicator component
// Usage: define $current_step (step key, e.g. 'date', 'menu', 'summary') and
//        optionally $flow_type ('package' | 'tray') before including.
require_once __DIR__ . '/booking_flow.php';

$flow_type = $flow_type ?? null;
$steps     = bookingFlowSteps($flow_type);
$keys      = array_keys($steps);
$cur_index = array_search($current_step ?? 'date', $keys, true);
if ($cur_index === false) $cur_index = 0;
// Completed steps are clickable (to go back and edit) until the booking is submitted
$allow_links = ($current_step ?? '') !== 'receipt';
?>
<nav class="step-indicator" aria-label="Booking progress">
  <?php foreach ($keys as $i => $key):
    [$label, $url] = $steps[$key];
    $state = $i < $cur_index ? 'done' : ($i === $cur_index ? 'active' : '');
    $tag   = ($state === 'done' && $allow_links && $url) ? 'a' : 'div';
  ?>
    <<?php echo $tag; ?> class="step-wrapper <?php echo $state ? 'is-' . $state : ''; ?>"
      <?php if ($tag === 'a'): ?>href="<?php echo BASE_URL . $url; ?>" title="Go back to <?php echo htmlspecialchars($label); ?>"<?php endif; ?>
      <?php if ($state === 'active'): ?>aria-current="step"<?php endif; ?>>
      <div class="step <?php echo $state; ?>">
        <div class="step-circle">
          <?php if ($state === 'done'): ?>
            <i class="fa fa-check" style="font-size:0.75rem;"></i>
          <?php else: echo $i + 1; endif; ?>
        </div>
      </div>
      <div class="step-label"><?php echo htmlspecialchars($label); ?></div>
    </<?php echo $tag; ?>>
    <?php if ($i < count($keys) - 1): ?>
      <div class="step-line <?php echo $i < $cur_index ? 'done' : ''; ?>"></div>
    <?php endif; ?>
  <?php endforeach; ?>
</nav>
