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


        <?php
            session_start();
            $Details = $_SESSION['details'];

            // Redirecting to the log-in page if logout button is pressed....
            if (isset($_POST['Logout'])) {

                // Redirect the user to the login page
                header("Location: http://localhost/LMS%20project/Log-in%20and%20sign-up/login.php");
                exit;
            }
        ?>

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
                <div class="col-sm-3 d-flex justify-content-end">
                    <span style="font-size:60px; color: white;"><?php echo $Details[0]['Admin_Id']; ?>_</span>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#demo"><i class="bi bi-person-circle" style="font-size:60px; color:white" ></i></a> 
                </div>
                <div id="demo" class="collapse text-end">
                    <form method="post">
                        <button type="submit" name="Logout" class="btn btn-danger">Logout</button>
                    </form>
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

                    if ($item['DonateFlag'] == 1){
                        // It's a donated book
                        echo '            <p class="card-text text-danger">**Donated Book**</p>';
                        echo '            <p class="card-text">Donated Date: ' . $item['DonateDate'] . '</p>';
                        echo '            <p class="card-text">Donated Member Id: ' . $item['Donated_Member_Id'] . '</p>';
                    }else{
                        // It's Bought book
                        echo '            <p class="card-text text-danger">**Bought Book**</p>';
                        echo '            <p class="card-text">Bought Date: ' . $item['Bought_Date'] . '</p>';
                        echo '            <p class="card-text">Seller Id: ' . $item['Seller_Id'] . '</p>';
                    }

                    if ($item['BorrowFlag'] == 1)
                    {
                        // Borrowable book...
                        echo '            <p class="card-text text-danger">**Borrowable Book**</p>';
                        if ($item['Borrow_Availability'] == 1){
                            echo '            <p class="card-text text-danger">Book is Available</p>';
                            echo '            <a href="#" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#BorrowModal">Give Borrow</a>';

                        }else{
                            echo '            <p class="card-text text-danger">Book is Not Available</p>';
                            echo '            <p class="card-text text-danger">Borrowed by: '.$item['Last_Borrow_Member_Id'].'</p>';
                            echo '            <a href="#" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#ReturnModal">Accept Return</a>';
                        }
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


            <!-- The Modal 2-->
            <div class="modal" id="ReturnModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Borrow</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <!-- Form Element.. -->
                            <form action="ReturnAdminAction.php" method="POST" style="margin-right: auto; margin-left:auto" class="was-validated">
                                
                                <input type="hidden" name="bookId" value= <?php echo $item['Book_Id'];?> >

                                <div class="mb-3 mt-3">
                                    <label for="id" class="form-label">MemberId:</label>
                                    <input type="text" class="form-control" id="id" placeholder="Enter the member id" name="id">
                                </div>

                                <div class="mb-3 mt-3">
                                    <label for="date" class="form-label">Return Date:</label>
                                    <input type="date" class="form-control" id="date" placeholder="Enter the new e-mail" name="date">
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Accept Return</button>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- The Modal 1-->
            <div class="modal" id="BorrowModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Borrow</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <!-- Form Element.. -->
                            <form action="BorrowAdminAction.php" method="POST" style="margin-right: auto; margin-left:auto" class="was-validated">
                                
                                <input type="hidden" name="bookId" value= <?php echo $item['Book_Id'];?> >

                                <div class="mb-3 mt-3">
                                    <label for="id" class="form-label">MemberId:</label>
                                    <input type="text" class="form-control" id="id" placeholder="Enter the member id" name="id">
                                </div>

                                <div class="mb-3 mt-3">
                                    <label for="date" class="form-label">Borrow Date:</label>
                                    <input type="date" class="form-control" id="date" placeholder="Enter the new e-mail" name="date">
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Done</button>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>

                    </div>
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