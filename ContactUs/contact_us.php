<!DOCTYPE html>
<html lang = "en">
<head>
        <title>Contact Us</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width = device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <style>
            body{
                background-color: lightyellow;
                flex-direction: column;
            }

            .bg-brown{
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


        </style>
    </head>

    <body style="display: flex; flex-direction: column; min-height: 100vh; margin: 0;">
        <div class="row px-4 pt-3 pb-3"> 
            <div class="col-sm-4">
                <p class="display-4" style="color:#510400"><b>LibraNET</b></p>
            </div>
            <div class="col-sm-8 pt-4 ">
                <ul class="nav nav-pills justify-content-end" id="my_nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php" style="background-color: #510400; color:lightyellow;">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/lms-project-main/LMS%20project/About%20us/aboutus.html" target="_blank">ABOUT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">BOOKS</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" >All</a></li>
                            <li><a class="dropdown-item" href="#">For Borrow</a></li>
                            <li><a class="dropdown-item" href="#">For Reference</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/lms-project-main/LMS%20project/ContactUs/contact_us.php">CONTACTS</a>
                    </li>
                    
                </ul>
            </div>
        </div>


        <?php
            //Creating arguments to connect to the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "project_final";

            //Connecting with the database
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            //Checking whether the connection is successful
            if (!$conn) {
                die("Connection failed: ".mysqli_connect_error());
            }
            //else connection successful

            //Selectong all the details from the table
            $retrieve = "SELECT Admin_Name, Admin_Mail FROM LIBRARIAN";
            $result_retrieve = mysqli_query($conn, $retrieve);

            ?>

            <!-- Spacer to push the footer to the bottom when content height is not enough -->
            
            <div class="container-fluid flex-grow-1">
                    <div class="row">
                        <?php while ($row = mysqli_fetch_assoc($result_retrieve)): ?>
                        <div class="col-xl-4 mb-3">
                            <div class="card rounded-4">
                                <div class="card-body rounded-4" style="background-color:rgb(128, 25, 25); border: 3px solid rgb(101, 67, 33);">
                                    <div style="text-align: center;">
                                        <h4 class="display-7" style="color:rgb(255, 218, 185);">
                                            <b><?php echo strtoupper($row['Admin_Name']); ?></b>
                                        </h4>
                                    </div>
                                    <div style="text-align: center;">
                                        <p class="card-text" style="color:rgb(255, 255, 255)"><?php echo $row['Admin_Mail']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
            </div>

            <!-- Footer Element of the page !-->
            <footer class="footer mt-5 pt-3 bg-dark text-center text-white">
                <div class="d-flex align-items-center justify-content-center">
                    <p>&copy; Copyright 2023 LibraNET. All rights reserved.</p>
                </div>
            </footer>

        
        
    </body>
</html>