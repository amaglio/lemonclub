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

<div class="content-wrapper">
 
    <div class="panel-body">
 
 
         <div class="col-md-12" style="margin-top:10px">   

                <div class="box-body" id="resultado">
                    
                    <table style="font-size:12px"  class="table table-striped table-bordered entrevistas" cellspacing="0" width="100%">
                        <thead>
                            <tr style="background-color:rgba(0, 128, 0, 0.23)">
                                <th><i class="fa fa-calendar"></i></th>
                                <th>Hora</th>
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
                                    <td><?=$row['informacion_pedido']['fecha_pedido']?></td>
                                    <td><?=$row['informacion_pedido']['hora_entrega']?></td>
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
                    "lengthMenu": "Mostrando _MENU_ pedidos entrevistas por pagina.",
                    "zeroRecords": "Ningun pedido de entrevista fue encontrado.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ningun pedido de entrevista disponible",
                    "infoFiltered": "(Filtrado de _MAX_ pedidos de entrevistas totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                },
                "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
                "footerCallback": function ( row, data, start, end, display ) 
                {   

                    var api = this.api(), data;

                    //console.log(" ");
                    var cantidad_baja = 0;
                    var cantidad_entrevistas = 0;

                    $.each(display, function(key, value) {
                      
                        var fila_visible = value;
                        var array_fila = data[fila_visible];
                        
                        //console.log(array_fila[9]);
                        if(array_fila[9] != "")
                        { 
                          cantidad_baja++;
                        }

                        if(array_fila[8] != "")
                        { 
                          cantidad_entrevistas++;
                        }

                        
                    });

                    //console.log("Cantidad Entre:" + cantidad_entrevistas);
                    console.log( row + 1 );

                    q('tr:eq(1) th:eq(1)', api.table().footer()).html( cantidad_entrevistas );
                    q('tr:eq(1) th:eq(2)', api.table().footer()).html( cantidad_baja );
                    q('tr:eq(2) th:eq(1)', api.table().footer()).html( cantidad_entrevistas-cantidad_baja );

                    /*
                    q( api.column( 9 ).footer() ).html(
                        cantidad_baja
                    );

                     q( api.column( 8 ).footer() ).html(
                        cantidad_entrevistas
                    );

                    //$('tr:eq(1) td:eq(3)', api.table().footer()).html( 'aaaa')
                    $('tr:eq(1) th:eq(1)', api.table().footer()).html( cantidad_entrevistas-cantidad_baja )
                   */
                }

            });
 

} );

</script>
 