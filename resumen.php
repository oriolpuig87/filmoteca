<!DOCTYPE HTML>

<html>
<?php session_start(); ?>
<?php $userId = $_SESSION['id_usuario']; ?>
<?php include 'includes/head.php'; ?>
<?php include "includes/database.php" ?>
	<header>
		<?php include 'includes/topmenu.php'; ?>
	</header>
	
	<section class="user-review boxed">
		<h2>Biblioteques</h2>
<?php
		$sql = "SELECT id, userId, nombre FROM bibliotecas WHERE userId = '".$userId."'";
		$result=$conn->query($sql);
		$resultset = array();
		while($row = $result->fetch_assoc()) {
                    $resultset[] = $row;
                }

foreach ($resultset as $result){
 ?>
		<article class="col-md-4" id="biblio">
			<div class="user-review-block-title">
				<h4><a href="/biblioteca.php?id=<?php echo $result['id']; ?>"><?php echo $result['nombre']; ?></a></h4>
			</div>
		</article>
	<?php } ?>	
	</section>

	<aside>
		<h2>About section</h2>
		<p>Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
	</aside>

	<footer>
		<p>Copyright 2009 Your name</p>
	</footer>

</body>

</html>