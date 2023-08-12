<!-- Testing database functionality.. -->
<?php


    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $memberId = $_POST["id"];
        $mem_username = $_POST["name"];

        // Validate and sanitize the user input (you can add more validation as needed)
        //member id
        $memberId = htmlspecialchars(trim($memberId));
        //username
        $mem_username = htmlspecialchars(trim($mem_username));

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

        // Prepare and execute the SQL SELECT statement to retrieve the username for the given member Id
        $selectSql = "SELECT userName FROM member WHERE Member_Id = ?";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bind_param("s", $memberId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();

        // Check if the provided username matches the retrieved username
        if ($row && $row["userName"] === $mem_username) {
            // The username match, proceed with the update operation

            // Prepare and execute the SQL UPDATE statement
            $sql = "UPDATE member SET Status = 'inactive' WHERE Member_Id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $memberId);

            if ($stmt->execute()) {
                echo "Deactivated successfully...";
            } else {
                echo "Error in deactivation.. " . $conn->error;
            }

            $stmt->close();
        } else {
            // The book titles do not match
            echo "Error: The provided username does not match.";
        }

        // Close the database connection
        $selectStmt->close();
        $conn->close();
    }

?>