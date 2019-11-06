<?php
    
    // DEFINIENDO EL FORMATO PARA FECHA Y HORA
    date_default_timezone_set('America/Santiago');

    // MOSTRAR ERRORES 
    error_reporting(E_ALL);
    ini_set('display_errors', '1'); 

    @session_start();

    // URLS
    $dominio    = $_SERVER["HTTP_HOST"];    // DOMINIO
    $path       = $_SERVER["REQUEST_URI"];  // PATH

    //print_r($_SESSION);

    // DESTRUIR LA SESSION
    if (isset($_SESSION['user_id']) && $path == '/login/salir'):

        // DESTRUYE LAS VARIABLES SESSION
        session_destroy();
        // REDIRIJE AL INICIO
        header("location: /"); 

    endif;

    
    // FUNCIONES
    include '_funciones_panel.php';
    
    // CONSULTAS WEB
    include 'class/class_opciones.php';
    include 'class/class_panel.php';
    include 'class/class_login.php'; 
    include '../class/class_web.php'; 


    // RECUPERAR LA CLAVE
    if ( !isset($_SESSION['user_id']) && 
        ( strstr($path, 'recuperar') || strstr($path, 'envioclave') || strstr($path, 'tocken') ) ):

        include 'themes/login.php';
        exit; // TERMINA EL SCRIPT AQUI

    endif;


    
    // COMPROBANDO INICIO DE SESSION
    if ( !isset($_SESSION['user_id']) && $path != '/login/' ):

        header("location: /login/ "); 
        
    endif;
    
    
    // PREGUNTAR SI $path ES DISTINTO 'home'
    if($path != '/' ):

        // DISTINTO HOME POR DEFECTOS
        if( $path == '/index.php' OR $path == '/index.html' OR $path == '/index' OR $path == '/index/' ):

            header("HTTP/1.1 301 Moved Permanently");
            header("Location: / ");
            exit();

        // CORRECION SEO 301
        else:
            // REVISAR 301 
            
        endif;

    endif;    

    // DERIVANDO SEGUN URL
    // URL PRODUCTOS
    if(strstr($path, '/ficha-producto.php')):

        # FICHA DE PRODUCTOS
        $path   = 'product-page';
        include 'themes/ficha-producto.php';

    else:

        switch ($path) {
            
            case '/':
                include 'themes/new.php';
                break;

            // LOGIN
            case '/login/':
                include 'themes/login.php';
                break;


            // PAGINAS
            case '/crear-pagina/':
                include 'themes/crear-pagina.php';
                break;
            case '/editar-pagina/':
                include 'themes/editar-pagina.php';
                break;    
            case '/list-servicios/':
                include 'themes/list-servicios.php';
                break;
            case '/list-articulos/':
                include 'themes/list-servicios.php';
                break;
            case '/categorias/':
                include 'themes/categorias.php';
                break;
                
            case '/opciones/':
                include 'themes/opciones.php';
                break;


            // AJAX
            case '/ajax/':
                include '_ajax.php';
                break;

            
     
            default: 
                $path_dinamic = 'si';
                break;

        } // FIN SWITCH


        // URLS DINAMICAS
        if(isset($path_dinamic)):

            if(strstr($path, '/tarea/')):
                include 'themes/tarea.php';

            elseif(strstr($path, '/buscador/')):
                include 'themes/buscador.php';

            elseif(strstr($path, '/editar-pagina/')):
                include 'themes/editar-pagina.php';

            elseif(strstr($path, '/eliminar-pagina/')):
                include 'themes/editar-pagina.php';

            elseif(strstr($path, '/categorias/')):
                include 'themes/categorias.php';

            elseif(strstr($path, '/list-servicios/')):
                include 'themes/list-servicios.php';

            elseif(strstr($path, '/list-articulos/')):
                include 'themes/list-articulos.php';

            else:
                
                //include 'themes/404.php';
                
            endif;

        endif;

   endif; // COMPROBACION SI ES PRODUCTO
   