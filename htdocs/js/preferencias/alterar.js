$(document).ready(function(){
	if (window.location.hash) {
		$(".nav-tabs").data("primeiro-load", true);
		$(".nav-tabs").data("push-state", true);
		$(".nav-tabs a[href=" + hash + "]").tab('show');
		$(".nav-tabs").data("primeiro-load", false);
	} else {
		$(".nav-tabs").data("primeiro-load", false);
		$(".nav-tabs").data("push-state", false);
		history.replaceState({"aba": "#aba-usuario"}, null, "#aba-usuario");
		$(".nav-tabs").data("push-state", true);
	}
});

$('.nav-tabs a').on('shown.bs.tab', function (e) {
	var hash = e.target.hash ? e.target.hash : "#aba-usuario";
	if (history.pushState) {
		if ($(".nav-tabs").data("primeiro-load")) {
			history.replaceState({"aba": hash}, null, hash);
		} else if ($(".nav-tabs").data("push-state")) {
			history.pushState({"aba": hash}, null, hash);
		}
	} else {
		window.location.hash = hash;
	}
});

window.onpopstate = function(e) {
	if (e.state) {
		$(".nav-tabs").data("push-state", false);
		$(".nav-tabs a[href=" + e.state.aba + "]").tab('show');
		$(".nav-tabs").data("push-state", true);
	}
};