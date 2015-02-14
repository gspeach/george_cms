<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php require_once("../includes/validation_functions.php"); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	$username = mysql_prep($_POST["username"]);
	$hashed_password = password_encrypt($_POST["hashed_password"]);

	// Validations
	$required_fields = array("username", "hashed_password");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("username" => 50, "hashed_password" => 60);
	validate_max_lengths($fields_with_max_lengths);

	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_admin.php");
	}

	// 2. Perform database query
	$query = "INSERT INTO admins (";
	$query .= "	username, hashed_password";
	$query .= ") VALUES (";
	$query .= " '{$username}', '{$hashed_password}'";
	$query .= ")";

	//Escape all strings
	$result = mysqli_query($connection, $query);
	
	//Test if there was a query error
	if ($result){
		//Success
		$_SESSION["message"] = "User created!";
		redirect_to("manage_admins.php");
	} else{
		//Failure
		//$message = "Subject creation failed";
		$_SESSION["message"] = "User creation failed.";
		redirect_to("new_admin.php");
	}
// 5. Close database connection
if(isset($connection)){ mysqli_close($connection); }
} else { ?>
	<div id="main">
		<div id="navigation">
		</div>
		<div id="page">
			<?php echo message(); ?>
			<?php $errors = errors(); ?>
			<?php echo form_errors($errors); ?>
			
			<h2>Create Subject</h2>
			<form action="new_admin.php" method="post">
				<p>User name:
					<input type="text" name="username" value="" />
				</p>
				<p>Password:
					<input type="password" name="hashed_password" value="" />
				</p>
				<input type="submit" name="submit" value="Create Admin" />
			</form>
			<br />
			<a href="manage_admins.php">Cancel</a>
		</div>
	</div>

<?php include("../includes/layouts/footer.php"); ?>
<?php } ?>