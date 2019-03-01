<?php
include "../includes/database.php";
require '../simple_html_dom.php';
session_start();
function getResults($query) {
    $ch = curl_init($query); // Inicia sesión cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
    $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
    curl_close($ch); // Cierra sesión cURL
    return $info; // Devuelve la información de la función
}
function getFilmImage($url,$filmId) {
    $saveto = '../images/originales/'.$filmId.'.jpg';

    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    curl_setopt($ch, CURLOPT_REFERER, "https://www.filmaffinity.com");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $raw = curl_exec($ch);
    curl_close ($ch);
    if(file_exists($saveto)){
        unlink($saveto);
    }
    $fp = fopen($saveto,'x');
    fwrite($fp, $raw);
    fclose($fp);
}
function getFilmInfo($filmId){
    global $conn;
    $sitioweb = getResults("https://www.filmaffinity.com/es/film".$filmId.".html");
    $dom = new simple_html_dom();
    $dom->load($sitioweb);
    $names = array();
    $links = array();
    $arrayDef = array();
    $image = $dom->find('div[id="movie-main-image-container"]');
    $imageFinal = $image[0]->children[0]->href;
    getFilmImage($imageFinal,$filmId);
     $titol = $dom->find('span[itemprop="name"]');
     $titolDef = $titol[0]->plaintext;
     $titolDef = str_replace("'",'`',$titolDef);
    foreach($dom->find('dd') as $a) {
     $links[] = $a->plaintext;
    }
    foreach($dom->find('dt') as $b) {
     $names[] = $b->plaintext;
    }
    $totals = count($links);
    for($x = 0; $x <= $totals; $x++){
        $arrayDef[$names[$x]] = $links[$x];
    }
    //print_r($arrayDef);
    if(isset($arrayDef['Título original'])){
        $nom = str_replace('  ','',$arrayDef['Título original']);$nomFinal=preg_replace('/(\v)/','',$nom);
        $nomFinal = str_replace("'",'`',$nomFinal);
    } else {
        $nomFinal = '';
    }

    if(isset($arrayDef['Año'])){
        $ano = str_replace('  ','',$arrayDef['Año']);$anoFinal=preg_replace('/(\v)/','',$ano);
        $anoFinal = str_replace("'",'`',$anoFinal);
    } else {
        $anoFinal = '';
    }
    if(isset($arrayDef['Dirección'])){
        $director = str_replace('  ','',$arrayDef['Dirección']);$directorFinal=preg_replace('/(\v)/','',$director);
        $directorFinal = str_replace("'",'`',$directorFinal);
    } else {
        $directorFinal = '';
    }
    if(isset($arrayDef['Duración'])){
        $duracio = str_replace('  ','',$arrayDef['Duración']);$duracioFinal=preg_replace('/(\v)/','',$duracio);
        $duracioFinal = str_replace("'",'`',$duracioFinal);
    } else {
        $duracioFinal = '';
    }
    if(isset($arrayDef['País'])){
        $pais = str_replace('  ','',$arrayDef['País']);$paisFinal=preg_replace('/(\v)/','',$pais);
        $paisFinal = str_replace("'",'`',$paisFinal);
    } else {
        $paisFinal = '';
    }
    if(isset($arrayDef['Guion'])){
        $guio = str_replace('  ','',$arrayDef['Guion']);$guioFinal=preg_replace('/(\v)/','',$guio);
        $guioFinal = str_replace("'",'`',$guioFinal);
    } else {
        $guioFinal = '';
    }
    if(isset($arrayDef['Música'])){
        $musica = str_replace('  ','',$arrayDef['Música']);$musicaFinal=preg_replace('/(\v)/','',$musica);
        $musicaFinal = str_replace("'",'`',$musicaFinal);
    } else {
        $musicaFinal = '';
    }
    if(isset($arrayDef['Fotografía'])){
        $foto = str_replace('  ','',$arrayDef['Fotografía']);$fotoFinal=preg_replace('/(\v)/','',$foto);
        $fotoFinal = str_replace("'",'`',$fotoFinal);
    } else {
        $fotoFinal = '';
    }
    if(isset($arrayDef['Reparto'])){
        $reparto = str_replace('  ','',$arrayDef['Reparto']);$repartoFinal=preg_replace('/(\v)/','',$reparto);
        $repartoFinal = str_replace("'",'`',$repartoFinal);
    } else {
        $repartoFinal = '';
    }
    if(isset($arrayDef['Productora'])){
        $productora = str_replace('  ','',$arrayDef['Productora']);$productoraFinal=preg_replace('/(\v)/','',$productora);
        $productoraFinal = str_replace("'",'`',$productoraFinal);
    } else {
        $productoraFinal = '';
    }
    if(isset($arrayDef['Género'])){
        $genero = str_replace('  ','',$arrayDef['Género']);$generoFinal=preg_replace('/(\v)/','',$genero);
        $generoFinal = str_replace("'",'`',$generoFinal);
    } else {
        $generoFinal = '';
    }
    if(isset($arrayDef['Web oficial'])){
        $web = str_replace('  ','',$arrayDef['Web oficial']);$webFinal=preg_replace('/(\v)/','',$web);
        $webFinal = str_replace("'",'`',$webFinal);
    } else {
        $webFinal = '';
    }
    if(isset($arrayDef['Sinopsis'])){
        $resumen = str_replace('  ','',$arrayDef['Sinopsis']);$resumenFinal=preg_replace('/(\v)/','',$resumen);
        $resumenFinal = str_replace("'",'`',$resumenFinal);
    } else {
        $resumenFinal = '';
    }

    $sql = "INSERT INTO originals (pelicode, pelinom, pelioriginal, pelidirector, peliano, peliduracio, pelipais, peliguio, pelimusica, peliimatge, pelireparto, peliproductora, peligenero, peliweb, peliresumen)
    VALUES (".$filmId.", '".$titolDef."', '".$nomFinal."', '".$directorFinal."', ".$anoFinal.", '".$duracioFinal."', '".$paisFinal."', '".$guioFinal."', '".$musicaFinal."', '".$fotoFinal."', '".$repartoFinal."', '".$productoraFinal."', '".$generoFinal."', '".$webFinal."', '".$resumenFinal."')";
        $result = $conn->query($sql);
       // echo "".$filmId.", '".$titolDef."', '".$nomFinal."', '".$directorFinal."', ".$anoFinal.", '".$duracioFinal."', '".$paisFinal."', '".$guioFinal."', '".$musicaFinal."', '".$fotoFinal."', '".$repartoFinal."', '".$productoraFinal."', '".$generoFinal."', '".$webFinal."', '".$resumenFinal."'";
    //print_r($imageFinal);
}
function searchFilm($query,$bibliotecaId){
    global $conn;
    $thequery = str_replace(' ', '+', $query);
    $sitioweb = getResults("https://www.filmaffinity.com/es/search.php?stype=title&stext=".$thequery.""); 
    $dom = new simple_html_dom();
    $dom->load($sitioweb);
    $pelis = $dom->find('div[class=movie-card movie-card-1]');
    foreach($pelis as $pelicula){
        $peliId = $pelicula->attr['data-movie-id'];
        $sql = "SELECT pelinom FROM originals WHERE pelicode = ".$peliId."";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        } else {
            $thefilm = getFilmInfo($peliId);
        }
    }
    $html = '<div class="modal-contenido">';
    $html .= '<a onclick="goback(1)" class="modal-back">Atràs</a>';
    $html .= '<a onclick="closeModal()" class="modal-close">x</a>';
    $html .= '<div class="modal-titulo">Selecciona tu película</div>';
    $html .= '<div class="selctFilm">';
    $i = 0;
    foreach($pelis as $pelicula){
        $i++;
        if ((($i - 1) % 4 == 0) || $i == 1){ 
            $html .= '<div class="biblioResults">';
            if ((($i - 1) % 2 == 0) || $i == 1){
                $html .= '<div class="biblioResultsPar">';
            }
        }
    		$peliId = $pelicula->attr['data-movie-id'];
            $sql = "SELECT * FROM originals WHERE pelicode = ".$peliId."";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $file = '/var/www/vhosts/peliteca.cat/httpdocs/images/originales/'.$row["pelicode"].'.jpg'; 
                    if (file_exists($file)) {
                        if(filesize($file) > 0){
                            $imageUrl = '/images/originales/'.$row["pelicode"].'.jpg';
                        } else {
                            $imageUrl = '/images/no-image.png';
                        }
                        
                    } else {
                        $imageUrl = '/images/no-image.png';
                    }
                    $peliCode = $row["pelicode"];
                    $sql2 = "SELECT id FROM userpelis WHERE bibliotecaId = '".$bibliotecaId."' AND pelicode = ".$peliCode."";
                    $result2=$conn->query($sql2);
                    if ($result2->num_rows == 0) {
                        $html .= '<a class="peli-result" id="'.$row["pelicode"].'" onclick="setForm(\''.$row["pelicode"].'\',\''.$bibliotecaId.'\')"><div class="peli-result-img"><img src="'.$imageUrl.'" /></div><div class="peli-result-name">'. $row["pelinom"].' ('. $row["peliano"].')</div></a>';
                    } else {
                        $html .= '<div class="peli-result"><div class="peli-result-img"><img src="'.$imageUrl.'" /></div><div class="peli-result-name">'. $row["pelinom"].' ('. $row["peliano"].')</div></div>';
                    }
                }
            }
        if ($i % 4 == 0){
            $html .= '</div>';
            if ($i % 2 == 0){
                $html .= '</div>';
            }
        }
    }
    $html .= '</div></div>';
    //return $dom;
    return $html;

}
$theQuery = $_POST['busqueda'];
$bibliotecaId = $_POST['biblioteca'];
echo searchFilm($theQuery, $bibliotecaId);