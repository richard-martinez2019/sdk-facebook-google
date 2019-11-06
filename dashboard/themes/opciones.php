<?php 
    
    if(isset($_POST) && !empty($_POST)):

        foreach ($_POST as $clave => $valor) {

            $actualizarOpciones     = new Opciones();
            $actualizarOpciones     = $actualizarOpciones->updOpciones($clave, $valor);

        }

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
                    <h4 class="page-title">Opciones Generales</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
        <div class="row">
            <div class="col-md-10 col-xl-6">
                <form method="post">
                    <div class="form-group row align-items-center">
                        <label for="telefono_1" class="col-sm-3 col-form-label">Teléfono </label>
                        <div class="col-sm-9">
                            <input type="text" name="telefono_1" class="form-control" placeholder="41000000" value="<?php obtenerValor('telefono_1');?>">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="telefono_1" class="col-sm-3 col-form-label">Teléfono 2</label>
                        <div class="col-sm-9">
                            <input type="text" name="telefono_2" class="form-control" placeholder="41000000" value="<?php obtenerValor('telefono_2');?>">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="whatsapp" class="col-sm-3 col-form-label">Whatsapp</label>
                        <div class="col-sm-9">
                            <input type="text" name="whatsapp" class="form-control" placeholder="900110011" value="<?php obtenerValor('whatsapp');?>">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" name="email" class="form-control" placeholder="email@example.com" value="<?php obtenerValor('email');?>">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="text_footer" class="col-sm-3 col-form-label">Texto Footer</label>
                        <div class="col-sm-9">
                            <input type="text" name="text_footer" class="form-control" placeholder="Texto de footer del sitio web" value="<?php obtenerValor('text_footer');?>">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="offset-3 col-sm-9">
                            <button type="submit" class="o btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div> <!-- container -->

    <!-- Footer Start -->
    <?php include '_footer.php';                