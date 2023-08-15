<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
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
        </nav>
        
        <div class="container-fluid d-flex flex-column min-vh-100" style="padding-right: 0; padding-left: 0;">
            <div class="container mt-5" style="margin-right: auto; margin-left: auto; max-width: 500px;">
                <div class="container mt-3 mb-3 text-center text-bg-danger">
                    <div class="h1">SIGN UP AS A MEMBER</div>
                </div>
                <!-- Form Element.. -->
                <form action="signupAction.php" method="POST" style="margin-right: auto; margin-left:auto" class="was-validated">

                    <div class="mb-3 mt-3">
                        <label for="fname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="fname" placeholder="Enter your first name" name="fname" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="lname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="lname" placeholder="Enter your last name" name="lname" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="dob" class="form-label">Date of Birth:</label>
                        <input type="date" class="form-control" id="dob" placeholder="Enter your date of birth" name="dob" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="nic" class="form-label">NIC:</label>
                        <input type="text" class="form-control" id="nic" placeholder="Enter your NIC number" name="nic" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="address" class="form-label">Current Address:</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter your current address" name="address"  required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="cNumber" class="form-label">Contact Number:</label>
                        <input type="digit" class="form-control" id="cNumber" placeholder="Enter your contact number" name="cNumber" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="cMail" class="form-label">Contact Mail:</label>
                        <input type="text" class="form-control" id="cMail" placeholder="Enter your email id" name="cMail" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="username" class="form-label">User Name:</label>
                        <input type="text" class="form-control" id="user" placeholder="Enter a user name you prefer" name="username" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="text" class="form-control" id="password" placeholder="Enter a password of 8 digits" name="password" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="cardNum" class="form-label">Debit Card Number:</label>
                        <input type="text" class="form-control" id="cardNum" placeholder="Enter the debit card number" name="cardNum" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">SIGN UP</button>
                </form>
            </div>

            
            
            <!-- Spacer to push the footer to the bottom when content height is not enough -->
            <div class="flex-grow-1"></div>

            <!-- Footer Element of the page !-->
            <footer class="footer mt-5 pt-3 bg-dark text-center text-white w-100">
                <div class=" d-flex align-items-center justify-content-center">
                    <p>&copy; Copyright 2023 LibraNET. All rights reserved.</p>
                </div>
            </footer>

        </div>
    </body>
</html>