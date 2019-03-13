<!DOCTYPE HTML>

<html>
<?php session_start(); 

if(!$_SESSION['id_usuario']){
	header("Location: http://filmoteca.cat/registro.php");
	die();
}
$userId = $_SESSION['id_usuario'];
include 'includes/head.php';
include "includes/database.php"; 
//include 'includes/topmenu.php'; 
include 'includes/sideindex.php';?>
	

	<section class="user-review main">
		<article id="biblio">
		<h2>Biblioteques</h2>
		<?php
		
		$sql = "SELECT * FROM bibliotecas WHERE userId = '".$userId."'";
		$result=$conn->query($sql);
		while ($row = $result->fetch_assoc()) {
			?>
				<div class="user-review-block-title">
					<a href="/biblioteca.php?id=<?php echo $row["id"] ; ?>"><?php echo  $row["nombre"] ; ?></a>
				</div>
			<?php
        }
?>
			<div class="addbiblio">
				<a id="addBiblio">+</a>
			</div>
		</article>
	</section>


	<footer>
		<p>Peliteca 2019</p>
	</footer>
<div class="modal-add" id="modalAddBiblio" style="display:none;">
	<div class="modal-contenido">
	<div class="modal-titulo">Añadir Biblioteca</div>
		<form class="anadirBiblioteca" id="anadirBiblioteca" method="POST">
			<input type="text" name="biblioname" placeholder="Nombre de la biblioteca" />
			<button type="submit" class="btn btn-success">Crear</button>
		</form>
	</div>
</div>
<div class="modal-add" id="modal-2" style="display:none;"></div>
<div class="modal-add" id="modal-3" style="display:none;"></div>
</body>

</html>
