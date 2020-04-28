<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicamentos_model extends CI_Model{

	
//verificar em models no codeigniter documentation
    function __construct(){
        parent::__construct();
    }
	public function medicamento_fabricantes(){
		$default 	= $this->load->database('default', TRUE);
		$Sql = 	"SELECT * 
				FROM tb_medicamentos,tb_fabricantemedicamentos
				WHERE
				fk_id_fabricante = pk_id_fabricante
				AND
				ds_dellogico = 'FALSE' 
				ORDER BY
				ds_nome_medicamento
				";
		$query = $default->query($Sql);
		return $query->result_array();
	}
	public function duplicidadeMedicamentos($generico = NULL,$nome = NULL,$apresentacao = NULL,$fabricante=NULL){
		$default 	= $this->load->database('default', TRUE);
		$Sql = 	"SELECT * 
				FROM tb_medicamentos
				WHERE
				ds_nome_generico LIKE '%$generico%'
				AND
				ds_nome_medicamento LIKE '%$nome%'
				AND
				ds_apresentacao LIKE '%$apresentacao%'
				AND
				fk_id_fabricante = $fabricante
				ORDER BY
				ds_nome_medicamento
				";
		$query = $default->query($Sql);
		return $query->result_array();
	}
	
	public function medicamentosInativos(){
		$default = $this->load->database('default', TRUE);
		$Sql = 	"SELECT * 
				FROM tb_medicamentos
				WHERE
				ds_dellogico = 'TRUE'
				ORDER BY
				ds_nome_medicamento
				";
		$query = $default->query($Sql);
		return $query->result_array();
	}
	
	
}