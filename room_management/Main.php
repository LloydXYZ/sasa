<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management System by Cartin</title>
    <link rel="icon" type="image/png" href="zdspgc-logo.jpg">
    <style>
        /* --- THEME VARIABLES --- */
        :root {
            --bg-body: #f0f2f5;
            --bg-card: #ffffff;
            --text-main: #2d3748;
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --input-bg: #ffffff;
            --input-border: #cbd5e0;
            --item-bg: #f7fafc;
            --shadow: rgba(0, 0, 0, 0.05);
        }

        /* DARK MODE OVERRIDES */
        body.dark-mode {
            --bg-body: #1a202c;
            --bg-card: #2d3748;
            --text-main: #f7fafc;
            --text-muted: #a0aec0;
            --border-color: #4a5568;
            --input-bg: #2d3748;
            --input-border: #4a5568;
            --item-bg: #283141;
            --shadow: rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            padding: 20px;
            transition: background 0.3s, color 0.3s;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px var(--shadow);
            position: relative;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        h1 {
            color: var(--text-main);
            margin: 0;
        }

        .total-badge {
            background: #3182ce;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .theme-toggle {
            background: none;
            border: 2px solid var(--border-color);
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 1.2em;
            color: var(--text-main);
            transition: 0.2s;
        }

        .theme-toggle:hover {
            background: var(--item-bg);
        }

        .control-panel {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .group {
            display: flex;
            gap: 5px;
            align-items: center;
            background: var(--item-bg);
            padding: 5px 10px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        input,
        select {
            padding: 8px 12px;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            background: var(--input-bg);
            color: var(--text-main);
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: white;
            font-weight: 600;
            transition: 0.2s;
            white-space: nowrap;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: #1877f2;
        }

        .btn-success {
            background: #42b72a;
        }

        .btn-danger {
            background: #ff4d4f;
        }

        .btn-warning {
            background: #faad14;
        }

        .btn-info {
            background: #13c2c2;
        }

        .btn-dark {
            background: #4a5568;
        }

        .btn-purple {
            background: #805ad5;
        }

        .sem-btn {
            background: var(--item-bg);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .sem-btn.active {
            background: #3182ce;
            color: white;
            border-color: #3182ce;
        }

        .filter-section {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-bar {
            width: 300px;
            padding: 10px;
            border: 2px solid var(--input-border);
            border-radius: 8px;
            background: var(--input-bg);
            color: var(--text-main);
        }

        .filter-dropdown {
            padding: 10px;
            border: 2px solid var(--input-border);
            border-radius: 8px;
            min-width: 150px;
            background: var(--input-bg);
            color: var(--text-main);
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .room-card {
            background: var(--bg-card);
            border-radius: 10px;
            box-shadow: 0 4px 6px var(--shadow);
            overflow: hidden;
            transition: 0.2s;
            border: 1px solid var(--border-color);
        }

        .room-header {
            background: #1877f2;
            color: white;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .room-header.locked {
            background: #4a5568;
        }

        .room-stats {
            font-size: 0.85em;
            opacity: 0.9;
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        .room-actions {
            display: flex;
            gap: 5px;
            position: relative;
            z-index: 10;
        }

        .icon-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1em;
            text-decoration: none;
            position: relative;
            z-index: 20;
        }

        .icon-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .icon-btn.delete:hover {
            background: #e53e3e;
        }

        .student-list {
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
        }

        .student-item {
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 6px;
            background: var(--item-bg);
            border-left: 3px solid #cbd5e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-main);
        }

        .tags {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .tag {
            font-size: 0.75em;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        .tag-Female {
            background: #fed7e2;
            color: #b83280;
        }

        .tag-Male {
            background: #bee3f8;
            color: #2b6cb0;
        }

        .tag-NA {
            background: #e2e8f0;
            color: #718096;
        }

        .tag-Active {
            background: #c6f6d5;
            color: #276749;
        }

        .tag-Dropped {
            background: #fed7d7;
            color: #c53030;
        }

        .tag-Graduate {
            background: #feebc8;
            color: #c05621;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--bg-card);
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 900px;
            max-height: 80vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            color: var(--text-main);
        }

        /* FIX: Higher Z-Index for Export Modal so it sits ON TOP of Archive Modal */
        #exportModal {
            z-index: 1100;
        }

        .archive-item {
            background: var(--item-bg);
            border: 1px solid var(--border-color);
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .archive-item:hover {
            border-color: #4299e1;
        }

        .archive-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .archive-table th {
            background: var(--item-bg);
            padding: 10px;
            text-align: left;
            color: var(--text-main);
        }

        .archive-table td {
            border-bottom: 1px solid var(--border-color);
            padding: 10px;
            color: var(--text-main);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: var(--text-main);
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            background: var(--input-bg);
            color: var(--text-main);
        }

        /* PRINT STYLES */
        #print-area {
            display: none;
        }

        @media print {
            @page {
                margin: 0.5in;
            }

            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                display: block;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                font-family: Arial, sans-serif;
                color: #000;
            }

            .print-header-container {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
                border-bottom: 2px solid #333;
                padding-bottom: 15px;
            }

            .print-logo {
                height: 80px;
                margin-right: 20px;
            }

            .print-text {
                text-align: center;
            }

            .print-text h1 {
                margin: 0;
                font-size: 24px;
                color: #000;
            }

            .print-text p {
                margin: 5px 0;
                color: #444;
                font-size: 14px;
            }

            .print-room-container {
                page-break-after: always;
                margin-bottom: 0;
                padding-top: 10px;
                display: block;
            }

            .print-room-container:last-child {
                page-break-after: auto;
            }

            .print-room-title {
                background: #eee !important;
                padding: 10px;
                font-weight: bold;
                font-size: 18px;
                margin-bottom: 15px;
                border: 1px solid #999;
                border-radius: 5px;
                -webkit-print-color-adjust: exact;
                color: #000;
            }

            .print-grid {
                display: flex;
                width: 100%;
                gap: 20px;
                align-items: flex-start;
            }

            .print-col {
                flex: 1;
                border: 1px solid #666;
            }

            .print-col-header {
                background: #e0e0e0 !important;
                padding: 8px;
                text-align: center;
                font-weight: bold;
                border-bottom: 1px solid #666;
                -webkit-print-color-adjust: exact;
                color: #000;
            }

            .print-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .print-list li {
                padding: 5px 8px;
                border-bottom: 1px solid #ccc;
                display: flex;
                justify-content: space-between;
                font-size: 11px;
                color: #000;
            }

            .print-list li:last-child {
                border-bottom: none;
            }

            .print-meta {
                font-size: 0.9em;
                color: #444;
                font-style: italic;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-top">
                <div>
                    <h1>Room Management System</h1>
                    <div id="yearDisplay" style="color: var(--text-muted); font-weight: 600; margin-bottom: 5px;">
                        Loading...</div>
                    <span id="totalStudentsDisplay" class="total-badge">Total Students: 0</span>
                </div>
                <button onclick="toggleTheme()" id="themeBtn" class="theme-toggle">🌙</button>
            </div>

            <div class="control-panel">
                <div class="group">
                    <input type="text" id="acadYear" placeholder="Year (2025-2026)" style="width: 140px;">
                    <button class="btn btn-primary" onclick="setYear()">Set Year</button>
                </div>

                <div class="group">
                    <button class="btn sem-btn" id="sem1Btn" onclick="setSemester('First Semester')">1st Sem</button>
                    <button class="btn sem-btn" id="sem2Btn" onclick="setSemester('Second Semester')">2nd Sem</button>
                </div>

                <div class="group">
                    <input type="number" id="roomCount" placeholder="Qty" style="width: 70px;" min="1" value="1">
                    <button class="btn btn-danger" onclick="createRooms()">Reset</button>
                    <button class="btn btn-success" onclick="addRooms()">+ Add Room</button>
                    <div style="border-left:1px solid #ccc; margin:0 5px; height:20px;"></div>
                    <label
                        style="font-size:0.8em; font-weight:600; color:var(--text-muted); margin-right:5px;">Max:</label>
                    <input type="number" id="globalMaxCap" value="40" style="width: 60px;" min="1"
                        onchange="updateGlobalCap()">
                </div>

                <div class="group">
                    <button class="btn btn-success" onclick="openAddStudentModal()">+ Add Student</button>
                    <button class="btn btn-purple" onclick="openTransferModal()">Transfer</button>
                </div>

                <div class="group">
                    <button class="btn btn-dark" onclick="archiveCurrentYear()">Archive</button>
                    <button class="btn btn-dark" onclick="showArchives()">View Archives</button>
                </div>
                <div class="group">
                    <input type="file" id="fileInput" accept=".xlsx, .csv" hidden onchange="handleFileImport(this)">
                    <button class="btn btn-warning"
                        onclick="document.getElementById('fileInput').click()">Import</button>
                    <button class="btn btn-info" onclick="printDashboard()">Print All</button>
                    <button class="btn btn-info" onclick="openExportModal()">Export</button>
                </div>
            </div>

            <div class="filter-section">
                <input type="text" class="search-bar" id="searchInput" placeholder="Search student name..."
                    onkeyup="renderRooms()">
                <select id="filterCourse" class="filter-dropdown" onchange="renderRooms()">
                    <option value="">All Courses</option>
                </select>
                <select id="filterYear" class="filter-dropdown" onchange="renderRooms()">
                    <option value="">All Year Levels</option>
                </select>
            </div>
        </div>

        <div id="roomsContainer" class="rooms-grid"></div>
    </div>

    <!-- Hidden Print Area -->
    <div id="print-area"></div>

    <!-- MODALS -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <h2 style="margin-bottom: 20px;">Add New Student</h2>
            <div class="form-group"><label class="form-label">Name</label><input type="text" id="new_name"
                    class="form-input" oninput="this.value = this.value.toUpperCase()"></div>
            <div class="form-group"><label class="form-label">Course</label><input type="text" id="new_course"
                    class="form-input" oninput="this.value = this.value.toUpperCase()"></div>
            <div class="form-group"><label class="form-label">Year</label><input type="text" id="new_year"
                    class="form-input"></div>
            <div class="form-group"><label class="form-label">Gender</label>
                <select id="new_gender" class="form-input">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group"><label class="form-label">Assign to Room</label><select id="new_room_id"
                    class="form-input"></select></div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button class="btn" style="background:var(--input-border); color:var(--text-main);"
                    onclick="closeModal('addStudentModal')">Cancel</button>
                <button class="btn btn-success" onclick="addNewStudent()">Save Student</button>
            </div>
        </div>
    </div>

    <div id="transferModal" class="modal">
        <div class="modal-content">
            <h2 style="margin-bottom: 20px;">Transfer Student</h2>
            <div class="form-group">
                <label class="form-label">From Room</label>
                <select id="trans_from_room" class="form-input" onchange="loadStudentsForTransfer()">
                    <option value="">Select Room</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Select Student</label>
                <select id="trans_student" class="form-input">
                    <option value="">Select Student</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">To Room</label>
                <select id="trans_to_room" class="form-input">
                    <option value="">Select Room</option>
                </select>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button class="btn" style="background:var(--input-border); color:var(--text-main);"
                    onclick="closeModal('transferModal')">Cancel</button>
                <button class="btn btn-purple" onclick="executeTransfer()">Transfer</button>
            </div>
        </div>
    </div>

    <div id="exportModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <h2 style="margin-bottom: 20px;">Export to Excel/CSV</h2>
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px;">Select Room:</label>
                <select id="exportRoomSelect" style="width: 100%; padding: 10px;"></select>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button class="btn" style="background: var(--input-border); color: var(--text-main);"
                    onclick="closeModal('exportModal')">Cancel</button>
                <button id="exportActionBtn" class="btn btn-success" onclick="executeExport()">Download</button>
            </div>
        </div>
    </div>

    <div id="archiveModal" class="modal">
        <div class="modal-content" style="max-width: 900px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 id="archiveModalTitle">Archived Years</h2>
                <div>
                    <!-- Archive Action Buttons -->
                    <button id="archiveExportBtn" class="btn btn-warning" style="display:none; margin-right:5px;"
                        onclick="openArchiveExportModal()">Export</button>
                    <button id="archivePrintBtn" class="btn btn-info" style="display:none; margin-right:5px;"
                        onclick="printArchive()">Print</button>
                    <button id="archiveBackBtn" class="btn"
                        style="display:none; background:var(--input-border); color:var(--text-main);"
                        onclick="showArchiveList()">Back</button>
                    <button onclick="closeModal('archiveModal')" class="btn"
                        style="background:#e53e3e; margin-left:10px;">Close</button>
                </div>
            </div>
            <div id="archiveList" class="archive-list-container">Loading...</div>
            <div id="archiveDetailView" class="archive-detail-view">
                <h3 id="archiveTotalStudents" style="margin-bottom:10px; color:var(--text-muted);">Total Students: 0
                </h3>
                <input type="text" id="archiveSearch" class="search-bar"
                    style="width:100%; max-width:100%; margin-bottom:15px;" placeholder="Search inside this archive..."
                    onkeyup="filterArchiveTable()">
                <div style="max-height: 500px; overflow-y: auto;">
                    <table class="archive-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Course</th>
                                <th>Year</th>
                                <th>Room</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="archiveTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        const API_URL = 'api.php';
        let MAX_PER_ROOM = 40;
        let rooms = [];
        let currentYearData = null;
        let currentArchiveStudents = [];
        let currentArchiveData = null;

        // --- DARK MODE LOGIC ---
        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            document.getElementById('themeBtn').textContent = isDark ? '☀️' : '🌙';
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
        window.onload = function () {
            if (localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark-mode');
                document.getElementById('themeBtn').textContent = '☀️';
            }
            const initialMax = parseInt(document.getElementById('globalMaxCap').value);
            if (!isNaN(initialMax) && initialMax > 0) MAX_PER_ROOM = initialMax;
            loadCurrentYear();
        };

        // --- CAPACITY LOGIC ---
        function updateGlobalCap() {
            const val = parseInt(document.getElementById('globalMaxCap').value);
            if (val > 0) { MAX_PER_ROOM = val; renderRooms(); }
        }

        // --- CORE FUNCTIONS (API) ---
        async function loadCurrentYear() {
            try {
                const res = await fetch(`${API_URL}?action=get_current_year`);
                const data = await res.json();
                if (data.success && data.year) {
                    currentYearData = data.year;
                    document.getElementById('yearDisplay').textContent = `${data.year.year} - ${data.year.semester}`;
                    document.getElementById('sem1Btn').classList.toggle('active', data.year.semester === 'First Semester');
                    document.getElementById('sem2Btn').classList.toggle('active', data.year.semester === 'Second Semester');
                    loadRooms();
                } else {
                    document.getElementById('yearDisplay').textContent = "No Active Year";
                }
            } catch (e) { console.error(e); }
        }

        async function setYear() {
            const y = document.getElementById('acadYear').value;
            if (!y) return alert("Enter year");
            await fetch(`${API_URL}?action=set_year`, { method: 'POST', body: JSON.stringify({ year: y, semester: 'First Semester' }) });
            loadCurrentYear();
        }
        async function setSemester(sem) {
            if (!currentYearData) return alert("Set a year first");
            await fetch(`${API_URL}?action=update_semester`, { method: 'POST', body: JSON.stringify({ semester: sem }) });
            loadCurrentYear();
        }
        async function createRooms() {
            if (!confirm("⚠️ RESET WARNING: Delete all rooms and start fresh?")) return;
            const num = document.getElementById('roomCount').value;
            await fetch(`${API_URL}?action=create_rooms`, { method: 'POST', body: JSON.stringify({ num_rooms: num }) });
            loadRooms();
        }
        async function addRooms(count = null) {
            let num = count || document.getElementById('roomCount').value;
            if (!num || num < 1) num = 1;
            await fetch(`${API_URL}?action=add_rooms`, { method: 'POST', body: JSON.stringify({ count: parseInt(num) }) });
            loadRooms();
        }
        async function deleteRoom(roomId) {
            if (!confirm("Delete this room?")) return;
            await fetch(`${API_URL}?action=delete_single_room`, { method: 'POST', body: JSON.stringify({ room_id: roomId }) });
            loadRooms();
        }
        async function toggleLock(roomId, currentStatus) {
            await fetch(`${API_URL}?action=toggle_lock`, { method: 'POST', body: JSON.stringify({ room_id: roomId, is_locked: !currentStatus }) });
            loadRooms();
        }
        async function archiveCurrentYear() {
            if (!currentYearData) return alert("No active year to archive");
            if (!confirm("Archive current data and CLEAR board?")) return;
            await fetch(`${API_URL}?action=archive_year`, { method: 'POST' });
            await fetch(`${API_URL}?action=delete_rooms`, { method: 'POST' });
            loadRooms();
            alert("Archived and Cleared!");
        }

        // --- DATA LOADING & FILTERING ---
        async function loadRooms() {
            const res = await fetch(`${API_URL}?action=get_rooms`);
            const data = await res.json();
            rooms = data.rooms;
            rooms.forEach(r => r.students.sort((a, b) => a.name.localeCompare(b.name)));

            // Calculate Total Students for Landing Page
            let total = 0;
            rooms.forEach(r => total += r.students.length);
            document.getElementById('totalStudentsDisplay').textContent = `Total Students: ${total}`;

            populateFilters();
            renderRooms();
            return rooms;
        }

        function populateFilters() {
            const courses = new Set();
            const years = new Set();
            rooms.forEach(room => {
                room.students.forEach(s => {
                    let cleanCourse = s.course.replace(/[0-9]/g, '').replace(/-/g, '').trim();
                    if (cleanCourse) courses.add(cleanCourse);
                    if (s.year) years.add(s.year);
                });
            });
            const courseSel = document.getElementById('filterCourse');
            const currentCourse = courseSel.value;
            courseSel.innerHTML = '<option value="">All Courses</option>';
            Array.from(courses).sort().forEach(c => { courseSel.innerHTML += `<option value="${c}">${c}</option>`; });
            courseSel.value = currentCourse;
            const yearSel = document.getElementById('filterYear');
            const currentYear = yearSel.value;
            yearSel.innerHTML = '<option value="">All Year Levels</option>';
            Array.from(years).sort().forEach(y => { yearSel.innerHTML += `<option value="${y}">Year ${y}</option>`; });
            yearSel.value = currentYear;
        }

        function renderRooms() {
            const container = document.getElementById('roomsContainer');
            const search = document.getElementById('searchInput').value?.toLowerCase() || "";
            const filterC = document.getElementById('filterCourse').value;
            const filterY = document.getElementById('filterYear').value;

            container.innerHTML = rooms.map(room => {
                const isLocked = room.is_locked;
                const filtered = room.students.filter(s => {
                    const matchSearch = s.name.toLowerCase().includes(search);
                    const cleanStudentCourse = s.course.replace(/[0-9]/g, '').replace(/-/g, '').trim();
                    const matchCourse = filterC === "" || cleanStudentCourse === filterC;
                    const matchYear = filterY === "" || s.year === filterY;
                    return matchSearch && matchCourse && matchYear;
                });

                if ((search || filterC || filterY) && filtered.length === 0) return '';

                const fCount = filtered.filter(s => s.gender === 'Female').length;
                const mCount = filtered.filter(s => s.gender === 'Male').length;

                return `
                <div class="room-card">
                    <div class="room-header ${isLocked ? 'locked' : ''}">
                        <div><div style="font-weight:bold;">${room.name} ${isLocked ? '🔒' : ''}</div><div class="room-stats">👥 ${filtered.length} / ${MAX_PER_ROOM} | F:${fCount} M:${mCount}</div></div>
                        <div class="room-actions">
                            <button class="icon-btn" onclick="printRoom(${room.id})" title="Print Room">🖨️</button>
                            <button class="icon-btn" title="Export Room" onclick="openExportForRoom(${room.id})">📥</button>
                            <a href="room_view.php?room_id=${room.id}" title="View Room" target="_blank" class="icon-btn" title="View" style="text-decoration:none;display:flex;align-items:center;justify-content:center;">👁️</a>
                            <button class="icon-btn" title="Lock Room" onclick="toggleLock(${room.id}, ${isLocked})">${isLocked ? '🔓' : '🔒'}</button>
                            <button title="Delete Room" class="icon-btn delete" onclick="deleteRoom(${room.id})">🗑️</button>
                        </div>
                    </div>
                    <div class="student-list">
                        ${filtered.map((s, idx) => `
                            <div class="student-item">
                                <div><div style="font-weight:500;">${idx + 1}. ${s.name}</div><div style="font-size:0.8em;opacity:0.8;">${s.course} - Year ${s.year}</div></div>
                                <div class="tags"><span class="tag tag-${s.gender}">${s.gender}</span><span class="tag tag-${s.status}">${s.status}</span></div>
                            </div>`).join('')}
                    </div>
                </div>`;
            }).join('');
        }

        // --- PRINTING LOGIC ---
        function getPrintHeader() {
            return `
                <div class="print-header-container">
                    <img src="zdspgc-logo.jpg" class="print-logo" alt="Logo"> 
                    <div class="print-text">
                        <h1>ZDSPGC - Tukuran</h1>
                        <p>Academic Year: ${currentYearData ? currentYearData.year + ' - ' + currentYearData.semester : ''}</p>
                    </div>
                </div>
            `;
        }

        function printDashboard() {
            let content = getPrintHeader();
            rooms.forEach(room => {
                const females = room.students.filter(s => s.gender === 'Female').sort((a, b) => a.name.localeCompare(b.name));
                const males = room.students.filter(s => s.gender !== 'Female').sort((a, b) => a.name.localeCompare(b.name));
                const courses = [...new Set(room.students.map(s => `${s.course} ${s.year}`))].join(', ');

                content += `
                <div class="print-room-container">
                    <div class="print-room-title">${room.name} (${room.students.length}) - <small>${courses}</small></div>
                    <div class="print-grid">
                        <div class="print-col">
                            <div class="print-col-header">FEMALE (${females.length})</div>
                            <ul class="print-list">${females.map((s, i) => `<li><span>${i + 1}. ${s.name}</span><span class="print-meta">${s.course}-${s.year}</span></li>`).join('')}</ul>
                        </div>
                        <div class="print-col">
                            <div class="print-col-header">MALE (${males.length})</div>
                            <ul class="print-list">${males.map((s, i) => `<li><span>${i + 1}. ${s.name}</span><span class="print-meta">${s.course}-${s.year}</span></li>`).join('')}</ul>
                        </div>
                    </div>
                </div>`;
            });
            document.getElementById('print-area').innerHTML = content;
            window.print();
        }

        function printRoom(id) {
            const room = rooms.find(r => r.id == id);
            if (!room) return;
            const females = room.students.filter(s => s.gender === 'Female').sort((a, b) => a.name.localeCompare(b.name));
            const males = room.students.filter(s => s.gender !== 'Female').sort((a, b) => a.name.localeCompare(b.name));
            const courses = [...new Set(room.students.map(s => `${s.course} - Year ${s.year}`))].join(', ');

            const html = getPrintHeader() + `
                <div class="print-room-container">
                    <div class="print-room-title">${room.name} (${room.students.length}) - <small>${courses}</small></div>
                    <div class="print-grid">
                        <div class="print-col"><div class="print-col-header">FEMALE (${females.length})</div><ul class="print-list">${females.map((s, i) => `<li><span>${i + 1}. ${s.name}</span><span class="print-meta">${s.course}-${s.year}</span></li>`).join('')}</ul></div>
                        <div class="print-col"><div class="print-col-header">MALE (${males.length})</div><ul class="print-list">${males.map((s, i) => `<li><span>${i + 1}. ${s.name}</span><span class="print-meta">${s.course}-${s.year}</span></li>`).join('')}</ul></div>
                    </div>
                </div>
            `;
            document.getElementById('print-area').innerHTML = html;
            window.print();
        }

        function printArchive() {
            if (!currentArchiveData) return;
            let content = `
                <div class="print-header-container">
                    <img src="logo.png" class="print-logo" alt="Logo"> 
                    <div class="print-text">
                        <h1>Archived Report</h1>
                        <p>${currentArchiveData.year} - ${currentArchiveData.semester} (Archived: ${currentArchiveData.date_archived})</p>
                    </div>
                </div>
             `;

            currentArchiveData.data.forEach(room => {
                const females = room.students.filter(s => (s.gender || '').startsWith('F')).sort((a, b) => a.name.localeCompare(b.name));
                const males = room.students.filter(s => !(s.gender || '').startsWith('F')).sort((a, b) => a.name.localeCompare(b.name));
                const courses = [...new Set(room.students.map(s => `${s.course} ${s.year}`))].join(', ');

                content += `
                <div class="print-room-container">
                    <div class="print-room-title">${room.name} (${room.students.length}) - <small>${courses}</small></div>
                    <div class="print-grid">
                        <div class="print-col">
                            <div class="print-col-header">FEMALE (${females.length})</div>
                            <ul class="print-list">${females.map((s, i) => `<li><span>${i + 1}. ${s.name}</span><span class="print-meta">${s.course}-${s.year}</span></li>`).join('')}</ul>
                        </div>
                        <div class="print-col">
                            <div class="print-col-header">MALE (${males.length})</div>
                            <ul class="print-list">${males.map((s, i) => `<li><span>${i + 1}. ${s.name}</span><span class="print-meta">${s.course}-${s.year}</span></li>`).join('')}</ul>
                        </div>
                    </div>
                </div>`;
            });

            document.getElementById('print-area').innerHTML = content;
            window.print();
        }

        function generatePrintHTML(content) {
            return `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Print</title>
                    <style>
                        @page { margin: 0.5in; }
                        body { font-family: Arial, sans-serif; padding: 20px; color: #000; }
                        .print-header-container { display: flex; align-items: center; justify-content: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 15px; }
                        .print-logo { height: 80px; margin-right: 20px; }
                        .print-text { text-align: center; }
                        .print-text h1 { margin: 0; font-size: 24px; color: #000; }
                        .print-text p { margin: 5px 0; color: #444; font-size: 14px; }
                        .print-room-container { page-break-after: always; margin-bottom: 0; padding-top: 10px; display: block; }
                        .print-room-container:last-child { page-break-after: auto; }
                        .print-room-title { background: #eee !important; padding: 10px; font-weight: bold; font-size: 18px; margin-bottom: 15px; border: 1px solid #999; border-radius: 5px; -webkit-print-color-adjust: exact; color: #000; }
                        .print-grid { display: flex; width: 100%; gap: 20px; align-items: flex-start; }
                        .print-col { flex: 1; border: 1px solid #666; }
                        .print-col-header { background: #e0e0e0 !important; padding: 8px; text-align: center; font-weight: bold; border-bottom: 1px solid #666; -webkit-print-color-adjust: exact; color: #000; }
                        .print-list { list-style: none; padding: 0; margin: 0; }
                        .print-list li { padding: 5px 8px; border-bottom: 1px solid #ccc; display: flex; justify-content: space-between; font-size: 11px; color: #000; }
                        .print-list li:last-child { border-bottom: none; }
                        .print-meta { font-size: 0.9em; color: #444; font-style: italic; }
                    </style>
                </head>
                <body>
                    ${content}
                    <script>
                        setTimeout(function() { window.print(); window.close(); }, 500); 
                    <\/script>
                </body>
                </html>
            `;
        }

        // --- NEW FEATURES: ADD / TRANSFER (FIXED FOR ALL) ---
        function openAddStudentModal() {
            const sel = document.getElementById('new_room_id');
            sel.innerHTML = rooms.map(r => `<option value="${r.id}">${r.name}</option>`).join('');
            document.getElementById('addStudentModal').classList.add('active');
        }
        async function addNewStudent() {
            const name = document.getElementById('new_name').value.toUpperCase();
            const course = document.getElementById('new_course').value.toUpperCase();
            const year = document.getElementById('new_year').value;
            const gender = document.getElementById('new_gender').value;
            const roomId = document.getElementById('new_room_id').value;
            if (!name || !course || !year) return alert("Fill all fields");
            const res = await fetch(`${API_URL}?action=add_student`, { method: 'POST', body: JSON.stringify({ name, course, year, gender, room_id: roomId }) });
            if ((await res.json()).success) { closeModal('addStudentModal'); loadRooms(); }
        }

        function openTransferModal() {
            const rOpts = '<option value="">Select Room</option>' + rooms.map(r => `<option value="${r.id}">${r.name}</option>`).join('');
            document.getElementById('trans_from_room').innerHTML = rOpts;
            document.getElementById('trans_to_room').innerHTML = rOpts;
            document.getElementById('trans_student').innerHTML = '<option value="">Select Student</option>';
            document.getElementById('transferModal').classList.add('active');
        }
        function loadStudentsForTransfer() {
            const rid = document.getElementById('trans_from_room').value;
            const sSel = document.getElementById('trans_student');
            if (!rid) { sSel.innerHTML = '<option value="">Select Student</option>'; return; }
            const room = rooms.find(r => r.id == rid);
            sSel.innerHTML = '<option value="">Select Student</option><option value="all" style="font-weight:bold;color:blue;">--- ALL STUDENTS ---</option>' +
                room.students.map(s => `<option value="${s.id}">${s.name}</option>`).join('');
        }
        async function executeTransfer() {
            const from = document.getElementById('trans_from_room').value;
            const to = document.getElementById('trans_to_room').value;
            const sid = document.getElementById('trans_student').value;
            if (!from || !to || !sid) return alert("Select all fields");
            if (from == to) return alert("Cannot transfer to same room");

            const action = (sid === 'all') ? 'transfer_all_students' : 'transfer_student';

            try {
                const res = await fetch(`${API_URL}?action=${action}`, {
                    method: 'POST', body: JSON.stringify({ from_room_id: from, to_room_id: to, student_id: sid })
                });
                if ((await res.json()).success) { closeModal('transferModal'); loadRooms(); alert("Transfer successful"); }
            } catch (e) { alert("Connection failed"); }
        }

        function showArchives() {
            document.getElementById('archiveModal').classList.add('active');
            showArchiveList();
            const list = document.getElementById('archiveList');
            list.innerHTML = "Loading...";
            fetch(`${API_URL}?action=get_archives`).then(r => r.json()).then(data => {
                if (data.success && data.archives.length > 0) {
                    list.innerHTML = data.archives.map((arch, idx) => `
                        <div class="archive-item" onclick='loadArchiveDetail(${JSON.stringify(arch)})'>
                            <div>
                                <div style="font-weight:bold; font-size:1.1em;">${arch.year} - ${arch.semester} (${arch.total_students || 0} Students)</div>
                                <div style="color:#718096; font-size:0.9em;">Archived: ${arch.date_archived}</div>
                            </div>
                            <button class="btn btn-info">View</button>
                        </div>`).join('');
                } else { list.innerHTML = "No archives found."; }
            });
        }
        function showArchiveList() {
            document.getElementById('archiveList').style.display = 'grid';
            document.getElementById('archiveDetailView').classList.remove('active');
            document.getElementById('archiveBackBtn').style.display = 'none';
            document.getElementById('archivePrintBtn').style.display = 'none';
            document.getElementById('archiveExportBtn').style.display = 'none';
            document.getElementById('archiveModalTitle').textContent = "Archived Years";
        }

        function loadArchiveDetail(archive) {
            currentArchiveData = archive; // Store for printing
            document.getElementById('archiveList').style.display = 'none';
            document.getElementById('archiveDetailView').classList.add('active');
            document.getElementById('archiveBackBtn').style.display = 'inline-block';
            document.getElementById('archivePrintBtn').style.display = 'inline-block';
            document.getElementById('archiveExportBtn').style.display = 'inline-block';
            document.getElementById('archiveModalTitle').textContent = `${archive.year} - ${archive.semester}`;
            document.getElementById('archiveTotalStudents').textContent = `Total Students: ${archive.total_students || 0}`;

            currentArchiveStudents = [];
            archive.data.forEach(room => {
                room.students.forEach(s => {
                    let g = s.gender || 'N/A';
                    if (g.toUpperCase().startsWith('F')) g = 'Female'; else if (g.toUpperCase().startsWith('M')) g = 'Male';
                    currentArchiveStudents.push({ ...s, gender: g, roomName: room.name });
                });
            });
            currentArchiveStudents.sort((a, b) => a.name.localeCompare(b.name));
            renderArchiveTable(currentArchiveStudents);
        }

        function renderArchiveTable(students) {
            document.getElementById('archiveTableBody').innerHTML = students.length === 0 ? '<tr><td colspan="6" style="text-align:center;">No students</td></tr>' :
                students.map(s => `<tr><td>${s.name}</td><td>${s.gender}</td><td>${s.course}</td><td>${s.year}</td><td>${s.roomName}</td><td>${s.status}</td></tr>`).join('');
        }
        function filterArchiveTable() {
            const term = document.getElementById('archiveSearch').value.toLowerCase();
            renderArchiveTable(currentArchiveStudents.filter(s => s.name.toLowerCase().includes(term) || s.course.toLowerCase().includes(term) || s.roomName.toLowerCase().includes(term)));
        }

        // --- ARCHIVE EXPORT LOGIC ---
        function openArchiveExportModal() {
            const sel = document.getElementById('exportRoomSelect');
            if (!currentArchiveData || !currentArchiveData.data) return;

            sel.innerHTML = '<option value="">Select Room...</option>' +
                currentArchiveData.data.map((r, idx) => `<option value="${idx}">${r.name} (${r.students.length})</option>`).join('');

            document.getElementById('exportActionBtn').onclick = executeArchiveExport;
            document.getElementById('exportModal').classList.add('active');
        }

        function executeArchiveExport() {
            const idx = document.getElementById('exportRoomSelect').value;
            if (idx === "") return;

            const room = currentArchiveData.data[idx];
            if (!room) return;

            let csv = `Room: ${room.name}\nSemester: ${currentArchiveData.semester} ${currentArchiveData.year}\n\nNo.,Name,Gender,Course,Year,Status\n`;
            room.students.forEach((s, i) => {
                csv += `${i + 1},"${s.name}",${s.gender},"${s.course}",${s.year},${s.status}\n`;
            });

            const blob = new Blob([csv], { type: 'text/csv' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `${room.name}_Archive_Export.csv`;
            link.click();
            closeModal('exportModal');
        }


        // --- IMPORT LOGIC ---
        function handleFileImport(input) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = e => {
                const data = new Uint8Array(e.target.result);
                const wb = XLSX.read(data, { type: 'array' });
                const json = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]]);
                processImport(json);
                input.value = '';
            };
            reader.readAsArrayBuffer(file);
        }
        function shuffleArray(array) { for (let i = array.length - 1; i > 0; i--) { const j = Math.floor(Math.random() * (i + 1));[array[i], array[j]] = [array[j], array[i]]; } }
        async function processImport(json) {
            await loadRooms();
            let avail = rooms.filter(r => !r.is_locked);
            avail.sort((a, b) => a.room_number - b.room_number);
            let genderKey = null;
            if (json.length > 0) {
                const keys = Object.keys(json[0]);
                genderKey = keys.find(k => k.match(/gender|sex|gen|^g$/i));
                if (!genderKey) { for (const key of keys) { const sample = String(json[0][key]).trim().toLowerCase(); if (['m', 'f', 'male', 'female'].includes(sample)) { genderKey = key; break; } } }
            }
            let students = json.map((row, i) => {
                const keys = Object.keys(row);
                const nameKey = keys.find(k => k.match(/name/i));
                const courseKey = keys.find(k => k.match(/course/i));
                const yearKey = keys.find(k => k.match(/year/i));
                if (!nameKey) return null;
                let gRaw = genderKey ? String(row[genderKey]).trim() : '';
                let gFinal = 'N/A';
                if (gRaw.match(/^f/i)) gFinal = 'Female'; else if (gRaw.match(/^m/i)) gFinal = 'Male';

                // FORCE UPPERCASE HERE ON IMPORT
                return {
                    tempId: Date.now() + i,
                    name: String(row[nameKey]).toUpperCase(),
                    course: courseKey ? String(row[courseKey]).toUpperCase() : 'N/A',
                    year: yearKey ? String(row[yearKey]) : '1',
                    gender: gFinal
                };
            }).filter(s => s !== null);
            if (students.length === 0) return alert("No valid columns found");

            // --- AUTO-SCALE FIX ---
            let totalStudentsToSeat = students.length;
            let currentUsableCapacity = 0;

            // 1. Determine usable rooms (those UNDER or at MAX_PER_ROOM)
            let usableRooms = avail.filter(r => r.students.length < MAX_PER_ROOM);

            // 2. Calculate remaining available seats in these rooms
            usableRooms.forEach(r => {
                currentUsableCapacity += (MAX_PER_ROOM - r.students.length);
            });

            if (totalStudentsToSeat > currentUsableCapacity) {
                const deficit = totalStudentsToSeat - currentUsableCapacity;
                const roomsNeeded = Math.ceil(deficit / MAX_PER_ROOM);

                await fetch(`${API_URL}?action=add_rooms`, { method: 'POST', body: JSON.stringify({ count: roomsNeeded }) });

                // Re-fetch rooms after creation
                rooms = await loadRooms();
                avail = rooms.filter(r => !r.is_locked);
                avail.sort((a, b) => a.room_number - b.room_number);

                // Re-calculate usableRooms array
                usableRooms = avail.filter(r => r.students.length < MAX_PER_ROOM);
            }

            // --- GLOBAL ZIPPER (Assigns students sequentially to usable rooms) ---
            let allF = students.filter(s => s.gender === 'Female');
            let allM = students.filter(s => s.gender !== 'Female');
            shuffleArray(allF); shuffleArray(allM);
            let mixedQueue = [];
            const maxLen = Math.max(allF.length, allM.length);
            for (let i = 0; i < maxLen; i++) { if (i < allF.length) mixedQueue.push(allF[i]); if (i < allM.length) mixedQueue.push(allM[i]); }

            let assigns = [];
            let roomPointer = 0;

            for (let student of mixedQueue) {
                // Find the next USABLE room (which is guaranteed to exist due to the auto-scale step)
                let room = usableRooms[roomPointer];
                if (!room) break; // Safety break

                assigns.push({ room_id: room.id, temp_student_id: student.tempId });

                // Simulate adding student to the room object to track capacity locally
                room.students.push(student);

                // Check if the room is now full based on MAX_PER_ROOM
                if (room.students.length >= MAX_PER_ROOM) {
                    roomPointer++; // Move to the next usable room
                    if (roomPointer >= usableRooms.length) {
                        // Should not happen if auto-scale worked, but good to prevent crash
                        break;
                    }
                }
            }

            if (assigns.length) {
                const res = await fetch(`${API_URL}?action=import_students`, { method: 'POST', body: JSON.stringify({ students: students, room_assignments: assigns }) });
                if ((await res.json()).success) { alert("Imported!"); loadRooms(); } else { alert("Error importing"); }
            }
        }
        function openExportModal() {
            document.getElementById('exportActionBtn').onclick = executeExport;
            document.getElementById('exportRoomSelect').innerHTML = '<option value="">Select Room...</option>' + rooms.map(r => `<option value="${r.id}">${r.name}</option>`).join('');
            document.getElementById('exportModal').classList.add('active');
        }
        function openExportForRoom(id) { openExportModal(); document.getElementById('exportRoomSelect').value = id; }
        function executeExport() {
            const id = document.getElementById('exportRoomSelect').value;
            if (!id) return;
            const r = rooms.find(x => x.id == id);
            let csv = `Room: ${r.name}\n\nNo.,Name,Gender,Course,Year,Status\n`;
            r.students.forEach((s, i) => csv += `${i + 1},"${s.name}",${s.gender},"${s.course}",${s.year},${s.status}\n`);
            const blob = new Blob([csv], { type: 'text/csv' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `${r.name}_Export.csv`;
            link.click();
            closeModal('exportModal');
        }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    </script>
</body>

</html>