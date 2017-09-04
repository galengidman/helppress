(function($) {

	$(function() {

		var $searchInput       = $('.helppress-search__input--suggest');
		var $searchSuggestions = $('.helppress-search__suggestions');

		$searchInput.devbridgeAutocomplete({
			serviceUrl:       helppress_l10n.admin_ajax,
			params:           {
				action: 'helppress_autocomplete_suggestions',
			},
			appendTo:         $searchSuggestions,
			forceFixPosition: true,
		});

	});

})(window.jQuery);
