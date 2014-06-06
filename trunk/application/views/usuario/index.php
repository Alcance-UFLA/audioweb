<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="box">
	<b><?php echo html::anchor('usuario/inserir', 'Adicionar Usuário') ?></b><br>
	<table cellpadding="10">
	<?php foreach($usuarios as $usuario): ?>
    <tr>
		<td align="left">
            <?php echo html::anchor('usuario/alterar/'.$usuario->id, 'Editar') ?>
            <?php echo html::anchor('usuario/remover/'.$usuario->id, 'Remover', array('onclick'=>'return confirm("Você deseja remover o registro?")')) ?>
        </td>
		<td align="left">
        	<?php echo $usuario->id.' - '.$usuario->usuario.' - '.$usuario->nome ?>
    	</td>
	</tr>
	<?php endforeach ?>
	</table>
</div>