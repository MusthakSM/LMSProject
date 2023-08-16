<!-- Testing database functionality.. -->
<?php

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $memberId = $_POST["id"];
        $bookId = $_POST['bookId'];
        $BorrowDate = $_POST["date"];


        // Validate and sanitize the user input (you can add more validation as needed)
        //memberid
        $memberId = htmlspecialchars(trim($memberId));
        //book Id
        $bookId = htmlspecialchars(trim($bookId));
        //Borrow Date
        $BorrowDate = htmlspecialchars(trim($BorrowDate));
        

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

        // Prepare and execute the SQL UPDATE statement to update the lastBorrowMemberId in the book table
        $selectSql = "UPDATE book SET Last_Borrow_Member_Id = ? WHERE Book_Id = ?";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bind_param("ss", $memberId, $bookId);        

        // Prepare and execute the INSERT statement in to the past borrowdetails..
        $sql = "INSERT INTO past_borrows (Book_Id, Member_Id, Borrow_Date) 
                VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $bookId, $memberId, $BorrowDate);

        if ($stmt->execute() && $selectStmt->execute()) {
            echo "Borrow Successfull.";
        } else {
            echo "Error " . $conn->error;
        }

        // Close the database connection
        $stmt->close();
        $selectStmt->close();
        $conn->close();
    }

?>