<link href="<?php echo base_url(); ?>assets/css/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/datatable/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<style type="text/css">

  .input-group{
    /*margin-top: 20px;*/
    margin-right: 10px;
  }

  div#errordiv{
    color:red;
    font-weight: bold;
  }


  label.error{
    display: table-caption;
  }

  .info-box-icon
  {
    float: left;
    height: 50px;
    width: 50px;
    text-align: center;
    font-size: 30px;
    line-height: 50px;
  }

  .info-box-content{
    margin-left:50px;
  }

  .info-box{
    min-height:0px;
  }

  .panel-heading {
    font-size: 16px;
    font-weight: bold;
  }

  button.dt-button, div.dt-button, a.dt-button{
    margin-right: 1px;
    padding: 4px;
  }

  .dataTables_wrapper .dataTables_filter input{
    width:150px;
  }

  .dataTables_wrapper .dataTables_info{
    font-size: 12px;
  }

  .dataTables_wrapper .dataTables_paginate{
    font-size: 12px;
  }

  .col-md-4{
        padding-right:  5px;
    padding-left:  5px;
  }

  .dataTables_wrapper .dataTables_filter{

    margin-bottom:20px;
  }

  .panel-default>.panel-heading {
    color: #fce028;
    background-color: rgb(0, 0, 0);
    border-color: #ddd;
  }

  .fila_head{
        background-color: rgba(0, 0, 0, 0.15);
    color: black;
  }

  .label{
        font-size: 85%;
  }

</style>

<?php echo "<div class='col-md-12'>".mensaje_resultado($mensaje)."</div>" ?>



      <?php if(isset($texto_filtros)): ?>

        <div class=" "  style=" margin: 0px 20px 20px 20px;"  >
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php echo $texto_filtros; ?>
        </div>

      <?php endif; ?>


      <div class="row" style="background-color: rgb(252, 224, 40); margin: 0px 20px 20px 20px; border-radius:4px; border:1px solid #d8c02b; padding:10px">

        <form  class="form-inline" id="form_buscar_estadisticas" method="post" action="<?=base_url()?>index.php/administrador/buscar_estaditicas">

          <div class="form-group">
              <label for="fecha_desde">Fecha desde</label>
              <input class="form-control" type="date" name="fecha_desde" value="<?php echo date('Y-m-d'); ?>">
          </div>
          <div class="form-group" style="margin-left: 20px ">
              <label for="fecha_hasta" style="margin-top:10px">Fecha Hasta</label>
              <input class="form-control" type="date" name="fecha_hasta" value="<?php echo date('Y-m-d', strtotime("+ 1 day") ) ; ?>">
          </div>
          <div class="checkbox" style="margin-left: 20px ">
           <input type="submit" id="buscar" name="Buscar" value="Buscar" class="btn btn-primary btn-block">
          </div>

        </form>
      </div>



      <div class="row"  style=" margin: 20px 20px 20px 20px; border-radius:4px; ">

        <div class="col-md-4">

          <div class="panel panel-default">
            <div class="panel-heading">Cantidad forma de pedidos</div>
            <div class="panel-body" style="text-align: center; "><strong style="font-size: 20px"><?=$cantidad_pedidos?></strong></div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Cantidad de productos</div>
            <div class="panel-body">

                  <table style="font-size:12px"  class="table table-striped table-bordered tabla_estadistica" cellspacing="0" width="100%">
                        <thead>
                            <tr class="fila_head">
                                <th>Nombre</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>

                          <?php  if( count($estadisticas_productos) > 0):


                                foreach ($estadisticas_productos as $row)
                                {  ?>

                                  <tr>
                                    <td><?=$row['nombre']?></td>
                                    <td><?=$row['cantidad']?></td>
                                    </td>
                                  </tr>
                            <?php  }

                              endif;

                          ?>
                        <tbody>


                        </tbody>
                  </table>

            </div>
          </div>

        </div>

        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">Cantidad por email</div>
            <div class="panel-body">

                <table style="font-size:12px"  class="table table-striped table-bordered tabla_estadistica" cellspacing="0" width="100%">
                        <thead>
                            <tr class="fila_head">
                                <th>Email</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>

                          <?php  if( count($estadisticas_email) > 0):


                                foreach ($estadisticas_email as $row)
                                {  ?>

                                  <tr>
                                    <td><?=$row['email']?></td>
                                    <td><?=$row['cantidad']?></td>
                                    </td>
                                  </tr>
                            <?php  }

                              endif;

                          ?>
                        <tbody>


                        </tbody>
                  </table>

            </div>
          </div>

        </div>

        <div class="col-md-4">

          <div class="panel panel-default">
            <div class="panel-heading">Cantidad forma de entrega</div>
            <div class="panel-body">

                <table style="font-size:12px"  class="table table-striped table-bordered tabla_estadistica" cellspacing="0" width="100%">
                        <thead>
                            <tr class="fila_head">
                                <th>Forma</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>

                          <?php  if( count($estadisticas_forma_entrega) > 0):


                                foreach ($estadisticas_forma_entrega as $row)
                                {  ?>

                                  <tr>
                                    <td><?=$row['descripcion']?></td>
                                    <td><?=$row['cantidad']?></td>
                                    </td>
                                  </tr>
                            <?php  }

                              endif;

                          ?>
                        <tbody>


                        </tbody>
                  </table>

            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Cantidad forma de pago</div>
            <div class="panel-body">

                <table style="font-size:12px"  class="table table-striped table-bordered tabla_estadistica" cellspacing="0" width="100%">
                        <thead>
                            <tr class="fila_head">
                                <th>Forma</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>

                          <?php  if( count($estadisticas_forma_pago) > 0):


                                foreach ($estadisticas_forma_pago as $row)
                                {  ?>

                                  <tr>
                                    <td><?=$row['descripcion']?></td>
                                    <td><?=$row['cantidad']?></td>
                                    </td>
                                  </tr>
                            <?php  }

                              endif;

                          ?>
                        <tbody>


                        </tbody>
                  </table>

            </div>
          </div>

           <div class="panel panel-default">
            <div class="panel-heading">Cantidad por estado</div>
            <div class="panel-body">

                <table style="font-size:12px"  class="table table-striped table-bordered tabla_estadistica" cellspacing="0" width="100%">
                        <thead>
                            <tr class="fila_head">
                                <th>Estado</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>

                          <?php  if( count($estadisticas_estados) > 0):


                                foreach ($estadisticas_estados as $row)
                                {  ?>

                                  <tr>
                                    <td><?=$row['descripcion']?></td>
                                    <td><?=$row['cantidad']?></td>
                                    </td>
                                  </tr>
                            <?php  }

                              endif;

                          ?>
                        <tbody>


                        </tbody>
                  </table>

            </div>
          </div>

        </div>



      </div>



</div>

<script src="<?php echo base_url(); ?>assets/js/datatable/jquery-1.12.4.js " type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/dataTables.buttons.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/buttons.flash.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/jszip.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/pdfmake.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/vfs_fonts.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/buttons.html5.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/buttons.print.min.js" type="text/javascript" ></script>

<script>
     var q = jQuery.noConflict();
</script>


<script type="text/javascript">

q(document).ready(function() {



    var table = q('.tabla_estadistica').DataTable({
                dom: 'Bfrtip',
                buttons: [
                      'excel', 'pdf', 'print'
                  ],
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ pedido por pagina.",
                    "zeroRecords": "Ningun pedido fue encontrado.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ningun pedid disponible",
                    "infoFiltered": "(Filtrado de _MAX_ pedido  totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                },
                "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]]

            });


} );

</script>
