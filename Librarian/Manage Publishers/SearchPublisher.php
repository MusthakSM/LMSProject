<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Search Publisher</title>
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


            <!-- php code for retrieve admins details from the database. -->
            <?php

                if($_SERVER["REQUEST_METHOD"] === "POST")
                {
                    //defining userinput variable..
                    $searchKey = $_POST["key"];

                    // Validate and sanitize the user input (you can add more validation as needed)
                    //searchKey
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

                    // Check if the first letter of the searchKey is 'P' and the second letter is a number.. then a search by the id
                    if (substr($searchKey, 0, 1) === 'P' && is_numeric(substr($searchKey, 1, 1))) {
                        // Search by Publisher Id
                        $sq1 = "SELECT Publisher_Id, Publisher_Name, Contact_Num, Contact_Mail, Address	FROM PUBLISHER WHERE Publisher_Id = ?";
                        $selectStmt = $conn->prepare($sq1);
                        $selectStmt->bind_param("s", $searchKey);

                        // Check if the preparation of the query was successful
                        if ($selectStmt) {
                            // Execute the query
                            $selectStmt->execute();
                            // Get the result set
                            $results = $selectStmt->get_result();

                            // Check if any rows were fetched from the database
                            if ($results->num_rows === 0) {
                                echo '<div class="container mt-5">';
                                echo '<p class="h2 text-center">No results found.</p>';
                                echo '</div>';
                            } else {
                                echo '<div class="container mt-5">';
                                // Fetch the data and print the resulting table
                                echo '<table class="table table-dark table-striped" style="font-size: 18px;">';
                                echo '<thead><tr><th class="text-center">Publisher ID</th><th class="text-center">Name</th><th class="text-center">Contact Number</th><th class="text-center">E-mail</th><th class="text-center">Address</th></tr></thead>';
                                echo '<tbody>';      

                                // Loop through the rows and output the data
                                while ($row = $results->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td class="text-center">' . $row['Publisher_Id'] . '</td>';
                                    echo '<td class="text-center">' . $row['Publisher_Name'] . '</td>';
                                    echo '<td class="text-center">' . $row['Contact_Num'] . '</td>';
                                    echo '<td class="text-center">' . $row['Contact_Mail'] . '</td>';
                                    echo '<td class="text-center">' . $row['Address'] . '</td>';
                                    echo '</tr>';
                                }

                                // Free up the result set
                                $results->free_result();

                                echo '</tbody>';
                                echo '</table>';

                                echo '</div>';
                            }
                            // Close the statement
                            $selectStmt->close();

                            echo '<div class="container mt-5" style="margin-right: auto; margin-left: auto; max-width: 500px;">';
                            echo '    <div class="container mt-3 mb-3 text-center text-bg-danger">';
                            echo '        <div class="h1">BOOKS PUBLISHED BY ' . $searchKey . '</div>';
                            echo '    </div>';
                            echo '</div>';

                            $sq1forBook = "SELECT Book_Id, Title, Edition, Genre, Language, year, Author FROM BOOK WHERE Publisher_Id = ?";
                            $stmtforBook = $conn->prepare($sq1forBook);
                            $stmtforBook->bind_param("s", $searchKey);

                            // Check if the preparation of the query was successful
                            if ($stmtforBook) {
                                // Execute the query
                                $stmtforBook->execute();

                                // Bind the result variables to fetch the data
                                $stmtforBook->bind_result($Book_Id, $Title, $Edition, $Genre, $Language, $Year, $Author);

                                // Fetch each row and store them in an array
                                $items = array();
                                while ($stmtforBook->fetch()) {
                                    $item = array(
                                        'Book_Id' => $Book_Id,
                                        'Title' => $Title,
                                        'Edition' => $Edition,
                                        'Genre' => $Genre,
                                        'Language' => $Language,
                                        'Year' => $Year,
                                        'Author' => $Author,
                                    );
                                    $items[] = $item;
                                }

                                // Close the statement
                                $stmtforBook->close();
                            } else {
                                // If there's an error in the prepared statement
                                echo "Error in SQL query: " . $conn->error;
                            }


                            echo '<div class="container" style="margin-top: 30px;">';
                            echo '    <div class="row">';
                                        foreach ($items as $item) :
                            echo '            <div class="col-md-3 mb-3">';
                            echo '                <div class="card bg-dark mx-auto" style="width: 300px;">';
                            echo '                    <img class="card-img-top" src="http://localhost/LMS%20project/BookImages/' . str_replace("+", "%20", urlencode($item["Title"])) . '.png" alt="Card image" style="width:100%" >';
                            echo '                    <div class="card-body">';
                            echo '                        <div class="card-body text-center text-white">';
                            echo '                            <h5 class="card-title">'.$item["Title"]. '</h5>';
                            echo '                            <p class="card-text">Book ID: '. $item["Book_Id"] .'</p>';
                            echo '                            <p class="card-text">Edition: '.$item["Edition"].'</p>';
                            echo '                            <p class="card-text">Genre: '. $item["Genre"].'</p>';
                            echo '                            <p class="card-text">Language: '.$item["Language"].'</p>';
                            echo '                            <p class="card-text">Year: '.$item["Year"].'</p>';
                            echo '                            <p class="card-text">Author: '.$item["Author"].'</p>';
                            echo '                        </div>';
                            echo '                    </div>';
                            echo '                </div>';
                            echo '            </div>';
                                        endforeach; 
                            echo '    </div>';
                            echo '</div>';


                        } else {
                            // If there's an error in the prepared statement
                            echo "Error in SQL query: " . $conn->error;
                        }

                    } else {
                        // Search by name
                        $sq1 = "SELECT Publisher_Id, Publisher_Name, Contact_Num, Contact_Mail, Address	FROM PUBLISHER WHERE Publisher_Name = ?";
                        $selectStmt = $conn->prepare($sq1);
                        $selectStmt->bind_param("s", $searchKey);

                        // Check if the preparation of the query was successful
                        if ($selectStmt) {
                            // Execute the query
                            $selectStmt->execute();
                            // Get the result set
                            $results = $selectStmt->get_result();

                            // Check if any rows were fetched from the database
                            if ($results->num_rows === 0) {
                                echo '<div class="container mt-5">';
                                echo '<p class="h2 text-center">No results found.</p>';
                                echo '</div>';
                            } else {
                                echo '<div class="container mt-5">';
                                // Fetch the data and print the resulting table
                                echo '<table class="table table-dark table-striped" style="font-size: 18px;">';
                                echo '<thead><tr><th class="text-center">Publisher ID</th><th class="text-center">Name</th><th class="text-center">Contact Number</th><th class="text-center">E-mail</th><th class="text-center">Address</th></tr></thead>';
                                echo '<tbody>';      

                                // Loop through the rows and output the data
                                while ($row = $results->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td class="text-center">' . $row['Publisher_Id'] . '</td>';
                                    echo '<td class="text-center">' . $row['Publisher_Name'] . '</td>';
                                    echo '<td class="text-center">' . $row['Contact_Num'] . '</td>';
                                    echo '<td class="text-center">' . $row['Contact_Mail'] . '</td>';
                                    echo '<td class="text-center">' . $row['Address'] . '</td>';
                                    echo '</tr>';
                                }

                                // Free up the result set
                                $results->free_result();

                                echo '</tbody>';
                                echo '</table>';

                                echo '</div>';
                            }

                            // Close the statement
                            $selectStmt->close();

                            echo '<div class="container mt-5" style="margin-right: auto; margin-left: auto; max-width: 500px;">';
                            echo '    <div class="container mt-3 mb-3 text-center text-bg-danger">';
                            echo '        <div class="h1">BOOKS PUBLISHED BY ' . $searchKey . '</div>';
                            echo '    </div>';
                            echo '</div>';

                            $sq1forBook = "SELECT Book_Id, Title, Edition, Genre, Language, year, Author FROM BOOK
                                        INNER JOIN PUBLISHER ON BOOK.Publisher_Id = PUBLISHER.Publisher_Id
                                        WHERE PUBLISHER.Publisher_Name = ?";
                            $stmtforBook = $conn->prepare($sq1forBook);
                            $stmtforBook->bind_param("s", $searchKey);

                            // Check if the preparation of the query was successful
                            if ($stmtforBook) {
                                // Execute the query
                                $stmtforBook->execute();

                                // Bind the result variables to fetch the data
                                $stmtforBook->bind_result($Book_Id, $Title, $Edition, $Genre, $Language, $Year, $Author);

                                // Fetch each row and store them in an array
                                $items = array();
                                while ($stmtforBook->fetch()) {
                                    $item = array(
                                        'Book_Id' => $Book_Id,
                                        'Title' => $Title,
                                        'Edition' => $Edition,
                                        'Genre' => $Genre,
                                        'Language' => $Language,
                                        'Year' => $Year,
                                        'Author' => $Author,
                                    );
                                    $items[] = $item;
                                }

                                // Close the statement
                                $stmtforBook->close();
                            } else {
                                // If there's an error in the prepared statement
                                echo "Error in SQL query: " . $conn->error;
                            }


                            echo '<div class="container" style="margin-top: 30px;">';
                            echo '    <div class="row">';
                                        foreach ($items as $item) :
                            echo '            <div class="col-md-3 mb-3">';
                            echo '                <div class="card bg-dark mx-auto" style="width: 300px;">';
                            echo '                    <img class="card-img-top" src="http://localhost/LMS%20project/BookImages/' . str_replace("+", "%20", urlencode($item["Title"])) . '.png" alt="Card image" style="width:100%" >';
                            echo '                    <div class="card-body">';
                            echo '                        <div class="card-body text-center text-white">';
                            echo '                            <h5 class="card-title">'.$item["Title"]. '</h5>';
                            echo '                            <p class="card-text">Book ID: '. $item["Book_Id"] .'</p>';
                            echo '                            <p class="card-text">Edition: '.$item["Edition"].'</p>';
                            echo '                            <p class="card-text">Genre: '. $item["Genre"].'</p>';
                            echo '                            <p class="card-text">Language: '.$item["Language"].'</p>';
                            echo '                            <p class="card-text">Year: '.$item["Year"].'</p>';
                            echo '                            <p class="card-text">Author: '.$item["Author"].'</p>';
                            echo '                        </div>';
                            echo '                    </div>';
                            echo '                </div>';
                            echo '            </div>';
                                        endforeach; 
                            echo '    </div>';
                            echo '</div>';

                        } else {
                            // If there's an error in the prepared statement
                            echo "Error in SQL query: " . $conn->error;
                        }
                    }
                    
                    // Close the database connection
                    $conn->close();
                }
            
            ?>

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