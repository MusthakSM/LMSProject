<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Search Members</title>
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
                    if (substr($searchKey, 0, 1) === 'M' && is_numeric(substr($searchKey, 1, 1))) {
                        // Search by Publisher Id
                        $sq1 = "SELECT Member_Id, Fname, Lname, DOB, NIC, Current_Address, Contact_Num, Contact_Mail, userName, Status FROM MEMBER WHERE Member_Id = ?";
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
                                echo '<thead><tr><th class="text-center">MemberID</th><th class="text-center">F_Name</th><th class="text-center">L_Name</th><th class="text-center">DOB</th><th class="text-center">NIC</th>
                                <th class="text-center">Address</th><th class="text-center">ContactNum</th><th class="text-center">Email</th>
                                <th class="text-center">Username</th><th class="text-center">Status</th></tr></thead>';                                
                                echo '<tbody>';      

                                // Loop through the rows and output the data
                                while ($row = $results->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td class="text-center">' . $row['Member_Id'] . '</td>';
                                    echo '<td class="text-center">' . $row['Fname'] . '</td>';
                                    echo '<td class="text-center">' . $row['Lname'] . '</td>';
                                    echo '<td class="text-center">' . $row['DOB'] . '</td>';
                                    echo '<td class="text-center">' . $row['NIC'] . '</td>';
                                    echo '<td class="text-center">' . $row['Current_Address'] . '</td>';
                                    echo '<td class="text-center">' . $row['Contact_Num'] . '</td>';
                                    echo '<td class="text-center">' . $row['Contact_Mail'] . '</td>';
                                    echo '<td class="text-center">' . $row['userName'] . '</td>';
                                    echo '<td class="text-center">' . $row['Status'] . '</td>';
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
                        } else {
                            // If there's an error in the prepared statement
                            echo "Error in SQL query: " . $conn->error;
                        }

                    } else {
                        // Search by username
                        $sq1 = "SELECT Member_Id, Fname, Lname, DOB, NIC, Current_Address, Contact_Num, Contact_Mail, userName, Status FROM MEMBER WHERE userName = ?";
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
                                echo '<thead><tr><th class="text-center">MemberID</th><th class="text-center">F_Name</th><th class="text-center">L_Name</th><th class="text-center">DOB</th><th class="text-center">NIC</th>
                                <th class="text-center">Address</th><th class="text-center">ContactNum</th><th class="text-center">Email</th>
                                <th class="text-center">Username</th><th class="text-center">Status</th></tr></thead>';                                
                                echo '<tbody>';      

                                // Loop through the rows and output the data
                                while ($row = $results->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td class="text-center">' . $row['Member_Id'] . '</td>';
                                    echo '<td class="text-center">' . $row['Fname'] . '</td>';
                                    echo '<td class="text-center">' . $row['Lname'] . '</td>';
                                    echo '<td class="text-center">' . $row['DOB'] . '</td>';
                                    echo '<td class="text-center">' . $row['NIC'] . '</td>';
                                    echo '<td class="text-center">' . $row['Current_Address'] . '</td>';
                                    echo '<td class="text-center">' . $row['Contact_Num'] . '</td>';
                                    echo '<td class="text-center">' . $row['Contact_Mail'] . '</td>';
                                    echo '<td class="text-center">' . $row['userName'] . '</td>';
                                    echo '<td class="text-center">' . $row['Status'] . '</td>';
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