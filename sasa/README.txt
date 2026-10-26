SASA BEACH RESORT – SETUP (XAMPP)

FOLDERS
  frontend/   What customers see: pages (index, cottages, cottage, reserve, receipt), css/, js/, img/, inc/,
              and uploads/cottages (pictures of cottages you add in the admin)
  backend/    Server logic: config.php (database connection + helper functions),
              admin/ (login, dashboard, reservations, cottages, settings),
              uploads/proofs (private payment screenshots)
  database/   schema.sql (database structure and starting data)

SETUP
1. Copy this whole folder to C:\xampp\htdocs\sasa
2. Start Apache and MySQL in the XAMPP Control Panel.
3. Open http://localhost/phpmyadmin > Import > choose database/schema.sql > Go.
   (Upgrading an older copy? Skip the import. New columns are added automatically.)
4. Website: http://localhost/sasa/            (opens frontend/index.php)
   Admin:   http://localhost/sasa/admin.php   (opens backend/admin/login.php)
   First login: admin / admin123  (change it afterwards)
5. Admin > Settings: enter the e-wallet number, contact number and email.

UPGRADING FROM THE OLD LAYOUT: delete the old files in htdocs\sasa first, then copy this version in,
so old copies of index.php, config.php, css/ and admin/ do not stay behind.

PICTURE UPLOADS: photos are shrunk in the browser before upload and .htaccess raises the server limits to 10 MB.
If uploads still fail, open C:\xampp\php\php.ini, set upload_max_filesize=10M and post_max_size=12M,
then restart Apache.
