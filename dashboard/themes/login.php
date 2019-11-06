<?php

	// COMPROBANDO SI EL PATH ES UNA PAGINA DE LOGIN
	if( strstr($path, '/login/') ):
		$login 	= true;
	endif;


	// RECUPERAR CONTRASEÑA
    if( strstr($path, 'recuperar') && !empty($_POST['recuperarEmail']) ):

        $recuperarClave = new Login();
        $recuperarClave = $recuperarClave->updClave($_POST['recuperarEmail'], $dominio);

    elseif(isset($_GET['tocken']) && !empty($_GET['tocken']) && !empty($_POST['inputPassword1']) & !empty($_POST['inputPassword2'])):

        if($_POST['inputPassword1']==$_POST['inputPassword2']):

            $claveNueva     = new Login();
            $claveNueva     = $claveNueva->updClaveTocken($_GET['tocken']);     

        else:

            $error = '<strong>Error!</strong> Las Claves NO coinciden, intentalo nuevamente.';

        endif;

    // INICIAR SESION
    elseif(isset($_POST['ingresar']) && !empty($_POST['email']) && !empty($_POST['password'])):

        $usuario = new Login();
        $usuario = $usuario->geLoginUsuario();
        
        if(is_array($usuario)):

            // CREAR SESSIONES DE USUARIO
            foreach ($usuario as $usua):
                $_SESSION['user_id']        = $usua['usuario_id'];
                $_SESSION['user_nombre']    = $usua['usuario_nombre'];
                $_SESSION['user_permiso']   = $usua['permiso_id'];
            endforeach;

            // SESION INICIADA Y VOLVER AL PANEL DE ADMINISTRACION
            if(isset($_SESSION['user_id']) && isset($_SESSION['user_nombre']) && isset($_SESSION['user_permiso'])):

                return header("location: /");

            else:
                // ERROR AL INICIAR LA SESION
                $error = '<strong>Error!</strong>: Tenemos un problema con el inicio de sesión, intente nuevamente';

            endif;

        // ERROR: EL CORREO NO EXISTE
        elseif ($usuario=='no_existe_correo'):

            $error = '<strong>Error!</strong>: Su correo '.$_POST['email'].' NO se encuentra Registrado';

        // ERROR: LA CONTRASEÑA ES INVALIDAD
        elseif ($usuario=='no_password'): 

            $error = '<strong>Error!</strong>: Su Contraseña NO es correcta. Si ha olvidado su Contraseña contacte a Soporte';

        else:
            // PENDIENTE ????
            echo "NO HAY ARRAY NI SALIDA DE ERROR ".$usuario;

        endif;

    endif;


	// ASIGNANDO ESTILO AL BODI PARA LA PAGINA DE LOGIN
	$css_body 	= 'authentication-bg';
    
    include '_header.php'; ?>

	 <div class="account-pages mt-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 pl-3 pr-3">
                        <div class="card">

                        	<?php if( isset($error) && !empty($error) ): ?>
								<div class="alert alert-danger mb-0" role="alert" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
				                    <?php echo $error; ?>
				                </div>
							<?php endif; ?>

                            <!-- Logo -->
                            <div class="card-header pt-3 pb-3 text-center bg-colorido">
                                <a href="/login/">
                                    <span><img src="https://o.hostinggratis.cl/images/logo-webyseo-blanco.svg" alt="" height="32"></span>
                                </a>
                            </div>

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 font-weight-bold">¡Bienvenid@s!</h4>
                                    <p class="text-muted mb-4">CMS - Propio!</p>
                                </div>

                                <form method="post">
                                	<?php if( strstr($path, 'recuperar') ): ?>
                            		<div class="form-group">
                                        <label for="recuperarEmail">Email</label>
                                        <input class="form-control" type="email" name="recuperarEmail" required="" placeholder="Ingresa tu email" autofocus="on">
                                    </div>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary" type="submit" name="ingresar"> Recuperar Password </button>
                                    </div>
                                    <?php elseif( strstr($path, 'envioclave') ): ?>
                                    	<div class="alert alert-success mb-0" role="alert">
						                    <strong>Felicidades</strong> hemos enviado un correo para que pueda recuperar su Contraseña.
						                </div>
					                <?php elseif( strstr($path, 'tocken') ): ?>
                                    	<div class="alert alert-success mb-3" role="alert">
						                    <strong>Felicidades</strong> escribe tu nueva Contraseña.
						                </div>
						                <div class="form-group">
	                                        <label for="inputPassword1">Password</label>
	                                        <input class="form-control" type="password" required="" name="inputPassword1" placeholder="Contraseña nueva" autofocus="on">
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="inputPassword2">Repetir Password</label>
	                                        <input class="form-control" type="password" required="" name="inputPassword2" placeholder="Repite tu Contraseña">
	                                    </div>
	                                    <div class="form-group mb-0 text-center">
	                                        <button class="btn btn-primary" type="submit" name="ingresar"> Cambiar Password </button>
	                                    </div>

                            		<?php else: ?>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" type="email" name="email" required="" placeholder="Ingresa tu email" autofocus="on">
                                    </div>

                                    <div class="form-group">
                                        <a href="/login/recuperar" class="text-muted float-right"><small>Recuperar contrseña?</small></a>
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" required="" name="password" placeholder="Ingresa tu contraseña">
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                        	<!--
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                            <label class="custom-control-label" for="checkbox-signin">Remember me</label> -->
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary" type="submit" name="ingresar"> Entrar </button>
                                    </div>
                                	<?php endif; ?>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                        <!-- PRONTO HABILITAR SOLICITAR ACCESO
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Don't have an account? <a href="pages-register.html" class="text-muted ml-1"><b>Sign Up</b></a></p>
                            </div> <!- end col ->
                        </div>
                        <!- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            2017 - 2019 © WebySEO - webyseo.cl
        </footer>

        <!-- App js -->
        <script src="/js/app.min.js"></script>
    </body>
</html>