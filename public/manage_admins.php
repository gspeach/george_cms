<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>

<div id="main">
	<div id="navigation">
		<br />
		<a href="admin.php">&laquo; Main menu</a>
	</div>
	<div id="page">
		<?php echo message(); ?>
		<h2>Manage Admins</h2>
		<?php display_admins(); ?>
		<p><a href="new_admin.php">Add new admin</a></p>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>