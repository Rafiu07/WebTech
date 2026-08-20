<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header('Location: index.php');
    exit;
}

$errors = [];

$availableCourses = [
    'CSE101' => 'Introduction to Programming',
    'CSE203' => 'Data Structures',
    'CSE305' => 'Database Systems',
    'CSE410' => 'Software Engineering',
    'MAT201' => 'Discrete Mathematics',
    'ENG102' => 'Technical Writing'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $semester = trim($_POST['semester'] ?? '');
    $courses  = $_POST['courses'] ?? [];
    $credits  = trim($_POST['credits'] ?? '');

    if ($semester === '' || empty($courses) || $credits === '') {
        $errors[] = "Please select a semester, at least one course, and enter your credit hours.";
    } elseif (!is_numeric($credits) || $credits <= 0) {
        $errors[] = "Credit hours must be a positive number.";
    }

    if (empty($errors)) {
        $_SESSION['semester'] = $semester;
        $_SESSION['courses']  = $courses;
        $_SESSION['credits']  = $credits;

        header('Location: page3.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>University Portal - Academic Information</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="portal-header">
        <h1>University Registration Portal</h1>
        <p>Semester Registration - Step 2 of 3</p>
    </div>

    <div class="steps">
        <span>1. Student Info</span>
        <span class="active">2. Academic Info</span>
        <span>3. Confirm &amp; Submit</span>
    </div>

    <div class="form-wrapper">

        <div class="info-card">
            <h3>Student Information <span class="badge">from session</span></h3>
            <div class="info-row"><span>Student ID</span><span><?php echo htmlspecialchars($_SESSION['student_id']); ?></span></div>
            <div class="info-row"><span>Name</span><span><?php echo htmlspecialchars($_SESSION['name']); ?></span></div>
            <div class="info-row"><span>Email</span><span><?php echo htmlspecialchars($_SESSION['email']); ?></span></div>
            <div class="info-row"><span>Department</span><span><?php echo htmlspecialchars($_SESSION['department']); ?></span></div>
        </div>

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

        <form method="POST" action="page2.php">

            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester" required>
                    <option value="">-- Select Semester --</option>
                    <?php
                    $semesters = ['Fall 2026', 'Spring 2027', 'Summer 2027'];
                    $selectedSem = $_POST['semester'] ?? '';
                    foreach ($semesters as $sem) {
                        $isSelected = ($selectedSem === $sem) ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($sem) . "\" $isSelected>" . htmlspecialchars($sem) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Course Selection</label>
                <div class="course-list">
                    <?php
                    $selectedCourses = $_POST['courses'] ?? [];
                    foreach ($availableCourses as $code => $title) {
                        $checked = in_array($code, $selectedCourses) ? 'checked' : '';
                        echo '<label>';
                        echo "<input type=\"checkbox\" name=\"courses[]\" value=\"" . htmlspecialchars($code) . "\" $checked>";
                        echo htmlspecialchars($code . ' - ' . $title);
                        echo '</label>';
                    }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="credits">Total Credit Hours</label>
                <input type="number" id="credits" name="credits" min="1" max="24" step="1"
                       value="<?php echo htmlspecialchars($_POST['credits'] ?? ''); ?>"
                       placeholder="e.g. 15" required>
            </div>

            <div class="btn-row">
                <a href="index.php" class="btn btn-secondary">&larr; Back</a>
                <button type="submit" class="btn">Continue to Confirmation &rarr;</button>
            </div>
        </form>

    </div>
</div>

</body>
</html>