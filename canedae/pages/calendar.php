<?php
// pages/calendar.php – Step 1: Check Availability → Select Date & Time → Continue
// Booking flow: Home → Book Now → THIS PAGE → Booking Type → Package → Package Details
//               → Menu → Event Details → Summary → Payment (30%) → Receipt
//               → My Reservations → Reservation Status
require_once '../config/db.php';
startSession();
requireLogin();

$page_title = 'Check Availability';
$db = getDB();

// Fetch booked / limited / blocked dates from DB
$blocked_stmt = $db->query("SELECT blocked_date FROM blocked_dates");
$blocked_dates = $blocked_stmt->fetchAll(PDO::FETCH_COLUMN);
$blocked_json  = json_encode(array_values($blocked_dates));

// Booked dates (count reservations per date to determine limited vs fully booked)
$booked_stmt = $db->query(
    "SELECT event_date, COUNT(*) AS cnt FROM reservations
     WHERE status NOT IN ('Cancelled') GROUP BY event_date"
);
$booked_counts = [];
foreach ($booked_stmt->fetchAll() as $row) {
    $booked_counts[$row['event_date']] = intval($row['cnt']);
}
$fully_booked = array_keys(array_filter($booked_counts, fn($c) => $c >= 3));
$limited      = array_keys(array_filter($booked_counts, fn($c) => $c >= 1 && $c < 3));
$fully_json   = json_encode(array_values($fully_booked));
$limited_json = json_encode(array_values($limited));

$pre_selected = $_SESSION['booking']['date'] ?? '';
$pre_time     = $_SESSION['booking']['event_time'] ?? '';

// Handle POST: validate chosen date & time then continue to Select Booking Type
$cal_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chosen_date = trim($_POST['selected_date'] ?? '');
    $chosen_time = trim($_POST['event_time'] ?? '');
    $date_obj    = DateTime::createFromFormat('Y-m-d', $chosen_date);

    if (!$chosen_date || !$date_obj || $date_obj->format('Y-m-d') !== $chosen_date) {
        $cal_error = 'Please select a valid event date.';
    } elseif ($chosen_date < date('Y-m-d')) {
        $cal_error = 'You cannot book a date in the past.';
    } elseif (in_array($chosen_date, $blocked_dates) || in_array($chosen_date, $fully_booked)) {
        $cal_error = 'Sorry, that date is no longer available. Please pick another date.';
    } elseif ($chosen_time === '') {
        $cal_error    = 'Please select your event time.';
        $pre_selected = $chosen_date;
    } else {
        $_SESSION['booking']['date']       = $chosen_date;
        $_SESSION['booking']['event_time'] = $chosen_time;
        redirect(BASE_URL . 'pages/booking-choice.php');
    }
}

$current_step = 'date';
include '../includes/header.php';
include '../includes/booking_steps.php';
?>

<style>
/* Scoped Calendar Mockup Styles */
.cal-wrapper {
  max-width: 980px;
  margin: 30px auto 60px;
  padding: 0 20px;
}
.cal-grid-layout {
  display: grid;
  grid-template-columns: 1.35fr 1fr;
  gap: 32px;
  align-items: start;
}
@media (max-width: 800px) {
  .cal-grid-layout { grid-template-columns: 1fr; }
}
.cal-paper-card {
  background: #ffffff;
  background-image: radial-gradient(circle, rgba(74, 55, 40, 0.12) 1.2px, transparent 1.2px);
  background-size: 22px 22px;
  border-radius: 18px;
  padding: 28px 32px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.08);
  border: 1px solid rgba(0,0,0,0.05);
}
.cal-header-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 8px;
}
.cal-nav-btn {
  background: #e2ded5;
  border: 1px solid #b3a898;
  border-radius: 16px;
  padding: 4px 16px;
  font-size: 1.1rem;
  font-weight: 700;
  cursor: pointer;
  color: #33261a;
  transition: all 0.15s;
}
.cal-nav-btn:hover {
  background: #cfc7ba;
}
.cal-month-heading {
  font-family: 'Cinzel', serif;
  font-size: 1.6rem;
  font-weight: 700;
  letter-spacing: 3px;
  color: #2b1f14;
  text-align: center;
  flex: 1;
}
.cal-divider-line {
  border-bottom: 1.5px solid #2b1f14;
  margin-bottom: 16px;
}
.cal-weekdays-row {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  text-align: center;
  font-family: 'Lato', sans-serif;
  font-weight: 700;
  font-size: 0.95rem;
  color: #2b1f14;
  margin-bottom: 14px;
}
.cal-days-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 8px;
  text-align: center;
}
.cal-cell {
  height: 42px;
  width: 42px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Playfair Display', serif;
  font-size: 1.05rem;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.15s;
  user-select: none;
}
.cal-cell:hover:not(.day-empty):not(.day-booked) {
  background: rgba(188, 211, 235, 0.45);
}
.cal-cell.day-limited {
  background: #f7d26d !important;
  color: #2b1c06 !important;
  font-weight: 700;
}
.cal-cell.day-booked {
  background: #7a1212 !important;
  color: #ffffff !important;
  cursor: not-allowed !important;
  font-weight: 700;
}
.cal-cell.day-selected {
  background: #bcd3eb !important;
  border: 1.5px solid #4a7bb5 !important;
  color: #1a2f4a !important;
  font-weight: 700;
}
.cal-side-card {
  background: #ffffff;
  background-image: radial-gradient(circle, rgba(74, 55, 40, 0.10) 1.2px, transparent 1.2px);
  background-size: 22px 22px;
  border-radius: 18px;
  padding: 24px 28px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.08);
  border: 1px solid rgba(0,0,0,0.05);
}
.cal-side-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.2rem;
  font-weight: 700;
  color: #1a140e;
  margin-bottom: 16px;
}
.cal-badge {
  display: inline-block;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  margin-right: 14px;
}
.cal-badge.limited { background: #f7d26d; border: 1px solid #d4ad3d; }
.cal-badge.booked  { background: #7a1212; border: 1px solid #5a0d0d; }
.cal-badge.selected{ background: #bcd3eb; border: 1.5px solid #4a7bb5; }
.cal-continue-btn {
  width: 100%;
  background: #2b551c;
  color: #ffffff;
  font-family: 'Lato', sans-serif;
  font-weight: 700;
  font-size: 1.05rem;
  padding: 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s, transform 0.1s;
}
.cal-continue-btn:hover:not(:disabled) {
  background: #1e3d13;
}
</style>

<div class="cal-wrapper">
  <div style="margin-bottom: 24px;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 2.4rem; font-weight: 700; color: #1a140e; margin-bottom: 4px;">
      Check Availability
    </h1>
    <p style="font-family:'Playfair Display', serif; font-size: 1.05rem; color: #4a3e30;">
      Select your preferred event date &amp; time, then press Continue to choose your booking type.
    </p>
  </div>

  <?php if ($cal_error): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($cal_error); ?></div>
  <?php endif; ?>

  <form method="POST" id="calendarForm">
    <input type="hidden" name="selected_date" id="selectedDateInput" value="<?php echo htmlspecialchars($pre_selected); ?>">

    <div class="cal-grid-layout">
      <!-- Left: Calendar widget -->
      <div class="cal-paper-card">
        <!-- Month navigation -->
        <div class="cal-header-bar">
          <button type="button" id="prevMonth" class="cal-nav-btn">&#8249;</button>
          <div class="cal-month-heading" id="calMonthLabel"></div>
          <button type="button" id="nextMonth" class="cal-nav-btn">&#8250;</button>
        </div>

        <div class="cal-divider-line"></div>

        <div class="cal-weekdays-row">
          <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
        </div>

        <div class="cal-days-grid" id="calDaysGrid"></div>
      </div>

      <!-- Right column -->
      <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Legend card -->
        <div class="cal-side-card">
          <h3 class="cal-side-title">Availability</h3>
          <div style="display: flex; flex-direction: column; gap: 14px; font-size: 1.05rem; font-family:'Playfair Display', serif;">
            <div style="display:flex; align-items:center;">
              <span class="cal-badge limited"></span>
              <span style="font-weight: 600;">Limited</span>
            </div>
            <div style="display:flex; align-items:center;">
              <span class="cal-badge booked"></span>
              <span style="font-weight: 600;">Fully Booked</span>
            </div>
            <div style="display:flex; align-items:center;">
              <span class="cal-badge selected"></span>
              <span style="font-weight: 600;">Selected</span>
            </div>
          </div>
        </div>

        <!-- Selected date + time card -->
        <div class="cal-side-card">
          <h3 class="cal-side-title">Selected Date</h3>
          <p id="displaySelectedDate" style="font-family:'Playfair Display', serif; font-size: 1.05rem; font-weight:600; color: #2b1f14; margin-bottom: 16px; min-height: 24px;">
            <?php echo $pre_selected ? date('F j, Y (l)', strtotime($pre_selected)) : 'No date selected yet.'; ?>
          </p>

          <label style="font-weight:700; font-size:0.9rem; margin-bottom:6px; display:block; color:#2b1f14;">Event Time:</label>
          <input type="time" name="event_time" id="eventTimeInput"
                 value="<?php echo htmlspecialchars($pre_time ?: '08:30'); ?>"
                 style="width:100%; padding:10px 14px; border:1.5px solid #4a3e30; border-radius:6px; font-size:1rem; margin-bottom: 20px; outline:none; background:#fff;" required>

          <button type="submit" id="continueBtn" class="cal-continue-btn"
                  style="<?php echo $pre_selected ? '' : 'opacity:0.5; cursor:not-allowed;'; ?>"
                  <?php echo $pre_selected ? '' : 'disabled'; ?>>
            Continue
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
const BLOCKED  = <?php echo $blocked_json; ?>;
const FULLY    = <?php echo $fully_json; ?>;
const LIMITED  = <?php echo $limited_json; ?>;

const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
const days   = ["Su","Mo","Tu","We","Th","Fr","Sa"];

let today = new Date();
today.setHours(0,0,0,0);
let cur = new Date(today.getFullYear(), today.getMonth(), 1);

let selected = "<?php echo $pre_selected; ?>";

function pad(n){ return String(n).padStart(2,'0'); }
function dateKey(y, m, d){ return y + '-' + pad(m+1) + '-' + pad(d); }

function renderCalendar() {
  const y = cur.getFullYear(), m = cur.getMonth();
  document.getElementById('calMonthLabel').textContent = months[m] + ' ' + y;

  const grid = document.getElementById('calDaysGrid');
  grid.innerHTML = '';

  const firstDay = new Date(y, m, 1).getDay(); // 0=Sun
  const totalDays = new Date(y, m+1, 0).getDate();

  // blank cells before first
  for (let i = 0; i < firstDay; i++) {
    const blank = document.createElement('div');
    blank.className = 'cal-cell day-empty';
    grid.appendChild(blank);
  }

  for (let d = 1; d <= totalDays; d++) {
    const key   = dateKey(y, m, d);
    const dateObj = new Date(y, m, d);
    const cell  = document.createElement('div');
    cell.textContent = d;
    cell.className = 'cal-cell';

    const isPast = dateObj < today;

    if (isPast || BLOCKED.includes(key)) {
      cell.classList.add('day-booked');
      cell.title = isPast ? 'Past date' : 'Blocked';
    } else if (FULLY.includes(key)) {
      cell.classList.add('day-booked');
      cell.title = 'Fully Booked';
    } else if (LIMITED.includes(key)) {
      cell.classList.add('day-limited');
      cell.title = 'Limited Availability';
      cell.addEventListener('click', () => selectDate(key, d));
    } else {
      cell.addEventListener('click', () => selectDate(key, d));
    }

    if (key === selected) {
      cell.classList.add('day-selected');
    }

    grid.appendChild(cell);
  }
}

function selectDate(key, d) {
  selected = key;
  document.getElementById('selectedDateInput').value = key;

  const dateObj = new Date(key + 'T00:00:00');
  document.getElementById('displaySelectedDate').textContent =
    dateObj.toLocaleDateString('en-US', { year:'numeric', month:'long', day:'numeric', weekday:'long' });

  const btn = document.getElementById('continueBtn');
  btn.disabled = false;
  btn.style.opacity = '1';
  btn.style.cursor  = 'pointer';

  renderCalendar();
}

document.getElementById('prevMonth').addEventListener('click', () => {
  cur = new Date(cur.getFullYear(), cur.getMonth() - 1, 1);
  renderCalendar();
});
document.getElementById('nextMonth').addEventListener('click', () => {
  cur = new Date(cur.getFullYear(), cur.getMonth() + 1, 1);
  renderCalendar();
});

renderCalendar();
</script>

<?php include '../includes/footer.php'; ?>
