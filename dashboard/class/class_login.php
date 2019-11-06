<?php
class Login {

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
    public function updClave($email, $dominio) {

        $verifica = $this->pdo->prepare("SELECT * FROM Usuarios 
            WHERE usuario_email = '".$email."' LIMIT 1");
        
        $verifica->execute();

        $exite = $verifica->fetch();

        if(is_array($exite) && !empty($exite)):
            
            $tocken  = sha1(md5(date('YmdGis')));

            $upClave = $this->pdo->prepare("UPDATE Usuarios SET 
                tocken  = '".$tocken."'
                WHERE usuario_email = '".$email."'
            ");

            $upClave->execute();

            $para      = $email;
            $titulo    = 'Recupera tu contraseña';
            $mensaje   = 'Hola!<br>'."\n\n";
            $mensaje  .= 'Hemos recibido una solicitud para Recupera tu Contraseña para Acceder al CMS de <a href="https://'.$dominio.'/login/">'.$dominio.'</a><br>'."\n\n";
            $mensaje  .= 'Solo debes hacer clic en el siguiente enlace <a href="https://'.$dominio.'/login/?tocken='.$tocken.'">'.$tocken.'</a><br>'."\n\n";
            $mensaje  .= 'Saludos!'."\n";
            $cabeceras  = 'From: noreply@'.$dominio. "\r\n";
            $cabeceras .= 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            if(mail($para, $titulo, $mensaje, $cabeceras)):
                header("location: /login/?envioclave=success");
            else:
                header("location: /login/?envioclave=error");
            endif;

        else:

            header("location: /login/?noenvioclave=error");

        endif;

    }

    // ACTUALIZAR CLAVE
    public function updClaveTocken($token) {

        $upClave = $this->pdo->prepare("UPDATE Usuarios SET 
                usuario_password = MD5('".$_POST['inputPassword1']."'),
                usuario_key      = NULL
                WHERE usuario_key = '".$token."'
                LIMIT 1 
            ");

        $upClave->execute();

        header("location: /login/");

    }


    // INICIO SESION
    public function geLoginUsuario() {

        $stm=$this->pdo->prepare("SELECT * FROM Usuarios 
            WHERE usuario_email = '".trim($_POST['email'])."'
            LIMIT 1 ");

        $stm->execute();

        $num = $stm->fetch();

        if(!empty($num)):

            $login=$this->pdo->prepare("SELECT * FROM Usuarios 
                WHERE usuario_email = '".trim($_POST['email'])."' 
                AND usuario_password = MD5('".$_POST['password']."') 
                LIMIT 1 ");

            $login->execute();

            $num2 = $login->fetch();

            if(!empty($num2)):

                $user=$this->pdo->prepare("SELECT * FROM Usuarios AS U
                    WHERE usuario_email = '".trim($_POST['email'])."' 
                    AND usuario_password = MD5('".$_POST['password']."') 
                    LIMIT 1 ");

                $user->execute();

                while ( $row = $user->fetch()) {
                    $this->datos[]  = $row;
                }
                return $this->datos;

            else:

                return $error='no_password';    

            endif;

        else:
            
            return $error='no_existe_correo';

        endif;
    }





    
}