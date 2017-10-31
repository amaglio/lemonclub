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
		$this->session->set_userdata('id_usuario', $query->row()->id_usuario);
		$this->session->set_userdata('email', $query->row()->email);
		$this->session->set_userdata('nombre', $query->row()->nombre);
		$this->session->set_userdata('apellido', $query->row()->apellido);
		$this->session->set_userdata('direccion', $query->row()->direccion);
		$this->session->set_userdata('telefono', $query->row()->telefono);

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

		$usuario['email'] = $array['email'];

		$this->db->insert('usuario', $usuario); 

		$id_usuario = $this->db->insert_id();

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

	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $resultado = false;
	}
	else
	{
	    if($this->db->affected_rows() > 0) // Se inserto
	    {
			$this->db->trans_commit();
			$resultado = true;
		}
		else
		{
			$this->db->trans_rollback();
	      	$resultado = false;
		}

		return $resultado;
	} 
}

public function usuario_invitado( $array, $token ) 
{
	chrome_log("Usuario_model/usuario_invitado");
 

	//--- Usuario ---

	$this->db->trans_start();

		//--- Usuario invitado ya existente ¿? --

		$sql = "SELECT 	*
	 			FROM 	usuario u 
	 			WHERE 	u.email = ? "; 

		$query = $this->db->query($sql, array( $array['email'] ));

		if($query->num_rows() > 0) // El email ya existe
		{
			$array_where = array( 'email' => $array['email'] );

			$educacion =  array();
			$educacion['token'] =  $token;

			$this->db->where($array_where);
			$this->db->update('usuario', $educacion); 
		}
		else // El email no existe
		{
			$usuario['email'] = $array['email'];
			$usuario['token'] = $token;
			$this->db->insert('usuario', $usuario); 
		}
	 

	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $resultado = false;
	}
	else
	{
	    if($this->db->affected_rows() > 0) // Se inserto el usuario o se actualizo el token
	    {
			$this->db->trans_commit();
			$resultado = true;
		}
		else
		{
			$this->db->trans_rollback();
	      	$resultado = false;
		}

		return $resultado;
	} 
	 
}

public function procesa_validar_usuario_invitado( $email, $token ) 
{
	chrome_log("Usuario_model/procesa_validar_usuario_invitado");
 

	$sql = "SELECT 	*
 			FROM 	usuario u 
 			WHERE 	u.email = ? 
 			AND 	u.token = ? "; 

	$query = $this->db->query($sql, array( $array['email'], $array['token'] ));
 
    if($this->db->affected_rows() > 0)
    {
		return true;
	}
	else
	{
		return false;
	}

 
}



public function existe_email_registrado($email)
{
	chrome_log("Usuario_model/existe_email");
	
	$sql = "SELECT *
 			FROM 	usuario u,
 					usuario_registrado ur
 			WHERE
 					u.id_usuario = ur.id_usuario
 			AND 	ur.email = ?  "; 
 
	$query = $this->db->query($sql, array($email)); 

	if($query->num_rows() > 0)
		return true;
	else
		return false;
}



}

/* End of file  */
/* Location: ./application/models/ */