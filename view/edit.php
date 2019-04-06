<?php ob_start();

// authentication check
require_once('auth.php');

// set the page title
$page_title = null;
$page_title = 'Your Profile';

// embed the header
require_once('header.php');

// connect
require_once('db.php');

// initialize variables
$user_id = null;
$user_name = null;
$location = null;
$skills = null;
$url = null;


// check the url for a movie_id parameter and store the value in a variable if we find one
if (empty($_GET['user_id']) == false) {
	$user_id = $_GET['user_id'];

	// connect
	require_once('db.php');

	// write the sql query
	$sql = "SELECT * FROM profiles WHERE user_id = :user_id";

	// execute the query and store the results
	$cmd = $conn->prepare($sql);
	$cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	$cmd->execute();
	$profiles = $cmd->fetchAll();

	// populate the fields for the selected profile from the query result
	foreach ($profiles as $profile) {
		$user_name = $profile['user_name'];
		$location = $profile['location'];
		$skills = $profile['skills'];
	}

// start the html display table
echo '<table class="table table-striped table-hover"><thead><th>Username</th><th>Location</th><th>Skills</th>
<th>Edit</th><th>Delete</th></thead><tbody>';

// loop through the results and show each movie in a new row and each value in a new column
foreach ($profiles as $profile) {
	echo '<tr><input>' . $profile['user_name'] . '</input>
		<input>' . $profile['location'] . '</input>
		<input>' . $profile['skills'] . '</input>
    <td><a href="profile.php?user_id=' . $profile['user_id'] . '">Edit</a></td>
<td><a href="delete-profile.php?user_id=' . $profile['movie_id'] . '"
  onclick="return confirm(\'Are you sure you want to delete this movie?\');">Delete</td></tr>';
  // there should also be a way to check to make sure that someone can't have the same username or email as someone else
}

// close the table and body
echo '</tbody></table>';

// disconnect
$conn = null;

// embed footer
require_once('footer.php');
ob_flush();
?>
