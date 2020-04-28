<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }
	
	public function clientesMedico($idMedico=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by("a.ds_nome_cliente", 'ASC');
		$query 		= $default->where("b.fk_id_profissional",$idMedico);
		$query		= $default->join('tb_consultas as b', 'b.fk_id_cliente = a.pk_id_cliente');
		$query 		= $default->from("tb_clientes as a");
		$query 		= $default->select("a.pk_id_cliente,a.ds_nome_cliente,a.ds_cpf_cliente,a.ds_logradouro,a.ds_numresidencia,a.ds_complemento,a.ds_bairro,a.ds_cidade,a.ds_telfixo,a.ds_telcel,a.ds_email");
		$query 		= $default->distinct();
		$query 		= $default->get();
		return $query->result_array();
	}
	
}