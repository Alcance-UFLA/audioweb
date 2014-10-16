$(document).ready(function(){

	// Ajustar form
	var form = $("#form-mapear");
	form.find("#regiao-tipo-regiao").prop("readonly", true).attr("readonly", true);
	form.find("#regiao-coordenadas").prop("readonly", true).attr("readonly", true);

	// Obter imagem
	var img = $("#imagem");
	img.one("load", function(){
		var img = $(this);

		// Tornar o tamanho da imagem estatico
		img.css({
			"width": img.width(),
			"height": img.height()
		});
		img.removeClass("img-responsive");

		// Definir o tipo de regiao
		var tipo_regiao = form.find("#regiao-tipo-regiao").val();
		$(".btn-" + tipo_regiao).click();
		var coordenadas = form.find("#regiao-coordenadas").val();
		if (coordenadas.length > 0) {
			var array_coordenadas = coordenadas.split(",");
			var finalizado = true;
			var imprimir_inicial = true;

			// Calcular o percentual de diferenca entre a imagem original e a imagem mostrada
			var percentual_ajuste = img.width() / img.data("largura-original");
			var array_coordenadas_ajustado = new Array();
			for (var i in array_coordenadas) {
				var item = array_coordenadas[i] * percentual_ajuste;
				array_coordenadas_ajustado.push(item);
			}
			array_coordenadas = array_coordenadas_ajustado;

		} else {
			var array_coordenadas = new Array();
			var finalizado = false;
			var imprimir_inicial = false;
		}

		// Definir a cor de selecao
		var cor_selecao = $("#cor-selecao").val();

		// Criar canvas
		var canvas = $('<canvas id="canvas" width="' + img.width() + '" height="' + img.height() + '"></canvas>');
		canvas.css({
			"position": "absolute",
			"display": "block",
			"cursor": "crosshair",
			"z-index": "2"
		});

		// Inserir canvas sobre a imagem
		canvas.insertBefore(img);

		// Iniciar canvas
		canvas.data("tipo_regiao", tipo_regiao);
		canvas.data("cor_selecao", cor_selecao);
		canvas.data("coordenadas", array_coordenadas);
		canvas.data("finalizado", finalizado);
		canvas.data("arrastando", false);

		$(".btn-salvar").prop("disabled", !finalizado);

		if (imprimir_inicial) {
			desenhar_regiao(tipo_regiao, canvas, false);
			$("#modal-form-regiao").modal();
		}

		/// Eventos

		/**
		 * Alterou o modo de marcacao: atualizar o canvas e limpar o desenho
		 */
		$("input[name=btn_tipo_regiao]").change(function(){
			$(".btn-limpar-regiao").click();
			$("#canvas").data("tipo_regiao", $(this).val());
			$("#regiao-tipo-regiao").val($(this).val());

			switch ($(this).val()) {
			case "poly":
				$(".btn-voltar-ponto").show();
				break;
			case "rect":
			case "circle":
				$(".btn-voltar-ponto").hide();
				break;
			}
		});

		/**
		 * Alterou a cor de selecao: atualizar o canvas
		 */
		$("#cor-selecao").change(function(){
			var canvas = $("#canvas");
			canvas.data("cor_selecao", $(this).val());
			limpar_desenho(canvas);
			desenhar_regiao(canvas.data("tipo_regiao"), canvas, false);
		});

		/**
		 * Voltar ultimo ponto do poligono
		 */
		$(".btn-voltar-ponto").click(function(){
			var canvas = $("#canvas");
			switch (canvas.data("tipo_regiao")) {
			case "poly":
				if (canvas.data("coordenadas").length > 2) {
					canvas.data("coordenadas").pop();
					canvas.data("coordenadas").pop();
					canvas.data("finalizado", false);
					$(".btn-salvar").prop("disabled", true);
					refazer_coordenadas(canvas);
					limpar_desenho(canvas);
					desenhar_poligono(canvas, false);
				}
				break;
			}
		});

		/**
		 * Limpou as marcacoes
		 */
		$(".btn-limpar-regiao").click(function(){
			var canvas = $("#canvas");
			canvas.data("coordenadas", new Array());
			canvas.data("finalizado", false);
			$(".btn-salvar").prop("disabled", true);
			limpar_desenho(canvas);
			refazer_coordenadas(canvas);
		});

		/**
		 * Clique simples
		 * Modo poligono: adiciona um ponto ao poligono
		 */
		canvas.click(function(e){
			var canvas = $("#canvas");
			if (canvas.data("finalizado")) {
				return;
			}

			// Detectando o ponto da imagem que o usuario clicou
			var ponto = {
				"x": parseInt(e.pageX - canvas.offset().left),
				"y": parseInt(e.pageY - canvas.offset().top)
			};

			switch (canvas.data("tipo_regiao")) {
			case "poly":

				// Determinar se fechou o poligono
				var fechou_poligono = false;
				if (canvas.data("coordenadas").length >= 6) {
					var limite = 5;
					var primeiro_ponto = {
						"x": canvas.data("coordenadas")[0],
						"y": canvas.data("coordenadas")[1]
					};
					fechou_poligono = Math.abs(primeiro_ponto.x - ponto.x) < limite && Math.abs(primeiro_ponto.y - ponto.y) < limite;
				}

				if (fechou_poligono) {
					canvas.data("finalizado", true);
					$(".btn-salvar").prop("disabled", false);
				} else {
					canvas.data("coordenadas").push(ponto.x);
					canvas.data("coordenadas").push(ponto.y);
					refazer_coordenadas(canvas);
				}

				// Redesenhar o poligono
				limpar_desenho(canvas);
				desenhar_poligono(canvas, false);
				break;
			}
		});

		/**
		 * Pressionou o mouse
		 * Modo retangulo: marcar ponto onde iniciou o retangulo
		 * Modo circulo: marcar centro do circulo
		 */
		canvas.mousedown(function(e){
			if (e.which != 1) {
				return;
			}
			var canvas = $("#canvas");

			// Limpar mapeamento não salvo
			if (canvas.data("finalizado")) {
				$(".btn-limpar-regiao").click();
			}

			// Detectando o ponto da imagem que o usuario comecou a pressionar
			var ponto = {
				"x": parseInt(e.pageX - canvas.offset().left),
				"y": parseInt(e.pageY - canvas.offset().top)
			};

			switch (canvas.data("tipo_regiao")) {
			case "rect":
			case "circle":
				canvas.data("arrastando", true);
				canvas.data("coordenadas").push(ponto.x);
				canvas.data("coordenadas").push(ponto.y);
				refazer_coordenadas(canvas);
				break;
			}
		});

		/**
		 * Soltou o mouse
		 * Modo retangulo: marcar ponto onde terminou o retangulo
		 * Modo circulo: marcar o raio do circulo
		 */
		$(window).mouseup(function(e){
			var canvas = $("#canvas");
			if (canvas.data("finalizado") || !canvas.data("arrastando")) {
				return;
			}

			canvas.data("arrastando", false);

			// Detectando o ponto da imagem que o usuario soltou o mouse
			var ponto = {
				"x": parseInt(e.pageX - canvas.offset().left),
				"y": parseInt(e.pageY - canvas.offset().top)
			};

			switch (canvas.data("tipo_regiao")) {
			case "rect":

				// Limitar o ponto a regiao da imagem
				if (ponto.x < 0) {
					ponto.x = 0;
				} else if (ponto.x > canvas.width()) {
					ponto.x = canvas.width();
				}
				if (ponto.y < 0) {
					ponto.y = 0;
				} else if (ponto.y > canvas.height()) {
					ponto.y = canvas.height();
				}

				var limite = 5;
				var primeiro_ponto = {
					"x": canvas.data("coordenadas")[0],
					"y": canvas.data("coordenadas")[1]
				};

				// Se o ponto eh muito proximo do ponto inicial: abortar
				if (Math.abs(primeiro_ponto.x - ponto.x) < limite && Math.abs(primeiro_ponto.y - ponto.y) < limite) {
					$(".btn-limpar-regiao").click();
				} else {

					// Sempre colocar o primeiro ponto a esquerda/topo e o segundo a direita/base
					if (ponto.x < primeiro_ponto.x) {
						var x1 = ponto.x;
						var x2 = primeiro_ponto.x;
					} else {
						var x1 = primeiro_ponto.x;
						var x2 = ponto.x;
					}
					if (ponto.y < primeiro_ponto.y) {
						var y1 = ponto.y;
						var y2 = primeiro_ponto.y;
					} else {
						var y1 = primeiro_ponto.y;
						var y2 = ponto.y;
					}

					canvas.data("coordenadas", new Array());
					canvas.data("coordenadas").push(x1);
					canvas.data("coordenadas").push(y1);
					canvas.data("coordenadas").push(x2);
					canvas.data("coordenadas").push(y2);
					refazer_coordenadas(canvas);
					canvas.data("finalizado", true);
					$(".btn-salvar").prop("disabled", false);

					limpar_desenho(canvas);
					desenhar_retangulo(canvas);
				}
				break;
			case "circle":
				var ponto_centro = {
					"x": canvas.data("coordenadas")[0],
					"y": canvas.data("coordenadas")[1]
				};
				var raio = calcular_raio(ponto_centro, ponto);
				canvas.data("coordenadas").push(raio);
				refazer_coordenadas(canvas);
				canvas.data("finalizado", true);
				$(".btn-salvar").prop("disabled", false);

				limpar_desenho(canvas);
				desenhar_circulo(canvas);
				break;
			}
		});

		/**
		 * Mover mouse
		 * Modo poligono: redesenhar poligono considerando novo ponto
		 * Modo retangulo: redesenhar retangulo considerando novo ponto final
		 * Modo circulo: redesenhar circulo considerando novo ponto final
		 */
		$(window).mousemove(function(e){
			var canvas = $("#canvas");
			if (canvas.data("finalizado")) {
				return;
			}

			// Detectando o ponto da imagem que o usuario esta
			var ponto = {
				"x": parseInt(e.pageX - canvas.offset().left),
				"y": parseInt(e.pageY - canvas.offset().top)
			};

			switch (canvas.data("tipo_regiao")) {
			case "poly":

				var fechara_poligono = false;
				if (canvas.data("coordenadas").length >= 6) {
					var limite = 5;
					var primeiro_ponto = {
						"x": canvas.data("coordenadas")[0],
						"y": canvas.data("coordenadas")[1]
					};
					fechara_poligono = Math.abs(primeiro_ponto.x - ponto.x) < limite && Math.abs(primeiro_ponto.y - ponto.y) < limite;
				}

				canvas.data("coordenadas").push(ponto.x);
				canvas.data("coordenadas").push(ponto.y);
				limpar_desenho(canvas);
				desenhar_poligono(canvas, fechara_poligono);
				canvas.data("coordenadas").pop();
				canvas.data("coordenadas").pop();
				break;
			case "rect":
				if (!canvas.data("arrastando")) {
					return;
				}
				canvas.data("coordenadas").push(ponto.x);
				canvas.data("coordenadas").push(ponto.y);
				limpar_desenho(canvas);
				desenhar_retangulo(canvas);
				canvas.data("coordenadas").pop();
				canvas.data("coordenadas").pop();
				break;
			case "circle":
				if (!canvas.data("arrastando")) {
					return;
				}
				var ponto_centro = {
					"x": canvas.data("coordenadas")[0],
					"y": canvas.data("coordenadas")[1]
				};
				var raio = calcular_raio(ponto_centro, ponto);
				canvas.data("coordenadas").push(raio);
				limpar_desenho(canvas);
				desenhar_circulo(canvas);
				canvas.data("coordenadas").pop();
				break;
			}
		});
	}).each(function(){
		if (this.complete) {
			$(this).load();
		}
	});

});

/**
 * Limpa o desenho do canvas
 * @param HTMLCanvas canvas
 * @return void
 */
function limpar_desenho(canvas) {
	try {
		var context = canvas[0].getContext("2d");
		context.beginPath();
		context.clearRect(0, 0, canvas.width(), canvas.height());
		context.closePath();
		context.stroke();
	} catch (e) {
		window.alert(e.message);
	}
}

/**
 * Desenha uma regiao de acordo com o tipo
 * @param string tipo_regiao
 * @param HTMLCanvas canvas
 * @param bool fechara_poligono Flag para desenhar uma bolinha quando estiver para fechar o poligono
 * @return void
 */
function desenhar_regiao(tipo_regiao, canvas, fechara_poligono) {
	switch (tipo_regiao) {
	case "poly":
		desenhar_poligono(canvas, fechara_poligono);
		break;
	case "rect":
		desenhar_retangulo(canvas);
		break;
	case "circle":
		desenhar_circulo(canvas);
		break;
	}
}

/**
 * Desenha um poligono no canvas.
 * @param HTMLCanvas canvas
 * @param bool fechara_poligono Flag para desenhar uma bolinha quando estiver para fechar o poligono
 * @return void
 */
function desenhar_poligono(canvas, fechara_poligono) {
	if (canvas.data("coordenadas").length <= 2) {
		return;
	}
	try {
		var context = canvas[0].getContext("2d");

		// Desenhar linhas
		if (canvas.data("finalizado")) {
			context.beginPath();
		}
		var ponto_anterior = {
			"x": canvas.data("coordenadas")[0],
			"y": canvas.data("coordenadas")[1]
		};
		context.moveTo(ponto_anterior.x, ponto_anterior.y);

		var total_coordenadas = canvas.data("coordenadas").length;
		for (var i = 2; i < total_coordenadas; i += 2) {
			var ponto = {
				"x": canvas.data("coordenadas")[i],
				"y": canvas.data("coordenadas")[i + 1],
			};
			context.lineTo(ponto.x, ponto.y);
			ponto_anterior = ponto;
		}
		context.lineWidth = 2;
		context.strokeStyle = canvas.data("cor_selecao");
		context.fillStyle = obter_cor_transparente(canvas.data("cor_selecao"), 0.2);
		if (canvas.data("finalizado")) {
			context.closePath();
		}
		context.stroke();
		context.fill();

		// Desenhar bolinha indicando o fechamento do poligono
		if (fechara_poligono) {
			context.beginPath();
			context.strokeStyle = "#000000";
			context.fillStyle = canvas.data("cor_selecao");
			context.arc(canvas.data("coordenadas")[0], canvas.data("coordenadas")[1], 10, 0, 2 * Math.PI, false);
			context.closePath();

			context.stroke();
			context.fill();
		}

	} catch (e) {
		window.alert(e.message);
	}
}

/**
 * Desenha um retangulo no canvas.
 * @param HTMLCanvas canvas
 * @return void
 */
function desenhar_retangulo(canvas) {
	if (canvas.data("coordenadas").length != 4) {
		return;
	}

	try {
		var context = canvas[0].getContext("2d");

		var ponto_inicio = {
			"x": canvas.data("coordenadas")[0],
			"y": canvas.data("coordenadas")[1]
		};
		var ponto_fim = {
			"x": canvas.data("coordenadas")[2],
			"y": canvas.data("coordenadas")[3],
		};
		var x = (ponto_inicio.x < ponto_fim.x) ? ponto_inicio.x : ponto_fim.x;
		var y = (ponto_inicio.y < ponto_fim.y) ? ponto_inicio.y : ponto_fim.y;
		var largura = Math.abs(ponto_inicio.x - ponto_fim.x);
		var altura = Math.abs(ponto_inicio.y - ponto_fim.y);

		context.lineWidth = 2;
		context.strokeStyle = canvas.data("cor_selecao");
		context.fillStyle = obter_cor_transparente(canvas.data("cor_selecao"), 0.2);
		context.rect(x, y, largura, altura);
		context.stroke();
		context.fill();

	} catch (e) {
		window.alert(e.message);
	}
}

/**
 * Desenha um circulo no canvas.
 * @param HTMLCanvas canvas
 * @return void
 */
function desenhar_circulo(canvas) {
	if (canvas.data("coordenadas").length != 3) {
		return;
	}

	try {
		var context = canvas[0].getContext("2d");

		var ponto_centro = {
			"x": canvas.data("coordenadas")[0],
			"y": canvas.data("coordenadas")[1]
		};
		var raio = canvas.data("coordenadas")[2];

		context.lineWidth = 2;
		context.strokeStyle = canvas.data("cor_selecao");
		context.fillStyle = obter_cor_transparente(canvas.data("cor_selecao"), 0.2);
		context.arc(ponto_centro.x, ponto_centro.y, raio, 0, 2 * Math.PI);
		context.stroke();
		context.fill();

	} catch (e) {
		window.alert(e.message);
	}
}

/**
 * Calcula o raio de um circulo com base no ponto central e um ponto da borda
 * @param Object ponto_centro
 * @param Object ponto_borda
 * @return int
 */
function calcular_raio(ponto_centro, ponto_borda) {
	var cateto1 = Math.abs(ponto_centro.x - ponto_borda.x);
	var cateto2 = Math.abs(ponto_centro.y - ponto_borda.y);
	var raio = Math.sqrt(cateto1 * cateto1 + cateto2 * cateto2);
	return Math.round(raio);
}

/**
 * Atualiza o textarea de coordenadas com os novos valores
 * @param Object canvas
 * @return void
 */
function refazer_coordenadas(canvas) {
	var coordenadas = $("#regiao-coordenadas");
	if (canvas.data("coordenadas").length > 0) {

		// Calcular o percentual de diferenca entre a imagem original e a imagem mostrada
		var img = $("#imagem");
		var percentual_ajuste = img.data("largura-original") / img.width();

		var conteudo = "";
		var virgula = "";
		for (var i in canvas.data("coordenadas")) {
			var item = canvas.data("coordenadas")[i];
			item = Math.round(item * percentual_ajuste);
			conteudo += virgula + item;
			virgula = ",";
		}
		coordenadas.val(conteudo);
	} else {
		coordenadas.val("");
	}
}

/**
 * Obtem uma cor HTML com nivel de transparencia
 * @param string cor_html Cor no formato #XXXXXX ou #XXX
 * @param float nivel 0 para mais transparente e 1 para mais opaco
 * @return string
 */
function obter_cor_transparente(cor_html, nivel) {
	if (cor_html.length == 7) {
		var cor = {
			"r": parseInt(cor_html.substr(1, 2), 16),
			"g": parseInt(cor_html.substr(3, 2), 16),
			"b": parseInt(cor_html.substr(5, 2), 16)
		}
	} else if (cor_html.length == 4) {
		var cor = {
			"r": parseInt(cor_html.substr(1, 1) + cor_html.substr(1, 1), 16),
			"g": parseInt(cor_html.substr(2, 1) + cor_html.substr(2, 1), 16),
			"b": parseInt(cor_html.substr(3, 1) + cor_html.substr(3, 1), 16)
		}
	} else {
		return;
	}

	return "rgba(" + cor.r + "," + cor.g + "," + cor.b + ", " + nivel + ")";
}