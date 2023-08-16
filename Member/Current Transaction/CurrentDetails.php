<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Current Details</title>
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

        <div class="container-fluid d-flex flex-column min-vh-100" style="padding-right: 0; padding-left: 0;">
            
            <!-- Body content goes here.. -->
            <div class="container mt-5" style="margin-right: auto; margin-left: auto; max-width: 900px;">
                <div class="container mt-3 mb-3 text-center text-bg-danger">
                    <div class="h1">BOOKS THAT ARE CURRENTLY BORROWED</div>
                </div>
            </div>

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

            // Prepare and execute the SQL SELECT statement to retrieve the admin name and the mail for the given admin Id
            $selectSql = "SELECT Book.Book_ID, Book.Title, Past_Borrows.Borrow_Date, Past_Borrows.Return_Date_Default FROM Book, Past_Borrows WHERE Past_Borrows.Member_Id = ? AND Book.Book_ID = Past_Borrows.Book_ID AND Past_Borrows.Return_Date_Act IS NULL";
            $selectStmt = $conn->prepare($selectSql);
            $selectStmt->bind_param("s", $Details[0]["Member_Id"]);
            $selectStmt->execute();
            $result = $selectStmt->get_result();
            $row = $result->fetch_assoc();

            

            // Check if the preparation of the query was successful
            if ($selectStmt) {
                // Execute the query
                $selectStmt->execute();

                // Bind the result variables to fetch the data
                $selectStmt->bind_result($Book_Id, $Title, $BorrowDate, $ReturnDate);

                
                    
                echo '<div class="container mt-5">';
                // Fetch the data and print the resulting table
                echo '<table class="table table-dark table-striped" style="font-size: 18px;">';
                echo '<thead><tr><th class="text-center">BookID</th><th class="text-center">Book Title</th><th class="text-center">Borrowed Date</th><th class="text-center">Return Date Default</th></tr></thread>';
                echo '<tbody>'; 

                                   
                while ($selectStmt->fetch()) {
                        echo '<tr>';
                        echo '<td class="text-center">' . $Book_Id. '</td>';
                        echo '<td class="text-center">' . $Title . '</td>';
                        echo '<td class="text-center">' . $BorrowDate . '</td>';
                        echo '<td class="text-center">' . $ReturnDate . '</td>';
                        echo '</tr>';
                }
                
                echo '</tbody>';
                echo '</table>';

                echo '</div>';
            

                // Close the statement
                $selectStmt->close();
            } else {
                // If there's an error in the prepared statement
                echo "Error in SQL query: " . $conn->error;
            }

            // Close the database connection
            $conn->close();
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