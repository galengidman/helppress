(function($) {

	$(function() {

		var $searchInput = $('.helppress-search__input--suggest');
		var $searchSuggestions = $('.helppress-search__suggestions');

		$searchInput.devbridgeAutocomplete({
			serviceUrl: helppressL10n.adminAjax,
			params: {
				action: 'helppress_search_suggestions',
			},
			appendTo: $searchSuggestions,
			forceFixPosition: true,
			onSelect: function(suggestion) {
				window.location.href = suggestion.data;
			},
		});

	});

})(window.jQuery);
