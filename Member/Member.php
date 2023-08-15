<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Member</title>
        <meta charset="utf-8">
        <!-- Bootstrap 5 !-->
        <meta name="viewport" content="width = device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap 5 icons library !-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        
    
        <?php
            if (isset($_GET['data']))
            {
                $Details = $_GET['data'];
            }

            session_start();
            $_SESSION['details'] = $Details;

            if (isset($_POST['Logout'])) {

                // Redirect the user to the login page
                header("Location: http://localhost/lms-project-main/LMS%20project/Log-in/login.php");
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
                color: #510400;
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
            <div class="row mx-5 mt-5">
                <div class="col-sm-1"></div>
                <div class="col-sm-4 pt-4 pb-4 px-2 bg-brown text-lightyellow text-center rounded-4">
                    <p class="display-6">AVAILABILITY OF BOOKS</p>
                    <a href="Manage%20Books/AllBooks.php" class="btn btn-lg btn-success" target="_blank">CHECK</a>
                </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-4 pt-4 pb-4 px-2 bg-brown text-lightyellow text-center rounded-4">
                    <p class="display-6">PERSONAL INFO</p>
                    <a href="Personal%20Info/PersonalInfo.php" class="btn btn-lg btn-success" target="_blank">MANAGE</a>
                </div>
            </div><br>
            
            <div class="row mx-5 mt-5">
                <div class="col-sm-1"></div>
                <div class="col-sm-4 pt-4 pb-4 px-2 bg-brown text-lightyellow text-center rounded-4">
                    <p class="display-6">BOOK TRANSACTION - PRESENT</p>
                    <a href="Current%20Transaction/CurrentDetails.php" class="btn btn-lg btn-success" target="_blank">CHECK</a>
                </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-4 pt-4 pb-4 px-2 bg-brown text-lightyellow text-center rounded-4">
                    <p class="display-6">PAST BORROW DETAILS</p>
                    <a href="Past%20Borrow/PastBorrow.php" class="btn btn-lg btn-success" target="_blank">SHOW</a>
                </div>
            </div><br>

            <div class="row mx-5 mt-5">
                <div class="col-sm-1"></div>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                <div class="col-sm-4 pt-4 pb-4 px-2 bg-brown text-lightyellow text-center rounded-4">
                    <p class="display-6">CHANGE PASSWORD</p>
                    <a href="Change%20Password/changePassword.php" class="btn btn-lg btn-success" target="_blank">CHANGE</a>
                </div>
                <div class="col-sm-1"></div>
            </div><br>

            <!-- Spacer to push the footer to the bottom when content height is not enough -->
            <div class="flex-grow-1"></div>

            <!-- Footer Element of the page !-->
            <footer class="container-fluid mt-5 pt-3 bg-dark text-center text-white w-100">
                <div class=" d-flex align-items-center justify-content-center">
                    <p>&copy; Copyright 2023 LibraNET. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>