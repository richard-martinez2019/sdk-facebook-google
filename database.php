<?php
class DataBase {

    private $pdo;
    private $datos;

    public function __construct(){

        $this->datos    = array();
        $cfg_servidor   = "localhost";
        $cfg_usuario    = 'hostingg_sdk';
        $cfg_password   = 'webyseo2019**';
        $cfg_bd         = 'hostingg_sdk';
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

        return header("location: index.php");
    }

    public function actualizarDatos($id_facebook, $imagen, $nombre, $apellido, $email) {

        $ingresar_datos  = $this->pdo->prepare("INSERT INTO Usuarios SET 
                facebook_id    = '".$id_facebook."',
                google_id    = '0',
                usuario_nombre     = '".$nombre."',
                usuario_apellido         = '".$apellido."',
                usuario_email       = '".$email."',
                usuario_foto      = '".$foto."'
            ");

        $ingresar_datos->execute();

        /*$verUsuarios=$this->pdo->prepare("SELECT * FROM Usuarios ");
        $verUsuarios->execute();

        while ( $row = $verUsuarios->fetch()) {

        	//if($id_facebook != $row['facebook_id']) {
		        $ingresar_datos  = $this->pdo->prepare("INSERT INTO Usuarios SET 
		                    facebook_id    = '".$id_facebook."',
		                    google_id    = '0',
		                    usuario_nombre     = '".$nombre."',
		                    usuario_apellido         = '".$apellido."',
		                    usuario_email       = '".$email."',
		                    usuario_foto      = '".$foto."'
		                ");

		        $ingresar_datos->execute();
        	//}


        }*/


    }

}