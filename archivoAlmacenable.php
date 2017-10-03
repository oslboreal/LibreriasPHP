<?php
// Para mas información https://github.com/oslboreal/LibreriasPHP

// Formato directorio: "/images/"
// Formato nombre: "imagen.jpg"
// Resultado: root/images/imagen.jpg

abstract class ArchivoAlmacenable
{
    // Estado de almacenamiento de la imagen. - True: Esta almacenada - False: No esta almacenada.
    private $_saveState;
    // Directorio de almacenamiento de la imagen : string 
    private $_saveDir;
    // Nombre del archivo al ser almacenado (Obligatoriamente instanciado antes de almacenar)
    private $fileName;

    public function getSaveState()
    {
        return $this->_saveState;
    }

    public function getSaveDir()
    {
        return $this->_saveDir;
    }

    public function getFileName()
    {
        return $this->fileName;
    }
        public function setSaveState($value)
    {
        $this->_saveState = $value;
    }

    public function setSaveDir($value)
    {
        $this->_saveDir = $value;
    }

    public function setFileName($value)
    {
        $this->fileName = $value;
    }

    public function deleteFile()
    {
        // En caso de que el archivo almacenable esté almacenado respetando el protocolo
        // Establecido (Es decir haber indicado a las propiedades de Almacenable que está almacenado y su ubicación.)
        if($this->_saveState)
        {
            if($this->getSaveDir() != null && $this->getFileName() != null)
            {
                return unlink($this->getSaveDir() + $this->getFileName());
            }
        }
    }
}

?>