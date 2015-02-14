<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php require_once("../includes/validation_functions.php"); ?>

<?php
	if (!isset($_GET["id"]) || find_username_by_id($_GET["id"]) == null) {
		//username was missing or invalid or
		//username couldn't be found in database
		redirect_to("manage_admins.php");
	}
?>

<?php
if (isset($_POST['submit'])) {
	// Validations
	$required_fields = array("username", "hashed_password");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("username" => 50, "hashed_password" => 60);
	validate_max_lengths($fields_with_max_lengths);

	if (empty($errors)) {
		//Perform udpate

		// Process the form
		$id = (int) $_GET["id"];
		$username = mysql_prep($_POST["username"]);
		$hashed_password = password_encrypt($_POST["hashed_password"]);

		// 2. Perform database query
		$query = "UPDATE admins SET ";
		$query .= "username = '{$username}', ";
		$query .= "hashed_password = '{$hashed_password}' ";
		$query .= "WHERE id = '{$id}' ";
		$query .= "LIMIT 1";

		//Escape all strings
		$result = mysqli_query($connection, $query);
		
		//Test if there was a query error
		if ($result && mysqli_affected_rows($connection) >= 0){
			//Success
			$_SESSION["message"] = "User updated!";
			redirect_to("manage_admins.php");
		} else{
			//Failure
			//$message = "Subject creation failed";
			$message = "User update failed.";
		}
	}
} else {
	// Is probably a get request
} // end if (isset($_POST['submit'])) 
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">
	</div>
	<div id="page">
		<?php //$message is just a variable, doesn't use the SESSION 
		if (!empty($message)) {
			echo "<div class=\"message\">" . htmlentities($message) . "</div>";
		}?>
		<?php echo form_errors($errors); ?>
		
		<h2>Edit User 
		<?php
		$id = $_GET["id"];
		$username = find_username_by_id($id);
		echo htmlentities($username);
		?></h2>
		<form action="edit_admin.php?id=<?php echo urlencode($id); ?>" method="post">
			<p>Username:
				<input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
			</p>
			<p>Password:
				<input type="password" name="hashed_password" value="" />
			</p>
			<input type="submit" name="submit" value="Edit User" />
		</form>
		<br />
		<a href="manage_admins.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>