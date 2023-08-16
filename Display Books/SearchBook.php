<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Search Books</title>
        <meta charset="utf-8">
        <!-- Bootstrap 5 !-->
        <meta name="viewport" content="width = device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap 5 icons library !-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        <!-- php code for retrieve Book details from the database using the Book ID or name which comes from the POST method.. -->
        <?php

            // Get the form data submitted by the user
            // getting searchKey from POST method..
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $searchKey = $_POST["key"];        
        
                // Validate and sanitize the user input (you can add more validation as needed)
                //search key
                $searchKey = htmlspecialchars(trim($searchKey));
                
            
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

                // Check if the first letter of the searchKey is 'B' and the second letter is a number.. then a search by the id
                if (substr($searchKey, 0, 1) === 'B' && is_numeric(substr($searchKey, 1, 1))) {
                    // Search by Book Id
                    $sq1 = "SELECT Book_Id, Title, Edition, Genre, Language, year, Author, DonateFlag, DonateDate, Donated_Member_Id, BoughtFlag, Bought_Date, Seller_Id, BorrowFlag, Last_Borrow_Member_Id, Borrow_Availability, ReferFlag, Publisher_Id  FROM BOOK WHERE Book_Id = ?";
                    $stmt = $conn->prepare($sq1);
                    $stmt -> bind_param("s",$searchKey);
 
                    // Check if the preparation of the query was successful
                    if ($stmt) {
                        // Execute the query
                        $stmt->execute();

                        // Bind the result variables to fetch the data
                        $stmt->bind_result($Book_Id, $Title, $Edition, $Genre, $Language, $year, $Author, $DonateFlag, $DonateDate, $Donated_Member_Id, $BoughtFlag, $Bought_Date, $Seller_Id, $BorrowFlag, $Last_Borrow_Member_Id, $Borrow_Availability, $ReferFlag, $Publisher_Id);


                        // Fetch each row and store them in an array
                        $items = array();
                        while ($stmt->fetch()) {
                            $item = array(
                                'Book_Id' => $Book_Id,
                                'Title' => $Title,
                                'Edition' => $Edition,
                                'Genre' => $Genre,
                                'Language' => $Language,
                                'year' => $year,
                                'Author' => $Author,
                                'DonateFlag' => $DonateFlag,
                                'DonateDate' => $DonateDate,
                                'Donated_Member_Id' => $Donated_Member_Id,
                                'BoughtFlag' => $BoughtFlag,
                                'Bought_Date' => $Bought_Date,
                                'Seller_Id' => $Seller_Id,
                                'BorrowFlag' => $BorrowFlag,
                                'Last_Borrow_Member_Id' => $Last_Borrow_Member_Id,
                                'Borrow_Availability' => $Borrow_Availability,
                                'ReferFlag' => $ReferFlag,
                                'Publisher_Id' => $Publisher_Id
                            );
                            $items[] = $item;
                        }

                        // Close the statement
                        $stmt->close();
                    } else {
                        // If there's an error in the prepared statement
                        echo "Error in SQL query: " . $conn->error;
                    }

                } else {
                    // Search by Title
                    $sq1 = "SELECT Book_Id, Title, Edition, Genre, Language, year, Author, DonateFlag, DonateDate, Donated_Member_Id, BoughtFlag, Bought_Date, Seller_Id, BorrowFlag, Last_Borrow_Member_Id, Borrow_Availability, ReferFlag, Publisher_Id  FROM BOOK WHERE Title = ?";
                    $stmt = $conn->prepare($sq1);
                    $stmt -> bind_param("s",$searchKey);
 
                    // Check if the preparation of the query was successful
                    if ($stmt) {
                        // Execute the query
                        $stmt->execute();

                        // Bind the result variables to fetch the data
                        $stmt->bind_result($Book_Id, $Title, $Edition, $Genre, $Language, $year, $Author, $DonateFlag, $DonateDate, $Donated_Member_Id, $BoughtFlag, $Bought_Date, $Seller_Id, $BorrowFlag, $Last_Borrow_Member_Id, $Borrow_Availability, $ReferFlag, $Publisher_Id);


                        // Fetch each row and store them in an array
                        $items = array();
                        while ($stmt->fetch()) {
                            $item = array(
                                'Book_Id' => $Book_Id,
                                'Title' => $Title,
                                'Edition' => $Edition,
                                'Genre' => $Genre,
                                'Language' => $Language,
                                'year' => $year,
                                'Author' => $Author,
                                'DonateFlag' => $DonateFlag,
                                'DonateDate' => $DonateDate,
                                'Donated_Member_Id' => $Donated_Member_Id,
                                'BoughtFlag' => $BoughtFlag,
                                'Bought_Date' => $Bought_Date,
                                'Seller_Id' => $Seller_Id,
                                'BorrowFlag' => $BorrowFlag,
                                'Last_Borrow_Member_Id' => $Last_Borrow_Member_Id,
                                'Borrow_Availability' => $Borrow_Availability,
                                'ReferFlag' => $ReferFlag,
                                'Publisher_Id' => $Publisher_Id
                            );
                            $items[] = $item;
                        }

                        // Close the statement
                        $stmt->close();
                    } else {
                        // If there's an error in the prepared statement
                        echo "Error in SQL query: " . $conn->error;
                    }
                }

                // Close the database connection
                $conn->close();
            }
            
            //count of the total books
            $totalBooks = count($items);
            
        
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
            </div>
        </div>

        <div class="container-fluid d-flex flex-column min-vh-100" style="padding-right: 0; padding-left: 0;">
            
            <!-- Body content goes here.. -->
            <div class="container mt-5" style="margin-right: auto; margin-left: auto; max-width: 500px;">
                <div class="container mt-3 mb-3 text-center text-bg-danger">
                    <div class="h1">SEARCH RESULTS</div>
                </div>
            </div>

            <div class="container" style="margin-top: 30px;">
                <div class="row">
                <?php foreach ($items as $item) :
                    echo '<div class="col-md-3 mb-3">';
                    echo '    <div class="card bg-dark mx-auto" style="width: 300px;">';
                    echo '        <img class="card-img-top" src="http://localhost/LMS%20project/BookImages/' . str_replace('+', '%20', urlencode($item['Title'])) . '.png" alt="Card image" style="width:100%">';
                    echo '        <div class="card-body">';
                    echo '            <div class="card-body text-center text-white">';
                    echo '                <h5 class="card-title">' . $item['Title'] . '</h5>';
                    echo '                <p class="card-text">Book ID: ' . $item['Book_Id'] . '</p>';
                    echo '                <p class="card-text">Edition: ' . $item['Edition'] . '</p>';
                    echo '                <p class="card-text">Genre: ' . ($item['Genre'] ? $item['Genre'] : 'Unknown') . '</p>';
                    echo '                <p class="card-text">Language: ' . $item['Language'] . '</p>';
                    echo '                <p class="card-text">Year: ' . ($item['year'] ? $item['year'] : 'Unknown') . '</p>';
                    echo '                <p class="card-text">Author: ' . $item['Author'] . '</p>';
                    echo '                <p class="card-text">Publisher: ' . ($item['Publisher_Id'] ? $item['Publisher_Id'] : 'Unknown') . '</p>';

                    if ($item['BorrowFlag'] == 1)
                    {
                        // Borrowable book...
                        echo '            <p class="card-text text-danger">**Borrowable Book**</p>';
                    }else{
                        // Refer only Book...
                        echo '            <p class="card-text text-danger">**Refer only Book**</p>';
                    }

                    echo '            </div>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
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