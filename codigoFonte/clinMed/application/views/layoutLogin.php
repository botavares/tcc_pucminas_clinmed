<?php
//carrega a view com o cabeçalho//
$this->load->view('fixos/header');

$this->load->view($camada1 .'/'.$camada2 . '/' . $pagina.'_view');

$this->load->view('fixos/footer');
?>   