<?php

session_start();

// Check if user is already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}

include 'operations/db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
	

    // Include database connection

    // Prepare query
    $sql = "SELECT `id`, `username`, `password`, `role` FROM `users` WHERE `username` = '$username' AND `password` = '$password';";
    $result = mysqli_query($conn, $sql);

    if(!$result) {
        // Display error message and exit
        die("Error executing query: " . mysqli_error($conn));
    }

    // Check if credentials are valid
    if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);

        // Store session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
		$_SESSION["role"] = $row['role'];

        // Redirect to dashboard
		if($row['role'] == 'editor') {
			header("location: dashboard.php");
		} else {
			header("location: view-only-dashboard.php");
		}
        exit;
    } else{
        // Display error message 
        $error = "Invalid username or password";    
    }
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
	<div class="container mt-5 ">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); transition: 0.3s;">
					<div class="card-header bg-dark text-light" style="color: #fff; text-align: center; font-size: 24px;">
						<img src="images/npo_logo.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px;"> National Printing Office
					</div>
					<div class="card-body" style="padding: 30px;">
						<form method="post" action="index.php">
							<div class="form-group">
								<label for="username" style="font-weight: bold;">Username</label>
								<input type="text" class="form-control" id="username" name="username" required >
							</div>
							<div class="form-group">
								<label for="password" style="font-weight: bold;">Password</label>
								<div class="input-group">
									<input type="password" class="form-control" name="password" autocomplete="current-password" required="" id="id_password">
									<i class="bg-dark btn bi bi-eye" id="togglePassword" style="color:white"></i>
								</div>		
							</div>
							<button type="submit" class="btn btn-dark" style=" border: none; margin-top: 20px; font-size: 18px; letter-spacing: 1px; padding: 10px 0; text-transform: uppercase; transition: 0.3s; width: 100%;">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('id_password');

togglePassword.addEventListener('click', function (e) {
  // toggle the type attribute
  const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
  password.setAttribute('type', type);
  // toggle the eye slash icon
  this.classList.toggle('bi-eye-slash');
});
</script>
</body>

</html>
