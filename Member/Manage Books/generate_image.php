<?php
    // Connect to your MySQL database using MySQLi or PDO
    // Replace "your_username", "your_password", and "your_database_name" with your actual database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project_final" ;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error)
    {
        die("connection failed".$conn->connect_error);
    }

    $sq1 = "SELECT Title FROM BOOK";
    $stmt = $conn->prepare($sq1);

    // Check if the preparation of the query was successful
    if ($stmt) {
        // Execute the query
        $stmt->execute();

        // Bind the result variables to fetch the data
        $stmt->bind_result($Title);

        // Fetch each row and store them in an array
        $items = array();
        while ($stmt->fetch()) {
            $item = array(
                'Title' => $Title,
            );
            $items[] = $item;
        }

        // Close the statement
        $stmt->close();
    } else {
        // If there's an error in the prepared statement
        echo "Error in SQL query: " . $conn->error;
    }

    // Close the database connection
    $conn->close();

    foreach($items as $item)
    {
    
        $book_title = $item["Title"]; // You can dynamically set this based on your needs

        // Call the Python script with the book title as an argument
        exec("python generate_image.py \"$book_title\"");
    }


    // if (isset($_GET['title'])) {
    //     $book_title = ""; // You can dynamically set this based on your needs
    //     // Call the Python script with the book title as an argument
    //     exec("python generate_image.py \"$book_title\"");
    // }

?>
