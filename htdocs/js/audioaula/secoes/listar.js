$(document).ready(function(){

	// Tornar a lista de secoes ordenavel
	$("#lista-secoes").each(function(){

		if ($(this).find(".secao").length > 1) {

			$(this).find(".tipo-secao").each(function(){
				var icone = $('<i class="glyphicon glyphicon-sort text-danger"></i>');
				icone.css("cursor", "move");
				$(this).prepend(icone);
				$(document.createTextNode(" ")).insertAfter(icone);
			});
			$(this).sortable({
				"cursor": "move",
				"handle": ".tipo-secao",
				"items": "> li.secao",
				"stop": function(event, ui){

					// Detectar mudancas
					var params = {
						"mudancas": {}
					};
					var precisa_salvar = false;
					var secoes = $("#lista-secoes .secao");
					for (var i = 0; i < secoes.length; i++) {
						var secao = $(secoes[i]);
						var posicao = i + 1;
						if (secao.data("posicao") != posicao) {
							params.mudancas[secao.data("id-secao")] = posicao;
							precisa_salvar = true;
							secao.data("posicao", posicao);
						}
					}

					// Se encontrou mudancas: salvar
					if (precisa_salvar) {
						$.ajax({
							"type": "POST",
							"url": $(this).data("action-salvar-posicoes"),
							"data": params,
							"success": function(data, text_status, xhr){
								if (!data.sucesso) {
									window.alert("Estamos com problemas para salvar as novas posições das seções.");
								}
								for (var id_secao in data.secoes) {
									$("#secao-" + id_secao + " .numero").text(data.secoes[id_secao]);
								}
							},
							"error": function(){
								window.alert("Estamos com problemas para salvar as novas posições das seções.");
							}
						});
					}
				}
			});
			$(this).disableSelection();
		}

		// Tornar os itens das secoes ordenavel
		$(this).find(".lista-itens-secao").each(function(){
			if ($(this).find(".item-secao").length > 1) {
				$(this).find(".tipo-item-secao").each(function(){
					var icone = $('<i class="glyphicon glyphicon-sort text-success"></i>');
					icone.css("cursor", "move");
					$(this).prepend(icone);
					$(document.createTextNode(" ")).insertAfter(icone);
				});

				var that = $(this);
				$(this).sortable({
					"cursor": "move",
					"handle": ".tipo-item-secao",
					"items": "> li.item-secao",
					"stop": function(event, ui){

						// Detectar mudancas
						var params = {
							"id_secao": $(this).data("id-secao"),
							"mudancas": {}
						};
						var precisa_salvar = false;
						var itens = that.find(".item-secao");
						for (var i = 0; i < itens.length; i++) {
							var item = $(itens[i]);
							var posicao = i + 1;
							if (item.data("posicao") != posicao) {
								params.mudancas[item.data("id-item-secao")] = posicao;
								precisa_salvar = true;
								item.data("posicao", posicao);
							}
						}

						// Se encontrou mudancas: salvar
						if (precisa_salvar) {
							$.ajax({
								"type": "POST",
								"url": $(this).data("action-salvar-posicoes"),
								"data": params,
								"success": function(data, text_status, xhr){
									if (!data.sucesso) {
										window.alert("Estamos com problemas para salvar as novas posições dos itens.");
									}
								},
								"error": function(){
									window.alert("Estamos com problemas para salvar as novas posições dos itens.");
								}
							});
						}
					}
				});
				$(this).disableSelection();
			}
		});
	});
});