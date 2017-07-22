(function($) {

	$(function() {

		var $searchInput = $('.helppress__search-input');

		$searchInput.devbridgeAutocomplete({
			serviceUrl: hpLocalization.adminAjax,
			params: {
				action: 'helppress_autocomplete_suggestions',
			},
		});

	});

})(window.jQuery);
