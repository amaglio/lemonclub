<?
class MY_Form_validation extends CI_Form_validation {
  
  function __constuct() {
    parent::__constuct();
  }

  function isnt($str,$field){
    $this->CI->form_validation->set_message('isnt', "%s contains an invalid response");
    return $str!==$field;
  }

  // Transforma los erroeres del form_validation en un array.
  public function error_array() {
        return $this->_error_array;
    }
  
}
?>