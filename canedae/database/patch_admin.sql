-- Run once in phpMyAdmin (SQL tab) on canedae_db.
-- 1) payment.php offers 'Credit Card' but the payments.payment_method ENUM
--    does not contain it, so that choice makes the booking insert fail.
ALTER TABLE payments
  MODIFY payment_method ENUM('GCash','Maya','Bank Transfer','Credit Card','Cash on Event') DEFAULT 'GCash';

-- 2) The schema defaults reservations.status to 'Submitted' but payment.php
--    inserts 'Pending'. Make the default match.
ALTER TABLE reservations MODIFY status VARCHAR(50) DEFAULT 'Pending';
UPDATE reservations SET status = 'Pending' WHERE status = 'Submitted';
