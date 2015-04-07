$(document).ready(function(){
	$('[data-toggle="popover"]').popover();
});

jQuery.fn.single_double_click = function(single_click_callback, double_click_callback, opt) {
	return this.each(function(){
		var clicks = 0, self = this;
		jQuery(this).click(function(event){
			if (opt.prevent) {
				event.preventDefault();
			}
			clicks++;
			if (clicks == 1) {
				setTimeout(function(){
					if(clicks == 1) {
						single_click_callback.call(self, event);
					} else {
						double_click_callback.call(self, event);
					}
					clicks = 0;
				}, opt.timeout || 300);
			}
		});
	});
}
