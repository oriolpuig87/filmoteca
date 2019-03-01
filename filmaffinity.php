<?php 
include "includes/database.php";
require 'simple_html_dom.php';
    // Definimos la función cURL
    function getResults($query) {
        $ch = curl_init($query); // Inicia sesión cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
        $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
        curl_close($ch); // Cierra sesión cURL
        return $info; // Devuelve la información de la función
    }
    function getFilmImage($url,$filmId) {
        $saveto = 'images/originales/'.$filmId.'.jpg';

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
         echo $titolDef;
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
        } else {
            $nomFinal = '';
        }

        if(isset($arrayDef['Año'])){
            $ano = str_replace('  ','',$arrayDef['Año']);$anoFinal=preg_replace('/(\v)/','',$ano);
        } else {
            $anoFinal = '';
        }
        if(isset($arrayDef['Dirección'])){
            $director = str_replace('  ','',$arrayDef['Dirección']);$directorFinal=preg_replace('/(\v)/','',$director);
        } else {
            $directorFinal = '';
        }
        if(isset($arrayDef['Duración'])){
            $duracio = str_replace('  ','',$arrayDef['Duración']);$duracioFinal=preg_replace('/(\v)/','',$duracio);
        } else {
            $duracioFinal = '';
        }
        if(isset($arrayDef['País'])){
            $pais = str_replace('  ','',$arrayDef['País']);$paisFinal=preg_replace('/(\v)/','',$pais);
        } else {
            $paisFinal = '';
        }
        if(isset($arrayDef['Guion'])){
            $guio = str_replace('  ','',$arrayDef['Guion']);$guioFinal=preg_replace('/(\v)/','',$guio);
        } else {
            $guioFinal = '';
        }
        if(isset($arrayDef['Música'])){
            $musica = str_replace('  ','',$arrayDef['Música']);$musicaFinal=preg_replace('/(\v)/','',$musica);
        } else {
            $musicaFinal = '';
        }
        if(isset($arrayDef['Fotografía'])){
            $foto = str_replace('  ','',$arrayDef['Fotografía']);$fotoFinal=preg_replace('/(\v)/','',$foto);
        } else {
            $fotoFinal = '';
        }
        if(isset($arrayDef['Reparto'])){
            $reparto = str_replace('  ','',$arrayDef['Reparto']);$repartoFinal=preg_replace('/(\v)/','',$reparto);
        } else {
            $repartoFinal = '';
        }
        if(isset($arrayDef['Productora'])){
            $productora = str_replace('  ','',$arrayDef['Productora']);$productoraFinal=preg_replace('/(\v)/','',$productora);
        } else {
            $productoraFinal = '';
        }
        if(isset($arrayDef['Género'])){
            $genero = str_replace('  ','',$arrayDef['Género']);$generoFinal=preg_replace('/(\v)/','',$genero);
        } else {
            $generoFinal = '';
        }
        if(isset($arrayDef['Web oficial'])){
            $web = str_replace('  ','',$arrayDef['Web oficial']);$webFinal=preg_replace('/(\v)/','',$web);
        } else {
            $webFinal = '';
        }
        if(isset($arrayDef['Sinopsis'])){
            $resumen = str_replace('  ','',$arrayDef['Sinopsis']);$resumenFinal=preg_replace('/(\v)/','',$resumen);
        } else {
            $resumenFinal = '';
        }


        $sql = "INSERT INTO originals (pelicode, pelinom, pelioriginal, pelidirector, peliano, peliduracio, pelipais, peliguio, pelimusica, peliimatge, pelireparto, peliproductora, peligenero, peliweb, peliresumen)
        VALUES (".$filmId.", '".$titolDef."', '".$nomFinal."', '".$directorFinal."', ".$anoFinal.", '".$duracioFinal."', '".$paisFinal."', '".$guioFinal."', '".$musicaFinal."', '".$fotoFinal."', '".$repartoFinal."', '".$productoraFinal."', '".$generoFinal."', '".$webFinal."', '".$resumenFinal."')";
            $result = $conn->query($sql);
        //print_r($imageFinal);
    }
    function searchFilm($query){
        global $conn;
        $sitioweb = getResults("https://www.filmaffinity.com/es/search.php?stype=title&stext=".$query.""); 
        $dom = new simple_html_dom();
        $dom->load($sitioweb);
        $pelis = $dom->find('div[class=movie-card movie-card-1]');
        foreach($pelis as $pelicula){
            $peliId = $pelicula->attr['data-movie-id'];

            $sql = "SELECT pelinom FROM originals WHERE pelicode = ".$peliId."";
            $result = $conn->query($sql);
            echo '<pre>';
            if ($result->num_rows > 0) {
            // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "id: " . $peliId . " - Name: " . $row["pelinom"]. "<br>";
                }
            } else {
                    echo "id: " . $peliId . " No está a la base de dades originals<br>";
                    echo getFilmInfo($peliId);
            }
            echo '</pre>';

        }
    }
    echo searchFilm('matrix');
?>