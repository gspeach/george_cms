<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php require_once("../includes/validation_functions.php"); ?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	$subject_id = (int) $_POST["subject"];//finish adding this into the code
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
	$content = mysql_prep($_POST["content"]);

	// Validations
	$required_fields = array("subject", "menu_name", "position", "visible", "content");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);

	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_page.php?subject=$subject_id");
	}

	// 2. Perform database query
	$query = "INSERT INTO pages (";
	$query .= "	subject_id, menu_name, position, visible, content";
	$query .= ") VALUES (";
	$query .= " {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'";
	$query .= ")";

	//Escape all strings
	$result = mysqli_query($connection, $query);
	
	//Test if there was a query error
	if ($result){
		//Success
		$_SESSION["message"] = "Page created!";
		redirect_to("manage_content.php?subject=$subject_id");
	} else{
		//Failure
		//$message = "Page creation failed";
		$_SESSION["message"] = "Page creation failed.";
		redirect_to("new_page.php?subject=$subject_id");
	}
} else {
	// Is probably a get request
	redirect_to("new_page.php?subject=$subject_id");
}
?>

<?php
// 5. Close database connection
if(isset($connection)){ mysqli_close($connection); }
?>