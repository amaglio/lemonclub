<?php
$config = array(
            
// --------------------------------- LOGUEO ADMIN ------------------------------


            'loguearse' => array(
                                    array(
                                            'field' => 'usuario',
                                            'label' => 'usuario',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'clave',
                                            'label' => 'clave',
                                            'rules' => 'required|trim|xss_clean'
                                        )
                                ),

// --------------------------------- PEDIDO ------------------------------


            'comprar' => array(
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'nombre',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'apellido',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'mail',
                                            'label' => 'mail',
                                            'rules' => 'required|trim|xss_clean'
                                        )
                                ),

// --------------------------------- USUARIO ------------------------------


            'loguearse_usuario' => array(
                                    array(
                                            'field' => 'email',
                                            'label' => 'email',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'clave',
                                            'label' => 'clave',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),

             'registrarse' => array(
                                    
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'nombre',
                                            'rules' => 'strip_tags|max_length[100]|trim|xss_clean'
                                         ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'apellido',
                                            'rules' => 'strip_tags|max_length[100]|trim|xss_clean'
                                         ),
                                    array(
                                            'field' => 'email',
                                            'label' => 'email',
                                            'rules' => 'strip_tags|required|max_length[100]|trim|valid_email|callback_comprobar_email_existente_validation|xss_clean'
                                         ),
                                    array(
                                            'field' => 'clave',
                                            'label' => 'clave',
                                            'rules' => 'strip_tags|required|max_length[100]|trim|matches[clave2]|min_length[6]|max_length[15]|xss_clean'
                                         ),
                                    array(
                                            'field' => 'clave2',
                                            'label' => 'clave2',
                                            'rules' => 'strip_tags|required|max_length[100]|trim|min_length[6]|max_length[15]|xss_clean'
                                         ) 
                                ),

          'usuario_invitado' => array(
                                    array(
                                            'field' => 'email',
                                            'label' => 'email',
                                            'rules' => 'required|trim|xss_clean|required'
                                        )/*,
                                     array(
                                            'field' => 'id_pedido',
                                            'label' => 'id_pedido',
                                            'rules' => 'required|trim|xss_clean|required|is_numeric'
                                        )*/
                                ),

          'validar_usuario_invitado' => array(
                                     array(
                                            'field' => 'id_usuario',
                                            'label' => 'id_usuario',
                                            'rules' => 'strip_tags|required|trim|xss_clean'
                                         ),
                                        array(
                                            'field' => 'token',
                                            'label' => 'token',
                                            'rules' => 'strip_tags|required|trim|xss_clean'
                                         )  
                                ),

            'procesa_validar_registro_ingresar' => array(
                                     array(
                                            'field' => 'id_pedido',
                                            'label' => 'id_pedido',
                                            'rules' => 'strip_tags|required|trim|xss_clean'
                                         ),
                                        array(
                                            'field' => 'token',
                                            'label' => 'token',
                                            'rules' => 'strip_tags|required|trim|xss_clean'
                                         )  
                                ),

            'procesa_validar_registro_usuario' => array(
                                     array(
                                            'field' => 'id_usuario',
                                            'label' => 'id_usuario',
                                            'rules' => 'strip_tags|required|trim|xss_clean'
                                         ),
                                        array(
                                            'field' => 'token',
                                            'label' => 'token',
                                            'rules' => 'strip_tags|required|trim|xss_clean'
                                         )  
                                ),

            'recuperar_clave' => array(
                                     array(
                                            'field' => 'email',
                                            'label' => 'email',
                                            'rules' => 'strip_tags|required|trim|xss_clean|callback_comprobar_email_registrado_validation'
                                         ) 
                                ),

'procesa_validar_recuperar_password' => array(

                                     array(
                                            'field' => 'id_usuario',
                                            'label' => 'id_usuario',
                                            'rules' => 'strip_tags|required|trim|xss_clean'
                                         ),
                                    array(
                                        'field' => 'token',
                                        'label' => 'token',
                                        'rules' => 'strip_tags|required|trim|xss_clean'
                                     )  
                                ),

        'cambiar_password' => array(
    
                                     array(
                                            'field' => 'id_usuario',
                                            'label' => 'id_usuario',
                                            'rules' => 'strip_tags|required|trim|xss_clean'
                                         ),
                                    array(
                                            'field' => 'clave',
                                            'label' => 'clave',
                                            'rules' => 'strip_tags|required|max_length[100]|trim|matches[clave2]|min_length[6]|max_length[15]|xss_clean'
                                         ),
                                    array(
                                            'field' => 'clave2',
                                            'label' => 'clave2',
                                            'rules' => 'strip_tags|required|max_length[100]|trim|min_length[6]|max_length[15]|xss_clean'
                                         ) 
                                ),
        
// --------------------------------- ADMINISTRADOR ------------------------------


            'agregar_ingrediente_producto' => array(
                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'id_ingrediente',
                                            'label' => 'id_ingrediente',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),

             'agregar_ingrediente_grupo' => array(
                                    array(
                                            'field' => 'id_grupo',
                                            'label' => 'id_grupo',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'id_ingrediente',
                                            'label' => 'id_ingrediente',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),
            
            'eliminar_ingrediente_grupo' => array(
                                    array(
                                            'field' => 'id_grupo',
                                            'label' => 'id_grupo',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'id_ingrediente',
                                            'label' => 'id_ingrediente',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),

            'agregar_grupo_producto' => array(
                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean|callback_existe_grupo_producto'
                                        ),
                                    array(
                                            'field' => 'id_grupo',
                                            'label' => 'id_grupo',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),
 
            'eliminar_grupo_producto' => array(
                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'id_grupo',
                                            'label' => 'id_grupo',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),



// --------------------------------- PEDIDO ------------------------------ 


            'finalizar_pedido' => array(

                                    array(
                                            'field' => 'id_pedido',
                                            'label' => 'id_pedido',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'mail',
                                            'label' => 'mail',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'id_producto',
                                            'rules' => 'trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'apellido',
                                            'rules' => 'trim|xss_clean'
                                        ) 
                                ),

            'procesa_cambiar_estado_pedido' => array(

                                    array(
                                            'field' => 'id_pedido',
                                            'label' => 'id_pedido',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'id_pedido_estado',
                                            'label' => 'id_pedido_estado',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),

            'agregar_producto_ajax' => array(

                                  
                                    array(
                                            'field' => 'id',
                                            'label' => 'id',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),

            'confirmar_pedido' => array(

                                  
                                    array(
                                            'field' => 'id_usuario',
                                            'label' => 'id_usuario',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),

            'modificar_cantidad_ajax' => array(

                                  
                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'qty',
                                            'label' => 'qty',
                                            'rules' => 'required|trim|xss_clean'
                                        ),


                                ),
            
            'eliminar_producto_ajax' => array(

                                  
                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 

                                ),


// --------------------------------- CONTACTO ------------------------------ 


            'alta_contacto' => array(

                                    array(
                                            'field' => 'nombre',
                                            'label' => 'nombre',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'apellido',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'mail',
                                            'label' => 'mail',
                                            'rules' => 'required|trim|xss_clean|valid_email'
                                        ),
                                    array(
                                            'field' => 'mensaje',
                                            'label' => 'mensaje',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),

// --------------------------------- ESTADISTICAS ------------------------------ 


            'buscar_estaditicas' => array(

                                    array(
                                            'field' => 'fecha_desde',
                                            'label' => 'fecha_desde',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'fecha_hasta',
                                            'label' => 'fecha_hasta',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),


// --------------------------------- ESTADISTICAS ------------------------------ 


            'ver_editar_ingredientes_producto' => array(

                                        array(
                                                'field' => 'id_pedido_producto',
                                                'label' => 'id_pedido_producto',
                                                'rules' => 'strip_tags|required|trim|xss_clean'
                                            )
                                    ),

            
            'editar_ingredientes_producto' => array(

                                        array(
                                               
                                            ) 
                                    ),

 // --------------------------------- PRODUCTO GRUPO ------------------------------ 


            'configuracion_ingrediente_producto' => array(

                                        array(
                                                'field' => 'id_producto',
                                                'label' => 'id_producto',
                                                'rules' => 'strip_tags|required|trim|xss_clean'
                                            ),

                                         array(
                                                'field' => 'id_grupo',
                                                'label' => 'id_grupo',
                                                'rules' => 'strip_tags|required|trim|xss_clean'
                                            ),

                                         array(
                                                 'field' => 'id_ingrediente',
                                                 'label' => 'id_ingrediente',
                                                 'rules' => 'strip_tags|required|trim|xss_clean'
                                             )
                                    ), 

            'set_producto_grupo_ingrediente' => array(

                                        array(
                                                'field' => 'id_producto',
                                                'label' => 'id_producto',
                                                'rules' => 'strip_tags|required|trim|xss_clean'
                                            ),

                                         array(
                                                'field' => 'id_grupo',
                                                'label' => 'id_grupo',
                                                'rules' => 'strip_tags|required|trim|xss_clean'
                                            ),

                                         array(
                                                 'field' => 'id_ingrediente',
                                                 'label' => 'id_ingrediente',
                                                 'rules' => 'strip_tags|required|trim|xss_clean'
                                             ),

                                         array(
                                                 'field' => 'accion',
                                                 'label' => 'accion',
                                                 'rules' => 'strip_tags|required|trim|xss_clean'
                                             ),

                                         array(
                                                 'field' => 'campo',
                                                 'label' => 'campo',
                                                 'rules' => 'strip_tags|required|trim|xss_clean'
                                             )
                                    ), 
            
);


?>