(function($) {

	$(function() {

		var $hpSearchInput       = $('.hpkb__search-input');
		var $hpSearchSuggestions = $('.hpkb__search-suggestions');

		$hpSearchInput.devbridgeAutocomplete({
			serviceUrl: hpkb_l10n.admin_ajax,
			params: {
				action: 'hpkb_autocomplete_suggestions',
			},
			appendTo: $hpSearchSuggestions,
			forceFixPosition: true,
		});

	});

})(window.jQuery);
