<link href="<?php echo base_url(); ?>assets/css/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/datatable/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />



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

  tfoot {
    display: table-row-group;
  }


</style>

<? echo "<div class='col-md-12'>".mensaje_resultado($mensaje)."</div>" ?>

<?// echo $menu_pedidos; ?>

<div class="content-wrapper">
 
 
            
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
 
 

    var table = q('.entrevistas').DataTable({
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
 