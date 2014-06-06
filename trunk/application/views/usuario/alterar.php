<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="box">
	<?php echo Form::open('usuario/alterar/salvar/'); ?>
	<?php echo Form::hidden('id', $usuario->id) ?>
	<b>Editar usuário</b><br />
	Nome:<br /><?php echo Form::input('nome', $usuario->nome) ?><br />
	Usuário:<br /><?php echo Form::input('usuario', $usuario->usuario) ?><br />
	<?php echo Form::button('submit','Salvar') ?> 
	<?php echo Form::close(); ?>
</div>