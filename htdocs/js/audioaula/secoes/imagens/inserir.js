$(document).ready(function(){
	$(".lista-imagens").each(function(){

		// Cada label
		$(this).find("label").each(function(){

			// Gerar hash para busca
			$(this).data("hash", gerar_hash($(this).find(".valor-nome").html()));

			// Ao clicar no label: Marcar o radio
			$(this).click(function(){
				$(this).find("input:radio").prop("checked", true).change();
			});
		});

		// Cada input radio
		$(this).find("input:radio").each(function(){

			// Esconder
			$(this).hide();

			// Ao mudar o radio: ajustar classe do label
			$(this).change(function(){
				$(this).parents(".lista-imagens").find("label").removeClass("active")
				$(this).parents("label").addClass("active");
			});
		});

		// Adicionar campo para localizar imagem
		var campo_busca = $('<div class="input-group area-busca-imagem"><div class="input-group-addon"><i class="glyphicon glyphicon-search"></i></div><input type="search" class="form-control busca-imagem" placeholder="Digite o nome da imagem para buscar" /></div>');
		campo_busca.find(".busca-imagem").each(function(){

			// Ao digitar "Enter": ignorar
			$(this).keypress(function(event){
				if (event.which == 13) {
					event.preventDefault();
					return false;
				}
			});

			// Ao digitar algo no campo de busca: buscar imagens
			$(this).on("propertychange keyup input paste", function(event){
				var lista = $(".lista-imagens");
				var str = gerar_hash($(this).val());
				if (str.length > 0) {
					lista.find("label").each(function(i, label){
						if ($(label).data("hash").search(str) >= 0) {
							$(label).parents("li").removeClass("hide");
						} else {
							$(label).parents("li").addClass("hide");
						}
					});
				} else {
					lista.find("li").removeClass("hide");
				}
				lista.find(".nenhum").remove();
				if (lista.find("li:not(.hide)").length == 0) {
					lista.append($('<div class="nenhum text-muted text-center">Nada encontrado</div>'));
				}
			});
		});
		$(this).parent().prepend(campo_busca);
	});

});

function gerar_hash(str) {
    return str
		.toLowerCase()
		.replace(/[áàâã]/g, "a")
		.replace(/[éèêẽ]/g, "e")
		.replace(/[íìîĩ]/g, "i")
		.replace(/[óòôõ]/g, "o")
		.replace(/[úùûüũ]/g, "u")
		.replace(/[ç]/g, "c")
		.replace(/[^\w]/g, "")
}