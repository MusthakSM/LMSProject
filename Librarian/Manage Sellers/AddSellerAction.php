<!-- Testing database functionality.. -->
<?php

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $contactNumber = $_POST["num"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        


        // Validate and sanitize the user input (you can add more validation as needed)
        //name
        $name = htmlspecialchars(trim($name));
        //contactNumber
        $contactNumber = (int)$contactNumber;
        //email
        $email = htmlspecialchars(trim($email));
        //address
        $address = htmlspecialchars(trim($address));
        

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

        // Prepare and execute the SQL INSERT statement
        $sql = "INSERT INTO seller (Seller_Name, Contact_Num, Contact_Mail, Address	)
        VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssss", $name, $contactNumber, $email, $address);
        if ($stmt->execute()) {
            echo "Seller has been added successfully.";
        } else {
            echo "Error adding seller " . $conn->error;
        }

        //Close the database connection
        $stmt->close();
        $conn->close();
    }

?>