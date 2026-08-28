<?php
include 'config/db.php';
include 'functions/auth.php';


require_login();


$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'];


$total_tasks = $conn->query("SELECT COUNT(*) as count FROM tasks WHERE user_id = $user_id")->fetch_assoc()['count'];
$pending_tasks = $conn->query("SELECT COUNT(*) as count FROM tasks WHERE user_id = $user_id AND status = 'Pending'")->fetch_assoc()['count'];
$completed_tasks = $conn->query("SELECT COUNT(*) as count FROM tasks WHERE user_id = $user_id AND status = 'Completed'")->fetch_assoc()['count'];


$recent_tasks = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard-wrapper">
    

    <div class="sidebar">
        <h3>📝 To-Do List</h3>
        <a href="dashboard.php" class="active">🏠 Dashboard</a>
        <a href="tasks.php">✅ Tasks</a>
        <a href="categories.php">🏷️ Categories</a>
    </div>
    

    <div class="main-content">
        
    
        <div class="navbar">
            <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>! 👋</h2>
            <a href="logout.php">Logout</a>
        </div>
        
        
        <div class="stats-container">
            <div class="stat-card">
                <h4>Total Tasks</h4>
                <div class="number"><?php echo $total_tasks; ?></div>
            </div>
            <div class="stat-card">
                <h4>Pending</h4>
                <div class="number" style="color: #ed8936;"><?php echo $pending_tasks; ?></div>
            </div>
            <div class="stat-card">
                <h4>Completed</h4>
                <div class="number" style="color: #48bb78;"><?php echo $completed_tasks; ?></div>
            </div>
        </div>
        
    
        <div class="table-container">
            <h3>Recent Tasks</h3>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($recent_tasks->num_rows > 0): ?>
                        <?php while ($task = $recent_tasks->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
                                <td class="priority-<?php echo strtolower($task['priority']); ?>">
                                    <?php echo $task['priority']; ?>
                                </td>
                                <td>
                                    <span class="status-<?php echo strtolower($task['status']); ?>">
                                        <?php echo $task['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo $task['due_date'] ? date('d-M-Y', strtotime($task['due_date'])) : 'No date'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999;">No tasks yet. Add your first task!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

</body>
</html>