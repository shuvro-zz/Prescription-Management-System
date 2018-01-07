jQuery(function() {
	"use strict";

	function initSparklines() {
		$(".content-container").find(".sparkline").sparkline('html', {
			enableTagOptions: true,
			tagOptionsPrefix: "data-"
		});
	}


	function _init() {
		initSparklines();
	}
	_init();

})