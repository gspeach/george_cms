<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php
if (isset($_GET["id"]) && find_username_by_id($_GET["id"]) != null) {
	$id = $_GET["id"];

	$query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) ==1) {
		//Success
		$_SESSION["message"] = "User deleted!";
		redirect_to("manage_admins.php");
	} else{
		//Failure
		$_SESSION["message"] = "User deletion failed.";
		redirect_to("manage_admins.php");
	}
} else{
	redirect_to("manage_admins.php");
}



?>