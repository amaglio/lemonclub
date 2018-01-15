<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model {
 
public function __construct()
{
	parent::__construct();
}


public function loguearse( $array ) 
{
	chrome_log("Usuario_model/loguearse");
 
	$email = $array['email'];
	$password = md5($array['clave']);

 	$sql = "SELECT *
 			FROM 	usuario u,
 					usuario_registrado ur
 			WHERE
 					u.id_usuario = ur.id_usuario
 			AND 	u.email = ? 
 			AND 	ur.password = ?"; 

	$query = $this->db->query($sql, array( $email, $password ));

	if($query->num_rows() > 0)
	{
		//$this->session->set_userdata('id_usuario', );
		return $query->row()->id_usuario;
	}
	else
	{
		return false;
	}
}


public function usuario_invitado( $email ) 
{
	chrome_log("Usuario_model/usuario_invitado");
 
	//--- Usuario ---

	$this->db->trans_start();

		//--- Usuario invitado ya existente ¿? --

		$sql = "SELECT 	*
	 			FROM 	usuario u 
	 			WHERE 	u.email = ? "; 

		$query = $this->db->query($sql, array( $email ));

		if($query->num_rows() > 0) // El email ya existe
		{
			chrome_log("Usuario_model/ El email ya existe");
			$id_usuario = $query->row()->id_usuario;
		}
		else // El email no existe
		{	
			chrome_log("Usuario_model/ El email No existe".$email);
			$usuario =  array();
			$usuario['email'] = $email; 
			$usuario['registrado'] = 0; 
			$this->db->insert('usuario', $usuario); 

			$id_usuario = $this->db->insert_id();
		} 

		/*
		//--- Token en la tabla --
		
		$borrar_token['id_pedido'] = $id_pedido;
		$this->db->delete('pedido_token',  $borrar_token );
		
		$pedido_token['id_pedido'] = $id_pedido;
		$pedido_token['token'] = $token;
		$this->db->insert('pedido_token', $pedido_token);
		
		//--- ACTUALIZAR ID_USUARIO EN PEDIDO --

		$array_where = array( 'id_pedido' =>  $id_pedido );
		$array_pedido['id_usuario'] = $id_usuario;
		
		$this->db->where($array_where);
		$this->db->update('pedido', $array_pedido);
		*/

	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    $resultado = false;
	}
	else
	{
		$this->db->trans_commit();
		$resultado = $id_usuario;
	} 

	return $resultado;
}

public function token_pedido_invitado( $id_usuario, $token, $id_pedido ) 
{
	chrome_log("Usuario_model/usuario_invitado");
 
	//--- Usuario ---

	$this->db->trans_start();

		//--- Token en la tabla --
		
		$borrar_token['id_pedido'] = $id_pedido;
		$this->db->delete('pedido_token',  $borrar_token );
		
		$pedido_token['id_pedido'] = $id_pedido;
		$pedido_token['token'] = $token;
		$this->db->insert('pedido_token', $pedido_token);
		
		//--- ACTUALIZAR ID_USUARIO EN PEDIDO --

		$array_where = array( 'id_pedido' =>  $id_pedido );
		$array_pedido['id_usuario'] = $id_usuario;
		
		$this->db->where($array_where);
		$this->db->update('pedido', $array_pedido);


	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    $resultado = false;
	}
	else
	{
		$this->db->trans_commit();
		$resultado = true;
	} 

	return $resultado;
}

public function procesa_validar_usuario_invitado( $id_usuario, $token ) 
{
	chrome_log("Usuario_model/procesa_validar_usuario_invitado");
 

	$sql = "SELECT 	*
 			FROM 	pedido p , 
 					pedido_token pt
 			WHERE 	p.id_pedido = pt.id_pedido
 			AND 	SHA1(p.id_usuario) = ? 
 			AND 	pt.token = ? "; 

	$query = $this->db->query($sql, array( $id_usuario, $token ));
 
    if($this->db->affected_rows() > 0)
    {

		$this->session->set_userdata('id_usuario', $query->row()->id_usuario ); 
		$this->session->set_userdata('id_pedido', $query->row()->id_pedido ); 
		
		//--- Token en la tabla --

		$borrar_token['id_pedido'] = $query->row()->id_pedido;
		$this->db->delete('pedido_token',  $borrar_token );

		return true;
	}
	else
	{
		return false;
	}

 
}

public function registrar_usuario( $array ) 
{
	chrome_log("Usuario_model/registrar_usuario");

	$this->db->trans_start();

	//--- Usuario ---

	//--- Email ya existete ¿? --

		$sql = "SELECT 	*
	 			FROM 	usuario u 
	 			WHERE 	u.email = ? "; 

		$query = $this->db->query($sql, array( $array['email'] ));

		if($query->num_rows() > 0) // El email ya existe
		{
			chrome_log("Usuario_model/ El email ya existe");
			$id_usuario = $query->row()->id_usuario;
		}
		else // El email no existe
		{	
			$usuario['email'] = $array['email'];
			$this->db->insert('usuario', $usuario); 

			$id_usuario = $this->db->insert_id();
		} 		

	//--- Usuario Registrado ---

		$usuario_registrado['id_usuario'] = $id_usuario;
		$usuario_registrado['nombre'] = $array['nombre'];
		$usuario_registrado['apellido'] = $array['apellido'];
		$usuario_registrado['password'] = md5($array['clave']);
   
		if(isset($array['direccion']) && !empty($array['direccion']))
	        $usuario_registrado['direccion'] =  $array['direccion'];

 
	    if(isset($array['telefono']) && !empty($array['telefono']))
	         $usuario_registrado['telefono'] =  $array['telefono'];
	 
		$this->db->insert('usuario_registrado', $usuario_registrado); 

		/*
		//--- Token en la tabla --

		$borrar_token['id_pedido'] = $id_pedido;
		$this->db->delete('pedido_token',  $borrar_token );


		$pedido_token['id_pedido'] = $id_pedido; 
		$pedido_token['token'] = $token; 
		$this->db->insert('pedido_token', $pedido_token); 

		//--- ACTUALIZAR ID_USUARIO EN PEDIDO --

		$array_where = array(  'id_pedido' =>  $id_pedido );
		$array_pedido['id_usuario'] = $id_usuario;

		$this->db->where($array_where);
		$this->db->update('pedido', $array_pedido); 
		*/

	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    chrome_log("Error Transaccion");
	    $this->db->trans_rollback();
	    $resultado = false;
	      
	}
	else
	{	
		chrome_log("Transaccion Correcta ");
		$this->db->trans_commit();
		$resultado = $id_usuario;
	} 

	return $resultado;
}


public function procesa_validar_registro( $id_usuario, $token ) 
{
	chrome_log("Usuario_model/procesa_validar_registro");

	$this->db->trans_start();
	 	
	 	// EXISTE EL USUARIO Y EL TOKEN

	 	$sql = "SELECT 	*
	 			FROM 	pedido p , 
	 					pedido_token pt
	 			WHERE 	p.id_pedido = pt.id_pedido
	 			AND 	SHA1(p.id_usuario) = ? 
	 			AND 	pt.token = ? "; 

		$query = $this->db->query($sql, array( $id_usuario, $token ));
		
		$id_usuario = $query->row()->id_usuario; 
		$id_pedido = $query->row()->id_pedido;

		// BORRAMOS EL TOKEN

		$borrar_token['id_pedido'] = $id_pedido;
		$this->db->delete('pedido_token',  $borrar_token );

		// Cambios a Registrado en la tabla usuario

		$array_where = array(  'id_usuario' =>  $id_usuario );
		$array_usuario['registrado'] = 1;

		$this->db->where($array_where);
		$this->db->update('usuario', $array_usuario); 


	$this->db->trans_complete();

    if ($this->db->trans_status() !== FALSE)
    {
        $this->session->set_userdata('id_usuario', $id_usuario ); 
		$this->session->set_userdata('id_pedido', $id_pedido ); 
        return TRUE;
    }
    else
    	return FALSE;

	
}



public function existe_email_registrado($email)
{
	chrome_log("Usuario_model/existe_email");
	
	$sql = "SELECT *
 			FROM 	usuario u,
 					usuario_registrado ur
 			WHERE
 					u.id_usuario = ur.id_usuario
 			AND 	u.email = ?  "; 
 
	$query = $this->db->query($sql, array($email)); 

	if($query->num_rows() > 0)
		return true;
	else
		return false;
}

public function traer_datos_usuario( $id_usuario ) 
{
	chrome_log("Usuario_model/traer_datos_usuario");

 	$sql = "SELECT  *,
					IF(ur.id_usuario IS NULL, 'Usuario Invitado', 'Usuario Registrado') as tipo_usuario
 			FROM 	usuario u
 					LEFT JOIN usuario_registrado ur ON u.id_usuario = ur.id_usuario 
 			WHERE  
 					u.id_usuario = ? "; 

	$query = $this->db->query($sql, array( $id_usuario ));

	if($query->num_rows() > 0)
	{
		return $query->row();
	}
	else
	{
		return false;
	}
}


public function traer_direcciones( $id_usuario ) 
{
	chrome_log("Usuario_model/traer_direcciones");

 	$sql = "SELECT  DISTINCT(pd.direccion), pd.nota
 			FROM 	pedido p
 					INNER JOIN pedido_delivery pd ON p.id_pedido = pd.id_pedido 
 			WHERE  
 					p.id_usuario = ? "; 

	$query = $this->db->query($sql, array( $id_usuario ));

	return $query->result_array();
}


}

/* End of file  */
/* Location: ./application/models/ */