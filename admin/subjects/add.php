<?php 
include '../partials/header.php';
include '../partials/side-bar.php';
include '../../functions.php';  // Include the functions file

// Handle form submission for adding a new subject
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subjectCode = $_POST['subject_code'];
    $subjectName = $_POST['subject_name'];

    // Add subject to the database
    addSubject($subjectCode, $subjectName);
}

// Fetch all subjects
$subjects = getSubjects();
?>

<html>
<head>
    <title>Add a New Subject</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Styling for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
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
        .form-container, .table-container {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th, .table-container td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table-container th {
            background-color: #f8f9fa;
        }
        .table-container td {
            background-color: #fff;
        }
        .table-container .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
        }
        .table-container .btn-edit {
            background-color: #ff00b3; /* Magenta color */
        }
        .table-container .btn-delete {
            background-color: #dc3545; /* Red color for delete */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a New Subject</h1>
        <div class="breadcrumb">
            <a href="#">Dashboard</a> / Add Subject
        </div>
        <div class="form-container">
            <!-- Form to add a subject -->
            <form method="POST">
                <input type="text" name="subject_code" placeholder="Subject Code" required>
                <input type="text" name="subject_name" placeholder="Subject Name" required>
                <button type="submit">Add Subject</button>
            </form>
        </div>
        <div class="table-container">
            <h2>Subject List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through subjects and display them in the table
                    if ($subjects) {
                        foreach ($subjects as $subject) {
                            echo "<tr>
                                <td>{$subject['subject_code']}</td>
                                <td>{$subject['subject_name']}</td>
                                <td>
                                    <a href='edit.php?subject_id={$subject['id']}'>
                                        <button class='btn btn-edit'>Edit</button>
                                    </a>
                                    <a href='delete.php?subject_id={$subject['id']}'>
                                        <button class='btn btn-delete'>Delete</button>
                                    </a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No subjects available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>