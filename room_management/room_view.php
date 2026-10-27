<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details Editor</title>
    <style>
        /* --- THEME VARIABLES --- */
        :root {
            /* Light Theme (Default) */
            --bg-body: #f4f6f8;
            --bg-card: #ffffff;
            --text-main: #2d3748;
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --input-bg: #ffffff;
            --input-text: #2d3748;
            --input-border: #cbd5e0;
            --th-bg: #f7fafc;
            --btn-save-bg: #e6fffa;
            --btn-save-text: #2c7a7b;
            --btn-save-border: #b2f5ea;
            --btn-del-bg: #fff5f5;
            --btn-del-text: #c53030;
            --btn-del-border: #feb2b2;
            --shadow: rgba(0, 0, 0, 0.1);
        }

        body.dark-mode {
            /* Dark Theme Override */
            --bg-body: #1a202c !important;
            --bg-card: #2d3748 !important;
            --text-main: #f7fafc !important;
            --text-muted: #cbd5e0 !important;
            --border-color: #4a5568 !important;
            --input-bg: #4a5568 !important;
            --input-text: #ffffff !important;
            --input-border: #718096 !important;
            --th-bg: #2d3748 !important;
            --btn-save-bg: #285e61 !important;
            --btn-save-text: #81e6d9 !important;
            --btn-save-border: #319795 !important;
            --btn-del-bg: #742a2a !important;
            --btn-del-text: #feb2b2 !important;
            --btn-del-border: #e53e3e !important;
            --shadow: rgba(0, 0, 0, 0.4) !important;
        }

        /* --- BASE STYLES --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            padding: 30px;
            transition: background-color 0.3s, color 0.3s;
        }

        .container {
            background-color: var(--bg-card);
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px var(--shadow);
            position: relative;
            border: 1px solid var(--border-color);
        }

        /* HEADER & TOGGLE */
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0 0 5px 0;
            color: var(--text-main);
        }

        .sub-header {
            color: var(--text-muted);
        }

        .theme-toggle {
            background: transparent;
            border: 2px solid var(--border-color);
            padding: 5px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 1.2em;
            color: var(--text-main);
            transition: 0.2s;
        }

        .theme-toggle:hover {
            background-color: var(--th-bg);
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            text-align: left;
            background-color: var(--th-bg);
            padding: 12px;
            color: var(--text-muted);
            font-weight: 700;
            border-bottom: 2px solid var(--border-color);
        }

        td {
            padding: 8px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            color: var(--text-main);
        }

        /* INPUTS - Force colors to prevent browser default messing up dark mode */
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            font-size: 0.95em;
            background-color: var(--input-bg);
            color: var(--input-text);
            transition: border 0.2s;
        }

        input[type="text"]:focus,
        select:focus {
            border-color: #4299e1;
            outline: none;
        }

        /* ACTION BUTTONS (Icons) */
        .actions-cell {
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: flex-start;
        }

        .btn-icon {
            border: 1px solid transparent;
            width: 34px;
            height: 34px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1em;
            transition: all 0.2s ease;
        }

        .btn-save {
            background-color: var(--btn-save-bg);
            color: var(--btn-save-text);
            border-color: var(--btn-save-border);
        }

        .btn-save:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        .btn-delete {
            background-color: var(--btn-del-bg);
            color: var(--btn-del-text);
            border-color: var(--btn-del-border);
        }

        .btn-delete:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        /* Status Colors */
        .status-Active {
            color: #38a169;
            font-weight: 700;
        }

        .status-Dropped {
            color: #e53e3e;
            font-weight: 700;
        }

        .status-Graduate {
            color: #dd6b20;
            font-weight: 700;
        }

        /* Adjust Status Colors for Dark Mode visibility */
        body.dark-mode .status-Active {
            color: #68d391;
        }

        body.dark-mode .status-Dropped {
            color: #fc8181;
        }

        body.dark-mode .status-Graduate {
            color: #f6ad55;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header-row">
            <div>
                <h1 id="roomTitle">Loading...</h1>
                <div class="sub-header" id="roomSub">Fetching data...</div>
            </div>
            <button class="theme-toggle" onclick="toggleTheme()" id="themeBtn" title="Toggle Theme">🌙</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="25%">Name</th>
                    <th width="12%">Gender</th>
                    <th width="20%">Course</th>
                    <th width="10%">Year</th>
                    <th width="15%">Status</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody id="studentTable"></tbody>
        </table>
    </div>

    <script>
        const API = 'api.php';
        const urlParams = new URLSearchParams(window.location.search);
        const roomId = urlParams.get('room_id');

        // --- THEME LOGIC ---
        function applyTheme() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
                document.getElementById('themeBtn').textContent = '☀️';
            } else {
                document.body.classList.remove('dark-mode');
                document.getElementById('themeBtn').textContent = '🌙';
            }
        }

        function toggleTheme() {
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'light');
            } else {
                localStorage.setItem('theme', 'dark');
            }
            applyTheme();
        }

        window.onload = function () {
            applyTheme();
            if (!roomId) {
                document.body.innerHTML = "<h1>Error: No Room ID provided</h1>";
                return;
            }
            loadData();
        };

        // --- DATA LOGIC ---
        async function loadData() {
            try {
                const res = await fetch(`${API}?action=get_room_details&room_id=${roomId}`);
                const data = await res.json();

                if (data.success) {
                    const r = data.room;
                    document.getElementById('roomTitle').innerText = r.name + (r.is_locked == 1 ? " (Locked 🔒)" : "");
                    document.getElementById('roomSub').innerText = `${data.students.length} Students Assigned`;
                    renderTable(data.students);
                }
            } catch (e) { console.error(e); }
        }

        function renderTable(students) {
            const tbody = document.getElementById('studentTable');
            tbody.innerHTML = students.map((s, i) => `
            <tr id="row-${s.id}">
                <td>${i + 1}</td>
                <td><input type="text" id="name-${s.id}" value="${s.name}" oninput="this.value = this.value.toUpperCase()"></td>
                <td>
                    <select id="gender-${s.id}">
                        <option value="Male" ${s.gender && s.gender.toLowerCase() === 'male' ? 'selected' : ''}>Male</option>
                        <option value="Female" ${s.gender && s.gender.toLowerCase() === 'female' ? 'selected' : ''}>Female</option>
                    </select>
                </td>
                <td><input type="text" id="course-${s.id}" value="${s.course}" oninput="this.value = this.value.toUpperCase()"></td>
                <td><input type="text" id="year-${s.id}" value="${s.year_level}"></td>
                <td>
                    <select id="status-${s.id}" onchange="this.className='status-'+this.value" class="status-${s.status}">
                        <option value="Active" class="status-Active" ${s.status === 'Active' ? 'selected' : ''}>Active</option>
                        <option value="Dropped" class="status-Dropped" ${s.status === 'Dropped' ? 'selected' : ''}>Dropped</option>
                        <option value="Graduate" class="status-Graduate" ${s.status === 'Graduate' ? 'selected' : ''}>Graduate</option>
                    </select>
                </td>
                <td>
                    <div class="actions-cell">
                        <button class="btn-icon btn-save" title="Save Changes" onclick="saveStudent(${s.id})">💾</button>
                        <button class="btn-icon btn-delete" title="Remove Student" onclick="deleteStudent(${s.id}, '${s.name.replace(/'/g, "\\'")}')">🗑️</button>
                    </div>
                </td>
            </tr>
        `).join('');
        }

        async function saveStudent(id) {
            const btn = document.querySelector(`#row-${id} .btn-save`);
            const originalContent = btn.innerHTML;
            btn.innerHTML = "⏳";

            const payload = {
                student_id: id,
                // Capture value but PHP backend handles final capitalization
                name: document.getElementById(`name-${id}`).value,
                gender: document.getElementById(`gender-${id}`).value,
                course: document.getElementById(`course-${id}`).value,
                year: document.getElementById(`year-${id}`).value,
                status: document.getElementById(`status-${id}`).value
            };

            try {
                const res = await fetch(`${API}?action=update_student_details`, {
                    method: 'POST',
                    body: JSON.stringify(payload)
                });
                const data = await res.json();

                if (data.success) {
                    btn.innerHTML = "✅";
                    // Reload data to show PHP's forced uppercase result
                    loadData();
                } else {
                    alert("Error saving");
                    btn.innerHTML = originalContent;
                }
            } catch (e) {
                alert("Connection error");
                btn.innerHTML = originalContent;
            }
        }

        async function deleteStudent(studentId, studentName) {
            if (!confirm(`Are you sure you want to remove "${studentName}" from this room?`)) return;

            const payload = {
                room_id: roomId,
                student_id: studentId
            };

            try {
                const res = await fetch(`${API}?action=remove_student`, {
                    method: 'POST',
                    body: JSON.stringify(payload)
                });
                const data = await res.json();

                if (data.success) {
                    loadData();
                } else {
                    alert("Failed to delete student.");
                }
            } catch (e) {
                console.error(e);
                alert("Connection error deleting student.");
            }
        }
    </script>

</body>

</html>