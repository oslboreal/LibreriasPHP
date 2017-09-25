<?php

// Conjunto de librerías que proveen herramientas necearias para el manejo de Archivos.
// Además brinda un constructor que recibe por defecto un archivo temporal (recién subido) y lo almacena
// Automáticamente al sistema.
// 
// Librerías desarrolladas por Juan Marcos Vallejo - Estudiante UTN FRA.
// Para más información: https://github.com/oslboreal/LibreriasPHP

class filesJmv
{
    // Nombre archivo
    private $_fileName;
    // Carpeta actual
    private $_folder;
    // Path completo del archivo.
    private $_fileDir;
    // Existe
    private $_fileExists;
    // Extension
    private $_fileType;
    

    // File name recibe el post
    // Formato del folder "folder/"
    public function filesJmv($fileName, $stringPath, $mode)
    {
        switch($mode)
        {
            case 'POST':
                if(isset($fileName))
                {
                    // Trabajamos $fileNameh como un ARRAY
                    $pathDestino = $stringPath . $fileName['name'];
                    move_uploaded_file($fileName['tmp_name'], $pathDestino);
                }

                if(file_exists($pathDestino))
                {
                    // Asignamos el nombre
                    $this->_fileName = $fileName['name'];
                    // Asignamos el folder
                    $this->_folder = $stringPath;
                    // Asigno la direccion del archivo
                    $this->_fileDir = $stringPath . $fileName['name'];
                    // Obtengo el tipo de archivo.
                    $this->_fileType = $this->obtainExtension();
                    // Cambiamos de estado la bandera.
                    $this->_fileExists = true;
                }
                break;
            case 'LOCAL':
                // Si existe el archivo que se envió por referencia. 
                if(file_exists($stringPath . $fileName))
                {
                    $this->_fileName = $fileName;
                    $this->_folder = $stringPath;
                    $this->_fileDir = $stringPath . $fileName;
                    $this->_fileType = $this->obtainExtension();
                    $this->_fileExists = true;
                }
            break;
        }        
    }

    // Algoritmo simple encargado de obtener la extension del archivo específicado en los campos fileDir.
    private function obtainExtension()
    {
        $pos = strpos($this->_fileDir, '.'); // Obtenemos posicion del punto.
        $i = $pos;
        $result = "";
        for($i; $i < strlen($this->_fileDir); $i++)
        {
            $result = $result . $this->_fileDir[$i];
        }
        return $result;
    }

    private function obtainCustomDirExtension($customDir)
    {
        $pos = strpos($customDir, '.'); // Obtenemos posicion del punto.
        $i = $pos;
        $result = "";
        for($i; $i < strlen($this->_fileDir); $i++)
        {
            $result = $result . $this->_fileDir[$i];
        }
        return $result;
    }

    // Borra un archivo y cambia los estados a nulo
    public function deleteFile()
    {
        // Si el archivo existe...
        if($this->_fileExists)
        {
            $this->_fileExists = false;
            return unlink($this->_fileDir);
        }
    }

    // Simplemente copia un Archivo y retorna su dirección para poder
    // Instanciarlo en otro objeto del tipo filesJMV
    public function copyFile($varNewName)
    {
        // Si el archivo existe...
        if($this->_fileExists)
        {
            if(copy($this->_fileDir, $varNewName))
            {
                return $this->_fileDir . $varNewName;
            }
        }
    }

    // Método que recibe un directorio y mueve el archivo.
    // Actualiza el Directorio, la Direccion Absoluta.
    // Mantiene el nombre y el Type
    public function moveFile($newDirToMove)
    {
        if($this->_fileExists)
        {
            // Copiamos el archivo en una dirección
            echo $newDirToMove . $this->_fileName;
            $this->copyFile($newDirToMove . $this->_fileName);
            if(file_exists($newDirToMove . $this->_fileName))
            {
                $this->deleteFile();
                $this->_fileDir = $newDirToMove . $this->_fileName;
                $this->_folder = $newDirToMove;
            }
        }
    }

    // Recibe un nombre por parametro.
    // Actualiza el nombre del archivo, la dirección absoluta y la extension del archivo.
    // Mantiene el folder.
    public function renameFile($newName)
    {
        if($this->_fileExists)
        {
            if(rename($this->_fileDir, $this->_folder . $newName))
            {
                // Si pudimos renombrar actualizamos datos.
                $this->_fileDir = $this->_folder . $newName;
                $this->_fileName = $newName;
                $this->_fileType = $this->obtainExtension($newName);
                // Folder sigue siendo el mismo.
            }

        }
    }

    // Funcion de instancia, retorna el directorio absoluto del archivo.
    public function getDir()
    {
        if($this->_fileExists)
        {
            return $this->_fileDir;
        } else
        {
            return null;
        }
    }
}


?>