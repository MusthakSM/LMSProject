<!-- Testing database functionality.. -->
<?php

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST["title"];
        $bookId = $_POST["id"];


        // Validate and sanitize the user input (you can add more validation as needed)
        //title
        $title = htmlspecialchars(trim($title));
        //book Id
        $bookId = htmlspecialchars(trim($bookId));
        

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

        // Prepare and execute the SQL SELECT statement to retrieve the book title for the given Book_Id
        $selectSql = "SELECT Title FROM book WHERE Book_Id = ?";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bind_param("s", $bookId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();

        // Check if the provided book title matches the retrieved book title
        if ($row && $row["Title"] === $title) {
            // The book titles match, proceed with the DELETE operation

            // Prepare and execute the SQL DELETE statement
            $deleteSql = "DELETE FROM book WHERE Book_Id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("s", $bookId);

            if ($deleteStmt->execute()) {
                echo "Deleted successfully.";
            } else {
                echo "Error Deleting the book: " . $conn->error;
            }

            $deleteStmt->close();
        } else {
            // The book titles do not match
            echo "Error: The provided book title does not match the existing book title.";
        }

        // Close the database connection
        $selectStmt->close();
        $conn->close();
    }

?>