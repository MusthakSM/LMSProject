<!-- Testing database functionality.. -->
<?php

    // getting the admin details from the database as an array..
    session_start();
    $Details = $_SESSION['details'];

    $adminId = $Details[0]["Admin_Id"];

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];


        // Validate and sanitize the user input (you can add more validation as needed)
        //title
        $name = htmlspecialchars(trim($name));
        //book Id
        $email = htmlspecialchars(trim($email));
        

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

        // Prepare and execute the SQL SELECT statement to retrieve the admin name and the mail for the given admin Id
        $selectSql = "SELECT Admin_Name, Admin_Mail FROM librarian WHERE Admin_Id = ?";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bind_param("s", $adminId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();

        if(empty($name))
        {
            $name = $row["Admin_Name"];
        }

        if(empty($email))
        {
            $email = $row["Admin_Mail"];
        }

        // Prepare and execute the SQL UPDATE statement
        $sql = "UPDATE librarian SET Admin_Name = ?, Admin_Mail = ? WHERE Admin_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $adminId);

        if ($stmt->execute()) {
            echo "Name and email updated successfully.";
        } else {
            echo "Error updating name and email: " . $conn->error;
        }

        // Close the database connection
        $stmt->close();
        $selectStmt->close();
        $conn->close();
    }

?>