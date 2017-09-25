<?php

/* La siguiente clase fue desarrollada por Juan Marcos Vallejo con la finalidad
de poder manejar de una manera generica imagenes JPEG y PNG a través de 
un Archivo o una dirección URL 

Este código puede se utilizado, estudiado, modificado y redistribuido libremente.
https://github.com/oslboreal/LibreriasPHP*/

require_once 'archivoAlmacenable.php';

class imageJmv extends ArchivoAlmacenable
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

    // Método constructor del objeto
    public function imageJmv($stringDir, $imgType)
    {
        $this->_saveState = false;
            $this->_state = false;
            $this->_type = $imgType;
            $this->_dir = $stringDir;
            $this->imageCreate();
    }

    // Crea el recurso de la Imagen.
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

    // En caso de existir un recurso, se muestra la imagen.
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
                return true;
                break;
                case "JPEG":
                header('Content-Type: image/jpeg');
                imagepng($this->_resource);
                imagedestroy($this->_resource);
                return true;
                break;
            }
        }else
        {
            return false;
        }
    }

    // Función que retorna el Recurso de la imagen en caso de que 
    // se haya creado correctamente la misma.
    //
    public function getResource()
    {
        if($this->_state == true)
        {
            return $this->_resource;
        }else
        {
            return null;
        }
    }

        // En caso de existir un recurso, se crea la imagen.
    public function imageSave($dir, $name)
    {
        if($this->_state == true)
        {
            $this->setFileName = $name;
            $this->setSaveDir = $dir;
            switch($this->_type)
            {
                case "PNG":
                imagepng($this->_resource, $dir . $name);
                imagedestroy($this->_resource);
                $this->setSaveState = true;
                return true;
                break;
                case "JPG":
                imagepng($this->_resource, $dir . $name);
                imagedestroy($this->_resource);
                $this->setSaveState = true;
                return true;
                break;
            }
        }else
        {
            return false;
        }
    }
}

?>
