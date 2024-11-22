<?php
session_start();

function openCon() {
    $conn = new mysqli("localhost", "root", "", "dct-ccs-finals");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function closeCon($conn) {
    $conn->close();
}

function debugLog($message) {
    error_log("[DEBUG] " . $message);
}

function loginUser($username, $password) {
    $conn = openCon();

    // Query to fetch user data by email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password using password_verify() with the hash stored in the database
        if (password_verify($password, $user['password'])) {
            // Set session variables for logged-in user
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];

            $stmt->close();
            closeCon($conn);
            return true;
        } else {
            debugLog("Incorrect password for user: " . $username);
        }
    } else {
        debugLog("No user found with email: " . $username);
    }

    $stmt->close();
    closeCon($conn);
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['email']);
}

function addSubject($subjectCode, $subjectName) {
    $conn = openCon();

    // Prepare the SQL statement to insert the new subject
    $sql = "INSERT INTO subjects (subject_code, subject_name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared correctly
    if ($stmt === false) {
        debugLog("Error preparing SQL statement: " . $conn->error);
        return;
    }

    $stmt->bind_param("ss", $subjectCode, $subjectName);

    if ($stmt->execute()) {
        debugLog("Subject added successfully: $subjectCode - $subjectName");
    } else {
        debugLog("Error adding subject: " . $stmt->error);
    }

    $stmt->close();
    closeCon($conn);
}

function getSubjects() {
    $conn = openCon();
    
    // SQL query to get all subjects
    $sql = "SELECT * FROM subjects";
    $result = $conn->query($sql);
    
    // Fetch all subjects as an associative array
    $subjects = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }
    } else {
        debugLog("No subjects found in the database.");
    }

    closeCon($conn);
    return $subjects;
}

function getSubjectById($id) {
    $conn = openCon();
    $sql = "SELECT * FROM subjects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $subject = null;
    if ($result->num_rows > 0) {
        $subject = $result->fetch_assoc();
    }

    $stmt->close();
    closeCon($conn);
    return $subject;
}

function updateSubjectName($id, $subjectName) {
    $conn = openCon();
    $sql = "UPDATE subjects SET subject_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $subjectName, $id);
    
    if ($stmt->execute()) {
        debugLog("Subject with ID $id updated successfully to $subjectName.");
        $stmt->close();
        closeCon($conn);
        return true;
    } else {
        debugLog("Error updating subject with ID $id: " . $stmt->error);
    }

    $stmt->close();
    closeCon($conn);
    return false;
}
?>