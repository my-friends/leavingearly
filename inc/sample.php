<?php 
require '../inc/master.php';
$title = "Sample";
require DOC_ROOT.'header.php';

$user_id = clean_in($_GET['id']);

$user = mysql_query("SELECT * FROM user WHERE id='$user_id'");
$user = mysql_fetch_assoc($user);

$items = mysql_query("SELECT * FROM item WHERE user_id='$user_id' ORDER BY id");
?>

<div class="row">
	<div class="span4">
		<?php echo $user['username']; ?>
	</div>
	<div class="span8">
		<?php while($item = mysql_fetch_assoc($items)) { ?>
			<?php echo $item['id']; ?><br>
		<?php } ?>
	</div>
</div>

<?php require DOC_ROOT.'footer.php'; ?>