<?php
// START OUTPUT BUFFERING (Prevents "Connection Failed" errors due to whitespace)
ob_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'db_config.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = isset($_GET['action']) ? $_GET['action'] : '';

// Handle preflight requests
if ($method === 'OPTIONS') {
    ob_clean();
    http_response_code(200);
    exit();
}

try {
    switch ($request) {
        // Academic Year
        case 'set_year':
            setAcademicYear($pdo);
            break;
        case 'get_current_year':
            getCurrentYear($pdo);
            break;
        case 'update_semester':
            updateSemester($pdo);
            break;

        // Room Operations
        case 'create_rooms':
            createRooms($pdo);
            break;
        case 'add_rooms':
            addRooms($pdo);
            break;
        case 'get_rooms':
            getRooms($pdo);
            break;
        case 'toggle_lock':
            toggleRoomLock($pdo);
            break;
        case 'delete_rooms':
            deleteRooms($pdo);
            break;
        case 'delete_single_room':
            deleteSingleRoom($pdo);
            break;
        case 'get_room_details':
            getRoomDetails($pdo);
            break;

        // Student Operations
        case 'add_student':
            addStudent($pdo);
            break;
        case 'import_students':
            importStudents($pdo);
            break;
        case 'remove_student':
            removeStudent($pdo);
            break;
        case 'transfer_student':
            transferStudent($pdo);
            break;
        case 'transfer_all_students':
            transferAllStudents($pdo);
            break;
        case 'update_student_details':
            updateStudentDetails($pdo);
            break;

        // Archive Operations
        case 'archive_year':
            archiveYear($pdo);
            break;
        case 'get_archives':
            getArchives($pdo);
            break;
        case 'get_archive_details':
            getArchiveDetails($pdo);
            break;

        default:
            sendJson(['error' => 'Invalid action']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    sendJson(['error' => $e->getMessage()]);
}

// --- HELPER ---
function sendJson($data)
{
    ob_clean();
    echo json_encode($data);
    exit();
}

// ============= FUNCTIONS =============

function setAcademicYear($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $year = $data['year'];
    $semester = $data['semester'] ?? 'First Semester';

    $stmt = $pdo->prepare("UPDATE academic_years SET is_active = 0");
    $stmt->execute();

    $stmt = $pdo->prepare("SELECT id FROM academic_years WHERE year = ? AND semester = ?");
    $stmt->execute([$year, $semester]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE academic_years SET is_active = 1 WHERE id = ?");
        $stmt->execute([$existing['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO academic_years (year, semester, is_active) VALUES (?, ?, 1)");
        $stmt->execute([$year, $semester]);
    }
    sendJson(['success' => true]);
}

function getCurrentYear($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM academic_years WHERE is_active = 1 LIMIT 1");
    $stmt->execute();
    $year = $stmt->fetch();
    sendJson(['success' => true, 'year' => $year]);
}

function updateSemester($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE academic_years SET semester = ? WHERE is_active = 1");
    $stmt->execute([$data['semester']]);
    sendJson(['success' => true]);
}

// ============= ROOMS =============
function createRooms($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $numRooms = $data['num_rooms'];

    $stmt = $pdo->prepare("SELECT id FROM academic_years WHERE is_active = 1 LIMIT 1");
    $stmt->execute();
    $year = $stmt->fetch();
    if (!$year) {
        sendJson(['error' => 'No active year']);
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM rooms WHERE year_id = ?");
    $stmt->execute([$year['id']]);

    $stmt = $pdo->prepare("INSERT INTO rooms (year_id, room_number, name, is_locked) VALUES (?, ?, ?, 0)");
    for ($i = 1; $i <= $numRooms; $i++) {
        $stmt->execute([$year['id'], $i, "Room $i"]);
    }
    sendJson(['success' => true]);
}

function addRooms($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $count = isset($data['count']) ? (int) $data['count'] : 1;

    $stmt = $pdo->prepare("SELECT id FROM academic_years WHERE is_active = 1 LIMIT 1");
    $stmt->execute();
    $year = $stmt->fetch();
    if (!$year) {
        sendJson(['error' => 'No active year']);
        return;
    }

    $stmt = $pdo->prepare("SELECT COALESCE(MAX(room_number), 0) as max_num FROM rooms WHERE year_id = ?");
    $stmt->execute([$year['id']]);
    $currentMax = $stmt->fetch()['max_num'];

    $stmt = $pdo->prepare("INSERT INTO rooms (year_id, room_number, name, is_locked) VALUES (?, ?, ?, 0)");
    for ($i = 1; $i <= $count; $i++) {
        $nextNum = $currentMax + $i;
        $stmt->execute([$year['id'], $nextNum, "Room $nextNum"]);
    }
    sendJson(['success' => true]);
}

function getRooms($pdo)
{
    $stmt = $pdo->prepare("SELECT id FROM academic_years WHERE is_active = 1 LIMIT 1");
    $stmt->execute();
    $year = $stmt->fetch();

    if (!$year) {
        sendJson(['success' => true, 'rooms' => []]);
        return;
    }

    $stmt = $pdo->prepare("
        SELECT r.id, r.room_number, r.name, r.is_locked,
               s.id as student_id, s.name as student_name, s.course, s.year_level, s.gender, s.status,
               ra.student_number
        FROM rooms r
        LEFT JOIN room_assignments ra ON r.id = ra.room_id
        LEFT JOIN students s ON ra.student_id = s.id
        WHERE r.year_id = ?
        ORDER BY r.room_number ASC, s.name ASC
    ");
    $stmt->execute([$year['id']]);
    $results = $stmt->fetchAll();

    $rooms = [];
    foreach ($results as $row) {
        $roomId = $row['id'];
        if (!isset($rooms[$roomId])) {
            $rooms[$roomId] = [
                'id' => $row['id'],
                'room_number' => $row['room_number'],
                'name' => $row['name'],
                'is_locked' => (bool) $row['is_locked'],
                'students' => []
            ];
        }
        if ($row['student_id']) {
            $rooms[$roomId]['students'][] = [
                'id' => $row['student_id'],
                'name' => $row['student_name'],
                'course' => $row['course'],
                'year' => $row['year_level'],
                'gender' => $row['gender'] ?? 'N/A',
                'status' => $row['status'] ?? 'Active',
                'number' => $row['student_number']
            ];
        }
    }
    sendJson(['success' => true, 'rooms' => array_values($rooms)]);
}

function toggleRoomLock($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE rooms SET is_locked = ? WHERE id = ?");
    $stmt->execute([$data['is_locked'] ? 1 : 0, $data['room_id']]);
    sendJson(['success' => true]);
}

function deleteSingleRoom($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->execute([$data['room_id']]);
    sendJson(['success' => true]);
}

function deleteRooms($pdo)
{
    $stmt = $pdo->prepare("SELECT id FROM academic_years WHERE is_active = 1 LIMIT 1");
    $stmt->execute();
    $year = $stmt->fetch();
    if ($year) {
        $stmt = $pdo->prepare("DELETE FROM rooms WHERE year_id = ?");
        $stmt->execute([$year['id']]);
    }
    sendJson(['success' => true]);
}

function getRoomDetails($pdo)
{
    $roomId = $_GET['room_id'];
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
    $stmt->execute([$roomId]);
    $room = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT s.* FROM students s JOIN room_assignments ra ON s.id = ra.student_id WHERE ra.room_id = ? ORDER BY s.name ASC");
    $stmt->execute([$roomId]);
    sendJson(['success' => true, 'room' => $room, 'students' => $stmt->fetchAll()]);
}

function addStudent($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $name = strtoupper(trim($data['name']));
    $course = strtoupper(trim($data['course']));

    $stmt = $pdo->prepare("SELECT id FROM students WHERE name = ? AND course = ? AND year_level = ?");
    $stmt->execute([$name, $course, $data['year']]);
    $s = $stmt->fetch();

    if ($s)
        $sid = $s['id'];
    else {
        $stmt = $pdo->prepare("INSERT INTO students (name, course, year_level, gender, status) VALUES (?, ?, ?, ?, 'Active')");
        $stmt->execute([$name, $course, $data['year'], $data['gender'] ?? 'N/A']);
        $sid = $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare("SELECT COALESCE(MAX(student_number), 0) + 1 as next FROM room_assignments WHERE room_id = ?");
    $stmt->execute([$data['room_id']]);
    $next = $stmt->fetch()['next'];

    $stmt = $pdo->prepare("INSERT INTO room_assignments (room_id, student_id, student_number) VALUES (?, ?, ?)");
    $stmt->execute([$data['room_id'], $sid, $next]);
    sendJson(['success' => true]);
}

function importStudents($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $students = $data['students'];
    $assignments = $data['room_assignments'];

    $pdo->beginTransaction();
    try {
        $map = [];
        foreach ($students as $v) {
            $name = strtoupper(trim($v['name']));
            $course = strtoupper(trim($v['course']));

            $stmt = $pdo->prepare("SELECT id FROM students WHERE name = ? AND course = ? AND year_level = ?");
            $stmt->execute([$name, $course, $v['year']]);
            $ex = $stmt->fetch();

            if ($ex) {
                $map[$v['tempId']] = $ex['id'];
                if ($v['gender'] && $v['gender'] !== 'N/A') {
                    $upd = $pdo->prepare("UPDATE students SET gender = ?, name = ?, course = ? WHERE id = ?");
                    $upd->execute([$v['gender'], $name, $course, $ex['id']]);
                }
            } else {
                $stmt = $pdo->prepare("INSERT INTO students (name, course, year_level, gender, status) VALUES (?, ?, ?, ?, 'Active')");
                $stmt->execute([$name, $course, $v['year'], $v['gender']]);
                $map[$v['tempId']] = $pdo->lastInsertId();
            }
        }

        $ins = $pdo->prepare("INSERT INTO room_assignments (room_id, student_id, student_number) VALUES (?, ?, ?)");

        foreach ($assignments as $a) {
            $rid = $a['room_id'];
            if (!isset($map[$a['temp_student_id']]))
                continue;

            $sid = $map[$a['temp_student_id']];
            $stmt = $pdo->prepare("SELECT COALESCE(MAX(student_number), 0) + 1 as next FROM room_assignments WHERE room_id = ?");
            $stmt->execute([$rid]);
            $next = $stmt->fetch()['next'];

            $ins->execute([$rid, $sid, $next]);
        }

        $pdo->commit();
        sendJson(['success' => true]);
    } catch (Exception $e) {
        $pdo->rollBack();
        sendJson(['error' => $e->getMessage()]);
    }
}

function transferStudent($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $fromRoomId = $data['from_room_id'];
    $toRoomId = $data['to_room_id'];
    $studentId = $data['student_id'];

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("DELETE FROM room_assignments WHERE room_id = ? AND student_id = ?");
        $stmt->execute([$fromRoomId, $studentId]);

        $stmt = $pdo->prepare("SELECT COALESCE(MAX(student_number), 0) + 1 as next FROM room_assignments WHERE room_id = ?");
        $stmt->execute([$toRoomId]);
        $next = $stmt->fetch()['next'];

        $stmt = $pdo->prepare("INSERT INTO room_assignments (room_id, student_id, student_number) VALUES (?, ?, ?)");
        $stmt->execute([$toRoomId, $studentId, $next]);

        renumberRoom($pdo, $fromRoomId);
        renumberRoom($pdo, $toRoomId);

        $pdo->commit();
        sendJson(['success' => true]);
    } catch (Exception $e) {
        $pdo->rollBack();
        sendJson(['error' => $e->getMessage()]);
    }
}

function transferAllStudents($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $fromRoomId = $data['from_room_id'];
    $toRoomId = $data['to_room_id'];

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("UPDATE room_assignments SET room_id = ? WHERE room_id = ?");
        $stmt->execute([$toRoomId, $fromRoomId]);
        renumberRoom($pdo, $toRoomId);
        $pdo->commit();
        sendJson(['success' => true]);
    } catch (Exception $e) {
        $pdo->rollBack();
        sendJson(['error' => $e->getMessage()]);
    }
}

function removeStudent($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("DELETE FROM room_assignments WHERE room_id = ? AND student_id = ?");
    $stmt->execute([$data['room_id'], $data['student_id']]);
    renumberRoom($pdo, $data['room_id']);
    sendJson(['success' => true]);
}

function renumberRoom($pdo, $roomId)
{
    $stmt = $pdo->prepare("SELECT ra.id FROM room_assignments ra JOIN students s ON ra.student_id = s.id WHERE ra.room_id = ? ORDER BY s.name ASC");
    $stmt->execute([$roomId]);
    $rows = $stmt->fetchAll();
    $upd = $pdo->prepare("UPDATE room_assignments SET student_number = ? WHERE id = ?");
    foreach ($rows as $index => $row) {
        $upd->execute([$index + 1, $row['id']]);
    }
}

function updateStudentDetails($pdo)
{
    $d = json_decode(file_get_contents('php://input'), true);
    $name = strtoupper(trim($d['name']));
    $course = strtoupper(trim($d['course']));

    $stmt = $pdo->prepare("UPDATE students SET name=?, course=?, year_level=?, gender=?, status=? WHERE id=?");
    $stmt->execute([$name, $course, $d['year'], $d['gender'], $d['status'], $d['student_id']]);
    sendJson(['success' => true]);
}

function archiveYear($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM academic_years WHERE is_active = 1 LIMIT 1");
    $stmt->execute();
    $year = $stmt->fetch();
    if (!$year) {
        sendJson(['error' => 'No active year']);
        return;
    }

    $stmt = $pdo->prepare("
        SELECT r.id, r.room_number, r.name,
               s.name as s_name, s.course, s.year_level, s.gender, s.status,
               ra.student_number
        FROM rooms r
        LEFT JOIN room_assignments ra ON r.id = ra.room_id
        LEFT JOIN students s ON ra.student_id = s.id
        WHERE r.year_id = ?
        ORDER BY r.room_number ASC, s.name ASC
    ");
    $stmt->execute([$year['id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $rooms = [];
    $totalStudents = 0;

    foreach ($rows as $r) {
        $rid = $r['id'];
        if (!isset($rooms[$rid])) {
            $rooms[$rid] = ['name' => $r['name'], 'students' => []];
        }
        if ($r['s_name']) {
            $rooms[$rid]['students'][] = [
                'name' => $r['s_name'],
                'course' => $r['course'],
                'year' => $r['year_level'],
                'gender' => $r['gender'],
                'status' => $r['status']
            ];
            $totalStudents++;
        }
    }

    $archiveData = [
        'year' => $year['year'],
        'semester' => $year['semester'],
        'date_archived' => date('Y-m-d H:i:s'),
        'total_students' => $totalStudents,
        'data' => array_values($rooms)
    ];

    $stmt = $pdo->prepare("INSERT INTO archives (year_id, archived_data, archived_at) VALUES (?, ?, NOW())");
    $stmt->execute([$year['id'], json_encode($archiveData)]);
    sendJson(['success' => true]);
}

function getArchives($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM archives ORDER BY archived_at DESC");
    $stmt->execute();
    $archives = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $result = [];
    foreach ($archives as $a) {
        $data = json_decode($a['archived_data'], true);
        $data['id'] = $a['id'];
        $result[] = $data;
    }
    sendJson(['success' => true, 'archives' => $result]);
}

function getArchiveDetails($pdo)
{
    $id = $_GET['archive_id'];
    $stmt = $pdo->prepare("SELECT archived_data FROM archives WHERE id = ?");
    $stmt->execute([$id]);
    $d = $stmt->fetch();
    sendJson(['success' => true, 'archive' => json_decode($d['archived_data'], true)]);
}