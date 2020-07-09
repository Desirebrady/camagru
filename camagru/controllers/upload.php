<?php
session_start();
include     'connect.php';
include 	'get_uploads.php';

if (isset($_GET['delete'])) {

	$id = $_GET['delete'];
	$select = mysqli_query($db, "SELECT name, user_id FROM images WHERE id=$id");
	$image = mysqli_fetch_all($select, MYSQLI_ASSOC);

	if ($image['user_id'] == $user['id']) {


		unlink(IMAGES . '/' . $image['name']);


		$db->query("DELETE FROM images WHERE id=$id");
		header('Location: upload.php');
		die();
	}
}
$results = mysqli_query($db, "SELECT * FROM images ORDER BY id DESC");
$images = mysqli_fetch_all($results, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
	<title>Edit Profile</title>
	<link rel="stylesheet" type="text/css" href="../css/my_style.css">
	<link rel="stylesheet" type="text/css" href="../css/Edit.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>
		.grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
			grid-gap: 20px;
			align-items: stretch;
		}

		.grid img {
			border: 1px solid #ccc;
			box-shadow: 2px 2px 6px 0px rgba(0, 0, 0, 0.3);
			max-width: 100%;
		}
	</style>
</head>

<body>
	<?php include_once '../header.php'; ?>
	<div class="container-fluid">
		<div style="margin-top: 10%; margin-left: 10%">
			<h1> Your images</h1>
			<main class="grid">
				<?php foreach ($images as $image) : ?>

					<?php
					if ($_SESSION['username'] === $image['username']) : ?>
						<img src="<?php echo '../img/' . $image['image'] ?>" width="450px" alt="">
						<a href="?delete=<?php echo $image['id']; ?>" onclick="return('Sur sur sur ?')">delete</a>
					<?php endif ?>
				<?php endforeach; ?>
			</main>
		</div>
		<?php include_once '../footer.php'; ?>
	</div>
</body>

</html>