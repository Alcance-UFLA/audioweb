$(document).ready(function(){

	// Ajustar form
	var form = $("#form-mapear");
	form.find("#regiao-tipo-regiao").prop("readonly", true).attr("readonly", true);
	form.find("#regiao-coordenadas").prop("readonly", true).attr("readonly", true);

	// Obter imagem
	var img = $("#imagem");
	img.one("load", function(){
		var img = $(this);

		// Iniciar
		var tipo_regiao = form.find("#regiao-tipo-regiao").val();
		$(".btn-" + tipo_regiao).click();
		var coordenadas = form.find("#regiao-coordenadas").val();
		if (coordenadas.length > 0) {
			var array_coordenadas = coordenadas.split(",");
			var finalizado = true;
			var imprimir_inicial = true;
		} else {
			var array_coordenadas = new Array();
			var finalizado = false;
			var imprimir_inicial = false;
		}

		// Criar canvas
		var canvas = $('<canvas id="canvas" width="' + img.width() + '" height="' + img.height() + '"></canvas>');
		canvas.css({
			"position": "absolute",
			"border": "1px solid blue",
			"display": "block",
			"cursor": "crosshair",
			"margin": "-1px 0 0 -1px"
		});

		// Inserir canvas sobre a imagem
		canvas.insertBefore(img);

		// Iniciar canvas
		canvas.data("tipo_regiao", tipo_regiao);
		canvas.data("coordenadas", array_coordenadas);
		canvas.data("finalizado", finalizado);
		$(".btn-salvar").prop("disabled", !finalizado);

		if (imprimir_inicial) {
			switch (tipo_regiao) {
			case "poly":
				desenhar_poligono(canvas);
				break;
			case "rect":
				desenhar_retangulo(canvas);
				break;
			case "circle":
				desenhar_circulo(canvas);
				break;
			}
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
					desenhar_poligono(canvas);
				}
				break;
			}
		});

		/**
		 * Limpou as marcacoes
		 */
		$(".btn-limpar-regiao").click(function(){
			$("#canvas").data("coordenadas", new Array()).data("finalizado", false);
			$(".btn-salvar").prop("disabled", true);
			limpar_desenho($("#canvas"));
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
				if (canvas.data("coordenadas").length > 4) {
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
				desenhar_poligono(canvas);
				break;
			}
		});

		/**
		 * Pressionou o mouse
		 * Modo retangulo: marcar ponto onde iniciou o retangulo
		 * Modo circulo: marcar centro do circulo
		 */
		canvas.mousedown(function(e){
			var canvas = $("#canvas");
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
		canvas.mouseup(function(e){
			var canvas = $("#canvas");
			if (canvas.data("finalizado")) {
				return;
			}

			// Detectando o ponto da imagem que o usuario soltou o mouse
			var ponto = {
				"x": parseInt(e.pageX - canvas.offset().left),
				"y": parseInt(e.pageY - canvas.offset().top)
			};

			switch (canvas.data("tipo_regiao")) {
			case "rect":
				canvas.data("coordenadas").push(ponto.x);
				canvas.data("coordenadas").push(ponto.y);
				refazer_coordenadas(canvas);
				canvas.data("finalizado", true);
				$(".btn-salvar").prop("disabled", false);

				limpar_desenho(canvas);
				desenhar_retangulo(canvas);
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
		 * Mover mouse sobre o canvas
		 * Modo poligono: redesenhar poligono considerando novo ponto
		 * Modo retangulo: redesenhar retangulo considerando novo ponto final
		 * Modo circulo: redesenhar circulo considerando novo ponto final
		 */
		canvas.mousemove(function(e){
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
				canvas.data("coordenadas").push(ponto.x);
				canvas.data("coordenadas").push(ponto.y);
				limpar_desenho(canvas);
				desenhar_poligono(canvas);
				canvas.data("coordenadas").pop();
				canvas.data("coordenadas").pop();
				break;
			case "rect":
				canvas.data("coordenadas").push(ponto.x);
				canvas.data("coordenadas").push(ponto.y);
				limpar_desenho(canvas);
				desenhar_retangulo(canvas);
				canvas.data("coordenadas").pop();
				canvas.data("coordenadas").pop();
				break;
			case "circle":
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

function desenhar_poligono(canvas) {
	try {
		var context = canvas[0].getContext("2d");

		// Desenhar linhas
		if (canvas.data("coordenadas").length > 2) {
			if (canvas.data("finalizado")) {
				context.beginPath();
			}
			var ponto_anterior = {
				"x": canvas.data("coordenadas")[0],
				"y": canvas.data("coordenadas")[1]
			};
			context.moveTo(ponto_anterior.x, ponto_anterior.y);
			for (i = 2; i < canvas.data("coordenadas").length; i += 2) {
				var ponto = {
					"x": canvas.data("coordenadas")[i],
					"y": canvas.data("coordenadas")[i + 1],
				};
				context.lineTo(ponto.x, ponto.y);
				ponto_anterior = ponto;
			}
			context.lineWidth = 1;
			context.strokeStyle = "#FF0000";
			if (canvas.data("finalizado")) {
				context.closePath();
			}
			context.stroke();
		}

	} catch (e) {
		window.alert(e.message);
	}
}

function desenhar_retangulo(canvas) {
	try {
		var context = canvas[0].getContext("2d");

		if (canvas.data("coordenadas").length == 4) {
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

			context.lineWidth = 1;
			context.strokeStyle = "#FF0000";
			context.rect(x, y, largura, altura);
			context.stroke();
		}

	} catch (e) {
		window.alert(e.message);
	}
}

function desenhar_circulo(canvas) {
	try {
		var context = canvas[0].getContext("2d");

		if (canvas.data("coordenadas").length == 3) {
			var ponto_centro = {
				"x": canvas.data("coordenadas")[0],
				"y": canvas.data("coordenadas")[1]
			};
			var raio = canvas.data("coordenadas")[2];

			context.lineWidth = 1;
			context.strokeStyle = "#FF0000";
			context.arc(ponto_centro.x, ponto_centro.y, raio, 0, 2 * Math.PI);
			context.stroke();
		}

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
		var conteudo = "";
		var virgula = "";
		for (var i in canvas.data("coordenadas")) {
			var item = canvas.data("coordenadas")[i]
			conteudo += virgula + item;
			virgula = ",";
		}
		coordenadas.val(conteudo);
	} else {
		coordenadas.val("");
	}
	console.log(coordenadas.val());
}