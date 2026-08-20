<?php
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $studentId  = trim($_POST['student_id'] ?? '');
    $name       = trim($_POST['name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $department = trim($_POST['department'] ?? '');

    if ($studentId === '' || $name === '' || $email === '' || $department === '') {
        $errors[] = "Please fill in every field before continuing.";
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "The email address you entered is not valid.";
    }

    if (empty($errors)) {

        $_SESSION['student_id']  = $studentId;
        $_SESSION['name']        = $name;
        $_SESSION['email']       = $email;
        $_SESSION['department']  = $department;

        if (isset($_POST['remember_id'])) {
            setcookie('remembered_student_id', $studentId, time() + (30 * 24 * 60 * 60), "/");
        } else {
            if (isset($_COOKIE['remembered_student_id'])) {
                setcookie('remembered_student_id', '', time() - 3600, "/");
            }
        }

        header('Location: page2.php');
        exit;
    }
}

$rememberedId = $_COOKIE['remembered_student_id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>University Portal - Student Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="portal-header">
        <h1>University Registration Portal</h1>
        <p>Semester Registration - Step 1 of 3</p>
    </div>

    <div class="steps">
        <span class="active">1. Student Info</span>
        <span>2. Academic Info</span>
        <span>3. Confirm &amp; Submit</span>
    </div>

    <div class="form-wrapper">

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <strong>Please fix the following:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php">

            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" id="student_id" name="student_id"
                       value="<?php echo htmlspecialchars($_POST['student_id'] ?? $rememberedId); ?>"
                       placeholder="e.g. 2023-CSE-014" required>
            </div>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name"
                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                       placeholder="e.g. Ahana Rahman" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                       placeholder="e.g. ahana@university.edu" required>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <select id="department" name="department" required>
                    <option value="">-- Select Department --</option>
                    <?php
                    $departments = [
                        'Computer Science and Engineering',
                        'Electrical and Electronic Engineering',
                        'Business Administration',
                        'English',
                        'Civil Engineering',
                        'Economics'
                    ];
                    $selectedDept = $_POST['department'] ?? '';
                    foreach ($departments as $dept) {
                        $isSelected = ($selectedDept === $dept) ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($dept) . "\" $isSelected>" . htmlspecialchars($dept) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="checkbox-row">
                <input type="checkbox" id="remember_id" name="remember_id"
                       <?php echo $rememberedId ? 'checked' : ''; ?>>
                <label for="remember_id" style="margin: 0; font-weight: 400;">
                    Remember my Student ID on this browser
                </label>
            </div>

            <button type="submit" class="btn">Continue to Academic Info &rarr;</button>
        </form>

        <p class="footer-note">
            <?php if ($rememberedId): ?>
                A Student ID has been remembered from a previous visit.
            <?php else: ?>
                Your information is stored temporarily in a PHP session during registration.
            <?php endif; ?>
        </p>

    </div>
</div>

</body>
</html>