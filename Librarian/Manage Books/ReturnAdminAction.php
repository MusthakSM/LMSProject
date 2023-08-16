<!-- Testing database functionality.. -->
<?php

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $memberId = $_POST['id'];
        $bookId = $_POST['bookId'];
        $ReturnDate = $_POST["date"];


        // Validate and sanitize the user input (you can add more validation as needed)
        //book Id
        $bookId = htmlspecialchars(trim($bookId));
        //Return Date
        $ReturnDate = htmlspecialchars(trim($ReturnDate));
        

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
        $selectSql = "UPDATE book SET Last_Borrow_Member_Id = NULL WHERE Book_Id = ?";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bind_param("s", $bookId);        

        // Prepare and execute the UPDATE statement in to the past borrowdetails to update the return date of the book..
        $sql = "UPDATE past_borrows SET Return_Date_Act = ? WHERE Book_Id = ? AND Member_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $ReturnDate, $bookId, $memberId);

        if ($stmt->execute() && $selectStmt->execute()) {

            echo "Return Successful";
            $sql2 = "SELECT Return_Date_Default FROM past_borrows WHERE Book_Id = ? AND Member_Id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("ss", $bookId, $memberId);

            if ($stmt2->execute()) {
                // Bind the result variables
                $stmt2->bind_result($returnDateDefault);
                // Fetch the result
                if ($stmt2->fetch()) {
                    $ReturnDateType = strtotime($ReturnDate);
                    $DefaultDate = strtotime($returnDateDefault);

                    $secondsDifference = $ReturnDateType - $DefaultDate;
                    $daysDifference = $secondsDifference / (60 * 60 * 24); // Convert seconds to days
                    $fine = max(0, $daysDifference) * 30; // Only impose fine for late returns

                    //echo "$ReturnDateType"; // Display the fine value
                    echo "<p>Fine: Rs. $fine</p>";
                }else {
                    echo "No matching record found.";
                }
            } else {
                echo "Error executing query: " . $stmt2->error;
            }

        } else {
            echo "Error " . $conn->error;
        }

        
       
            
      

        // Close the database connection
        $stmt->close();
        $selectStmt->close();
        $conn->close();
    }

?>