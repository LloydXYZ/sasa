<?php
// includes/booking_flow.php – Central definition of the customer booking flow
//
// Flexible Flow:
//   HOME → BOOK NOW
//     ↓
//   CHECK AVAILABILITY / SELECT DATE & TIME (calendar.php)
//     ↓
//   SELECT BOOKING TYPE (booking-choice.php)
//     ↓
//   CATERING PACKAGE (packages.php) ──[or Skip Package]──┐
//     ↓                                                  │
//   PACKAGE DETAILS (package-details.php)                │
//     ↓                                                  │
//   MENU CUSTOMIZATION (menu.php)                        │
//     ↓                                                  │
//   FOOD TRAYS (trays.php) <─────────────────────────────┘
//     (Order both Package + Trays, or Trays only, or Skip Trays)
//     ↓
//   EVENT DETAILS (event-details.php)
//     ↓
//   RESERVATION SUMMARY (summary.php)
//     ↓
//   PAYMENT / 30% DOWNPAYMENT (payment.php)
//     ↓
//   DIGITAL RECEIPT (receipt.php)
//     ↓
//   MY RESERVATIONS (my-reservations.php)
//     ↓
//   RESERVATION STATUS (reservation-status.php)

if (!defined('DOWNPAYMENT_RATE')) {
    define('DOWNPAYMENT_RATE', 0.30); // 30% downpayment
}

/**
 * Steps shown in the step indicator based on whether package is chosen or skipped.
 */
function bookingFlowSteps(?string $flow_mode = null): array {
    $has_package = !empty($_SESSION['booking']['package_id']);
    if ($flow_mode === 'tray' || (!$has_package && !empty($_SESSION['booking']['skip_package']))) {
        return [
            'date'    => ['Date & Time',   'pages/calendar.php'],
            'trays'   => ['Food Trays',    'pages/trays.php'],
            'details' => ['Event Details', 'pages/event-details.php'],
            'summary' => ['Summary',       'pages/summary.php'],
            'payment' => ['Payment (30%)', 'pages/payment.php'],
            'receipt' => ['Receipt',       null],
        ];
    }

    return [
        'date'    => ['Date & Time',   'pages/calendar.php'],
        'package' => ['Package',       'pages/packages.php'],
        'menu'    => ['Menu',          'pages/menu.php'],
        'trays'   => ['Food Trays',    'pages/trays.php'],
        'details' => ['Event Details', 'pages/event-details.php'],
        'summary' => ['Summary',       'pages/summary.php'],
        'payment' => ['Payment (30%)', 'pages/payment.php'],
        'receipt' => ['Receipt',       null],
    ];
}

/** Is the user currently in the middle of a booking (has picked a date)? */
function bookingInProgress(): bool {
    return !empty($_SESSION['booking']['date']);
}

/**
 * Normalize and return the currently selected trays array: [ tray_id => quantity ]
 */
function bookingGetTrays(): array {
    $trays = $_SESSION['booking']['trays'] ?? [];
    if (!is_array($trays)) return [];
    $clean = [];
    foreach ($trays as $id => $qty) {
        $id = intval($id);
        $qty = intval($qty);
        if ($id > 0 && $qty > 0) {
            $clean[$id] = $qty;
        }
    }
    return $clean;
}

/**
 * Returns [level, url, message] for the first incomplete step of the booking.
 * Levels: 1 = date, 2 = package/trays, 3 = menu, 4 = event details, 99 = complete.
 */
function bookingFirstMissing(): array {
    $b = $_SESSION['booking'] ?? [];

    if (empty($b['date'])) {
        return [1, 'pages/calendar.php', 'Please check availability and select your event date first.'];
    }

    $has_package = !empty($b['package_id']);
    $trays       = bookingGetTrays();
    $has_trays   = !empty($trays);

    // If no package AND no trays selected yet:
    if (!$has_package && !$has_trays) {
        if (!empty($b['skip_package'])) {
            return [2, 'pages/trays.php', 'Please select at least one food tray.'];
        }
        return [2, 'pages/packages.php', 'Please select a catering package or choose food trays.'];
    }

    // If package is selected, menu must be customized
    if ($has_package && empty($b['menu_items'])) {
        return [3, 'pages/menu.php', 'Please customize your menu for the selected package.'];
    }

    // Event details
    if (empty($b['event_name']) || empty($b['event_venue'])) {
        return [4, 'pages/event-details.php', 'Please complete your event details.'];
    }

    return [99, null, ''];
}

/**
 * Guard: make sure every step up to and including $level is complete,
 * otherwise send the customer back to the first incomplete step.
 */
function requireBookingProgress(int $level): void {
    [$missing, $url, $msg] = bookingFirstMissing();
    if ($missing <= $level) {
        $_SESSION['flash'] = ['type' => 'warning', 'message' => $msg];
        redirect(BASE_URL . $url);
    }
}

/** Compute total / downpayment / balance for an amount. */
function bookingAmounts(float $total): array {
    $down = round($total * DOWNPAYMENT_RATE, 2);
    return [
        'total'       => $total,
        'downpayment' => $down,
        'balance'     => round($total - $down, 2),
    ];
}

/**
 * Full calculation of package + trays totals from the current booking session.
 */
function bookingCalculateTotals(PDO $db): array {
    $b = $_SESSION['booking'] ?? [];
    $pkg_id = intval($b['package_id'] ?? 0);
    $package = null;
    $package_price = 0.0;

    if ($pkg_id > 0) {
        $st = $db->prepare("SELECT * FROM packages WHERE id = ?");
        $st->execute([$pkg_id]);
        $package = $st->fetch() ?: null;
        if ($package) {
            $package_price = floatval($package['price_min'] ?? 0);
        }
    }

    $trays_selected = bookingGetTrays();
    $trays_list = [];
    $trays_total = 0.0;

    if (!empty($trays_selected)) {
        $placeholders = implode(',', array_fill(0, count($trays_selected), '?'));
        $st = $db->prepare("SELECT * FROM trays WHERE id IN ($placeholders) AND is_active = 1");
        $st->execute(array_keys($trays_selected));
        $rows = $st->fetchAll();
        foreach ($rows as $row) {
            $qty = $trays_selected[$row['id']] ?? 1;
            $unit_price = floatval($row['price'] ?? 0);
            $subtotal = $unit_price * $qty;
            $trays_total += $subtotal;
            $trays_list[] = [
                'tray'       => $row,
                'quantity'   => $qty,
                'unit_price' => $unit_price,
                'subtotal'   => $subtotal,
            ];
        }
    }

    $grand_total = $package_price + $trays_total;
    $amounts = bookingAmounts($grand_total);

    return [
        'package'       => $package,
        'package_price' => $package_price,
        'trays'         => $trays_list,
        'trays_total'   => $trays_total,
        'grand_total'   => $grand_total,
        'downpayment'   => $amounts['downpayment'],
        'balance'       => $amounts['balance'],
    ];
}
