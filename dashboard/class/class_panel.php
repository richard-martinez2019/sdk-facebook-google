<?php
class Panel {

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


    /*
     * URL
     * * * * * * * * * * * * * * * * * * * * * * */
    private function crearUrl($slug) {

        // CREANDO LAS URLS
        $slug   = str_replace(' ','-',
                    str_replace('/','-', 
                    str_replace('ñ','n', 
                    str_replace('á','a', 
                    str_replace('é','e', 
                    str_replace('í','i', 
                    str_replace('ó','o', 
                    str_replace('ú','u', 
                    strtolower(trim($slug))))))))));

        return $slug;

    }

    private function insUrls($categoria_id, $productos_id, $post_id, $comuna_id, $slug, $title, $description, $keywords) {
        
        // INSERTAR URLS
        $insertUrls    = $this->pdo->prepare("INSERT INTO Urls SET 
                categoria_id    = '".$categoria_id."',
                producto_id     = '".$productos_id."',
                post_id         = '".$post_id."',
                comuna_id       = '".$comuna_id."',
                url_slug        = '/".$slug."/',
                url_title       = '".$title."',
                url_metadescripcion = '".$description."',
                url_kw          = '".$keywords."'
            ");

        $insertUrls->execute();

    }

    private function editUrlsPost($categoria_id, $productos_id, $post_id, $comuna_id, $slug, $title, $description, $keywords) {
        
        // INSERTAR URLS
        $insertUrls    = $this->pdo->prepare("UPDATE Urls SET 
                categoria_id    = '".$categoria_id."',
                producto_id     = '".$productos_id."',
                post_id         = '".$post_id."',
                comuna_id       = '".$comuna_id."',
                url_slug        = '/".$slug."/',
                url_title       = '".$title."',
                url_metadescripcion = '".$description."',
                url_kw          = '".$keywords."'
                WHERE post_id = '".$post_id."'
            ");

        $insertUrls->execute();

    }

    /*
     * PAGINAS
     * * * * * * * * * * * * * * * * * * * * * * */

    // INSERTAR PAGINAS
    public function insPagina() {

        $h1         = trim($_POST['tituloh1']);
        $contenido  = trim($_POST['contenido']);
        $tipo       = trim($_POST['tipo']);
        $template   = trim($_POST['template']);
        $estado     = trim($_POST['estado']);

        if(isset($_POST['categorias']) && !empty($_POST['categorias'])):
            $categorias = trim($_POST['categorias']);
        else:
            $categorias = 'NULL';
        endif;


        $insPost = $this->pdo->prepare("INSERT INTO Post SET 
                usuario_id     = '100',
                post_h1         = '".$h1."',
                post_contenido  = '".$contenido."',
                post_tipo       = '".$tipo."',
                post_template   = '".$template."',
                post_estado     = '".$estado."'
            ");

        $insPost->execute();

        // SE OBTIENE EL ID DEL POST CREADO
        $idPost     = $this->pdo->lastInsertId();

        // LLAMANDO A LA FUNCION CREAR URLS
        $slug = $this->crearUrl($h1);
        
        // URLS
        $title      = trim($_POST['titleseo']);
        $metaSEO    = trim($_POST['metaseo']);
        $kw         = trim($_POST['kw']);


        // INSERTAR URLS
        $insertarUrls   = $this->insUrls('0', '0', $idPost, '0', $slug, $title, $metaSEO, $kw);

        return header("location: /editar-pagina/$idPost");

    }

    // UPDATE PAGINAS
    public function updPagina($id) {

        $h1         = trim($_POST['tituloh1']);
        $contenido  = trim($_POST['contenido']);
        $tipo       = trim($_POST['tipo']);
        $template   = trim($_POST['template']);
        $estado     = trim($_POST['estado']);
        $idPadre    = trim($_POST['padre']);
        $idUsuario  = trim($_SESSION['user_id']);

        if(!empty($_POST['categorias'])):
            $categorias = trim($_POST['categorias']);
        endif;

        if(empty($idPadre)):
            $idPadre    = '0';
        endif;


        $insPost = $this->pdo->prepare("UPDATE Post SET 
                usuario_id     = '".$idUsuario."',
                post_padre_id   = '".$idPadre."',
                post_h1         = '".$h1."',
                post_contenido  = '".$contenido."',
                post_tipo       = '".$tipo."',
                post_template   = '".$template."',
                post_estado     = '".$estado."'
                WHERE post_id = '".$id."'
                LIMIT 1
            ");

        $insPost->execute();


        if(isset($_POST['postrelacionados']) && !empty($_POST['postrelacionados'])):

            // BORRAR POST RELACIONADOS
            $eliminaPostRelacionados    = $this->pdo->prepare("DELETE FROM PostRelacionados 
                WHERE post_id = '".$id."' ");

            $eliminaPostRelacionados->execute();

            // CONTANDO TOTAL DE POST RELACIONADOS
            $totalPostRelacionados  = count($_POST['postrelacionados']);

            for ($i=0; $i < $totalPostRelacionados; $i++) { 
                

                // INSERTAR POST RELACIONADOS
                $postRelacionado = $this->pdo->prepare("INSERT INTO PostRelacionados SET
                    post_id             = '".$id."',
                    post_relacionado    = '".$_POST['postrelacionados'][$i]."'
                ");

                $postRelacionado->execute();
            }

        endif;

        // RELACIONANDO CATEGORIAS AL POST
        if(isset($_POST['categorias']) && !empty($_POST['categorias'])):

            // BORRAR CATEGORIAS RELACIONADOS
            $eliminaPostCategotias    = $this->pdo->prepare("DELETE FROM CategoriasPost 
                WHERE post_id = '".$id."' ");

            $eliminaPostCategotias->execute();

            // CONTANDO TOTAL DE CATEGORIAS RELACIONADOS
            $totalPostCategorias  = count($_POST['categorias']);

            for ($i=0; $i < $totalPostCategorias; $i++) { 

                // INSERTAR CATEGORIAS RELACIONADOS
                $postCategorias = $this->pdo->prepare("INSERT INTO CategoriasPost SET
                    post_id     = '".$id."',
                    categoria_id= '".$_POST['categorias'][$i]."'
                ");

                $postCategorias->execute();
            }

        endif;

        // LLAMANDO A LA FUNCION CREAR URLS
        $slug = $this->crearUrl($h1);
        
        // URLS
        $title      = trim($_POST['titleseo']);
        $metaSEO    = trim($_POST['metaseo']);
        $kw         = trim($_POST['kw']);

        // EDITAR URLS
        $editarUrls   = $this->editUrlsPost('0', '0', $id, '0', $slug, $title, $metaSEO, $kw);

        // CONTENIDO RELACIONADO
        if( isset($_POST['relacionado']) && !empty($_POST['relacionado']) ):
            
            // BORRAR POST RELACIONADOS
            $eliminaPostRelacionados    = $this->pdo->prepare("DELETE FROM ContenidoPost 
                WHERE post_id = '".$id."' ");

            $eliminaPostRelacionados->execute();

            $relacion = $this->pdo->prepare("INSERT INTO ContenidoPost SET
                            post_id                 = '".$id."',
                            contenido_post_titulo   = '".$_POST['titulorelacionado']."',
                            contenido_post_texto    = '".$_POST['relacionado']."'
                        ");
            $relacion->execute();

        endif;

        if(isset($_FILES['imagenprincipal'])):
            
            $stm = $this->pdo->prepare("DELETE FROM ImagenesPost 
                    WHERE post_id = '".$id."' ");
        
            $stm->execute();

            if(!empty($_FILES['imagenprincipal']['name'])):
                $tamano = $_FILES['imagenprincipal']['size']; // Leemos el tamaño del fichero 
                $tamaño_max="512000"; // Tamaño maximo permitido bytes
                if( $tamano < $tamaño_max): // Comprovamos el tamaño  
                    $destino = '../img/fotos_post' ; // Carpeta donde se guardata 
                    $sep=explode('image/',$_FILES["imagenprincipal"]["type"]); // Separamos image/ 
                    $tipo=$sep[1]; // Optenemos el tipo de imagen que es 
                    //echo $sep[1].' 2 '.$tipo;
                    if( $tipo == "jpg" || $tipo == "jpeg" ) { // Si el tipo de imagen a subir es el mismo de los permitidos, segimos. Puedes agregar mas tipos de imagen 
                        $destino = $destino.'/'.$slug.'-'.date('YmdHms').'.'.$tipo;
                        move_uploaded_file( $_FILES['imagenprincipal']['tmp_name'], $destino );  // Subimos el archivo 
                        $nombre_foto    = $slug.'-'.date('YmdHms').'.'.$tipo;

                        $subirFoto = $this->pdo->prepare("INSERT INTO ImagenesPost SET 
                                    usuario_id  = '".$idUsuario."',
                                    post_id     = '".$id."',
                                    imagen_post_nombre     = '".$nombre_foto."'
                                     ");

                        $subirFoto->execute();

                    } else {
                        $error_archivo = 'El tipo de Archivo no es de los permitidos (jpeg) ';
                    }
                else:
                    $error_archivo = 'El Archivo supera el peso permitido (jpeg) ';
                endif;
            else:
                $error_archivo = 'NO adjunto ninguna imagen para subir, por favor intentelo nuevamente ';
            endif;

        endif; 

        return header("location: /editar-pagina/$id");

    }

    // ELIMINAR FOTO 
    public function borrarFotoPost($id) {

        $stm = $this->pdo->prepare("DELETE FROM ImagenesPost 
                    WHERE post_id = '".$id."' ");

        $stm->execute();

    }

    // DUPLICAR PAGINAS
    public function duplicarPagina($id) {

        $buscarPost = $this->pdo->prepare("SELECT * FROM Post AS P
            INNER JOIN Urls AS U USING(post_id)
            WHERE post_id = '".$id."' "); 

        $buscarPost->execute();

        while ( $row = $buscarPost->fetch()) {

            $h1         = trim($row['post_h1']).' Copia';
            $contenido  = trim($row['post_contenido']);
            $tipo       = trim($row['post_tipo']);
            $template   = trim($row['post_template']);
            $idUsuario  = trim($_SESSION['user_id']);

            $insPost = $this->pdo->prepare("INSERT INTO Post SET 
                    usuario_id     = '".$idUsuario."',
                    post_h1         = '".$h1."',
                    post_contenido  = '".$contenido."',
                    post_tipo       = '".$tipo."',
                    post_template   = '".$template."',
                    post_estado     = 'borrador'
                ");

            $insPost->execute();

            // SE OBTINE EL ID DEL POST CREADO
            $idPost     = $this->pdo->lastInsertId();

            // LLAMANDO A LA FUNCION CREAR URLS
            $slug = $this->crearUrl($h1);
            
            // URLS
            $title      = trim($row['url_title']).' Copia';
            $metaSEO    = trim($row['url_metadescripcion']);
            $kw         = trim($row['url_kw']);

            // INSERTAR URLS
            $insertarUrls   = $this->insUrls('0', '0', $idPost, '0', $slug, $title, $metaSEO, $kw);

            return header("location: /editar-pagina/$idPost");

        }

    }

    // ELIMINAR POST
    public function eliminarPagina($id) {

        $deletePost     = $this->pdo->prepare("DELETE FROM Post 
            WHERE post_id = '".$id."'
            LIMIT 1 ");

        $deletePost->execute();

    }

    // PAGINA POR ID
    public function verPagina($id) {

        $verPost = $this->pdo->prepare("SELECT * FROM Post AS P
            INNER JOIN Urls AS U USING(post_id)
            LEFT JOIN ImagenesPost AS I USING(post_id)
            WHERE post_id = '".$id."' 
            LIMIT 1 ");

        $verPost->execute();

        while ( $row = $verPost->fetch()) {
            
            $this->datos[]  = $row;

        }
        
        return $this->datos;

    }

    // LISTAR PAGINAS
    public function listPaginas($estado='', $tipo) {

        switch ($estado) {
            case 'borrador':
                $estado     = 'AND post_estado = \'borrador\' '; 
                break;
            
            case 'publicado':
                $estado     = 'AND post_estado = \'publicado\' '; 
                break;

            case 'eliminado':
                $estado     = 'AND post_estado = \'eliminado\' '; 
                break;

            case 'programado':
                $estado     = 'AND post_estado = \'programado\' '; 
                break;

            default:
                # code...
                $estado     = 'AND post_estado != \'eliminado\' '; 
                break;
        }

        $qPost    = $this->pdo->prepare("SELECT * FROM Post AS P
            INNER JOIN Urls AS U USING(post_id)
            WHERE post_tipo = '".$tipo."'
            ".$estado."
            ORDER BY post_id DESC ");

        $qPost->execute();

        while ( $row = $qPost->fetch()) {
            
            $this->datos[]  = $row;

        }
        
        return $this->datos;


    }


    // POST RELACIONADOS
    public function postRelacionados($id) {

        $postRel    = $this->pdo->prepare("SELECT * FROM PostRelacionados
            WHERE post_id = '".$id."' ");

        $postRel->execute();

        while ( $row = $postRel->fetch()) {
            
            $this->datos[]  = $row['post_relacionado'];

        }
        
        return $this->datos;

    }

    // PREGUNTA RELACIONADOS
    public function getPreguntasPost($idPost, $idPregunta) {

        $postRel    = $this->pdo->prepare("SELECT * FROM PostRelacionados
            WHERE post_id = '".$idPost."' 
            AND post_relacionado = '".$idPregunta."' ");

        $postRel->execute();

        while ( $row = $postRel->fetch()) {
            
            $this->datos[]  = $row['post_relacionado'];

        }
        
        return $this->datos;

    }

    /*
     * CATEGORIAS
     * * * * * * * * * * * * * * * * * * * * * * */

    // INSERTAR CATEGORIAS
    public function insCategoria() {

        $nombre     = trim($_POST['categoria']);
        $contenido  = trim($_POST['contenido']);
        $padre      = trim($_POST['categoriapadre']);
        //$imagen     = trim($_POST['']);

        $insCat = $this->pdo->prepare("INSERT INTO Categorias SET 
                usuario_id          = '".trim($_SESSION['user_id'])."',
                categoria_nombre    = '".utf8_decode($nombre)."',
                categoria_contenido = '".utf8_decode($contenido)."',
                categoria_estado    = 'publicado'
            ");

        
        $insCat->execute();

        // SE OBTINE EL ID DEL POST CREADO
        $idCategoria = $this->pdo->lastInsertId();

        // REGISTRAR LA CATEGORIA PADRE
        if(!empty($padre)):

            // CONTANDO TOTAL DE POST RELACIONADOS
            $totalPostRelacionados  = count($_POST['categoriapadre']);

            for ($i=0; $i < $totalPostRelacionados; $i++) { 

                // INSERTAR POST RELACIONADOS
                $insCatPadre = $this->pdo->prepare("INSERT INTO CategoriasParientes SET 
                    categoria_id          = '".$idCategoria."',
                    categoria_padre_id    = '".$padre[$i]."'
                ");
            
                $insCatPadre->execute();

            }
            

        endif;

        // LLAMANDO A LA FUNCION CREAR URLS
        $slug = $this->crearUrl($nombre);
        
        // URLS
        $title      = $nombre;
        $metaSEO    = $nombre;
        $kw         = $nombre;

        // INSERTAR URLS
        $insertarUrls   = $this->insUrls($idCategoria, '0', '0', '0', $slug, $title, $metaSEO, $kw);

        return header("location: /categorias/editar/$idCategoria");


    }

    // ACTUALIZAR CATEGORIA
    public function updCategoria($id) {

        $actualizarCategoria     = $this->pdo->prepare("UPDATE Categorias SET
            categoria_contenido = '".trim($_POST['contenido'])."',
            categoria_nombre    = '".trim($_POST['tituloh1'])."'
            WHERE categoria_id = '".$id."'
            LIMIT 1 ");

        $actualizarCategoria->execute();

    }

    // ELIMINAR CATEGORIA
    public function eliminarCategoria($id) {

        $deleteCategoria     = $this->pdo->prepare("DELETE FROM Categorias 
            WHERE categoria_id = '".$id."'
            LIMIT 1 ");

        $deleteCategoria->execute();

    }

    // VER CATEGORIA
    public function verCategoria($id) {

        $actualizarCategoria     = $this->pdo->prepare("SELECT * FROM Categorias 
            INNER JOIN Urls AS U USING(categoria_id)
            WHERE categoria_id = '".$id."'
            LIMIT 1 ");

        $actualizarCategoria->execute();

        while ( $row = $actualizarCategoria->fetch()) {
            
            $this->datos[]  = $row;

        }
        
        return $this->datos;

    }

    // PREGUNTA RELACIONADOS
    public function getCategoriasPost($idPost, $idCategoria) {

        $postRel    = $this->pdo->prepare("SELECT * FROM CategoriasPost
            WHERE post_id = '".$idPost."' 
            AND categoria_id = '".$idCategoria."' ");

        $postRel->execute();

        while ( $row = $postRel->fetch()) {
            
            $this->datos[]  = $row['categoria_id'];

        }
        
        return $this->datos;

    }

    // LISTAR CATEGORIAS
    public function listCategorias($estado='') {

        switch ($estado) {
            case 'borrador':
                $estado     = 'WHERE categoria_estado = \'borrador\' '; 
                break;
            
            case 'publicado':
                $estado     = 'WHERE categoria_estado = \'publicado\' '; 
                break;

            case 'eliminado':
                $estado     = 'WHERE categoria_estado = \'eliminado\' '; 
                break;

            default:
                # code...
                $estado     = ''; 
                break;
        }

        $qCategorias    = $this->pdo->prepare("SELECT * FROM Categorias AS C
            INNER JOIN Urls AS U USING(categoria_id)
            ".$estado." ");

        $qCategorias->execute();

        while ( $row = $qCategorias->fetch()) {
            
            $this->datos[]  = $row;

        }
        
        return $this->datos;


    }

        
}