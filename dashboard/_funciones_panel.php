<?php
	

	$url_principal 	= 'https://' . $_SERVER["HTTP_HOST"];
	$slug 			= $_SERVER["REQUEST_URI"];
	$url_actual 	= $url_principal.$slug;
	$url_dominio 	= str_replace('dashboard.', '', $url_principal);
	
	function btnes($url,$tipo) {

		switch ($tipo) {
			case 'editar':
				# code...
				$icono 	= 'mdi-lead-pencil';
				$color 	= 'btn-warning';
				break;
			
			case 'eliminar':
				# code...
				$icono 	= 'mdi-delete-forever';
				$color 	= 'btn-danger';
				break;

			case 'duplicar':
				# code...
				$icono 	= 'mdi-content-copy';
				$color 	= 'btn-info';
				break;
			
			
			default:
				# code...
				break;
		}

		echo '<a class="btn '.$color.' btn-rounded" href="'.$url.'">
        <i class="mdi '.$icono.' mr-1"></i> 
        <span>'.ucfirst($tipo).'</span> </a>';

	}


	function obtenerValor($opcion) {		

		$informacion    = new Opciones();
    	$informacion    = $informacion->getValorOpcion($opcion);

    	echo utf8_encode($informacion);

	}