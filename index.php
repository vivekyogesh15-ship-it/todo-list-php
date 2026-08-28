<?php
include 'config/db.php';

$msg = '';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['login'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                header("Location: dashboard.php");
                exit;
            } else {
                $msg = "❌ Wrong password!";
            }
        } else {
            $msg = "❌ Email not found!";
        }
    }
    
    elseif (isset($_POST['register'])) {
        $name = $conn->real_escape_string($_POST['reg_name']);
        $email = $conn->real_escape_string($_POST['reg_email']);
        $password = $_POST['reg_password'];
        
        $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
        
        if ($check->num_rows > 0) {
            $msg = "❌ Email already registered!";
        } 
        else 
        {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            
            if ($conn->query($sql)) {
                $msg = "✅ Registration successful! Now login.";
            } else {
                $msg = "❌ Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List - Login & Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>📝 To-Do List</h2>
        
        
        <?php if (!empty($msg)): ?>
            <div class="alert <?php echo (strpos($msg, '✅') !== false) ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <h3 style="margin-bottom: 20px; color: #2d3748;">Login</h3>
            <div class="form-group">
                <label>📧 Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>🔐 Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
        
        <div class="divider"><span>OR</span></div>
        
        <form method="POST">
            <h3 style="margin-bottom: 20px; color: #2d3748;">Register</h3>
            <div class="form-group">
                <label>👤 Full Name</label>
                <input type="text" name="reg_name" required>
            </div>
            <div class="form-group">
                <label>📧 Email</label>
                <input type="email" name="reg_email" required>
            </div>
            <div class="form-group">
                <label>🔐 Password</label>
                <input type="password" name="reg_password" required>
            </div>
            <button type="submit" name="register" class="btn btn-success">Register</button>
        </form>
    </div>
</div>

</body>
</html>