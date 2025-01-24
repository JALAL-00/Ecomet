<?php
session_start();
include('server/connection.php');

// Handle Help Request Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('process_help_request.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Need Help?</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Main Content -->
    <section id="help" class="my-5">
        <div class="container">
            <h3 class="text-center">Need Help?</h3>
            <p class="text-center">Submit your help request, and we'll get back to you as soon as possible.</p>
            <hr class="mb-4">

            <!-- Contact Form -->
            <div class="contact-form my-5">
                <form action="help.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </form>
                <?php if (isset($success_msg)) echo "<p class='text-success'>$success_msg</p>"; ?>
                <?php if (isset($error_msg)) echo "<p class='text-danger'>$error_msg</p>"; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 YourStore | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>