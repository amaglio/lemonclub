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
    <section class="content-header">
      <h4>
         <i class="fa fa-comments" aria-hidden="true"></i>  <a style="color:#000" href="<?=base_url()?>index.php/entrevista/"> Pedidos Entrevistas </a>
      </h4>
    </section>
    <div class="panel-body">
 
 
         <div class="col-md-12" style="margin-top:10px">   
              
              <div class="box box-Orange">
                <div class="box-header with-border" style="padding-bottom:10px">
                  <h3 class="box-title">Pedidos de Entrevistas </strong></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body" id="resultado">

 
                    
                    <table style="font-size:12px"  class="table table-striped table-bordered entrevistas" cellspacing="0" width="100%">
                        <thead>
                            <tr style="background-color:rgba(0, 128, 0, 0.23)">
                                <th><i class="fa fa-calendar"></i></th>
                                <th>Hora</th>
                                <th>Nombre</th>
                                <th>Tipo Doc</th>
                                <th>Doc</th>
                                <th>Tipo</th>
                                <th>PRG</th> 
                                <th>Entrevistador</th>
                                <th>Alta</th>
                                <th>Baja</th>
                            </tr>
                        </thead>
                        <tfoot>
                      
                           <tr  style="background-color:rgba(128, 128, 128, 0.19)">
                              <td style="text-align:center"></td>
                              <td style="text-align:center"></td>
                              <td style="text-align:center"></td>
                              <td style="text-align:center"></td>
                              <td style="text-align:center"></td>
                              <td style="text-align:center"></td>
                              <td style="text-align:center"></td> 
                              <td style="text-align:center"></td>
                              <td style="text-align:center"></td>
                              <td style="text-align:center"></td>
                          </tr>
                          <tr  style="background-color:rgba(128, 128, 128, 0.19)">
                              <th colspan="8" style="text-align:right">Total:</th>
                              <th style="text-align:center"></th>
                              <th style="text-align:center"></th> 
                          </tr>
                          <tr  style="background-color:rgba(128, 128, 128, 0.19)">
                               <th colspan="8" style="text-align:right">Neto:</th>
                              <th colspan="2" id="neto" style="text-align:center" ></th>  
                          </tr>
                        </tfoot>
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
    
     table.columns().every( function () {
        var that = this;
        

        q( 'input', this.footer() ).on( 'keyup change', function () {
            
          if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }

        } );
    } );

} );

</script>

 

<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>    

<script>
   var jg = jQuery.noConflict();
</script>

<script src="<?=base_url()?>assets/js/editar_experiencia.js" type="text/javascript"></script>   



<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">

jg('.calendario').datepicker({
  autoclose: true,
  format: 'dd/mm/yyyy'
});


</script>

<!-- VALIDATE -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script> 

<script>
var jq = jQuery.noConflict();
</script>

<script type="text/javascript">

    jq(function(){

            jq('#f_entrevistas').validate({

                rules :{

                        fecha_desde : {
                            required : true
                        },
                        fecha_hasta: {
                            required : true
                        }
                },
                messages : {

                        fecha_desde : {
                            required : "Debe elegir la fecha desde"
                        },
                        fecha_hasta: {
                            required : "Debe elegir la fecha hasta"
                        }
                } 

            });    
    });     
 

 </script>