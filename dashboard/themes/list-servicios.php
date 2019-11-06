<?php 

    $listaServicios = new Panel();
    if( $path == '/list-servicios/' ):

        $listaServicios = $listaServicios->listPaginas('','pagina'); 
        $title          =  'Servicios';

    elseif( $path == '/list-articulos/' ):

        $listaServicios = $listaServicios->listPaginas('','articulo'); 
        $title          =  'Articulos';

    endif;

    // DUPLICAR POST
    if( isset($_GET['duplicar']) && 
         isset($_GET['post']) && !empty($_GET['post']) && is_numeric($_GET['post']) ):

        $duplicarPost     = new Panel();
        $duplicarPost     = $duplicarPost->duplicarPagina($_GET['post']);

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
                    <h4 class="page-title">Paginas de <?php echo $title; ?></h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <div class="row">
        	<div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3"><?php echo $title; ?></h4>

                        <div class="table-responsive">
                            <table class="table table-hover table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Categoria</th>
                                        <th>Activa?</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <?php 
                                
                                if (is_array($listaServicios) && !empty($listaServicios)):  ?>
                                <tbody>
                                    <?php foreach ($listaServicios as $ls): ?>
                                    <tr>
                                        <td><?php echo $ls['post_h1']; ?></td>
                                        <td>
                                            <span class="badge badge-primary">sin categorias</span>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="switch<?php echo $ls['post_id']; ?>" <?php if($ls['post_estado']=='publicado'): ?>checked=""<?php endif; ?> data-switch="success">
                                            <label for="switch<?php echo $ls['post_id']; ?>" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                        </td> 
                                        <td>
                                            <?php btnes('/editar-pagina/'.$ls['post_id'].'','editar'); ?>
                                            <?php btnes('?duplicar=true&post='.$ls['post_id'].'','duplicar'); ?>
                                            <?php btnes('/eliminar-pagina/'.$ls['post_id'].'','eliminar'); ?>
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


        </div>
        
    </div> <!-- container -->

    <!-- Footer Start -->
    <?php include '_footer.php';