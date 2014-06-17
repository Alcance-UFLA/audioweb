$(document).ready(function(){

	// Acao ao clicar no botao remover
	$(".btn-remover").click(function(e){
		e.preventDefault();

		var confirmou = window.confirm("Você deseja remover o registro?");
		if ( ! confirmou)
		{
			return false;
		}

		window.location.href = $(this).attr("href") + "/salvar";
	});
});