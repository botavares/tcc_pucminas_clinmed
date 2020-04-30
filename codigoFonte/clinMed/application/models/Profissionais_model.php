<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profissionais_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }
	public function profissionaisCargos(){
		$default = $this->load->database('default', TRUE);
		$sql = "SELECT pk_id_profissional, ds_nome_profissional, fk_id_cargo, ds_nome_cargo, ds_telcel
				FROM tb_profissionais, tb_cargos
				WHERE
				tb_profissionais.fk_id_cargo = tb_cargos.pk_id_cargo
				ORDER BY
				ds_nome_profissional";
		$query = $default->query($sql);
        return $query->result_array();
	}
	/*
	public function profissionais_medicos(){
		$default = $this->load->database('default', TRUE);
		$sql = "SELECT *
				FROM tb_profissionais
				WHERE
				tb_profissionais.ds_crm > 0
				ORDER BY
				ds_nome_profissional";
		$query = $default->query($sql);
        return $query->result_array();
	}*/
	
	public function listarMedicosEspecialidades(){
		$default = $this->load->database('default', TRUE);
		
		$sql = "SELECT tb_profissionais.pk_id_profissional,tb_profissionais.ds_nome_profissional, tb_especialidades.ds_nome_especialidade
				FROM tb_profissionais, tb_especialidades
				WHERE
				tb_especialidades.pk_id_especialidade = tb_profissionais.fk_id_especialidade
				AND
				tb_profissionais.ds_crm > 0
				ORDER BY
				tb_profissionais.pk_id_profissional	";
		$query = $default->query($sql);
        return $query->result_array();
	}
	
	public function listarProfissionaisById($id=NULL){
		$default = $this->load->database('default', TRUE);
		$sql = "SELECT pk_id_profissional, ds_nome_profissional, fk_id_cargo, ds_nome_cargo, ds_telcel,ds_crm
				FROM tb_profissionais, tb_cargos
				WHERE
				tb_profissionais.fk_id_cargo = tb_cargos.pk_id_cargo
				AND
				tb_profissionais.pk_id_profissional = $id
				ORDER BY
				ds_nome_profissional";
		$query = $default->query($sql);
        return $query->result_array();
	}
}