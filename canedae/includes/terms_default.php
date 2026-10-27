<?php
// includes/terms_default.php – default Terms text + renderer (shared by the website and the admin editor)
// Format: a line starting with "## " is a heading; a blank line starts a new paragraph.

function termsDefault()
{
	return <<<'TXT'
By making a reservation with CaneDae ThirdHome Catering, you agree to the following terms.

## 1. Reservations
A reservation is only a request until we approve it. A date is secured once your downpayment has been received, checked and approved by CaneDae ThirdHome Catering.

Dates marked as fully booked or blocked cannot be reserved. We may decline a booking if the date or service is not available.

## 2. Downpayment and Payment
A 30% downpayment of the total amount is required to secure your event date. The remaining balance is settled with us as agreed for your event.

You must upload a clear proof of payment (JPG, PNG or PDF, up to 5 MB) when paying the downpayment. Your reservation stays Pending until we verify it.

If your proof of payment cannot be verified, we will let you know and you may upload a new one from the Reservation Status page.

## 3. Event Details and Guest Count
Please make sure that your event date, time, venue, number of guests and special requests are correct. Changes are subject to availability and our approval, and may change the total amount.

Tell us about any food allergies or dietary needs in your special requests when you book.

## 4. Menu and Prices
Packages, menu items, food trays and prices are those shown on the website when you book. We may replace a dish with a similar one if an ingredient is not available.

Prices and offerings may change over time, but they will not change for a reservation we have already approved.

## 5. Cancellation and Refunds
You may ask to cancel a reservation by contacting us. Whether the downpayment can be refunded, in full or in part, is decided by CaneDae ThirdHome Catering depending on how close the event date is and the preparations already made.

We may cancel a reservation if payment cannot be verified, if the information provided is incorrect, or if we are unable to serve the event. You will be given the reason in your Reservation Status page.

## 6. Venue and Access
You are responsible for making sure the venue allows catering service and that our team can access it at the agreed time.

## 7. Liability
We prepare and serve food with care. We are not responsible for delays or losses caused by events outside our control, or by information that was incorrect or incomplete when you booked.

## 8. Your Information
We use the details you give us (such as your name, contact details and event information) only to manage your account and reservations, and we do not sell them.

## 9. Changes to These Terms
We may update these Terms and Conditions from time to time. The version shown on this page applies to new bookings.
TXT;
}

function termsRender($text)
{
	$text = str_replace(["\r\n", "\r"], "\n", trim($text));
	$out = '';
	foreach (preg_split("/\n{2,}/", $text) as $block) {
		$block = trim($block);
		if ($block === '')
			continue;
		if (strpos($block, '## ') === 0) {
			$parts = explode("\n", $block, 2);
			$out .= '<h3 style="font-family:\'Playfair Display\', serif; margin:22px 0 6px;">' . htmlspecialchars(trim(substr($parts[0], 3))) . '</h3>';
			$block = isset($parts[1]) ? trim($parts[1]) : '';
			if ($block === '')
				continue;
		}
		$out .= '<p style="margin:0 0 8px;">' . nl2br(htmlspecialchars($block)) . '</p>';
	}
	return $out;
}