<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="box">
	<?php echo Form::open('usuario/salvar'); ?>
	<?php echo Form::hidden('id', $usuario->id) ?>
	<b><?php echo ($usuario->id) ? 'Editar' : 'Adicionar' ?> usuário</b><br />
	Nome:<br /><?php echo Form::input('nome', $usuario->nome) ?><br />
	Usuário:<br /><?php echo Form::input('usuario', $usuario->usuario) ?><br />
	<?php echo Form::button('submit','Salvar') ?> 
	<?php echo Form::close(); ?>
	
	<?php if(isset($erros)): ?>
	<b>Dados enviados possuem erros:</b>
	<ul>
		<?php foreach ($erros as $key => $valor): ?>
	    <li><b><?php echo $key ?>:</b> <?php echo $valor ?></li>
		<?php endforeach ?>
	</ul>
	<?php endif ?>
</div>