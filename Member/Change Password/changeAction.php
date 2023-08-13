<!-- Testing database functionality.. -->
<?php


    // getting the admin details from the database as an array..
    session_start();
    $Details = $_SESSION['details'];

    $adminId = $Details[0]["Member_Id"];


    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $newPassword = $_POST["new_pswd"];

        // Validate and sanitize the user input (you can add more validation as needed)
        //new password
        $newPassword = htmlspecialchars(trim($newPassword));
        

        // Connect to your MySQL database using MySQLi or PDO
        // Replace "your_username", "your_password", and "your_database_name" with your actual database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "trybench";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("connection failed".$conn->connect_error);
        }

       // Prepare and execute the SQL UPDATE statement
        $sql = "UPDATE member SET Password = ? WHERE Member_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newPassword, $memberId);

        if ($stmt->execute()) {
            echo "Password has been updated successfully..";
        } else {
            echo "Error updating the password " . $conn->error;
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    }

?>