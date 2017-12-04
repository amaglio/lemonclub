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
		  	<select class="form-control" id="id_forma_entrega" name="id_forma_entrega">
		    
			    <option value="-1">Todos</option>

			    <? foreach ($forma_entrega as $row): ?>

			    	<option value="<?=$row['id_forma_entrega']?>"><?=$row['descripcion']?></option>

		 		<? endforeach; ?>

		  	</select>

		   	<label style="margin-top:10px" >Estado</label>
			<select class="form-control" id="id_pedido_estado" name="id_pedido_estado" >

				<option value="-1">Todos</option>

				<? foreach ($estados as $row): ?>

				<option value="<?=$row['id_pedido_estado']?>"><?=$row['descripcion']?></option>

				<? endforeach; ?>

			</select>

		</div>
	</div>

	<!-- Fecha desde, Fecha Hasta -->
	<div class="col-md-2">
		<div class="form-group">

		  	<label for="fecha_desde">Fecha desde</label>
		   	<input class="form-control" type="date" name="fecha_desde" value="<?php echo date('Y-m-d'); ?>">

		  	<label for="fecha_hasta" style="margin-top:10px">Fecha Hasta</label>
		   	<input class="form-control" type="date" name="fecha_hasta" value="<?php echo date('Y-m-d', strtotime("+ 1 day") ) ; ?>">

		</div>
		
	</div>

	<!-- Hora desde, Hora Hasta  value="13:00:00"-->
	<div class="col-md-2">
		<div class="form-group">

		  	<label for="fecha_desde">Hora desde</label>
		   	<input class="form-control" type="time" name="hora_desde"  value="08:00:00"   >

		  	<label for="fecha_hasta" style="margin-top:10px">Fecha Hasta</label>
		   	<input class="form-control" type="time" name="hora_hasta" value="15:00:00">

		</div>
		
	</div>

	<!-- Producto  , Email -->
	<div class="col-md-3">
		<div class="form-group">

		    <label for="id_productos" >Producto</label><br>
		    <select class="selectpicker" data-live-search="true" multiple name="id_productos[]">
 
			  <? foreach ($productos as $row): ?>

		    	<option value="<?=$row['id_producto']?>"><?=$row['nombre']?></option>

	 			<? endforeach; ?>
			</select><br>

			<label style="margin-top:10px" >Email</label>
		  	<input type="text" name="email" class="form-control">

		</div>
	</div>

	<!-- Ordenar -->
 	<div class="col-md-2">
		<div class="form-group">

		    <label  >Ordenar</label><br>


			<div class="radio">
			  <label><input type="radio" name="ordenar" value="hora_entrega" checked="checked">Hora entrega</label>
			</div>

		    <div class="radio">
			  <label><input type="radio" name="ordenar" value="pedido_estado">Estado</label>
			</div>

			<div class="radio disabled">
			  <label><input type="radio" name="ordenar" value="forma_entrega">Forma Entrega</label>
			</div>

			<label class="radio-inline"><input type="radio" name="ordenar_direccion" value="ASC" >Asc </label>
			<label class="radio-inline"><input type="radio" name="ordenar_direccion" value="DESC" checked="checked">Desc</label>

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