<?php 

/**
* Clase para generar un rss.
* 
* Uso rapido:
* $rss = new Rss("Titulo de rss","Link al blog / Enlace del rss","Descripcion del rss");
* $rss->setImageUrl("path/to/logo");
* $rss->setItemTitle("Titulo del item");
* $rss->setItemLink("enlace_al_articulo.html");
* $rss->setItemDescription("Descripcion del item");
* $rss->setItemDate("28-05-2015");
* $rss->setItemCategory("Categoria");
* $rss->setItemImg("path/to/imagen");
* $rss->addItem();
* $rss->clearItem(); // Repetir desde setItemTitle() para agergar items.
* $rss->createRss();
* $rss->print();
* 
* @package Rss
* @author Rodrigo Battagliero <rbattagliero@gmail.com>
*
*/


class Rss {

	/**
	* Variable que contiene todo el XML para el RSS.
	* @var string rss completo.
	* 
	*/
	private $rss;

	/**
	* @var string Titulo del RSS.
	*/
	private $titleRss;

	/**
	* @var string Enlace del RSS (hacia el sitio).
	*/
	private $linkRss;

	/**
	* @var string Descripcion del RSS.
	*/
	private $descriptionRss;


	/**
	* @var string Titulo de la imagen/logo del RSS (similar a alt de html)
	*/
	private $imageTitle;

	/**
	* @var string URL de la  imagen/logo del RSS (donde se busca la imagen)
	*/
	private $imageUrl;

	/**
	* @var string Enlace al sitio (u otro lugar para la imagen)
	*/
	private $imageLink;

	/**
	* @var string Ancho de la imagen/logo del RSS
	*/
	private $imageWidth;

	/**
	* @var string Alto de la imagen/logo del RSS
	*/
	private $imageHeigth;

	/**
	* @var string Elemento <item> del RSS.
	*/
	private $item;

	/**
	* @var string Titulo del item <item><title></title></item>
	*/
	private $itemTitle;

	/**
	* @var string Enlace del item.
	*/
	private $itemLink;

	/**
	* @var string Descripcion del item
	*/
	private $itemDescription;

	/**
	* @var string Fecha del item
	*/
	private $itemDate;

	/**
	* @var string Categoria del item.
	*/
	private $itemCategory;

	/**
	* @var array Imagenes del item.
	*/
	private $itemImg;

	/**
	* Descripcion breve de la funcion
	*
	* @param string $titulo Titulo del RSS.
	* @param string $link Enlace del RSS (Al blog de noticias u otro).
	* @param string $desc Descripcion del RSS.
	*/
	public function __construct($titulo,$link,$desc){
		$this->titleRss = $titulo;
		$this->linkRss = $link;
		$this->descriptionRss = $desc;
		$this->item = array();
	}

	/**
	* Setea el titulo de la imagen/Logo del RSS
	*
	* @param string $string Titulo de la imagen/Logo del RSS.
	*/
	public function setImagenTitle($string){
		$this->imagenTitle = $string;
	}

	/**
	* Setea la URL de la imagen/Logo del RSS
	*
	* @param string $string URL de la imagen/Logo del RSS.
	*/
	public function setImageUrl($string){
		$this->imageUrl = $string;
	}

	/**
	* Setea el link de la imagen/Logo del RSS
	*
	* @param string $string Link de la imagen/Logo del RSS.
	*/
	public function setImageLink($string){
		$this->imageLink = $string;
	}

	/**
	* Setea el ancho de la imagen/Logo del RSS. Si no se le proporciona una, se calcula automaticamente.
	*
	* @param string $string Ancho de la imagen/Logo del RSS.
	*/
	public function setImageWidth($string){
		$this->imageWidth = $string;
	}

	/**
	* Setea el Alto de la imagen/Logo del RSS. Si no se le proporciona una, se calcula automaticamente.
	*
	* @param string $string Alto de la imagen/Logo del RSS.
	*/
	public function setImageHeigth($string){
		$this->imageHeigth = $string;
	}

	/**
	* Setea el titulo del item RSS.
	*
	* @param string $string Titulo del item RSS.
	*/
	public function setItemTitle($string){
		$this->itemTitle = $string;
	}

	/**
	* Setea el link del item RSS.
	*
	* @param string $string Link del item RSS.
	*/
	public function setItemLink($string){
		$this->itemLink = $string;
	}

	/**
	* Setea la descripción del item RSS.
	*
	* @param string $string Descripción del item RSS.
	*/
	public function setItemDescription($string){
		$this->itemDescription = $string;
	}

	/**
	* Setea la fecha del item RSS.
	*
	* @param string $string Fecha del item RSS.
	*/
	public function setItemDate($string){
		$this->itemDate = $string;
	}

	/**
	* Setea la categoría del item RSS.
	*
	* @param string $string Categoría del item RSS.
	*/
	public function setItemCategory($string){
		$this->itemCategory = $string;
	}

	/**
	* Setea la URL de la imagen del item RSS.
	*
	* @param string $string URL de la imagen del item RSS.
	*/
	public function setItemImg($array = array()){
		$this->itemImg = $array;
	}

	/**
	* Agregar un item al RSS con los datos que se setearon para cada elemento (titulo, link, descriipcion, fecha, categoria e imagen)
	*/
	public function addItem(){
		$item = '';
		$item .='
		<item>
				<title><![CDATA['.$this->itemTitle.']]></title>
				<link><![CDATA['.$this->itemLink.']]></link>
				<guid isPermaLink="true">'.$this->itemLink.'</guid>
				<description><![CDATA['.substr($this->itemDescription, 0,300).'...'.']]></description>
				<pubDate><![CDATA['.$this->itemDate.' -0300]]></pubDate>
				<category><![CDATA['.$this->itemCategory.']]></category>
				<content:encoded><![CDATA['.$this->itemDescription.']]></content:encoded>
				';
		foreach ($this->itemImg as $img) {
			$imgInfo = getimagesize($img);
			$item .= '<enclosure url="'.$img.'" length="'.$this->getRemoteFileSize($img).'" type="'.image_type_to_mime_type($imgInfo[2]).'"  />'."\n";
		}				
		$item .= '
		</item>
		';
		$this->item[] = $item;
	}

	/**
	* Limpia las variables de los elemtos del item para comenzar a agrear uno nuevo.
	*/
	public function clearItem(){
		$this->itemTitle = '';
		$this->itemLink = '';
	 	$this->itemDescription = '';
	 	$this->itemDate = '';
	 	$this->itemCategory = '';
	 	$this->itemImg = '';

	}

	/**
	* Crea el XML completo para el RSS
	*/
	public function createRss(){
		$this->rss = '';
		$this->setHeader();
		$this->setChannel();
		$this->setItems();
		$this->setFooter();
	}

	/**
	* Imprime el RSS creado.
	* @return string RSS Completo.
	*/
	public function output(){
		header('Content-type: text/xml; charset="utf-8"', true);
		echo $this->rss;
	}

	private function setHeader(){
		$this->rss .= '<?xml version="1.0" encoding="utf-8" ?>
						<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/">
					';
	}

	private function setChannel(){

		$this->rss .= '
		<channel>
			<title><![CDATA['.$this->titleRss.']]></title>
			<link><![CDATA['.$this->linkRss.']]></link>
			<description><![CDATA['.$this->descriptionRss.']]></description>
		';

		// Si esta seteada la imagen / Logo del RSS
		if(!empty($this->imageUrl)){

			$imgInfo = getimagesize($this->imageUrl);

			// Si no esta seteado el ancho
			if(empty($this->imageWidth))
				$this->imageWidth = $imgInfo[0];
			
			// Si no esta seteado el alto
			if(empty($this->imageHeigth))
				$this->imageHeigth = $imgInfo[1];

			// Si no esta seteado el titulo de la imagen / logo
			if(empty($this->imageTitle))
				$this->imageTitle = $this->titleRss;

			// Si no esta seteado el enlace de la imagen / logo
			if(empty($this->imageLink))
				$this->imageLink = $this->linkRss;

			$this->rss .= '
				<image>';
				$this->rss .= "\n";
					if(!empty($this->imageTitle)){$this->rss .= '<title>'.$this->imageTitle.'</title>'."\n";}
					$this->rss .= '<url>'.$this->imageUrl.'</url>'."\n";
					if(!empty($this->imageLink)){$this->rss .= '<link>'.$this->imageLink.'</link>'."\n";}
					if(!empty($this->imageWidth)){/*$this->rss .= '<width>'.$this->imageWidth.'</width>'."\n";*/}
					if(!empty($this->imageHeigth)){/*$this->rss .= '<height>'.$this->imageHeigth.'</height>'."\n";*/}
			$this->rss .=	'
				</image>
			';
		}
	}

	private function setItems(){
		foreach ($this->item as $itm) {
			$this->rss .= $itm;
		}
	}

	private function setFooter(){
		$this->rss .= '
				</channel>
			</rss>';
	}

	/**
	* Devuelve el tamaño, solo numeros, del archivo ubicado en la URL
	* @param string $url URL del archivo.
	* @return string Tamaño del arhivo.
	*/
	private function getRemoteFileSize($url) {
		$tamano = get_headers($url,1);

		if (is_array($tamano['Content-Length'])) {
			$tamano = end($tamano['Content-Length']);
		}
		else {
			$tamano = $tamano['Content-Length'];
		}

		return $tamano;
	}

}
?>