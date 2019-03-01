<?php
	
	session_start();
	require 'includes/database.php';
	
	if(isset($_SESSION["id_usuario"])){
		header("Location: index.php");
	}
	global $conn;
	$sql = "SELECT id, tipo FROM tipo_usuario";
	$result=$conn->query($sql);
	
	$bandera = false;
	
	if(!empty($_POST))
	{
		$usuario = mysqli_real_escape_string($conn,$_POST['usuario']);
		$password = mysqli_real_escape_string($conn,$_POST['password']);
		$tipo_usuario = $_POST['tipo_usuario'];
		$sha1_pass = sha1($password);
		
		$error = '';
		
		$sqlUser = "SELECT id FROM usuarios WHERE usuario = '$usuario'";
		$resultUser=$conn->query($sqlUser);
		$rows = $resultUser->num_rows;
		
		if($rows > 0) {
			$error = "El usuario ya existe";
		} else {			
			$sqlUsuario = "INSERT INTO usuarios (usuario, password, tipo_usuario) VALUES('$usuario','$sha1_pass',0)";
			$resultUsuario = $conn->query($sqlUsuario);
			
			if($resultUsuario>0)
			$bandera = true;
			else
			$error = "Error al Registrar";
		}
	}
?>
 
<html>
	<head>
		<title>Registro</title>
		
		<script>
			
			function validarUsuario()
			{
				valor = document.getElementById("usuario").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar Usuario');
					return false;
				} else { return true;}
			}
			
			function validarPassword()
			{
				valor = document.getElementById("password").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar Password');
					return false;
					} else { 
					valor2 = document.getElementById("con_password").value;
					
					if(valor == valor2) { return true; }
					else { alert('Las contraseña no coinciden'); return false;}
				}
			}
			
			// function validarTipoUsuario()
			// {
			// 	indice = document.getElementById("tipo_usuario").selectedIndex;
			// 	if( indice == null || indice==0 ) {
			// 		alert('Seleccione tipo de usuario');
			// 		return false;
			// 	} else { return true;}
			// }
			
			function validar()
			{
				if(validarUsuario() && validarPassword())
				{
					document.registro.submit();
				}
			}
		</script>
		
	</head>
	
	<body>
	<?php include 'includes/notloggedtopmenu.php'; ?>
		<section>
		<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" > 
			
			<div><label>Usuario:</label><input id="usuario" name="usuario" type="text"></div>
			<br />
			
			<div><label>Password:</label><input id="password" name="password" type="password"></div>
			<br />
			
			<div><label>Confirmar Password:</label><input id="con_password" name="con_password" type="password"></div>

			<br />
			
			<div><input name="registar" type="button" value="Registrar" onClick="validar();"></div> 
		</form>
		<a href="entrar.php">Ya tengo una cuenta</a>
		
		<?php if($bandera) { ?>
			<h1>Registro exitoso</h1>
			<a href="welcome.php">Regresar</a>
			
			<?php }else{ ?>
			<br />
			<div style = "font-size:16px; color:#cc0000;"><?php echo isset($error) ? utf8_decode($error) : '' ; ?></div>
			
		<?php } ?>
		
	</body>
</html>