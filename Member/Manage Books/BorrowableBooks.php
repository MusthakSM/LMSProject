<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Borrowable Books</title>
        <meta charset="utf-8">
        <!-- Bootstrap 5 !-->
        <meta name="viewport" content="width = device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap 5 icons library !-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        <?php
            session_start();
            $Details = $_SESSION['details'];

            // Redirecting to the log-in page if logout button is pressed....
            if (isset($_POST['Logout'])) {

                // Redirect the user to the login page
                header("Location: http://localhost/LMS%20project/Log-in and sign-up/login.php");
                exit;
            }
        ?>

        <!-- php code for retrieve admins details from the database. -->
        <?php
            
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

            $sq1 = "SELECT Book.Book_Id, Book.Title, Book.Edition, Book.Genre, Book.Language, Book.year, Book.Author, Publisher.Publisher_Name, Book.BorrowFlag, Book.Last_Borrow_Member_Id, Book.Borrow_Availability, Book.ReferFlag FROM BOOK, PUBLISHER where Book.Publisher_Id = Publisher.Publisher_ID";
            $stmt = $conn->prepare($sq1);

            // Check if the preparation of the query was successful
            if ($stmt) {
                // Execute the query
                $stmt->execute();

                // Bind the result variables to fetch the data
                $stmt->bind_result($Book_Id, $Title, $Edition, $Genre, $Language, $Year, $Author, $Publisher, $borrowFlag, $LastBorrowID, $BorrowAvailability, $ReferFlag);

                // Fetch each row and store them in an array
                $items = array();
                while ($stmt->fetch()) {
                    $item = array(
                        'Book.Book_Id' => $Book_Id,
                        'Book.Title' => $Title,
                        'Book.Edition' => $Edition,
                        'Book.Genre' => $Genre,
                        'Book.Language' => $Language,
                        'Book.Year' => $Year,
                        'Book.Author' => $Author,
                        'Publisher.Publisher_Name' => $Publisher,
                        'Book.BorrowFlag' => $borrowFlag,
                        'Book.Last_Borrow_Member_Id' => $LastBorrowID,
                        'Book.Borrow_Availability' => $BorrowAvailability,
                        'Book.ReferFlag' => $ReferFlag
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


            
            //count of the total books
            $totalBooks = count($items);
            //borrowable books count
            $borrowableCount = 0;
            foreach($items as $item){
                if ($item['Book.BorrowFlag'] == 1) {
                    $borrowableCount++;
                }
            }

            //borrowable percentage
            $borrowableWidthPercentage = ($borrowableCount/$totalBooks)*100;
        
        ?>

        <?php

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


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookId = $_POST['book_id'];
                $currentDate = date("Y-m-d");
                $memberId = $Details[0]['Member_Id'];

                // Update BOOK table to mark the book as borrowed using a prepared statement
                $updateBookSql = "UPDATE BOOK SET Borrow_Availability = 0, Last_Borrow_Member_Id = ? WHERE Book_Id = ?";
                $stmt = $conn->prepare($updateBookSql);
                $stmt->bind_param("ss", $memberId, $bookId);

                if ($stmt->execute()) {
                    // Update PAST_BORROWS table with borrowed information using a prepared statement
                    $insertPastBorrowsSql = "INSERT INTO PAST_BORROWS (Member_Id, Book_Id, Borrow_Date) VALUES (?, ?, ?)";
                    $stmt2 = $conn->prepare($insertPastBorrowsSql);
                    $stmt2->bind_param("sss", $memberId, $bookId, $currentDate);

                    if ($stmt2->execute()) {
                        echo "Book borrowed successfully!";
                    } else {
                        echo "Error inserting record into PAST_BORROWS table: " . $stmt2->error;
                    }

                    $stmt2->close();
                } else {
                    echo "Error updating record in BOOK table: " . $stmt->error;
                }

                $stmt->close();

            }

            // Close the database connection
            $conn->close();
        

        ?>

        <style>
            body{
                background-color: lightyellow;
            }

            .bg-brown, .text-brown{
                background-color: #510400;
            }
            
            .text-lightyellow{
                color: lightyellow;
            }

            .custom-para{
                color: white;
            }

            .nav-item{
                padding-left: 25px;
            }

            hr{
                color: #510400;
            }
            
            #my_nav .nav-link{
                color: white;
            }

            /* Style for the active link */
            .nav-pills .nav-link.active {
                background-color: #dc3545; /* Active link background color */
            }

        </style>

    </head>

    <body>
        <div class="container-fluid">
            <div class="row px-4 pt-3 pb-3 bg-brown"> 
                <div class="col-sm-9">
                    <p class="display-4" style="color:white"><b>LibraNET</b></p>
                </div>
                <div class="col-sm-3 d-flex justify-content-end">
                    <span style="font-size:60px; color: white;"><?php echo $Details[0]['Member_Id']; ?>_</span>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#demo"><i class="bi bi-person-circle" style="font-size:60px; color:white" ></i></a> 
                </div>
                <div id="demo" class="collapse text-end">
                    <form method="post">
                        <button type="submit" name="Logout" class="btn btn-danger">Logout</button>
                    </form>
                </div>  
            </div>
        </div>

        <nav class="navbar navbar-expand-sm bg-dark navbar-dark" id="my_nav">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav nav-pills">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Borrowable</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="AllBooks.php">All</a></li>
                                <li><a class="dropdown-item" href="#">Borrowable</a></li>
                                <li><a class="dropdown-item" href="ReferableBooks.php">Referable</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form action="SearchBook.php" method="POST" class="d-flex" style="margin-left: 20px;" target="_blank">
                        <input class="form-control me-2" type="text" placeholder="Book Id (or) Name" name="key">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>                
            </div>
        </nav>

        <div class="container-fluid d-flex flex-column min-vh-100" style="padding-right: 0; padding-left: 0;">
            
            <!-- Body content goes here.. -->
            <div class="container mt-5" style="margin-right: auto; margin-left: auto; max-width: 500px;">
                <div class="container mt-3 mb-3 text-center text-bg-danger">
                    <div class="h1">BORROWABLE BOOKS</div>
                </div>
            </div>

            <!-- progress Bar -->
            <div class="container">
                <div class="progress" style="height: 50px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: <?php echo $borrowableWidthPercentage; ?>%; font-size: 20px">
                         Borrowable(<?php echo $borrowableCount; ?>)
                    </div>
                    <div class="progress-bar " style="width: <?php echo 100 - $borrowableWidthPercentage; ?>%; font-size: 20px">
                        Referable(<?php echo $totalBooks-$borrowableCount; ?>)
                    </div>
                </div>
            </div>

            <div class="container mt-8" style="margin-right: auto; margin-left: auto; max-width: 1000px;">
                <div class="container mt-3 mb-3 text-center text-bg-accent">
                    <div class="h8">You can reserve books, but please note that the maximum number of books you can borrow is 3 and the number of days will be counted from the day you reserve the book, not the day you get the book.</div>
                </div>
            </div>

            <div class="container" style="margin-top: 30px;">
                <div class="row">
                <?php foreach ($items as $item) :
                    if ($item['Book.BorrowFlag'] == 1) :
                        // Check if the member has already borrowed three books
                        $borrowedBooksCount = 0;  // Initialize the count
                        foreach ($items as $borrowedBook) {
                            if ($borrowedBook['Book.Borrow_Availability'] == 0 &&
                                $borrowedBook['Book.Last_Borrow_Member_Id'] == $Details[0]['Member_Id']) {
                                $borrowedBooksCount++;
                            }
                        }

                        $_SESSION['borrowedBooksCount'] = $borrowedBooksCount;
                ?>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-dark mx-auto" style="width: 270px;">
                                <img class="card-img-top" src=<?php echo "http://localhost/LMS%20project/BookImages/" . str_replace('+', '%20', urlencode($item['Book.Title']))  . ".png";?> alt="Card image" style="width:100%" >
                                <div class="card-body">
                                    <div class="card-body text-center text-white">
                                        <h5 class="card-title"><?php echo $item['Book.Title']; ?></h5>
                                        <p class="card-text">Book ID: <?php echo $item['Book.Book_Id']; ?></p>
                                        <p class="card-text">Edition: <?php echo $item['Book.Edition']; ?></p>
                                        <p class="card-text">Genre: <?php echo $item['Book.Genre']; ?></p>
                                        <p class="card-text">Language: <?php echo $item['Book.Language']; ?></p>
                                        <p class="card-text">Year: <?php echo $item['Book.Year']; ?></p>
                                        <p class="card-text">Author: <?php echo $item['Book.Author']; ?></p>
                                        <p class="card-text">Publisher: <?php echo $item['Publisher.Publisher_Name'];?> </p>
                                        <?php 
                                                if ($item['Book.Borrow_Availability'] == 1 AND $item['Book.Last_Borrow_Member_Id'] == NULL){
                                                    echo '            <p class="card-text text-danger">Book is Available</p>';?>
                                                    <?php if ($borrowedBooksCount <= 3) : ?>
                                                        <!-- Show the "Borrow" button if the member can still borrow -->
                                                        <form method="post">
                                                            <input type="hidden" name="book_id" value="<?php echo $item['Book.Book_Id']; ?>">
                                                            <input type="submit" class="btn btn-success" name="borrow" value="BORROW">
                                                        </form>
                                                    <?php else : ?>
                                                        <p class="card-text text-danger">You have reached the maximum borrowing limit of 3 books.</p>
                                                    <?php endif; ?>

                                        <?php }elseif ($item['Book.Borrow_Availability'] == '0' AND $item['Book.Last_Borrow_Member_Id'] == NULL AND $item['Book.ReferFlag'] == '0' ) {
                                                    echo '            <p class="card-text text-danger">Book is Not Available</p>';
                                                }else{
                                                    echo '            <p class="card-text text-danger">The book has been borrowed.</p>';
                                                }?>
                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;
                    endforeach; ?>
                </div>
            </div>
            
            <!-- Spacer to push the footer to the bottom when content height is not enough -->
            <div class="flex-grow-1"></div>

            <!-- Footer Element of the page !-->
            <footer class="footer mt-5 pt-3 bg-dark text-center text-white">
                <div class=" d-flex align-items-center justify-content-center">
                    <p>&copy; Copyright 2023 LibraNET. All rights reserved.</p>
                </div>
            </footer>

        
        </div>
    </body>
</html>