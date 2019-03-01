<?php
include "../includes/database.php";
require '../simple_html_dom.php';
session_start();
global $conn;
$userId = $_POST['usuario'];
$peliId = $_POST['pelicode'];
$bibliotecaId = $_POST['biblioteca'];
$pelinom = $_POST['pelinom'];
$pelioriginal = $_POST['pelioriginal'];
$peliduracio = $_POST['peliduracio'];
$peliano = $_POST['peliano'];
$pelivaloracion = $_POST['pelivaloracion'];
$peliweb = $_POST['peliweb'];
$pelidirector = $_POST['pelidirector'];
$pelipais = $_POST['pelipais'];
$peligenero = $_POST['peligenero'];
$peliguio = $_POST['peliguio'];
$peliproductora = $_POST['peliproductora'];
$pelimusica = $_POST['pelimusica'];
$peliimatge = $_POST['peliimatge'];
$pelireparto = $_POST['pelireparto'];
$peliresumen = $_POST['peliresumen'];

$sql = "INSERT INTO userpelis (pelicode, userId, bibliotecaId, pelinom, pelioriginal, pelidirector, peliano, peliduracio, pelipais, peliguio, pelimusica, peliimatge, pelireparto, peliproductora, peligenero, peliweb, peliresumen)
    VALUES (".$peliId.", '".$userId."', '".$bibliotecaId."', '".$pelinom."', '".$pelioriginal."', '".$pelidirector."', ".$peliano.", '".$peliduracio."', '".$pelipais."', '".$peliguio."', '".$pelimusica."', '".$peliimatge."', '".$pelireparto."', '".$peliproductora."', '".$peligenero."', '".$peliweb."', '".$peliresumen."')";
$result = $conn->query($sql);

