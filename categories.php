<?php
include 'config/db.php';
include 'functions/auth.php';

require_login();

$user_id = $_SESSION['user_id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $name = $conn->real_escape_string($_POST['category_name']);
    
    $sql = "INSERT INTO categories (user_id, name) VALUES ($user_id, '$name')";
    if ($conn->query($sql)) {
        $msg = "✅ Category added!";
    } else {
        $msg = "❌ Error: " . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $cat_id = (int)$_GET['delete'];
    $conn->query("DELETE FROM categories WHERE id = $cat_id AND user_id = $user_id");
    header("Location: categories.php");
    exit;
}

$categories = $conn->query("SELECT * FROM categories WHERE user_id = $user_id ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories - To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard-wrapper">
    
    <div class="sidebar">
        <h3>📝 To-Do List</h3>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="tasks.php">✅ Tasks</a>
        <a href="categories.php" class="active">🏷️ Categories</a>
    </div>
    
    <div class="main-content">
        
        <div class="navbar">
            <h2>Categories</h2>
            <a href="logout.php">Logout</a>
        </div>
        
        <?php if (!empty($msg)): ?>
            <div class="alert alert-success"><?php echo $msg; ?></div>
        <?php endif; ?>
        
        <div class="table-container" style="margin-bottom: 20px; max-width: 500px;">
            <h3>Add New Category</h3>
            <form method="POST" style="display: flex; gap: 10px; margin-top: 15px;">
                <input type="text" name="category_name" placeholder="Category name" required
                       style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                <button type="submit" name="add_category" class="btn-add" style="margin-bottom: 0;">Add</button>
            </form>
        </div>
        
        <div class="table-container" style="max-width: 500px;">
            <h3>My Categories</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($categories->num_rows > 0): ?>
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cat['name']); ?></td>
                                <td>
                                    <a href="categories.php?delete=<?php echo $cat['id']; ?>" 
                                       class="btn-delete" 
                                       onclick="return confirm('Delete this category?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" style="text-align: center; color: #999;">No categories yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

</body>
</html>