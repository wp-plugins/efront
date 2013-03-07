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
	
	jQuery('#ef-get-course').click(function() {
		var data = {
			action: 'ef_get_course',
			ef_login: ajax_object.ef_login,
			ef_password: ajax_object.ef_password,
			course_id: ajax_object.course_id
			
		};
	
		jQuery.post(ajax_object.ajax_url, data, function(response) {
			var response = jQuery.parseJSON(response);
			if(response.status == 'ok'){
				window.open(response.url, '_blank');				
			} else {
				alert(response.msg);
			}
		});			
		return false;
	});
	jQuery('#ef-get-lesson').click(function() {
		var data = {
			action: 'ef_get_lesson',
			ef_login: ajax_object.ef_login,
			ef_password: ajax_object.ef_password,
			lesson_id: ajax_object.lesson_id
		};
	
		jQuery.post(ajax_object.ajax_url, data, function(response) {
			var response = jQuery.parseJSON(response);
			if(response.status == 'ok'){
				window.open(response.url, '_blank');				
			} else {
				alert(response.msg);
			}
		});			
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
