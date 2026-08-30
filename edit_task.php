<?php
include 'config/db.php';
include 'functions/auth.php';

require_login();

$user_id = $_SESSION['user_id'];
$msg = '';

if (!isset($_GET['id'])) {
    header("Location: tasks.php");
    exit;
}

$task_id = (int)$_GET['id'];

$categories = $conn->query("SELECT * FROM categories WHERE user_id = $user_id");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : 'NULL';
    $due_date = !empty($_POST['due_date']) ? "'" . $conn->real_escape_string($_POST['due_date']) . "'" : 'NULL';
    $priority = $conn->real_escape_string($_POST['priority']);
    $status = $conn->real_escape_string($_POST['status']);
    
    $sql = "UPDATE tasks SET 
            title = '$title', 
            description = '$description', 
            category_id = $category_id, 
            due_date = $due_date, 
            priority = '$priority', 
            status = '$status' 
            WHERE id = $task_id AND user_id = $user_id";
    
    if ($conn->query($sql)) {
        header("Location: tasks.php");
        exit;
    } else {
        $msg = "❌ Error: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM tasks WHERE id = $task_id AND user_id = $user_id");

if ($result->num_rows == 0) {
    header("Location: tasks.php");
    exit;
}

$task = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task - To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard-wrapper">
    
    <div class="sidebar">
        <h3>📝 To-Do List</h3>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="tasks.php" class="active">✅ Tasks</a>
        <a href="categories.php">🏷️ Categories</a>
    </div>
    
    <div class="main-content">
        
        <div class="navbar">
            <h2>Edit Task</h2>
            <a href="logout.php">Logout</a>
        </div>
        
        <div class="table-container" style="max-width: 600px;">
            
            <?php if (!empty($msg)): ?>
                <div class="alert alert-danger"><?php echo $msg; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"><?php echo htmlspecialchars($task['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">-- No Category --</option>
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $task['category_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Due Date</label>
                    <input type="date" name="due_date" value="<?php echo $task['due_date']; ?>">
                </div>
                
                <div class="form-group">
                    <label>Priority</label>
                    <select name="priority" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="Low" <?php echo $task['priority'] == 'Low' ? 'selected' : ''; ?>>Low</option>
                        <option value="Medium" <?php echo $task['priority'] == 'Medium' ? 'selected' : ''; ?>>Medium</option>
                        <option value="High" <?php echo $task['priority'] == 'High' ? 'selected' : ''; ?>>High</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="Pending" <?php echo $task['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Completed" <?php echo $task['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Task</button>
                <a href="tasks.php" style="display: block; text-align: center; margin-top: 10px; color: #667eea;">Cancel</a>
            </form>
            
        </div>
        
    </div>
</div>

</body>
</html>