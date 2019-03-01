<?php
$idUsuario = $_SESSION['id_usuario'];
$sql = "SELECT id, usuario FROM usuarios WHERE id = '$idUsuario'";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
?>
<aside>
	<h2><?php echo 'Hola, '.utf8_decode($row['usuario']); ?></h2>
	<p>Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
</aside>