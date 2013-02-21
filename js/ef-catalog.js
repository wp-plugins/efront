jQuery(document).ready(function() {
	jQuery('.ef-toggle-category').click(function() {
		var id = jQuery(this).attr('id').split("-")[2];
		jQuery('#ef-category-contents-' + id).toggle('slow');
	});

	jQuery('.ef-internal').click(function() {
		var to = jQuery(this).attr('href');
    	var toWrapped = jQuery(to);
		scrollToDiv(toWrapped, 40);
		return false;
	});
});

function scrollToDiv(element, navheight) {
	var offset = element.offset();
	var offsetTop = offset.top;
	var totalScroll = offsetTop - navheight;

	jQuery('body,html').animate({
		scrollTop : totalScroll
	}, 500);
}
