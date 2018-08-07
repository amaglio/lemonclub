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

// --------------------------------- USUARIO ------------------------------


            'loguearse_usuario' => array(
                                    array(
                                            'field' => 'email',
                                            'label' => 'email',
                                            'rules' => 'required|trim|xss_clean|valid_email'
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
                                            'rules' => 'strip_tags|max_length[45]|trim|xss_clean'
                                         ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'apellido',
                                            'rules' => 'strip_tags|max_length[45]|trim|xss_clean'
                                         ),
                                    array(
                                            'field' => 'email',
                                            'label' => 'email',
                                            'rules' => 'strip_tags | required | max_length[100] | trim | valid_email | callback_comprobar_email_existente_validation | xss_clean'
                                         ),
                                    array(
                                            'field' => 'clave',
                                            'label' => 'clave',
                                            'rules' => 'strip_tags|required|trim|matches[clave2]|min_length[6]| max_length[64] | xss_clean'
                                         ),
                                    array(
                                            'field' => 'clave2',
                                            'label' => 'clave2',
                                            'rules' => 'strip_tags|required| trim | min_length[6] max_length[64]| xss_clean'
                                         ),
                                    array(
                                            'field' => 'direccion',
                                            'label' => 'direccion',
                                            'rules' => 'strip_tags|max_length[100]|trim|xss_clean'
                                         ),
                                    array(
                                            'field' => 'telefono',
                                            'label' => 'telefono',
                                            'rules' => 'strip_tags|max_length[45]|trim|xss_clean'
                                         )

                                ),

            'usuario_invitado' => array(
                                    array(
                                            'field' => 'email',
                                            'label' => 'email',
                                            'rules' => 'required|trim|xss_clean|valid_email'
                                        ) 
                                ),

            'validar_usuario_invitado' => array(
                                     array(
                                            'field' => 'id_usuario',
                                            'label' => 'id_usuario',
                                            'rules' => 'strip_tags|required|trim|xss_clean|numeric'
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
                                            'rules' => 'strip_tags|required|trim|xss_clean|numeric'
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
                                            'rules' => 'strip_tags|required|trim|xss_clean | numeric'
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
                                            'rules' => 'strip_tags | required | trim | xss_clean |valid_email | max_length[100]'
                                         ) 
                                ),

            'procesa_validar_recuperar_password' => array(

                                    array(
                                            'field' => 'id_usuario',
                                            'label' => 'id_usuario',
                                            'rules' => 'strip_tags|required|trim|xss_clean | numeric'
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
                                            'rules' => 'strip_tags|required|trim|xss_clean|numeric'
                                         ),
                                    array(
                                            'field' => 'clave',
                                            'label' => 'clave',
                                            'rules' => 'strip_tags | required |min_length[6]| max_length[100] | trim | matches[clave2] | xss_clean'
                                         ),
                                    array(
                                            'field' => 'clave2',
                                            'label' => 'clave2',
                                            'rules' => 'strip_tags | required | trim | min_length[6] | max_length[100] | xss_clean'
                                         ) 
                                ),
        
// --------------------------------- ADMINISTRADOR ------------------------------


            'agregar_ingrediente_producto' => array(
                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'id_ingrediente',
                                            'label' => 'id_ingrediente',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ) 
                                ),

             'agregar_ingrediente_grupo' => array(
                                    array(
                                            'field' => 'id_grupo',
                                            'label' => 'id_grupo',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'id_ingrediente',
                                            'label' => 'id_ingrediente',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ) 
                                ),
            
            'delete_ingrediente_grupo' => array(
                                    array(
                                            'field' => 'id_grupo',
                                            'label' => 'id_grupo',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'id_ingrediente',
                                            'label' => 'id_ingrediente',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ) 
                                ),

            'agregar_grupo_producto' => array(
                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean|callback_existe_grupo_producto|numeric'
                                        ),
                                    array(
                                            'field' => 'id_grupo',
                                            'label' => 'id_grupo',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ) 
                                ),
 
            'eliminar_grupo_producto' => array(
                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'id_grupo',
                                            'label' => 'id_grupo',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ) 
                                ),



// --------------------------------- PEDIDO ------------------------------ 


            'finalizar_pedido' => array(

                                    array(
                                            'field' => 'id_pedido',
                                            'label' => 'id_pedido',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'mail',
                                            'label' => 'mail',
                                            'rules' => 'required|trim|xss_clean|valid_email | max_length[100]'
                                        ),
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'id_producto',
                                            'rules' => 'trim|xss_clean | max_length[45] '
                                        ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'apellido',
                                            'rules' => 'trim|xss_clean | max_length[45]'
                                        ) 
                                ),

            'procesa_cambiar_estado_pedido' => array(

                                    array(
                                            'field' => 'id_pedido',
                                            'label' => 'id_pedido',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'id_pedido_estado',
                                            'label' => 'id_pedido_estado',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ) 
                                ),

            'agregar_producto_ajax' => array(

                                  
                                    array(
                                            'field' => 'id',
                                            'label' => 'id',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ) 
                                ),

            'confirmar_pedido' => array(

                                  
                                    array(
                                            'field' => 'id_usuario',
                                            'label' => 'id_usuario',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ) 
                                ),

            'modificar_cantidad_ajax' => array(

                                  
                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean|numeric'
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
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ) 

                                ),


// --------------------------------- CONTACTO ------------------------------ 


            'alta_contacto' => array(

                                    array(
                                            'field' => 'nombre',
                                            'label' => 'nombre',
                                            'rules' => 'required|trim|xss_clean| max_length[45] '
                                        ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'apellido',
                                            'rules' => 'required|trim|xss_clean | max_length[45]'
                                        ),
                                    array(
                                            'field' => 'mail',
                                            'label' => 'mail',
                                            'rules' => 'required | trim | xss_clean | valid_email | max_length[100]'
                                        ),
                                    array(
                                            'field' => 'mensaje',
                                            'label' => 'mensaje',
                                            'rules' => 'required|trim|xss_clean'
                                        ) 
                                ),

// --------------------------------- TIPO PRODUCTO ------------------------------ 


            'delete_producto_tipo' => array(

                                    array(
                                            'field' => 'id_producto_tipo',
                                            'label' => 'id_producto_tipo',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        )  
                                ),


// --------------------------------- PRODUCTO ------------------------------ 


            'delete_producto' => array(

                                    array(
                                            'field' => 'id_producto',
                                            'label' => 'id_producto',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        )  
                                ),

// --------------------------------- GRUPO ------------------------------ 


            'delete_grupo_ingrediente' => array(

                                    array(
                                            'field' => 'id_grupo',
                                            'label' => 'id_grupo',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        )  
                                ),


// --------------------------------- INGREDIENTE ------------------------------ 


            'delete_ingrediente' => array(

                                    array(
                                            'field' => 'id_ingrediente',
                                            'label' => 'id_ingrediente',
                                            'rules' => 'required|trim|xss_clean|numeric'
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
                                                'rules' => 'required|trim|xss_clean|numeric'
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
                                                'rules' => 'strip_tags|required|trim|xss_clean|numeric'
                                            ),

                                         array(
                                                'field' => 'id_grupo',
                                                'label' => 'id_grupo',
                                                'rules' => 'strip_tags|required|trim|xss_clean|numeric'
                                            ),

                                         array(
                                                 'field' => 'id_ingrediente',
                                                 'label' => 'id_ingrediente',
                                                 'rules' => 'strip_tags|required|trim|xss_clean|numeric'
                                             )
                                    ), 

            'set_producto_grupo_ingrediente' => array(

                                        array(
                                                'field' => 'id_producto',
                                                'label' => 'id_producto',
                                                'rules' => 'strip_tags|required|trim|xss_clean|numeric'
                                            ),

                                         array(
                                                'field' => 'id_grupo',
                                                'label' => 'id_grupo',
                                                'rules' => 'strip_tags|required|trim|xss_clean|numeric'
                                            ),

                                         array(
                                                 'field' => 'id_ingrediente',
                                                 'label' => 'id_ingrediente',
                                                 'rules' => 'strip_tags|required|trim|xss_clean|numeric'
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