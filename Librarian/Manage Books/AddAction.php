<!-- Testing database functionality.. -->
<?php

    // Get the form data submitted by the user
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST["title"];
        $edition = $_POST["edition"];
        $genre = $_POST["genre"];
        $language = $_POST["lang"];
        $year = $_POST['year'];
        $author = $_POST["author"];

        if (isset($_POST['dDate'])) {
            $donatedDate = $_POST['dDate'];
        } else {
            $donatedDate = "";
        }

        if (isset($_POST['dMember'])) {
            $donatedMember = $_POST['dMember'];
        } else {
            $donatedMember  ="";
        }

        if (isset($_POST['bDate'])) {
            $boughtDate = $_POST['bDate'];
        } else {
            $boughtDate = "";
        }

        if (isset($_POST['seller'])) {
            $seller = $_POST['seller'];
        } else {
            $seller = "";
        }
      
        $publisher = $_POST["publisher"];
        $bookFor = $_POST["permission"];        // availability of the book for borrow or refer..
        // setting borrowFlag and ReferFlag..
        if ($bookFor == "borrow")
        {
            $borrowFlag = 1;
            $referFlag = 0;
        }else{
            $borrowFlag = 0;
            $referFlag = 1;
        }

        // Validate and sanitize the user input (you can add more validation as needed)
        //title
        $title = htmlspecialchars(trim($title));
        //edition
        $edition = htmlspecialchars(trim($edition));
        //genre,. can be null
        if(!empty($genre)){
            $genre = htmlspecialchars(trim($genre));
        }else{
            $genre = NULL;
        }
        //language
        $language = htmlspecialchars(trim($language));
        //year,. can be null
        if(!empty($year)){
            $year = (int)$year;
        }else{
            $year = NULL;
        }
        //author
        $author = htmlspecialchars(trim($author));
        //donatedDate,. can be null
        if(!empty($donatedDate)){
            $donatedDate = htmlspecialchars(trim($donatedDate));
            $dFlag = 1;
        }else{
            $donatedDate = NULL;
            $dFlag = 0;
        }
        //donatedMember., can be null
        if(!empty($donatedMember)){
            $donatedMember = htmlspecialchars(trim($donatedMember));
        }else{
            $donatedMember = NULL;
        }
        //boughtDate,. can be null
        if(!empty($boughtDate)){
            $boughtDate = htmlspecialchars(trim($boughtDate));
            $bFlag = 1;
        }else{
            $boughtDate = NULL;
            $bFlag = 0;
        }
        //sellerId, can be null..
        if(!empty($seller)){
            $seller = htmlspecialchars(trim($seller));
        }else{
            $seller = NULL;
        }
        //publisher,. can be null
        if(!empty($publisher)){
            $publisher = htmlspecialchars(trim($publisher));
        }else{
            $publisher = NULL;
        }


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
        $sql = "INSERT INTO book (Title, Edition, Genre, Language, year, Author, DonateFlag, DonateDate, Donated_Member_Id, BoughtFlag, Bought_Date, Seller_Id, BorrowFlag, ReferFlag, Publisher_Id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssssisississiis", $title, $edition, $genre, $language, $year, $author, $dFlag, $donatedDate,$donatedMember, $bFlag, $boughtDate, $seller, $borrowFlag, $referFlag, $publisher);
        if ($stmt->execute()) {
            $book_title = $title;
            // Call the Python script with the book title as an argument
            exec("python generate_image.py \"$book_title\"");
            echo "Book added successfully.";
            
        } else {
            echo "Error adding Book: " . $conn->error;
        }

        //Close the database connection
        $stmt->close();
        $conn->close();
    }

?>