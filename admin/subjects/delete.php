<?php 
include '../../functions.php';  // Ensure the correct path to functions.php is included

// Get the subject ID from the URL
if (isset($_GET['subject_id'])) {
    $subjectId = $_GET['subject_id'];

    // Fetch subject details based on the subject_id for confirmation display
    $subject = getSubjectById($subjectId);
}

// Handle deletion if the "Delete Subject Record" button is clicked
if (isset($_POST['delete_subject'])) {
    $subjectId = $_POST['subject_id'];
    deleteSubject($subjectId);
    // Redirect back to the add.php page after deletion
    header("Location: add.php");
    exit();
}

?>

<?php include '../partials/header.php'; ?>
<?php include '../partials/side-bar.php'; ?>

<html>
<head>
    <title>Delete Subject</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 0px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .breadcrumb {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .breadcrumb span {
            color: #6c757d;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .inner-container {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }
        .confirmation {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .confirmation ul {
            list-style-type: none;
            padding: 0;
        }
        .confirmation ul li {
            margin-bottom: 10px;
        }
        .confirmation ul li::before {
            content: "\2022";
            color: #000;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }
        .buttons button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .buttons .cancel {
            background-color: #6c757d;
            color: #fff;
        }
        .buttons .delete {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="#">Dashboard</a> / <a href="#">Add Subject</a> / <span>Delete Subject</span>
        </div>
        <h1>Delete Subject</h1>
        <div class="inner-container">
            <?php if (isset($subject)): ?>
                <div class="confirmation">
                    <p>Are you sure you want to delete the following subject record?</p>
                    <ul>
                        <li>Subject Code: <?php echo $subject['subject_code']; ?></li>
                        <li>Subject Name: <?php echo $subject['subject_name']; ?></li>
                    </ul>
                </div>
                <form method="POST">
                    <!-- Hidden input to pass the subject_id for deletion -->
                    <input type="hidden" name="subject_id" value="<?php echo $subject['id']; ?>">
                    <div class="buttons">
                        <!-- Cancel button: Redirect back to add.php -->
                        <a href="add.php">
                            <button type="button" class="cancel">Cancel</button>
                        </a>
                        <!-- Delete button: Trigger the subject deletion -->
                        <button type="submit" name="delete_subject" class="delete">Delete Subject Record</button>
                    </div>
                </form>
            <?php else: ?>
                <p>Subject not found!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<!-- UNFINISHED PROJECT-->