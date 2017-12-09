<?php
	//var_dump($opciones_busqueda);

//echo $opciones_busqueda["id_forma_entrega"]
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link   type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.css" rel="stylesheet" /> 

<style type="text/css">
#buscar{
	border-radius: 3px;
    position: relative;
    padding: 15px 5px;
    /*margin: 0 0 10px 10px;*/
    min-width: 80px;
    height: 80px;
    text-align: center;
    color: #FFF;
    font-weight: bold;
    
    border: 1px solid #244f73; 
    font-size:18px;
    margin-top: 20px
}

.label{
	font-size: 85%;
}

</style>


<?php if(isset($texto_filtros)): ?>

<div class=" "  style=" margin: 0px 20px 20px 20px;"  >
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $texto_filtros; ?>
</div>

<? endif; ?>

<div class="row" style="background-color: rgb(252, 224, 40); margin: 0px 20px 20px 20px; border-radius:4px; border:1px solid #d8c02b; padding:10px">
	
	<form autocomplete="off" id="form_buscar_pedidos" method="post" action="<?=base_url()?>index.php/administrador/buscar_pedidos/<?=$this->uri->segment(3);?>">

 

	<!-- Tipo entrega, Estado -->
	<div class="col-md-2">
		<div class="form-group">

		  	<label for="id_forma_entrega">Tipo entrega</label>

		  	<?  (isset($opciones_busqueda["id_forma_entrega"])) ? $val = $opciones_busqueda["id_forma_entrega"] :$val = -1; ?>

		  	 <? 
		  		$tipos_engrega = array(); 

		  		$tipos_engrega[-1] =  'Todos'; ?>
                                        
            <? 	foreach ($forma_entrega as $row):  
                  
                    $tipos_engrega[$row['id_forma_entrega']] = $row['descripcion'];

                endforeach; 
 			
                
                echo form_dropdown('id_forma_entrega', $tipos_engrega, $val ,'class="form-control" id="id_forma_entrega" name="id_forma_entrega"  ' ); 
            ?>
 

		   	<label style="margin-top:10px" >Estado</label>

		   	<?  (isset($opciones_busqueda["id_pedido_estado"])) ? $val = $opciones_busqueda["id_pedido_estado"] :$val = -1; ?>

		  	<? 
		  		$pedido_estado = array(); 

		  		$pedido_estado[-1] =  'Todos'; ?>
                                        
            <? 	foreach ($estados as $row):  
                  
                    $pedido_estado[$row['id_pedido_estado']] = $row['descripcion'];

                endforeach; 
 			
                
                echo form_dropdown('id_pedido_estado', $pedido_estado, $val ,'class="form-control" id="id_pedido_estado" name="id_pedido_estado"  ' ); 
            ?>
 

		</div>
	</div>

	<!-- Fecha desde, Fecha Hasta -->
	<div class="col-md-2">
		<div class="form-group">

			<?  (isset($opciones_busqueda["fecha_desde"])) ? $fecha_desde_busqueda = $opciones_busqueda["fecha_desde"] : $fecha_desde_busqueda = date('Y-m-d'); 
				(isset($opciones_busqueda["fecha_hasta"])) ? $fecha_hasta_busqueda = $opciones_busqueda["fecha_hasta"] : $fecha_hasta_busqueda = date('Y-m-d', strtotime("+ 1 day") ); 

			?>

		  	<label for="fecha_desde">Fecha desde</label>
		   	<input class="form-control" type="date" name="fecha_desde" value="<?php echo $fecha_desde_busqueda; ?>">

		  	<label for="fecha_hasta" style="margin-top:10px">Fecha Hasta</label>
		   	<input class="form-control" type="date" name="fecha_hasta" value="<?php echo $fecha_hasta_busqueda; ?>">

		</div>
		
	</div>

	<!-- Hora desde, Hora Hasta  value="13:00:00"-->
	<div class="col-md-2">
		<div class="form-group">

			<?  (isset($opciones_busqueda["hora_desde"])) ? $hora_desde_busqueda = $opciones_busqueda["hora_desde"] : $hora_desde_busqueda = "07:00:00"; 
				
				(isset($opciones_busqueda["hora_hasta"])) ? $hora_hasta_busqueda = $opciones_busqueda["hora_hasta"] : $hora_hasta_busqueda = "20:00:00"; 

			?>

		  	<label for="fecha_desde">Hora desde</label>
		   	<input class="form-control" type="time" name="hora_desde"  value="<?php echo $hora_desde_busqueda; ?>"   >

		  	<label for="fecha_hasta" style="margin-top:10px">Fecha Hasta</label>
		   	<input class="form-control" type="time" name="hora_hasta" value="<?php echo $hora_hasta_busqueda; ?>">

		</div>
		
	</div>

	<!-- Producto  , Email -->
	<div class="col-md-3">
		<div class="form-group">

			<?  (isset($opciones_busqueda["email"])) ? $email = $opciones_busqueda["email"] : $email = ''; ?>

		    <label for="id_productos" >Producto</label><br>
 

 
		    <select class="selectpicker" data-live-search="true" multiple name="id_productos[]">
 
			  <? foreach ($productos as $row): ?>


			  		<?	
			  			$select_producto = '';
			  			
			  			if(isset($opciones_busqueda["id_productos"])):
			  				
			  				

			  				if ( in_array($row['id_producto'], $opciones_busqueda["id_productos"]) )
			  					$select_producto = "selected='selected' ";

			  			endif;
			  		?>

		    		<option value="<?=$row['id_producto']?>" <?=$select_producto?> ><?=$row['nombre']?></option>

	 		  <? endforeach; ?>

			</select>
			 
			<br>
			<?  (isset($opciones_busqueda["email"])) ? $email = $opciones_busqueda["email"] : $email = ''; ?>
			<label style="margin-top:10px" >Email</label>
		  	<input type="text" name="email" class="form-control" value="<?=$email?>">

		</div>
	</div>

	<!-- Ordenar -->
 	<div class="col-md-2">
		<div class="form-group">

		    <label  >Ordenar</label><br>

		    <?	

		     	(isset($opciones_busqueda["ordenar"]) &&  $opciones_busqueda["ordenar"] == 'hora_entrega') ? $hora_check = TRUE : $hora_check = FALSE; 

		     	( !isset($opciones_busqueda["ordenar"]) ) ? $hora_check = TRUE  : $hora_check = TRUE;  

		    	$radio_hora = array (
					'name' => 'ordenar',
					'value' => 'hora_entrega', 
					'checked' => $hora_check
				);

				(isset($opciones_busqueda["ordenar"]) &&  $opciones_busqueda["ordenar"] == 'pedido_estado') ? $estado_check = TRUE : $estado_check = FALSE; 

				$radio_estado = array (
				'name' => 'ordenar',
				'value' => 'pedido_estado',
				'checked' => $estado_check
				);

				(isset($opciones_busqueda["ordenar"]) &&  $opciones_busqueda["ordenar"] == 'forma_entrega') ? $forma_check = TRUE : $forma_check = FALSE; 

				$radio_forma = array (
				'name' => 'ordenar',
				'value' => 'forma_entrega',
				'checked' =>  $forma_check
				);

				$des_check = $asc_check = FALSE;

				(isset($opciones_busqueda["ordenar_direccion"]) &&  $opciones_busqueda["ordenar_direccion"] == 'ASC') ? $asc_check = TRUE : $des_check = TRUE; 

				$radio_asc = array (
					'name' => 'ordenar_direccion',
					'value' => 'ASC',
					'checked' =>  $asc_check
				);

				$radio_desc = array (
					'name' => 'ordenar_direccion',
					'value' => 'DESC',
					'checked' =>  $des_check
				);

		    ?>
		    <div class="radio">
			  <label> <?=form_radio($radio_hora)?> Hora entrega</label>
			</div>


		    <div class="radio">
			  <label> <?=form_radio($radio_estado)?> Estado</label>
			</div>

			 <div class="radio">
			  <label> <?=form_radio($radio_forma)?> Forma Entrega</label>
			</div>
 

			<label class="radio-inline"> <?=form_radio($radio_asc)?> Asc </label>
			<label class="radio-inline"> <?=form_radio($radio_desc)?> Desc</label>
			


		</div>
	</div>
 
	<div class="col-md-1">
 		<a href='<?php echo site_url('administrador/pedidos/tabla/')?>'> <i class="fa fa-2x fa-bars" aria-hidden="true"></i></a>
 		<a style="padding-left: 10px" href='<?php echo site_url('administrador/pedidos/lista/')?>'> <i class="fa fa-2x fa-table" aria-hidden="true"></i></a>

		  <input type="submit" id="buscar" name="Buscar" value="Buscar" class="btn btn-primary btn-block">
		 
	</div>

	</form>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.js"></script>

<script type="text/javascript">
$('.selectpicker').selectpicker({
 
});

</script>