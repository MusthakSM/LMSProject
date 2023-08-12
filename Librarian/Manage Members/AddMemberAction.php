<!-- Testing database functionality.. -->
<?php

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $dob = $_POST["dob"];
        $nic = $_POST["nic"];
        $address = $_POST['address'];
        $contactNumber = $_POST["cnum"];
        $email = $_POST["mail"];


        // Validate and sanitize the user input (you can add more validation as needed)
        //first name
        $fname = htmlspecialchars(trim($fname));
        //last name
        $lname = htmlspecialchars(trim($lname));
        //date of birth
        $dob = htmlspecialchars(trim($dob));
        //NIC
        $nic = htmlspecialchars(trim($nic));
        //address
        $address = htmlspecialchars(trim($address));
        //Contact number
        $contactNumber = htmlspecialchars(trim($contactNumber));
        //email
        $email = htmlspecialchars(trim($email));


        //username
        $userName = $fname;
        //password
        $Temppassword = $nic;

        // Connect to your MySQL database using MySQLi or PDO
        // Replace "your_username", "your_password", and "your_database_name" with your actual database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "trybench";
    
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error)
        {
            die("connection failed".$conn->connect_error);
        }

        // Prepare the query to check if the NIC exists in the database
        $query = "SELECT COUNT(*) AS count FROM member WHERE NIC = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nic);

        // Execute the query and handle any potential SQL errors
        if (!$stmt->execute()) {
            die("Error executing the query: " . $stmt->error);
        }

        // Get the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Get the count of matching rows
        $count = $row['count'];

        if ($count > 0) {
            // NIC already exists in the database
            echo "Error in adding... NIC is already used.";
        } else {
            // NIC is unique
            // Prepare and execute the SQL INSERT statement
            $sql = "INSERT INTO member (Fname, Lname, DOB, NIC, Current_Address, Contact_Num, Contact_Mail, userName, Password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($sql);

            $insertStmt->bind_param("sssssssss", $fname, $lname, $dob, $nic, $address, $contactNumber, $email, $userName, $Temppassword );
            if ($insertStmt->execute()) {
                echo "Member has been added successfully.";
            } else {
                echo "Error in adding the member: " . $conn->error;
            }

            //Close the statement
            $insertStmt->close();
        }

        // Close the statement
        $stmt->close();
        // close the database connection.
        $conn->close();
    }

?>