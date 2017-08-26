(function($) {

	$(function() {

		var $hpSearchInput       = $('.hpkb-search__input');
		var $hpSearchSuggestions = $('.hpkb-search__suggestions');

		$hpSearchInput.devbridgeAutocomplete({
			serviceUrl:       hpkb_l10n.admin_ajax,
			params:           {
				action: 'hpkb_autocomplete_suggestions',
			},
			appendTo:         $hpSearchSuggestions,
			forceFixPosition: true,
		});

	});

})(window.jQuery);
