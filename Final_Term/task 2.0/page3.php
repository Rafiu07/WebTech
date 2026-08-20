<?php
session_start();

if (!isset($_SESSION['student_id']) || !isset($_SESSION['semester'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>University Portal - Confirm Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="portal-header">
        <h1>University Registration Portal</h1>
        <p>Semester Registration - Step 3 of 3</p>
    </div>

    <div class="steps">
        <span>1. Student Info</span>
        <span>2. Academic Info</span>
        <span class="active">3. Confirm &amp; Submit</span>
    </div>

    <div class="form-wrapper">

        <div class="info-card">
            <h3>Student Information <span class="badge">from session</span></h3>
            <div class="info-row"><span>Student ID</span><span><?php echo htmlspecialchars($_SESSION['student_id']); ?></span></div>
            <div class="info-row"><span>Name</span><span><?php echo htmlspecialchars($_SESSION['name']); ?></span></div>
            <div class="info-row"><span>Email</span><span><?php echo htmlspecialchars($_SESSION['email']); ?></span></div>
            <div class="info-row"><span>Department</span><span><?php echo htmlspecialchars($_SESSION['department']); ?></span></div>
        </div>

        <div class="info-card">
            <h3>Academic Information <span class="badge">from session</span></h3>
            <div class="info-row"><span>Semester</span><span><?php echo htmlspecialchars($_SESSION['semester']); ?></span></div>
            <div class="info-row">
                <span>Courses</span>
                <span><?php echo htmlspecialchars(implode(', ', $_SESSION['courses'])); ?></span>
            </div>
            <div class="info-row"><span>Credit Hours</span><span><?php echo htmlspecialchars($_SESSION['credits']); ?></span></div>
        </div>

        <div class="info-card">
            <h3>Browser Cookie <span class="badge cookie">from cookie</span></h3>
            <?php if (isset($_COOKIE['remembered_student_id'])): ?>
                <div class="info-row">
                    <span>Remembered Student ID</span>
                    <span><?php echo htmlspecialchars($_COOKIE['remembered_student_id']); ?></span>
                </div>
                <p class="footer-note" style="margin-top:8px;">
                    This value is stored in a cookie on your browser and will remain
                    available for 30 days, even after this session ends.
                </p>
            <?php else: ?>
                <p class="footer-note">No Student ID cookie was saved for this browser.</p>
            <?php endif; ?>
        </div>

        <form method="POST" action="logout.php">
            <div class="btn-row">
                <a href="page2.php" class="btn btn-secondary">&larr; Back</a>
                <button type="submit" class="btn">Complete Registration</button>
            </div>
        </form>

    </div>
</div>

</body>
</html>