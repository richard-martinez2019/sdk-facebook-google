<?php
class Opciones {

    private $pdo;
    private $datos;

    public function __construct(){

        $this->datos    = array();
        $cfg_servidor   = "localhost";
        $cfg_usuario    = 'hostingg_uaccion';
        $cfg_password   = 'webyseo2019**';
        $cfg_bd         = 'hostingg_accionesjudiciales';
        $cfg_dsn        = "mysql:host=$cfg_servidor;dbname=$cfg_bd";

        try {
            
            $this->pdo=new PDO($cfg_dsn,$cfg_usuario,$cfg_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
            $this->pdo->prepare("SET NAMES 'UTF8'");

        } catch (Exception $e) {
            
            $this->pdo=null;
            error_log("Error en la bd ".$e->getMessage());

        }

 
    }

    private function _redirect(){

        return header("location: /");
    }


    // ACTUALIZAR CLAVE
    public function updOpciones($opcion, $valor) {

        $upClave = $this->pdo->prepare("UPDATE Opciones SET 
                opcion_valor   = '".utf8_decode($valor)."'
                WHERE opcion_nombre = '".$opcion."'
                LIMIT 1 
            ");

        $upClave->execute();

    }

    public function getValorOpcion($opcion) {

        $info     = $this->pdo->prepare("SELECT opcion_valor FROM Opciones 
            WHERE opcion_nombre = '".$opcion."' ");

        $info->execute();

          while ( $row = $info->fetch()) {
            
            $valor  = $row['opcion_valor'];

        }

        return $valor;
        

    }

    
}