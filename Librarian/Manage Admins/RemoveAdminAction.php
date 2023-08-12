<!-- Testing database functionality.. -->
<?php

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $adminId = $_POST["id"];


        // Validate and sanitize the user input (you can add more validation as needed)
        //title
        $name = htmlspecialchars(trim($name));
        //book Id
        $adminId = htmlspecialchars(trim($adminId));
        

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

        // Prepare and execute the SQL SELECT statement to retrieve the admin name for the given admin Id
        $selectSql = "SELECT Admin_Name FROM librarian WHERE Admin_Id = ?";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bind_param("s", $adminId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();

        // Check if the provided admin name matches the retrieved admin name
        if ($row && $row["Admin_Name"] === $name) {
            // The book titles match, proceed with the DELETE operation

            // Prepare and execute the SQL DELETE statement
            $deleteSql = "DELETE FROM librarian WHERE Admin_Id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("s", $adminId);

            if ($deleteStmt->execute()) {
                echo "Admin has been removed successfully.";
            } else {
                echo "Error removing the admin: " . $conn->error;
            }

            $deleteStmt->close();
        } else {
            // The book titles do not match
            echo "Error: The provided admin name does not match the existing admin name.";
        }

        // Close the database connection
        $selectStmt->close();
        $conn->close();
    }

?>