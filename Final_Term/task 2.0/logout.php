<?php
session_start();

$studentName = $_SESSION['name'] ?? 'Student';

session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>University Portal - Registration Complete</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="portal-header">
        <h1>University Registration Portal</h1>
        <p>Registration Complete</p>
    </div>

    <div class="form-wrapper">
        <div class="success-box">
            <div class="icon">&#10003;</div>
            <h2>Thank you, <?php echo htmlspecialchars($studentName); ?>!</h2>
            <p class="footer-note">
                Your registration has been submitted and your session data has
                been cleared for security. session_unset() and session_destroy()
                have been called, so none of your details remain on the server.
            </p>
            <br>
            <a href="index.php" class="btn">Start a New Registration</a>
        </div>
    </div>
</div>

</body>
</html>