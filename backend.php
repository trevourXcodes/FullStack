<?php
session_start();

// 🛠️ DB Config
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'todo_project';

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die('Database Integration Failed: ' . mysqli_connect_error());
}

// 🔹 Add Task
if (isset($_POST['add'])) {
    $item = trim($_POST['item']);
    $priority = $_POST['priority'] ?? 'Low';

    // Sanitize values
    $item = mysqli_real_escape_string($conn, $item);
    $priority = mysqli_real_escape_string($conn, $priority);

    if (!empty($item)) {
        $query = "INSERT INTO todo_table (name, priority) VALUES ('$item', '$priority')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "✅ Item Added Successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "❌ Failed to Add Task!";
            $_SESSION['message_type'] = "danger";
        }
        header("Location: index.php");
        exit();
    }
}

// 🔹 Mark as Done / Delete
if (isset($_GET['action'], $_GET['item'])) {
    $itemID = (int) $_GET['item'];

    if ($_GET['action'] === 'done') {
        $query = "UPDATE todo_table SET status = 1 WHERE id = $itemID";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "☑️ Item Marked as Done!";
            $_SESSION['message_type'] = "info";
        }
    } elseif ($_GET['action'] === 'delete') {
        $query = "DELETE FROM todo_table WHERE id = $itemID";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "🗑️ Item Deleted Successfully!";
            $_SESSION['message_type'] = "danger";
        }
    }

    header("Location: index.php");
    exit();
}

// 🔹 Edit Task
if (isset($_POST['edit'])) {
    $id = (int) $_POST['edit_id'];
    $name = trim($_POST['edit_name']);
    $priority = $_POST['edit_priority'];

    $name = mysqli_real_escape_string($conn, $name);
    $priority = mysqli_real_escape_string($conn, $priority);

    $query = "UPDATE todo_table SET name = '$name', priority = '$priority' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "✏️ Item Updated Successfully!";
        $_SESSION['message_type'] = "update"; // 🟦 use alert-primary for updates
    } else {
        $_SESSION['message'] = "❌ Failed to Update!";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: index.php");
    exit();
}
?>
