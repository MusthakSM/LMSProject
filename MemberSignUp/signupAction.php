<!-- Testing database functionality.. -->
<?php


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project_final";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error)
    {
        die("connection failed".$conn->connect_error);
    }




    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $dob =  $_POST["dob"];
       
        

        if (isset($_POST["nic"])) {
            // Check if the NIC number already exists
            $nic = $_POST["nic"];

            $checkNicSql = "SELECT * FROM MEMBER WHERE NIC = ?";
            $stmtCheckNic = $conn->prepare($checkNicSql);
            $stmtCheckNic->bind_param("s", $nic);
            $stmtCheckNic->execute();
            $resultCheckNic = $stmtCheckNic->get_result();

            if ($resultCheckNic->num_rows > 0) {
                echo "NIC number already registered. Please use a different NIC number.";
                exit; // Stop further processing
            }


            $stmtCheckNic->close();
        }

        $address = $_POST["address"];
        $cNumber = $_POST["cNumber"];
        $cMail = $_POST["cMail"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Validate and sanitize the user input (you can add more validation as needed) - No inputs can be null here
        //First Name
        $fname = htmlspecialchars(trim($fname));
        //Last Name
        $lname = htmlspecialchars(trim($lname));
        //Date of Birth
        $dob = htmlspecialchars(trim($dob));
        //National Identity Card Number
        $nic = htmlspecialchars(trim($nic));
        //Current Address
        $address = htmlspecialchars(trim($address));
        //Contact Number
        $cNumber = htmlspecialchars(trim($cNumber));
        //Contact Mail
        $cMail = htmlspecialchars(trim($cMail));
        //User Name
        $username = htmlspecialchars(trim($username));
        //Password
        $password = htmlspecialchars(trim($password));



        // Connect to your MySQL database using MySQLi or PDO
        // Replace "your_username", "your_password", and "your_database_name" with your actual database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project_final";
    
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error)
        {
            die("connection failed".$conn->connect_error);
        }



        // Prepare and execute the SQL INSERT statement
        $sql = "INSERT INTO MEMBER (Fname, Lname, DOB, NIC, Current_Address, Contact_Num, Contact_Mail, username, password)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sssssisss", $fname, $lname, $dob, $nic, $address, $cNumber, $cMail, $username, $password);
        if ($stmt->execute()) {
            echo "Member Added Successfully.";
        } else {
            echo "Error adding member: " . $conn->error;
        }

        //Close the database connection
        $stmt->close();
        $conn->close();
    }

?>