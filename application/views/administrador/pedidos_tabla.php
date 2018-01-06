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

  tfoot {
    display: table-row-group;
  }


</style>

<? echo $menu_pedidos; ?>

<? echo "<div class='col-md-12'>".mensaje_resultado($mensaje)."</div>"; ?>
 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<div class="content-wrapper">
 
    <div class="panel-body">
 
        <div class="col-md-12" style="margin-top:10px">   

                <div class="box-body" id="resultado">
                    
                    <table style="font-size:12px"  class="table table-striped table-bordered entrevistas" cellspacing="0" width="100%">
                        <thead>
                            <tr style=" background-color: rgb(0, 0, 0); color: white;">
                                <th><i class="fa fa-calendar"></i></th>
                                <th>Entrega</th>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Productos</th>
                                <th>Forma entrega</th>
                                <th>Forma Pago</th>
                                <th>Estado</th> 
                            </tr>
                        </thead>

                          <?  if( count($pedidos) > 0):

                                foreach ($pedidos as $row) 
                                {  ?>

                                  <tr>
                                    <td><?=$row['informacion_pedido']['fecha_pedido']?> <br> <a target="_blank" href="<?=site_url('administrador/imprimir_comanda/'.$row['informacion_pedido']['id_pedido'].'')?>"> <i class="fa fa-print" aria-hidden="true"></i> </a> </td>
                                    <td><?=$row['informacion_pedido']['fecha_entrega']?></td>
                                    <td><?=$row['informacion_pedido']['id_pedido']?></td>
                                    <td><?=$row['informacion_pedido']['email']?></td>
                                    <td>
                                        <?
                                          foreach ($row['productos'] as $row2) 
                                          { ?>
                                              <div class="col-md-12">
                                                  <strong><?=$row2['nombre']?></strong>
                                                  <div class="pull-right"><span>$</span><span><?=$row2['precio']?></span></div>
                                              </div>
                                        <?
                                          }
                                        ?>

                                    </td>
                                    <td><?=$row['informacion_pedido']['forma_entrega']?></td>
                                    <td><?=$row['informacion_pedido']['forma_pago']?></td>
                                    <td>

                                        <form autocomplete="off" id="form_cambiar_estado_<?=$row['informacion_pedido']['id_pedido']?>" method="post" action="<?=base_url()?>index.php/pedido/procesa_cambiar_estado_pedido">

                                          <input type="hidden" name="id_pedido" id="id_pedido" value="<?=$row['informacion_pedido']['id_pedido']?>" >

                                          <?  $estados = array(); ?>
                                            
                                          <?  foreach ($estados_pedidos as $row3):  

                                                
                                                  $estados[$row3['id_pedido_estado']] = strtoupper($row3['descripcion']);

                                              endforeach; 
                                             
                                              echo form_dropdown('id_pedido_estado', $estados, $row['informacion_pedido']['id_pedido_estado']  ,'class="form-control estados_pedido" id="id_estado_cons_prg" name="id_estado_cons_prg" style=" font-size:12px; padding:0px" ' ); 
                                          ?>

                                          <button type="submit" class="btn btn-primary btn-xs btn-block">Cambiar</button>

                                        </form>

                                    </td>
                                  </tr>
                            <?  }

                              endif;

                          ?>
                        <tbody>
                          
      
                        </tbody>
                    </table>
                 
                
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
 <script type="text/javascript">
    $(function() 
    {
        $( ".mensaje_resultado" ).hide( 8000, function() {
            $( ".mensaje_resultado" ).remove();
        });

    });

  
</script>