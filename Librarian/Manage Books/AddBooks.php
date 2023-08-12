<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Books</title>
        <meta charset="utf-8">
        <!-- Bootstrap 5 !-->
        <meta name="viewport" content="width = device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap 5 icons library !-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script>
            function handleInputChange() {
            const donatedMemberInput = document.getElementById('dMember');
            const sellerInput = document.getElementById('seller');
            const donatedDateInput = document.getElementById('dDate');
            const boughtDateInput = document.getElementById('bDate');

            if (donatedDateInput.value) {
                boughtDateInput.disabled = true;
                sellerInput.disabled = true;
            } else {
                boughtDateInput.disabled = false;
                sellerInput.disabled = false;
            }

            if (boughtDateInput.value) {
                donatedDateInput.disabled = true;
                donatedMemberInput.disabled = true;
            } else {
                donatedDateInput.disabled = false;
                donatedMemberInput.disabled = false;
            }
            }
        </script>


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
        
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark" id="my_nav">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav nav-pills">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="AllBooks.php" role="button" data-bs-toggle="dropdown">All</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="AllBooks.php">All</a></li>
                                <li><a class="dropdown-item" href="#">Borrowable</a></li>
                                <li><a class="dropdown-item" href="#">Referable</a></li>
                                <li><a class="dropdown-item" href="#">Donated</a></li>
                                <li><a class="dropdown-item" href="#">Bought</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="#">Add</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="RemoveBooks.php">Remove</a>
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
            <div class="container mt-5" style="margin-right: auto; margin-left: auto; max-width: 500px;">
                <div class="container mt-3 mb-3 text-center text-bg-danger">
                    <div class="h1">ADD BOOK</div>
                </div>
                <!-- Form Element.. -->
                <form action="AddAction.php" method="POST" style="margin-right: auto; margin-left:auto" class="was-validated">

                    <div class="mb-3 mt-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" class="form-control" id="title" placeholder="Enter the title" name="title" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="edition" class="form-label">Edition:</label>
                        <input type="text" class="form-control" id="edition" placeholder="Enter the edition" name="edition" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="genre" class="form-label">Genre:</label>
                        <input type="text" class="form-control" id="genre" placeholder="Enter the genre" name="genre">
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="lang" class="form-label">Language:</label>
                        <input type="text" class="form-control" id="lang" placeholder="Enter the language" name="lang" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="year" class="form-label">Year:</label>
                        <input type="number" class="form-control" id="year" placeholder="Enter the year" name="year">
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="author" class="form-label">Author:</label>
                        <input type="text" class="form-control" id="author" placeholder="Enter the author" name="author" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="donated" class="form-label">Donated date:</label>
                        <input type="date" id="dDate" name="dDate" onchange="handleInputChange()" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="dMember" class="form-label">Donated member:</label>
                        <input type="text" class="form-control" id="dMember" placeholder="Enter the member id" name="dMember" onchange="handleInputChange()" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="bought" class="form-label">Bought date:</label>
                        <input type="date" id="bDate" name="bDate" onchange="handleInputChange()" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="seller" class="form-label">Seller:</label>
                        <input type="text" class="form-control" id="seller" placeholder="Enter the seller id" name="seller" onchange="handleInputChange()" required>
                    </div>


                    <div class="mb-3 mt-3">
                        <label for="publisher" class="form-label">Publisher:</label>
                        <input type="text" class="form-control" id="publisher" placeholder="Enter the publisher id" name="publisher">
                    </div>

                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="borrow" name="permission" value="borrow" checked>Borrowable
                        <label class="form-check-label" for="borrow"></label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="refer" name="permission" value="refer">Referable
                        <label class="form-check-label" for="refer"></label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Add</button>
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