<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Personal Info</title>
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

        <?php

            // Connect to your MySQL database using MySQLi or PDO
            // Replace "your_username", "your_password", and "your_database_name" with your actual database credentials
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "trybench";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("connection failed".$conn->connect_error);
            }

            // Prepare and execute the SQL SELECT statement to retrieve the admin name and the mail for the given admin Id
            $selectSql = "SELECT Member_ID, Fname, Lname, DOB, NIC, Current_Address, Contact_Num, Contact_Mail, userName FROM member WHERE Member_Id = ?";
            $selectStmt = $conn->prepare($selectSql);
            $selectStmt->bind_param("s", $Details[0]["Member_Id"]);
            $selectStmt->execute();
            $result = $selectStmt->get_result();
            $row = $result->fetch_assoc();

            $selectStmt->close();
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

            <div class="container" style="width:800px; margin-top:80px">
                <p class="display-5 text-center text-bg-danger"><b>My INFO</b></p>
        
                <div class="row bg-white" style="width:800px; height: 400px;">
                    <div class="col-sm-6" style="padding: 0;">
                        <img class="img-fluid" src="img_avatar1.png" alt="Card image" style="width:400px; height:400px;">
                    </div>
                    <div class="col-sm-6">
                        <div style="margin-inline-start: 30px; margin-top: 100px;">
                            <p class="h4">Member Id: <?php echo $Details[0]['Member_Id']; ?></p>
                            <p class="h4">Name: <?php echo $row['Fname']." ".$row['Lname']; ?></p>
                            <p class="h4">Date of Birth: <?php echo $row['DOB']; ?></p>
                            <p class="h4">NIC: <?php echo $row['NIC']; ?></p>
                            <p class="h4">Current Address: <?php echo $row['Current_Address']; ?></p>
                            <p class="h4">Contact Number: <?php echo $row['Contact_Num']; ?></p>
                            <p class="h4">Email: <?php echo $row['Contact_Mail']; ?></p>
                            <p class="h4">User Name: <?php echo $row['userName']; ?></p>
                            <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#myModal">Edit Profile</a>
                        </div>
                    </div>

                    <!-- The Modal -->
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit profile</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <!-- Form Element.. -->
                                    <form action="EditAction.php" method="POST" style="margin-right: auto; margin-left:auto" class="was-validated">
                                        
                                        <div class="mb-3 mt-3">
                                            <label for="userName" class="form-label">UserName:</label>
                                            <input type="text" class="form-control" id="userName" placeholder="Enter the new user name" name="userName">
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="email" class="form-label">Email:</label>
                                            <input type="text" class="form-control" id="email" placeholder="Enter the new e-mail" name="email">
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">CHANGE</button>
                                    </form>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <br>
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