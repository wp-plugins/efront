<?php
	if ($screen_id == $efront_admin_page) {
		get_current_screen()->add_help_tab( array(
		'id'		=> 'about',
		'title'		=> __('About eFront'),
		'content'	=>
			'<p>' . '<strong>' . __('eFront') . '</strong>' . __(' is a robust learning platform, bundled with key enterprise functionality ranging from branch management to tailor-made reports. We have worked with hundreds of organizations to shape a product that meet the training needs of modern enterprises. .') . '</p>'
		) );
		get_current_screen()->add_help_tab( array(
		'id'		=> 'screen-content',
		'title'		=> __('Screen Content'),
		'content'	=>
			'<p>' . __('You can customize the display of this screen&#8217;s contents in a number of ways:') . '</p>' .
			'<ul>' .
				'<li>' . __('You can hide/display columns based on your needs and decide how many posts to list per screen using the Screen Options tab.') . '</li>' .
				'<li>' . __('You can filter the list of posts by post status using the text links in the upper left to show All, Published, Draft, or Trashed posts. The default view is to show all posts.') . '</li>' .
				'<li>' . __('You can view posts in a simple title list or with an excerpt. Choose the view you prefer by clicking on the icons at the top of the list on the right.') . '</li>' .
				'<li>' . __('You can refine the list to show only posts in a specific category or from a specific month by using the dropdown menus above the posts list. Click the Filter button after making your selection. You also can refine the list by clicking on the post author, category or tag in the posts list.') . '</li>' .
			'</ul>'
		) );
		get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('For more information:') . '</strong></p>' .
		'<p>' . __('<a href="http://www.efrontlearning.net/" target="_blank">www.efrontlearning.net</a>') . '</p>' .
		'<p>' . __('<a href="http://www.efrontlearning.net/support" target="_blank">Support</a>') . '</p>'
		);		
	}
?>