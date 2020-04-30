<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Inserir Resultados no Exame Médico</h2>
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
			
			<table class="tabela-consulta table table-striped">
			<thead>
				<tr>
					<th>Nome do Exame</th>
					<th>Inserir Resultado</th>
					<th>Excluir</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				foreach($examesDaConsulta as $valExpedidos){
					if(!empty($valExpedidos["ds_resultado_exame"])){
						$check = "<i class='blue fa fa-check'></i> ";
					}else{
						$check = "";
					}
			?>
					<tr>
						<td align="left" class="font12"><?php echo $check.$valExpedidos["ds_nome_exame"]?></td>

							<td align="center"><a class="pointer" id="insereResultadoExame" data-id="<?php echo $valExpedidos["pk_id_exameconsulta"]?>"> <i class="green fa fa-pencil"></i></a></td>
							<td align="center"><a href="<?php echo base_url()."Exames/excluirExame/".$valExpedidos["fk_id_exame"]."/".$idConsulta."/1" ?>"> <i class="red fa fa-trash"></i></a></td>
					</tr>
						<?php 
							}
						?>
			</tbody>
		</table>
		</div>
	</div>
</div>