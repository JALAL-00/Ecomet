<?php
session_start();
include('../server/connection.php'); 


if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM help_requests";
                        
$help_requests_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Help Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .back-button {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

   
    <section class="container my-5">
        <a href="dashboard.php" class="btn btn-primary back-button">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        
        <h3>Help Requests</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($request = mysqli_fetch_assoc($help_requests_result)): ?>
                    <tr>
                        <td><?php echo $request['id']; ?></td>
                        <td><?php echo $request['name']; ?></td>
                        <td><?php echo $request['email']; ?></td>
                        <td><?php echo $request['message']; ?></td>
                        
                        <td><?php echo $request['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>