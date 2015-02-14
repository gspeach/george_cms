<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>

<?php
$username = "";

if (isset($_POST['submit'])) {
	// Validations
	$required_fields = array("username", "hashed_password");
	validate_presences($required_fields);

	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_admin.php");
	}
	//Attempt Login
	$username = $_POST["username"];
	$password = $_POST["hashed_password"];

	$found_admin = attempt_login($username, $password);

	//Test if there was a query error
	if ($found_admin){
		//Success
		//Mark user as logged in
		$_SESSION["admin_id"] = $found_admin["id"];
		$_SESSION["username"] = $found_admin["username"];
		redirect_to("admin.php");
	} else{
		//Failure
		$_SESSION["message"] = "Username/Password not found."; //Did not tell which one was found... prevent hackers from finding correct usernames
	}
// 5. Close database connection
if(isset($connection)){ mysqli_close($connection); }
} else { ?>
	<div id="main">
		<div id="navigation">
			&nbsp;
		</div>
		<div id="page">
			<?php echo message(); ?>
			<?php $errors = errors(); ?>
			<?php echo form_errors($errors); ?>
			
			<h2>Login</h2>
			<form action="login.php" method="post">
				<p>Username:
					<input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
				</p>
				<p>Password:
					<input type="password" name="hashed_password" value="" />
				</p>
				<input type="submit" name="submit" value="Submit" />
			</form>
		</div>
	</div>

<?php include("../includes/layouts/footer.php"); ?>
<?php } ?>