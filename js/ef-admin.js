jQuery(document).ready(function() {
	if (jQuery("#ef-catalog-template-pagination").is(':checked')) {
		jQuery("#ef-template-pagination-options").show();
	} else {
		jQuery("#ef-template-pagination-options").hide();
	}
	jQuery("input[name='ef-catalog-template']").change(function() {
		if (jQuery("#ef-catalog-template-pagination").is(':checked')) {
			jQuery("#ef-template-pagination-options").show();
		} else {
			jQuery("#ef-template-pagination-options").hide();
		}
	});
	jQuery("#ef-catalog-pagination-per-page").blur(function() {
		if (jQuery(this).val() && jQuery(this).val() > 0) {
			jQuery('#ef-catalog-pagination-bottom').prop('checked', true);
		} else {
			jQuery('#ef-catalog-pagination-top').prop('checked', false);
			jQuery('#ef-catalog-pagination-bottom').prop('checked', false);
		}
	});
});