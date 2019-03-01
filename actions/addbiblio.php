<?php
include "../includes/database.php";
session_start();
global $conn;
$biblioname = $_POST['biblioname'];
$userId = $_SESSION['id_usuario'];

$sql = "INSERT INTO bibliotecas (userId, nombre)
    VALUES (".$userId.", '".$biblioname."')";
        $result = $conn->query($sql);

$sql2 = "SELECT * FROM bibliotecas WHERE userId = '".$userId."' ORDER BY id DESC LIMIT 1";
		$result2=$conn->query($sql2);
		while ($row2 = $result2->fetch_assoc()) {
			$bibloId = $row2["id"];
			echo $bibloId;
        }
