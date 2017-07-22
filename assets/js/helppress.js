(function($) {

	$(function() {

		var $search = $('.helppress__search');

		$search.devbridgeAutocomplete({
			serviceUrl: hpLocalization.adminAjax,
			params: {
				action: 'helppress_autocomplete_suggestions',
			},
		});

	});

})(window.jQuery);
