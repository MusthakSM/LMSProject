<!-- Testing database functionality.. -->
<?php

    // getting the admin details from the database as an array..
    session_start();
    $Details = $_SESSION['details'];

    $memberId = $Details[0]["Member_Id"];

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $userName = $_POST["userName"];
        $email = $_POST["email"];


        // Validate and sanitize the user input (you can add more validation as needed)
        //title
        $userName = htmlspecialchars(trim($userName));
        //book Id
        $email = htmlspecialchars(trim($email));
        

        // Connect to your MySQL database using MySQLi or PDO
        // Replace "your_username", "your_password", and "your_database_name" with your actual database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project_final";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("connection failed".$conn->connect_error);
        }

        // Prepare and execute the SQL SELECT statement to retrieve the admin name and the mail for the given admin Id
        $selectSql = "SELECT Member_ID, FName, LName, DOB, NIC, Current_Address, Contact_Num, Contact_Mail, userName FROM member WHERE Member_Id = ?";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bind_param("s", $memberId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();

        if(empty($userName))
        {
            $userName = $row["userName"];
        }

        if(empty($email))
        {
            $email = $row["Contact_Mail"];
        }

        // Prepare and execute the SQL UPDATE statement
        $sql = "UPDATE member SET userName = ?, Contact_Mail = ? WHERE Member_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $userName, $email, $memberId);

        if ($stmt->execute()) {
            echo "User Name and email updated successfully.";
        } else {
            echo "Error updating name and email: " . $conn->error;
        }

        // Close the database connection
        $stmt->close();
        $selectStmt->close();
        $conn->close();
    }

?>