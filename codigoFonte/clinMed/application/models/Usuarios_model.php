<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model{

	
	public $nomeUsuario  = "";
	public $senhaUsuario = "";
	
//verificar em models no codeigniter documentation
    function __construct(){
        parent::__construct();
    }
	
	public function getUsuario($nomeUsuario = NULL, $senhaUsuario = NULL){
		$default = $this->load->database('default', TRUE);
		
		$query = "
		SELECT pk_id_usuario,ds_nome_usuario,ds_nivel,fk_id_profissional,ds_nome_profissional,ds_nome_cargo,ds_sexo
		FROM tb_usuarios,tb_profissionais,tb_cargos
		WHERE ds_nome_usuario = '$nomeUsuario' 
		AND ds_senha_usuario = '$senhaUsuario'
		AND tb_usuarios.fk_id_profissional = tb_profissionais.pk_id_profissional
		AND tb_cargos.pk_id_cargo = tb_profissionais.fk_id_cargo";
		$query = $default->query($query);
		return $query->result_array();
	}
	
	public function readUsuarios(){
		$default = $this->load->database('default', TRUE);
		$query = "SELECT pk_id_usuario,ds_nome_usuario,ds_nivel,fk_id_profissional,ds_nome_profissional,ds_nome_cargo,ds_sexo
		FROM tb_usuarios,tb_profissionais,tb_cargos
		WHERE 
		tb_usuarios.fk_id_profissional = tb_profissionais.pk_id_profissional
		AND
		tb_profissionais.fk_id_cargo = tb_cargos.pk_id_cargo
		ORDER BY
		ds_nome_profissional
		";
		$query = $default->query($query);
		return $query->result_array();
	}
	//Selecionar apenas profissionais sem usuários
	public function readProfSemUsuarios(){
		$default = $this->load->database('default', TRUE);
		$query = "SELECT pk_id_profissional,ds_nome_profissional,ds_sexo 
				FROM tb_profissionais 
				WHERE pk_id_profissional NOT IN(SELECT fk_id_profissional FROM tb_usuarios)
		";
		$query = $default->query($query);
		return $query->result_array();
	}
	//selecionar dados do profissional de acordo com o id do usuário
	public function readUsuarioProfissional($id=NULL){
		$default = $this->load->database('default', TRUE);
		$query = "SELECT pk_id_usuario, ds_nome_usuario,ds_nivel, fk_id_profissional,ds_nome_profissional,ds_sexo
				FROM tb_profissionais,tb_usuarios
				WHERE 
				tb_profissionais.pk_id_profissional = tb_usuarios.fk_id_profissional
				AND
				tb_usuarios.pk_id_usuario = $id
		";
		$query = $default->query($query);
		return $query->result_array();
	}
	
}