<?php 
    
    if(strstr($path, '/eliminar/') ):
        $idCategoria         = str_replace('/categorias/eliminar/','',$path);
        $updateCategoria     = new Panel();
        $updateCategoria     = $updateCategoria->eliminarCategoria($idCategoria);
        
        // RETORNAR A LA PAGINA ANTERIOR
        return header("location: ".$_SERVER['HTTP_REFERER']." ");

    elseif(strstr($path, '/editar/') ):

        $idCategoria         = str_replace('/categorias/editar/','',$path);
        
        if( isset($_POST['actualizarpost']) && 
             isset($idCategoria) && !empty($idCategoria) && is_numeric($idCategoria) ):

            $updateCategoria     = new Panel();
            $updateCategoria     = $updateCategoria->updCategoria($idCategoria);

        endif;
        
        // EXISTE EDITAR
        $editar     = true;

        $verCategoria     = new Panel();
        $verCategoria     = $verCategoria->verCategoria($idCategoria);

        if( is_array($verCategoria) && !empty($verCategoria) ):
            foreach ($verCategoria as $p):

                $categoria_id   = $p['categoria_id'];
                $url            = $p['url_slug'];
                $titulo_h1      = $p['categoria_nombre'];
                $contenido      = $p['categoria_contenido'];
                $estado         = $p['categoria_estado'];

            endforeach;
        endif;

    endif;

    if(isset($_POST['crearCategoria']) && !empty($_POST['categoria']) ):

        $crearCategoria     = new Panel();
        $crearCategoria     = $crearCategoria->insCategoria();

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
                    <h4 class="page-title">Categorias</h4>
                </div>
            </div>
        </div>  
        <!-- end page title --> 
        <?php if(isset($editar)): ?>
        <form class="row" action="" method="post"  enctype="multipart/form-data">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <input type="text" name="tituloh1" class="form-control" placeholder="TITULO" required="" value="<?php echo $titulo_h1; ?>">
                        <p class="text-muted font-13 mt-1">URL: <a href="<?php echo $url_dominio. $url; ?>" target="_blank"><?php echo $url; ?></a></p>

                        <?php 
                        $listaCategorias = new Panel();
                        $listaCategorias = $listaCategorias->listCategorias('publicado'); 
                        
                        if (is_array($listaCategorias) && !empty($listaCategorias)):  ?>
                        <select class="form-control mb-3" name="categoriapadre">
                            <option value="">-- Elige una Categoria Padre --</option>
                            <?php foreach ($listaCategorias as $sc): ?>
                                <option value="<?php echo $sc['categoria_id']; ?>"><?php echo $sc['categoria_nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php endif; ?>

                        <!-- basic summernote-->
                        <textarea  id="summernote-basic" name="contenido" class="summernote" required="">
                            <?php echo $contenido; ?>
                        </textarea>

                         <div class="text-right mt-3 mb-2">
                            <button type="submit" name="actualizarpost" class="btn btn-primary">Actualizar</button>
                        </div>

                    </div>
                </div>

            </div>
        </form>


        <?php else: ?>
        <div class="row">
        	<div class="col-7">
        		<div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Categorias</h4>

                        <div class="table-responsive">
                            <table class="table table-hover table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Creada</th>
                                        <th>Activa?</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <?php 

                                $listaCategorias = new Panel();
                                $listaCategorias = $listaCategorias->listCategorias();
                                
                                if (is_array($listaCategorias) && !empty($listaCategorias)): ?>
                                <tbody>
                                    <?php foreach ($listaCategorias as $c): ?>
                                    <tr>
                                        <td><?php echo $c['categoria_nombre']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($c['categoria_creada'])); ?></td>
                                        <td>
                                            <input type="checkbox" id="switch<?php echo $c['categoria_id']; ?>" <?php if($c['categoria_estado']=='publicado'): ?>checked=""<?php endif; ?> data-switch="success">
                                            <label for="switch<?php echo $c['categoria_id']; ?>" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                        </td> 
                                        <td>
                                            <?php btnes('/categorias/editar/'.$c['categoria_id'].'','editar'); ?>
                                            <?php btnes('/categorias/eliminar/'.$c['categoria_id'].'','eliminar'); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <?php endif; ?>
                            </table>
                        </div> <!-- end table responsive-->
                    </div> <!-- end col-->
                </div> <!-- end row-->
        	</div>
        	<form method="post" class="col-lg-6 col-xl-5">
        		<div class="card">
        			<div class="card-body">

        				<h4 class="header-title mb-3">Crear Categoria</h4>

        				<div class="row mb-2 align-items-center">
        					<h4 class="header-title col-4 mb-0">Nombre</h4>
            				<div class="col-8">
            					<input type="text" name="categoria" class="form-control" required="">
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <h4 class="header-title col-4 mb-0">Descripción</h4>
                            <div class="col-8">
                                <textarea class="form-control" name="contenido" rows="6" placeholder="Descripción corta"></textarea>
                            </div>
                        </div>
                        <?php 
                        $listaCategorias = new Panel();
                        $listaCategorias = $listaCategorias->listCategorias('publicado'); 
                        
                        if (is_array($listaCategorias) && !empty($listaCategorias)):  ?>
                        <div class="row mb-2 align-items-center">
                            <h4 class="header-title col-4 mb-0">Padre</h4>
                            <div class="col-8">
                                <select class="form-control" name="categoriapadre">
                                    <option value="">-- Elige una Categoria Padre --</option>
                                    <?php foreach ($listaCategorias as $sc): ?>
                                        <option value="<?php echo $sc['categoria_id']; ?>"><?php echo $sc['categoria_nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="row mb-2 align-items-center">
        					<h4 class="header-title col-4 mb-0">Imagen</h4>
            				<div class="col-8">
                				<div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imgCategoria" name="imgCategoria">
                                        <label class="custom-file-label" for="imgCategoria">Elija un Archivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2 align-items-center">
                        	<div class="col-11">
                            	<div class="text-right mt-3">
									<button type="submit" name="crearCategoria" class="btn btn-primary">Guardar</button>
								</div>
							</div>
						</div>

        			</div>
        		</div>
            </form>
        </div>
        <?php endif; ?>
        
    </div> <!-- container -->

<!-- Footer Start -->
<?php include '_footer.php';
          