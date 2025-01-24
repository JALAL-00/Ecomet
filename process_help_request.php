<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('server/connection.php');

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO help_requests (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Thank you for reaching out! We will get back to you soon.";
    } else {
        echo "There was an error submitting your request. Please try again.";
    }
}
?>