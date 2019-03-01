<?php
$idUsuario = $_SESSION['id_usuario'];
$sql = "SELECT id, usuario FROM usuarios WHERE id = '$idUsuario'";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
?>
<aside>
	<h2><?php echo 'Hola, '.utf8_decode($row['usuario']); ?></h2>
<?php
$sql = "SELECT * FROM bibliotecas WHERE userId = '".$userId."'";
		$result=$conn->query($sql);
		while ($row = $result->fetch_assoc()) {
			?>
				<div class="biblio-side-title">
					<a href="/biblioteca.php?id=<?php echo $row["id"] ; ?>"><?php echo  $row["nombre"] ; ?></a>
				</div>
			<?php
        }
?>
</aside>