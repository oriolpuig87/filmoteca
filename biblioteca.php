<!DOCTYPE HTML>

<html>
<?php 
include 'includes/head.php';
include "includes/database.php";
session_start();
if(!$_SESSION['id_usuario']){
	header("Location: http://peliteca.cat/registro.php");
	die();
}
$userId = $_SESSION['id_usuario'];
 
$bibliotecaId = $_GET['id'];
$sql = "SELECT id, userId, nombre FROM bibliotecas WHERE userId = '".$userId."' AND id = '".$bibliotecaId."'";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
$bibliotecaName = $row['nombre'];
?>
	<?php include 'includes/sidebibliotecas.php';?>
	<section class="user-review main">
		<div class="titleBox">
			<h2><?php echo $bibliotecaName; ?></h2>
			<div class="peli-box-add">
				<div class="peli-box-addtext" id="addFilm">+</div>
			</div>
		</div>

		<?php
			$sql2 = "SELECT id, pelicode, pelinom, peliano FROM userpelis WHERE bibliotecaId = '".$bibliotecaId."' ORDER BY pelinom ASC";
		$result2=$conn->query($sql2);
		$resultset2 = array();
		while($row2 = $result2->fetch_assoc()) {
                    $resultset2[] = $row2;
                }
$i = 0;
foreach ($resultset2 as $result2){
	$i++;
 	if ((($i - 1) % 4 == 0) || $i == 1){ ?>
 		<div class="biblioFilms">
 			<?php if ((($i - 1) % 2 == 0) || $i == 1){ ?>
 				<div class="biblioFilmsPar">
 			<?php
 			}
 	} ?>
 	<div class="biblioFilm <?php echo $i; ?>">
 		<a href="/pelicula.php?id=<?php echo $result2['id']; ?>">
			<article>
				<div class="peli-box">
					<div class="peli-box-image"><img src="/images/originales/<?php echo $result2['pelicode']; ?>.jpg" /></div>
					<div class="peliInner">
						<div class="peli-box-title"><?php echo $result2['pelinom']; ?><br/> (<?php echo $result2['peliano']; ?>)</div>
					</div>
				</div>
			</article>
		</a>
	</div>
	<?php
	if ($i % 4 == 0){
		?>
	 	</div>
	 	<?php if ($i % 2 == 0){ ?>
	 		</div>
	 		<?php
	 	}
	 }
} ?>	

	</section>

	<footer>
		<p>Copyright 2009 Your name</p>
	</footer>
<div class="modal-add" id="modal-1" style="display:none;">
	<div class="modal-contenido">
	<div class="modal-titulo">Buscar Película</div>
	<a onclick="closeModal()" class="modal-close">x</a>
		<form class="searchFilm" id="searchFilm" method="POST">
			<input type="text" name="busqueda" placeholder="Nombre de la peli" />
			<input type="hidden" name="biblioteca" value="<?php echo $_GET['id']; ?>" />
			<button type="submit" class="btn btn-success">Buscar</button>
		</form>
	</div>
</div>
<div class="modal-add" id="modal-2" style="display:none;"></div>
<div class="modal-add" id="modal-3" style="display:none;"></div>
</body>

</html>