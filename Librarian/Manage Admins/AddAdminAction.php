<!-- Testing database functionality.. -->
<?php

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $startingDate = $_POST["sDate"];
        
        // Validate and sanitize the user input (you can add more validation as needed)
        //name
        $name = htmlspecialchars(trim($name));
        //email
        $email = htmlspecialchars(trim($email));
        //StartingDate
        $startingDate = htmlspecialchars(trim($startingDate));

        // breaking the name by parts to select the first name... Name format will be (Weerasinghe R.R.T.)
        $nameParts = explode(" ", $name);

        $defaultPassword = $nameParts[0]."1234";  // password would be Weerasinghe1234

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
        $sql = "INSERT INTO librarian (Admin_Name, Admin_Mail, Admin_Password, Starting_Date)
        VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssss", $name, $email, $defaultPassword, $startingDate);
        if ($stmt->execute()) {
            echo "Admin is added successfully.";
        } else {
            echo "Error adding admin: " . $conn->error;
        }

        //Close the database connection
        $stmt->close();
        $conn->close();
    }

?>