<?php

error_reporting(E_ALL);
ini_set("display_errors","1");

include("rss.php");
//Use Rss;

$rss = new Rss("Título del RSS","http://www.sitio.com.ar","Descripion");
$rss->setImageUrl("http://www.sitio.com.ar/imagenes/logo.jpg");

$db = new Datos();

$noticias = array();

foreach ($noticias as $nota) {
	$imagenes = array();
	$rss->setItemTitle($nota['titulo']);
	$rss->setItemLink("http://www.sitio.com.ar/".$nota['id']);
	$rss->setItemDescription($nota['copete']);
	$rss->setItemDate($nota['fecha']);
	$rss->setItemCategory($nota['categoria']);

	$images = array();
	foreach ($imagenes as $img)
		$images[] = "http://www.sitio.com.ar/imagenes/".$img['url'];
	
	$rss->setItemImg($images);
	$rss->addItem();
	$rss->clearItem();		
}
$rss->createRss();
$rss->output();

?>
