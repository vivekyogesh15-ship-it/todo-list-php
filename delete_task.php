<?php
include 'config/db.php';
include 'functions/auth.php';

require_login();

$user_id = $_SESSION['user_id'];


if (isset($_GET['id'])) {
    $task_id = (int)$_GET['id']; // 
    
    $sql = "DELETE FROM tasks WHERE id = $task_id AND user_id = $user_id";
    $conn->query($sql);
}

header("Location: tasks.php");
exit;
?>