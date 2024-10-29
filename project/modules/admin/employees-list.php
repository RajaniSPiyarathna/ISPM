<?php
   session_start();
   if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
       header("Location: ../auth/login.php");
       exit;
   }
   
   // Include the database configuration file
   include '../../config/config.php';
   
   // Fetch all employee details from the database
   $query = "SELECT id, name, email,tel, date_of_birth, address FROM users WHERE role = 'employee'";
   $result = $conn->query($query);
   
   // Check if there are any employees
   if ($result->num_rows > 0) {
       $employees = $result->fetch_all(MYSQLI_ASSOC); 
   } else {
       $employees = [];
   }

   // Delete employees if delete_id is set
   if (isset($_GET['delete_id'])) {
      $delete_id = intval($_GET['delete_id']);
      $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
      $delete_stmt->bind_param("i", $delete_id);
      if ($delete_stmt->execute()) {
         header("Location: employees-list.php");
         exit();
      }
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Dashboard - LECO Security Awareness</title>
      <!-- Bootstrap 5 CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
         /* Custom styling for dashboard layout */
        body {
            min-height: 100vh;
        }
        .navbar-top {
            height: 60px;
            background-color: #343a40;
            color: #e9ecef;
            position: fixed;
            top: 0;
            width: 100%;
        }
        .navbar-top .navbar-brand {
            color: #e9ecef;
            font-weight: bold;
        }
        .navbar-top .nav-link {
            color: #e9ecef;
        }
        .sidebar {
            width: 250px;
            position: fixed;
            top: 60px;
            bottom: 0;
            background-color: #343a40;
            padding-top: 10px;
            color: #FFF;
        }
        .sidebar a {
            font-size: 1rem;
            padding: 15px 20px;
            display: block;
            color: #FFF;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #e9ecef;
            color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 40px;
            min-height: calc(100vh - 60px);
            background-color: #f8f9fa;
        }
         .profile-card {
         background-color: white;
         padding: 20px;
         margin-bottom: 20px;
         box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
         }
      </style>
   </head>
   <body>
      <!-- Top Navigation Bar -->
      <nav class="navbar navbar-expand-lg navbar-top">
         <div class="container-fluid">
            <a class="navbar-brand" href="#">LECO Admin Dashboard</a>
            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav ms-auto">
                  <h6>Hello, <?php echo $_SESSION['name']; ?></h6>
               </ul>
            </div>
         </div>
      </nav>
<!-- Sidebar Navigation -->
    <div class="sidebar">
        <a href="admin-dashboard.php" class="active">Dashboard</a> 
        <a href="manage-quizzes.php">Manage Quizzes</a>
        <a href="policies.php">Policy Management</a>
        <a href="notifications.php">Notifications</a>
        <a href="add-employee.php">Add Employee</a>
        <a href="employees-list.php">Employees</a>
        <a href="view-reports.php">View Reports</a>
        <a href="logs/view-logs.php">Security Logs</a>
        <a class="nav-link" href="../auth/logout.php">Logout</a>
    </div>
    
      <!-- Main Content Area -->
      <div class="main-content">
         <h2 class="mb-4">Employees List</h2>
         <!-- Check if there are any employees -->
         <?php if (!empty($employees)): ?>
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact No</th>
                  <th>Birthday</th>
                  <th>Address</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($employees as $employee): ?>
               <tr>
                  <td><?php echo $employee['id']; ?></td>
                  <td><?php echo $employee['name']; ?></td>
                  <td><?php echo $employee['email']; ?></td>
                  <td><?php echo $employee['tel']; ?></td>
                  <td><?php echo $employee['date_of_birth']; ?></td>
                  <td><?php echo $employee['address']; ?></td>
                  <td>
                     <a href="edit-employee.php?id=<?php echo $employee['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                     <a href="employees-list.php?delete_id=<?php echo $employee['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                  </td>
               </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
         <?php else: ?>
         <p class="text-muted">No employees found.</p>
         <?php endif; ?>
      </div>
      </div>
      <!-- Bootstrap 5 JS and Popper.js -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
   </body>
</html>