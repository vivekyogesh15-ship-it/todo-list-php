# 📝 To-Do List Application

A simple and efficient task management web application built using PHP and MySQL. Users can register, log in, and manage their daily tasks with categories, priorities, and status tracking.

## 🎯 Project Overview

This project was developed as a Minor Project for **T.Y.B.C.A. Semester 5** (Subject: Web Framework and Services - 504) at Veer Narmad South Gujarat University, Surat.

**Submitted By:**
- Tambe Vivek (Roll: 2638077)
- Rohan Anil Shukla (Roll: 2638081)

**Guided By:** Prof. Vivek S Jagarwal

## ✨ Features

✅ **User Authentication** - Secure registration and login with password hashing
✅ **Task Management** - Create, Edit, Delete, and View tasks (CRUD operations)
✅ **Task Categorization** - Organize tasks into different categories
✅ **Priority Levels** - Assign High, Medium, or Low priority to tasks
✅ **Status Tracking** - Mark tasks as Pending or Completed
✅ **Search & Filter** - Search tasks by title and filter by status
✅ **Dashboard** - Real-time statistics (Total, Pending, Completed tasks)
✅ **Category Management** - Add and delete task categories
✅ **Session Management** - Logout functionality with session destroy

## 🛠️ Tech Stack

| Component | Technology |
|-----------|-----------|
| **Frontend** | HTML5, CSS3 (Custom Css) |
| **Backend** | PHP 8.2 |
| **Database** | MySQL |
| **Server** | Apache (XAMPP) |
| **Version Control** | Git & GitHub |

## 📂 Project Structure
todo_app/
├── index.php # Login & Register page
├── dashboard.php # Dashboard with statistics
├── tasks.php # View, search & filter tasks
├── add_task.php # Add new task form
├── edit_task.php # Edit existing task
├── delete_task.php # Delete task handler
├── categories.php # Manage categories
├── logout.php # Logout handler
├── config/
│ └── db.php # Database connection
├── functions/
│ └── auth.php # Authentication check
├── css/
│ └── style.css # Styling
└── README.md # Project documentation


## 🗄️ Database Schema

**Three main tables with relationships:**

**users** table:
- id (Primary Key)
- name, email (Unique), password (Hashed)
- created_at

**categories** table:
- id (Primary Key)
- user_id (Foreign Key → users.id)
- name, created_at

**tasks** table:
- id (Primary Key)
- user_id (Foreign Key → users.id)
- category_id (Foreign Key → categories.id)
- title, description, due_date
- priority (High/Medium/Low)
- status (Pending/Completed)
- created_at

**Relationships:** One-to-Many (1:N)
- One User has Many Categories
- One User has Many Tasks
- One Category has Many Tasks

## ⚙️ Installation & Setup

### Prerequisites
- XAMPP (Apache + MySQL + PHP)
- Git
- Web browser (Chrome)

### Step 1: Clone the Repository
```bash
cd C:\xampp\htdocs
git clone https://github.com/YOUR_USERNAME/todo-list-php.git
cd todo-list-php
```

### Step 2: Start XAMPP Services
1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL**

### Step 3: Create Database
1. Open `http://localhost/phpmyadmin`
2. Create a new database named `todo_app`
3. Import SQL schema:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    due_date DATE,
    priority ENUM('High', 'Medium', 'Low') DEFAULT 'Medium',
    status ENUM('Pending', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);
```

### Step 4: Update Database Credentials (if needed)
Edit `config/db.php` with your database credentials:
```php
$host = 'localhost';
$db_user = 'root';
$db_pass = ''; // XAMPP default
$db_name = 'todo_app';
```

### Step 5: Access the Application
Open your browser and navigate to:
http://localhost/todo_app/


## 🚀 How to Use

1. **Register** - Create a new account with email and password
2. **Login** - Log in with your credentials
3. **Add Task** - Click "Add New Task" button to create a task
4. **View Tasks** - See all your tasks in the list
5. **Edit Task** - Click "Edit" button to modify task details
6. **Delete Task** - Click "Delete" button to remove a task
7. **Search & Filter** - Search by title or filter by status (Pending/Completed)
8. **Categories** - Create categories to organize tasks
9. **Dashboard** - View statistics on the dashboard
10. **Logout** - Click "Logout" to end your session

## 📊 Features Explanation

### Authentication Module
- Secure user registration with email validation
- Login with password verification using `password_verify()`
- Session-based authentication for maintaining user state
- Logout functionality that destroys session data

### Task Management
- **Create** - Add new tasks with title, description, category, due date, and priority
- **Read** - View all tasks in a formatted table with details
- **Update** - Edit any field of an existing task
- **Delete** - Remove tasks with confirmation dialog

### Search & Filter
- **Search** - Type task title and click Filter to find matching tasks
- **Filter by Status** - Select Pending or Completed to view specific tasks
- **Combine** - Use search + filter together for precise results

### Dashboard
- **Statistics** - Shows Total, Pending, and Completed task counts
- **Recent Tasks** - Displays 5 most recent tasks
- **Quick Overview** - Understand your task progress at a glance

## 🔒 Security Features

✅ Password hashing using `password_hash()` with PASSWORD_DEFAULT algorithm
✅ SQL injection prevention using `real_escape_string()`
✅ Session-based authentication for user verification
✅ User-specific data isolation (each user sees only their tasks)

## 📈 Future Enhancements (Semester 6 Major Project)

- Email notifications for task reminders
- Task collaboration and sharing with other users
- Advanced analytics and progress reports
- Mobile app version using React Native
- Two-factor authentication for enhanced security
- Task attachment and file upload support
- Prepared statements for database queries
- Advanced API endpoints for integration

## 📝 Testing

All features have been tested and verified:

| Feature | Status |
|---------|--------|
| User Registration | ✓ PASS |
| User Login | ✓ PASS |
| Add Task | ✓ PASS |
| Edit Task | ✓ PASS |
| Delete Task | ✓ PASS |
| Search Task | ✓ PASS |
| Filter by Status | ✓ PASS |
| Category Management | ✓ PASS |
| Dashboard Statistics | ✓ PASS |
| Session Management | ✓ PASS |

## 📚 References

1. PHP Official Documentation — https://www.php.net/docs.php
2. MySQL Official Manual — https://dev.mysql.com/doc/
3. W3Schools Web Development — https://www.w3schools.com/
4. XAMPP Documentation — https://www.apachefriends.org/
5. Git & GitHub — https://docs.github.com/
6. MDN Web Docs — https://developer.mozilla.org/
7. Claude AI Assistant — Anthropic (Claude Haiku 4.5) for project planning, code development, documentation support.

## 📄 License

This project is created for academic purposes as part of T.Y.B.C.A. curriculum.

## 👥 Authors

- **Tambe Vivek** - Backend & Database Design
- **Rohan Anil Shukla** - Frontend & UI Design

---

**Project Submission Date:** September 2026
**College:** Udhna Citizen College, Surat
**University:** Veer Narmad South Gujarat University



