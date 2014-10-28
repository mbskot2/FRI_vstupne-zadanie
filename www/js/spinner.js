(function ($, undefined) {
	$.nette.ext('spinner', {
		init: function () {
			this.spinner = $('<div>', {
				id: 'ajax-spinner',
				css: {
					display: 'none'
				}
			});
			this.spinner.appendTo('body');
		},
		start: function () {
			var widowHeight = $(window).height();
			var windowWidth = $(window).width();

			this.spinner.css({
				top: ((widowHeight - this.spinner.outerHeight()) / widowHeight * 50) + "%",
				left: ((windowWidth - this.spinner.outerWidth()) / windowWidth * 50) + "%"
			});
			this.spinner.show(this.speed);
		},
		complete: function () {
			this.spinner.hide(this.speed);
		}
	}, {
		spinner: null,
		speed: undefined
	});
})(jQuery);