<?php 
    
    // ELIMINAR FOTOS
    if(strstr($path, '/eliminar-foto/')):   

        $idProducto     = str_replace('/editar-pagina/eliminar-foto/','',$path);         

        $eliminarFoto = new Panel();
        $eliminarFoto = $eliminarFoto->borrarFotoPost($idProducto);

        // RETORNAR A LA PAGINA ANTERIOR
        return header("location: ".$_SERVER['HTTP_REFERER']." ");
    
    elseif(strstr($path, '/eliminar-pagina/') ):

        $idPost         = str_replace('/eliminar-pagina/','',$path);
        $updatePost     = new Panel();
        $updatePost     = $updatePost->eliminarPagina($idPost);

        
        // RETORNAR A LA PAGINA ANTERIOR
        return header("location: ".$_SERVER['HTTP_REFERER']." ");

    
    elseif( strstr($path, '/editar-pagina/') ):

        $idPost     = str_replace('/editar-pagina/','',$path);

        // GUARDAR EDICION DEL POST
        if( isset($_POST['actualizarpost']) && 
             isset($idPost) && !empty($idPost) && is_numeric($idPost) ):

            $updatePost     = new Panel();
            $updatePost     = $updatePost->updPagina($idPost);

        endif;

    endif;



    // VER POST PARA EDITAR
    if( isset($idPost) && !empty($idPost) && is_numeric($idPost) ):

        $verPost     = new Panel();
        $verPost     = $verPost->verPagina($idPost);

        if( is_array($verPost) && !empty($verPost) ):
            foreach ($verPost as $p):

                $padre_id       = $p['post_padre_id'];
                $titulo_h1      = $p['post_h1'];
                $contenido      = $p['post_contenido'];
                $tipo           = $p['post_tipo'];
                $estado         = $p['post_estado'];
                $url            = $p['url_slug'];
                $title          = $p['url_title'];
                $metaseo        = $p['url_metadescripcion'];
                $kw             = $p['url_kw'];
                $plantilla      = $p['post_template'];
                $foto           = $p['imagen_post_nombre'];

            endforeach;
        endif;

    endif;


    include '_header.php';

    ?>
    <!-- Start Content-->
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <?php include 'inc/_ruta.php'; ?>
                    <h4 class="page-title">Editando: <?php echo $titulo_h1; ?></h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <form class="row" action="" method="post"  enctype="multipart/form-data">
        	<div class="col-8">
        		<div class="card">
        			<div class="card-body">

        				<input type="text" name="tituloh1" class="form-control" placeholder="TITULO" required="" value="<?php echo $titulo_h1; ?>">
        				<p class="text-muted font-13 mt-1">URL: <a href="<?php echo $url_dominio. $url; ?>" target="_blank"><?php echo $url; ?></a></p>

        				<!-- basic summernote-->
                        <textarea  id="summernote-basic" name="contenido" class="summernote" required="">
                            <?php echo $contenido; ?>
                        </textarea>

                        <?php 

                        // LAS PREGUNTAS
                        $listaServicios = new Panel();
                        $listaServicios = $listaServicios->listPaginas('publicado','articulo'); 

                        //print_r($listaServicios);

                        // SI EXISTEN PREGUNTAS
                        if (is_array($listaServicios) && !empty($listaServicios)):  ?>
                        <div class="row mt-4 mb-2 align-items-center">
                            <h4 class="header-title col-auto mb-0 pr-0">Preguntas Frecuentes</h4>
                            <div class="col">
                                <select class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." name="postrelacionados[]">
                                <?php //RECORREMOS LAS PREGUNTAS
                                foreach ($listaServicios as $ls):

                                    // PREGUNTA ACTUAL
                                    $idPregunta     = $ls['post_id'];
                                    
                                    // CONSULTA 
                                    $preguntasDelPost = new Panel();
                                    $preguntasDelPost = $preguntasDelPost->getPreguntasPost($idPost,$idPregunta);

                                    // SI EXISTE LA PREGUNTA SELECCIONADA EN EL POST
                                    if( is_array($preguntasDelPost) && !empty($preguntasDelPost) ): 
                                        
                                        // LA PREGUNTA SE MUESTRA SELECCIONADA ?>
                                        <option value="<?php echo $ls['post_id']; ?>" selected="selected"><?php echo $ls['post_h1']; ?></option>
                                    
                                    <?php // NO EXISTE LA PREGUNTA
                                    else: 
                                        // LA PREGUNTA NO SE MUESTRA SELECCIONADA ?>
                                        <option value="<?php echo $ls['post_id']; ?>"><?php echo $ls['post_h1']; ?></option>
                                    
                                    <?php endif;
                                endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php endif;?>                        
                        <!--
                        <div class="text-right mt-3 mb-2">
                            <button type="submit" name="actualizarpost" class="btn btn-primary">Actualizar</button>
                        </div> -->
        			</div>
        		</div>

                 <div class="card">
                    <div class="card-body">
                    <?php

                    // MOSTRAR CONTENIDO RELACIONADO
                    $contenidoRelacionado = new Web();
                    $contenidoRelacionado = $contenidoRelacionado->mostrarContenidoPost($idPost); 
                    
                    if( is_array($contenidoRelacionado) & !empty($contenidoRelacionado) ): 
                        foreach ($contenidoRelacionado as $cr):
                            $tituloRelacionado          = $cr['contenido_post_titulo'];
                            $contenidoPostRelacionado   = $cr['contenido_post_texto'];
                        endforeach;
                    endif; ?>
                        <h4 class="header-title pl-0 mb-2">CONTENIDO RELACIONADO</h4>
                        <input type="text" name="titulorelacionado" class="form-control mb-2" placeholder="Titulo Contenido Extra" value="<?php if(isset($tituloRelacionado) && !empty($tituloRelacionado)): echo $tituloRelacionado; endif; ?>">

                        <textarea class="form-control" placeholder="Cualquier contenido extra" name="relacionado"><?php if(isset($contenidoPostRelacionado) && !empty($contenidoPostRelacionado)): echo $contenidoPostRelacionado; endif; ?></textarea>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        
                        <h4 class="header-title pl-0 mb-2">SEO</h4>

                        <input type="text" name="titleseo" class="form-control mb-2" placeholder="TITULO" maxlength="90" value="<?php echo $title; ?>">

                        <textarea name="metaseo" placeholder="META DESCRIPCION" class="form-control mb-2" maxlength="155"><?php echo $metaseo; ?></textarea>

                        <input type="text" name="kw" class="form-control mb-2" placeholder="PALABRA CLAVE" maxlength="90" value="<?php echo $kw; ?>">

                        <div class="text-right mt-3 mb-2">
                            <button type="submit" name="actualizarpost" class="btn btn-primary">Actualizar</button>
                        </div>

                    </div>
                </div>

        	</div>
        	<div class="col-4">
        		<div class="card">
        			<div class="card-body">
        				<div class="row mb-2 align-items-center">
        					<h4 class="header-title col-4 mb-0">Tipo</h4>
            				<div class="col-8">
                				<select class="form-control" name="tipo" required="">
                					<option value="">-- Tipo --</option>
                                    <option <?php if($tipo=='pagina'): ?>selected="selected"<? endif; ?> value="pagina">Servicio</option>
                                    <option <?php if($tipo=='articulo'): ?>selected="selected"<? endif; ?> value="articulo">Articulo</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
        					<h4 class="header-title col-4 mb-0">Estado</h4>
            				<div class="col-8">
                				<select class="form-control" name="estado" required="">
                					<option value="">-- Estado --</option>
                                    <option <?php if($estado=='>borrador'): ?>selected="selected"<? endif; ?> value="borrador">Borrador</option>
                                    <option <?php if($estado=='publicado'): ?>selected="selected"<? endif; ?> value="publicado">Publicado</option>
                                    <option <?php if($estado=='eliminado'): ?>selected="selected"<? endif; ?> value="eliminado">Eliminado</option>
                                    <option <?php if($estado=='programar'): ?>selected="selected"<? endif; ?> value="programado">Programar</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
        					<h4 class="header-title col-4 mb-0">Página Padre</h4>
            				<div class="col-8">
                                <?php 
                                $listaPaginas = new Panel();
                                $listaPaginas = $listaPaginas->listPaginas('publicado','pagina'); 
                                if(is_array($listaPaginas) && !empty($listaPaginas)): ?>
                				<select class="form-control" name="padre">
                					<option value="">-- Páginas --</option>
                                    <?php foreach ($listaPaginas as $ls): ?>
                                        <option value="<?php echo $ls['post_id']; ?>" <?php if($padre_id==$ls['post_id']): ?>selected="selected"<?php endif; ?>><?php echo $ls['post_h1']; ?></option>
                                    <?php endforeach; ?> 
                                </select>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <h4 class="header-title col-4 mb-0">Template</h4>
                            <div class="col-8">
                                <select class="form-control" name="template">
                                    <option value="">-- Plantilla --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
        					<h4 class="header-title col-4 mb-0 pr-0">Categorias</h4>
            				<div class="col-8">
                                <?php 
                                $listaCategorias = new Panel();
                                $listaCategorias = $listaCategorias->listCategorias('publicado'); 
                                
                                if (is_array($listaCategorias) && !empty($listaCategorias)):  ?>
                                <select class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" name="categorias">
                                <?php foreach ($listaCategorias as $sc): 
                                    // PREGUNTA ACTUAL
                                    $idCategoria     = $sc['categoria_id'];
                                    
                                    // CONSULTA 
                                    $categoriasDelPost = new Panel();
                                    $categoriasDelPost = $categoriasDelPost->getCategoriasPost($idPost,$idCategoria);

                                    // SI EXISTE LA PREGUNTA SELECCIONADA EN EL POST
                                    if( is_array($categoriasDelPost) && !empty($categoriasDelPost) ): 
                                        
                                        // LA PREGUNTA SE MUESTRA SELECCIONADA ?>
                                        <option value="<?php echo $sc['categoria_id']; ?>" selected="selected"><?php echo $sc['categoria_nombre']; ?></option>
                                    
                                    <?php // NO EXISTE LA PREGUNTA
                                    else: 
                                        // LA PREGUNTA NO SE MUESTRA SELECCIONADA ?>
                                        <option value="<?php echo $sc['categoria_id']; ?>"><?php echo $sc['categoria_nombre']; ?></option>
                                    
                                    <?php endif; 
                                endforeach; ?>
                                </select>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
        					<h4 class="header-title col-4 mb-0">Imagen</h4>
            				<div class="col-8">
                                <?php if(!empty($foto)): ?>
                                    <img src="http://accionesjudiciales.hostinggratis.cl/img/fotos_post/<?php echo $foto; ?>" class="img-fluid mb-3">
                                    <?php btnes('/editar-pagina/eliminar-foto/'.$idPost.'','eliminar'); ?>
                                <?php else: ?>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imagenprincipal" name="imagenprincipal">
                                        <label class="custom-file-label" for="imagenprincipal">Elija un Archivo</label>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
        			</div>
        		</div>
        	</div>
        </form>
        
    </div> <!-- container -->

</div> <!-- content -->

<!-- Footer Start -->
<?php include '_footer.php';