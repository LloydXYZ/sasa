<?php
session_start();
$pdo=new PDO('mysql:host=localhost;dbname=sasa_resort;charset=utf8mb4','root','',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
function colx($t,$c){global $pdo;return (bool)$pdo->query("SHOW COLUMNS FROM $t LIKE '$c'")->fetch();}
if(!colx('cottages','name')){$pdo->exec("ALTER TABLE cottages ADD name VARCHAR(80) AFTER cottage_no, ADD amenities VARCHAR(255)");$pdo->exec("UPDATE cottages SET name=CONCAT('Cottage ',cottage_no),amenities='Bamboo benches,Table,Shaded roof,Near the beach'");}
if(!colx('reservations','token')){$pdo->exec("ALTER TABLE reservations ADD token CHAR(32), ADD payment_method ENUM('ewallet','resort') DEFAULT 'resort', ADD payment_ref VARCHAR(60), ADD payment_proof VARCHAR(100), ADD payment_status ENUM('unpaid','submitted','verified','rejected') DEFAULT 'unpaid', ADD paid_at DATETIME NULL");}
$pdo->exec("INSERT IGNORE INTO settings VALUES('overnight_multiplier','2'),('ewallet_name','GCash'),('ewallet_number',''),('ewallet_holder','')");
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function setting($k){global $pdo;$s=$pdo->prepare('SELECT v FROM settings WHERE k=?');$s->execute([$k]);return $s->fetchColumn();}
function mult(){$v=(float)setting('overnight_multiplier');return $v>0?$v:2;}
function cname($x){return $x['name']?:'Cottage '.$x['cottage_no'];}
function cimg($x,$b=''){return file_exists(__DIR__.'/../frontend/uploads/cottages/'.$x['image'])?$b.'uploads/cottages/'.$x['image']:$b.'img/'.$x['image'];}
function booked_ids($date,$type){global $pdo;$s=$pdo->prepare("SELECT rc.cottage_id FROM reservation_cottages rc JOIN reservations r ON r.id=rc.reservation_id WHERE r.reservation_date=? AND r.type=? AND r.status IN('pending','approved')");$s->execute([$date,$type]);return $s->fetchAll(PDO::FETCH_COLUMN);}
function flash($t,$m){$_SESSION['fl']=[$t,$m];}
function save_img($f,$dir){global $uerr;$uerr='';$er=$f['error']??4;if($er==4)return null;
if($er==1||$er==2||($f['size']??0)>8*1048576){$uerr='The picture is too large. Please choose a smaller photo.';return null;}
if($er!==0){$uerr='Upload failed. Please try again.';return null;}
$i=@getimagesize($f['tmp_name']);$ext=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$i['mime']??'']??null;if(!$ext){$uerr='Only JPG, PNG or WEBP pictures are allowed.';return null;}
$d=($dir=='cottages'?__DIR__.'/../frontend':__DIR__)."/uploads/$dir";if(!is_dir($d))@mkdir($d,0775,true);if(!is_writable($d)){$uerr='The uploads folder is not writable.';return null;}
$n=bin2hex(random_bytes(8)).".$ext";if(!move_uploaded_file($f['tmp_name'],"$d/$n")){$uerr='Could not save the picture.';return null;}return $n;}
