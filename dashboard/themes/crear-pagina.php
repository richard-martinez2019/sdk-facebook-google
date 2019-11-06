<?php     

    if( isset($_POST['guardarpost']) ):

        $crearPost     = new Panel();
        $crearPost     = $crearPost->insPagina();

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
                    <h4 class="page-title">Pagina en Blanco</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <form class="row" action="" method="post"  >
            <div class="col-8">
                <div class="card">
                    <div class="card-body">

                        <input type="text" name="tituloh1" class="form-control" placeholder="TITULO" required="">
                        <p class="text-muted font-13 mt-1">URL: /titulo/</p>

                        <!-- basic summernote-->
                        <textarea  id="summernote-basic" name="contenido" class="summernote" required=""></textarea>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        
                        <h4 class="header-title pl-0 mb-2">SEO</h4>

                        <input type="text" name="titleseo" class="form-control mb-2" placeholder="TITULO" maxlength="90">

                        <textarea name="metaseo" placeholder="META DESCRIPCION" class="form-control mb-2" maxlength="155"></textarea>

                        <input type="text" name="kw" class="form-control mb-2" placeholder="PALABRA CLAVE" maxlength="90">

                        <div class="text-right mt-3 mb-2">
                            <button type="submit" name="guardarpost" class="btn btn-primary">Guardar</button>
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
                                    <option value="pagina">Servicio</option>
                                    <option value="articulo">Articulo</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <h4 class="header-title col-4 mb-0">Estado</h4>
                            <div class="col-8">
                                <select class="form-control" name="estado" required="">
                                    <option value="">-- Estado --</option>
                                    <option value="borrador">Borrador</option>
                                    <option value="publicado">Publicado</option>
                                    <option value="eliminado">Eliminado</option>
                                    <option value="programado">Programar</option>
                                </select>
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
                                <select class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." name="categorias">
                                    <option value="">Select</option>
                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                        <option value="AK">Alaska</option>
                                        <option value="HI">Hawaii</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <h4 class="header-title col-4 mb-0">Imagen</h4>
                            <div class="col-8">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imagenprincipal" name="imagenprincipal">
                                        <label class="custom-file-label" for="imagenprincipal">Elija un Archivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    </div> <!-- container -->

    <!-- Footer Start -->
    <?php include '_footer.php';             