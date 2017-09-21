<?php

/* La siguiente clase fue desarrollada por Juan Marcos Vallejo con la finalidad
de poder manejar de una manera generica imagenes JPEG y PNG a través de 
un Archivo o una dirección URL 

Este código puede se utilizado, estudiado, modificado y redistribuido libremente.*/

abstract class Almacenable
{
    // Estado de almacenamiento de la imagen. - True: Esta almacenada - False: No esta almacenada.
    private $_saveState;
    // Directorio de almacenamiento de la imagen : string 
    private $_saveDir;
    // Nombre del archivo al ser almacenado (Obligatoriamente instanciado antes de almacenar)
    private $fileName;
}

class imageJmv extends Almacenable
{   
    private $_dir;
    // Determina el tipo de IMG: 0 PNG 1 JPEG
    private $_type;
    // Determina el Estado de la imagen, borrada o indexada. - True/False
    private $_state; 

    // En caso de error se almacena aquí.
    private $_lastError;

    // Almacena el resource obtenido con la creación de la imagen.
    public $_resource;

/*--------------------------- Apartado de Almacenamiento de imagenes ----------------------------------*/


    // Método constructor del objeto
    public function imageJmv($stringDir, $imgType)
    {
        $this->_saveState = false;
            $this->_state = false;
            $this->_type = $imgType;
            $this->_dir = $stringDir;
            $this->imageCreate();
    }

    public function imageCreate()
    {
        $temporalResource;
            // Evaluamos el tipo de la imagen y formamos el resource en función de eso.
            switch($this->_type)
            {
                case "PNG":
                $this->_resource = imagecreatefrompng($this->_dir);
                $this->_state = true;
                break;
                case "JPEG":
                $this->_resource = imagecreatefromjpeg($this->_dir);
                $this->_state = true;
                break;
            }       
    }

    public function imageShow()
    {
        if($this->_state == true)
        {
            switch($this->_type)
            {
                case "PNG":
                header('Content-Type: image/png');
                imagepng($this->_resource);
                imagedestroy($this->_resource);
                break;
                case "JPEG":
                header('Content-Type: image/jpeg');
                imagepng($this->_resource);
                imagedestroy($this->_resource);
                break;
            }
        }
    }
}

// Creo mi imagen.
$asd = "http://www.islabit.com/wp-content/imagenes/jpeg.jpg";
$dada = new imageJmv($asd, "JPEG");
$dada->imageShow();

?>
