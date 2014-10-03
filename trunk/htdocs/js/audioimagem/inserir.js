$(document).ready(function(){
	$('form:has(input[name=MAX_FILE_SIZE])').submit(function(e){
		var arquivo = $("input[type=file]");
		var max = $("input[name=MAX_FILE_SIZE]").val();
		if (arquivo[0].files.length > 0) {
			var tamanho = arquivo[0].files[0].size;
			if (tamanho > max) {
				e.preventDefault();
				arquivo[0].setCustomValidity("Selecione um arquivo com tamanho máximo " + $("input[name=MAX_FILE_SIZE]").val() + " bytes.");
			}
		}
	});
});