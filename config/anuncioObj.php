<?php
class Anuncio {
    public $id;
    public $fecha;
    public $titulo;
    public $subtitulo;
    public $mensaje;
    public $imagen;
    
    // Constructor opcional para inicializar propiedades
    public function __construct($id, $fecha, $titulo, $subtitulo, $mensaje, $imagen) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->titulo = $titulo;
        $this->subtitulo = $subtitulo;
        $this->mensaje = $mensaje;
        $this->imagen = $imagen;
    }
}

