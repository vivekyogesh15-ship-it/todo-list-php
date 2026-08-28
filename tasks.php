<?php
include 'config/db.php';
include 'functions/auth.php';

require_login();

$user_id = $_SESSION['user_id'];


$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';

$sql = "SELECT t.*, c.name as category_name 
        FROM tasks t 
        LEFT JOIN categories c ON t.category_id = c.id 
        WHERE t.user_id = $user_id";

if (!empty($search)) {
    $sql .= " AND t.title LIKE '%$search%'";
}

if (!empty($status_filter)) {
    $sql .= " AND t.status = '$status_filter'";
}

$sql .= " ORDER BY t.created_at DESC";

$tasks = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks - To-Do List</title>
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
            <h2>My Tasks</h2>
            <a href="logout.php">Logout</a>
        </div>
        
        <div class="table-container" style="margin-bottom: 20px;">
            <form method="GET" style="display: flex; gap: 15px; align-items: center;">
                <input type="text" name="search" placeholder="Search tasks..." 
                       value="<?php echo htmlspecialchars($search); ?>"
                       style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; flex: 1;">
                
                <select name="status" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="">All Status</option>
                    <option value="Pending" <?php echo $status_filter == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Completed" <?php echo $status_filter == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
                
                <button type="submit" class="btn-add" style="margin-bottom: 0;">🔍 Filter</button>
                <a href="tasks.php" style="color: #667eea; text-decoration: none;">Clear</a>
            </form>
        </div>
        
    
        <a href="add_task.php" class="btn-add" style="text-decoration: none; display: inline-block;">+ Add New Task</a>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tasks->num_rows > 0): ?>
                        <?php while ($task = $tasks->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
                                <td><?php echo $task['category_name'] ? htmlspecialchars($task['category_name']) : '—'; ?></td>
                                <td class="priority-<?php echo strtolower($task['priority']); ?>">
                                    <?php echo $task['priority']; ?>
                                </td>
                                <td>
                                    <span class="status-<?php echo strtolower($task['status']); ?>">
                                        <?php echo $task['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo $task['due_date'] ? date('d-M-Y', strtotime($task['due_date'])) : '—'; ?></td>
                                <td class="action-buttons">
                                    <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="delete_task.php?id=<?php echo $task['id']; ?>" 
                                       class="btn-delete" 
                                       onclick="return confirm('Delete this task?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #999;">No tasks found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

</body>
</html>