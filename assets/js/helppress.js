(function($) {

	$(function() {

		var $hpSearchInput       = $('.helppress__search-input');
		var $hpSearchSuggestions = $('.helppress__search-suggestions');

		$hpSearchInput.devbridgeAutocomplete({
			serviceUrl: hpLocalization.adminAjax,
			params: {
				action: 'helppress_autocomplete_suggestions',
			},
			appendTo: $hpSearchSuggestions,
			forceFixPosition: true,
		});

	});

})(window.jQuery);
