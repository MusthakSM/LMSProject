<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Change Password</title>
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

        <!-- php to retrieve the current password from the database to verify the current password provided in the form. -->
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
            $selectSql = "SELECT Admin_Password FROM librarian WHERE Admin_Id = ?";
            $selectStmt = $conn->prepare($selectSql);
            $selectStmt->bind_param("s", $Details[0]["Admin_Id"]);
            $selectStmt->execute();
            $result = $selectStmt->get_result();
            $row = $result->fetch_assoc();

            $selectStmt->close();
            $conn->close();

            // Assign the Admin password to a JavaScript variable
            echo '<script>var adminPassword = "' . $row["Admin_Password"] . '";</script>';
        ?>

        <!-- javascript to check the passwords.. -->
        <script>
            function validateForm() {
                var currentPassword = document.getElementById("crnt_pswd").value;
                var newPassword = document.getElementById("new_pswd").value;
                var confirmPassword = document.getElementById("cnfrm_pswd").value;

                //check whether the current password is correct or not..
                if (currentPassword !== adminPassword) {
                    alert("Incorrect current password!");
                    return false; // Prevent form submission
                }

                // check whether the new password and confirmation passwords are matching..
                if (newPassword !== confirmPassword) {
                    alert("New password and confirm password do not match!");
                    return false; // Prevent form submission
                }
            }
        </script>

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
                    <div class="h1">CHANGE PASSWORD</div>
                </div>

                <!-- Form Element.. -->
                <form action="changeAction.php" onsubmit="return validateForm()" method="POST" style="margin-right: auto; margin-left:auto" class="was-validated">
                    
                    <div class="mb-3 mt-3">
                        <label for="crnt_pswd" class="form-label">Current Password:</label>
                        <input type="password" class="form-control" id="crnt_pswd" placeholder="Enter the Current Password" name="crnt_pswd" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="new_pswd" class="form-label">New Password:</label>
                        <input type="password" class="form-control" id="new_pswd" placeholder="Enter the New Password" name="new_pswd" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="cnfrm_pswd" class="form-label">Confirm New Password:</label>
                        <input type="password" class="form-control" id="cnfrm_pswd" placeholder="Enter the New Password again" name="cnfrm_pswd" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Change</button>
                </form>
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