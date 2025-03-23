<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "mangyan");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $tagalog_word = $_POST['tagalog_word'];
    $mangyan_word = $_POST['mangyan_word'];
    $dialect = $_POST['dialect'];

    $stmt = $conn->prepare("INSERT INTO translations (tagalog_word, mangyan_word, dialect) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $tagalog_word, $mangyan_word, $dialect);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $tagalog_word = $_POST['tagalog_word'];
    $mangyan_word = $_POST['mangyan_word'];

    $stmt = $conn->prepare("UPDATE translations SET tagalog_word=?, mangyan_word=? WHERE id=?");
    $stmt->bind_param("ssi", $tagalog_word, $mangyan_word, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM translations WHERE id=$id");
    header("Location: admin.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit();
}

$result = $conn->query("SELECT * FROM translations");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0ffe0;
            color: #006600;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 102, 0, 0.5);
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #006600;
            border-radius: 5px;
        }
        button {
            background: #006600;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #009900;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #006600;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Panel</h2>
        <form method="POST">
            <input type="text" name="tagalog_word" placeholder="Tagalog Word" required>
            <input type="text" name="mangyan_word" placeholder="Mangyan Word" required>
            <select name="dialect" required>
                <option value="Hanunuo">Hanunuo</option>
                <option value="Buhid">Buhid</option>
                <option value="Tawbuid">Tawbuid</option>
                <option value="Iraya">Iraya</option>
            </select>
            <div class="button-group">
                <button type="submit" name="add"><i class="fas fa-plus-circle"></i> Add Translation</button>
            </div>
        </form>
        <form method="POST" style="margin-top: 20px;">
            <button type="submit" name="logout" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</button> <!-- Logout button -->
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>Tagalog Word</th>
                <th>Mangyan Word</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['tagalog_word']; ?></td>
                    <td><?php echo $row['mangyan_word']; ?></td>
                    <td>
                        <button onclick="openModal('editModal', '<?php echo $row['id']; ?>', '<?php echo $row['tagalog_word']; ?>', '<?php echo $row['mangyan_word']; ?>')">Edit</button>
                        <button onclick="openModal('deleteModal', '<?php echo $row['id']; ?>')">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3>Edit Translation</h3>
            <form method="POST">
                <input type="hidden" name="id" id="editId">
                <input type="text" name="tagalog_word" id="editTagalog" required>
                <input type="text" name="mangyan_word" id="editMangyan" required>
                <button type="submit" name="edit">Save Changes</button>
                <button type="button" onclick="closeModal('editModal')">Cancel</button>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Are you sure you want to delete this translation?</h3>
            <form method="POST">
                <input type="hidden" name="id" id="deleteId">
                <button type="submit" name="delete">Delete</button>
                <button type="button" onclick="closeModal('deleteModal')">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId, id, tagalog = '', mangyan = '') {
            document.getElementById(modalId).style.display = 'flex';
            if (modalId === 'editModal') {
                document.getElementById('editId').value = id;
                document.getElementById('editTagalog').value = tagalog;
                document.getElementById('editMangyan').value = mangyan;
            } else if (modalId === 'deleteModal') {
                document.getElementById('deleteId').value = id;
            }
        }
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
    </script>
</body>
</html>