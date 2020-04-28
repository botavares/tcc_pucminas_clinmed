<?php
$controler = "Consultas";
$assunto = "Agendar Consultas Médicas";
$anoAtual = date('Y');
$refer =  base_url()."Home/iniciar/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2><small>Agendar Consulta</small> Escolha do médico ou especialidade</h2>
				<div class="clearfix"></div>
			</div>
			<?php
				if($this->session->flashdata('mensagemok')):?>
					<div id="porta-mensagem">
						<div class="mensagem alert alert-success alert-block alert-aling" role="alert">
							<?php echo $this->session->flashdata('mensagemok')?>
						</div>
					</div>
			<?php endif;?>
			<?php
				if($this->session->flashdata('mensagemerror')):?>
					<div id="porta-mensagem">
						<div class="mensagem alert alert-danger alert-block alert-aling" role="alert">
							<?php echo $this->session->flashdata('mensagemerror')?>
						</div>
					</div>
			<?php endif;?>
			
			<table id="datatable-fixed-header" class="table table-striped table-bordered">
				<thead>
					<tr>
						<?php
							for($i = 0,$j=count($titulosTabela);$i<$j;$i++){
						?>
						<th><?php echo $titulosTabela[$i]?></th>
						<?php 
							}
						?>
						<th>Escolher</th>
						
					</tr>
				</thead>
				<tbody>
						<?php
							foreach($dados as $keyDados){?>
					<tr>
						<td><?php echo $keyDados['ds_nome_profissional']?></td>
						<td><?php echo $keyDados['ds_nome_especialidade']?></td>


						<td align="center"><a href="<?php echo base_url().'Recepcao/formAgendarConsultas/'.$keyDados['pk_id_profissional'].'/'.$anoAtual?>" data-id="<?php echo $keyDados["pk_id_profissional"]?>"> <i class="fa fa-check"></i></a>
						</td>
					</tr>
						<?php } ?>
				</tbody>
			</table>
			<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
		</div>
	</div>
</div>