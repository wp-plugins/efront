<?php
	if ($screen_id == $ef_admin_page) {
		get_current_screen()->add_help_tab( array(
			'id'		=> 'about',
			'title'		=> __('About eFront'),
			'content'	=>
				'<p>' . '<strong>' . __('eFront') . '</strong>' . __(' is a robust learning platform, bundled with key enterprise functionality ranging from branch management to tailor-made reports. We have worked with hundreds of organizations to shape a product that meet the training needs of modern enterprises.') . '</p>'
		) );
		get_current_screen()->add_help_tab( array(
			'id'		=> 'screen-content',
			'title'		=> __('Screen Content'),
			'content'	=>
				'<p>' . __('eFront Setup:') . '</p>' .
				'<ul>' .
					'<li>' . __('eFront Domain: Fill in your eFront domain.') . '</li>' .
					'<li>' . __('eFront Admin Username: Fill in an eFront administrator usernamne.') . '</li>' .
					'<li>' . __('eFront Admin Password: Fill in an eFront administrator password.') . '</li>' .
				'</ul>' .
				'<p>' . __('Cache control:') . '</p>' .
				'<ul>' .
					'<li>' . __('Each time eFront WordPress plugin communicates with eFront via eFront API the results are cached in WordPress. If you want to force communication of WordPress and eFront clear your cache.') . '</li>' .
				'</ul>'
		) );
		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://www.efrontlearning.net/" target="_blank">www.efrontlearning.net</a>') . '</p>' .
			'<p>' . __('<a href="http://www.efrontlearning.net/support" target="_blank">Support</a>') . '</p>'
		);		
	}
	if($screen_id == $ef_options_page){
		get_current_screen()->add_help_tab( array(
			'id'		=> 'about',
			'title'		=> __('About eFront'),
			'content'	=>
				'<p>' . '<strong>' . __('eFront') . '</strong>' . __(' is a robust learning platform, bundled with key enterprise functionality ranging from branch management to tailor-made reports. We have worked with hundreds of organizations to shape a product that meet the training needs of modern enterprises.') . '</p>'
		) );
		get_current_screen()->add_help_tab( array(
			'id'		=> 'screen-content',
			'title'		=> __('Screen Content'),
			'content'	=>
				'<p>' . __('Catalog Configuration:') . '</p>' .
				'<ul>' .
					'<li>' . __('Catalog with pagination - courses displayed in a paginated table: ') . 
						'<ul>' .
							'<li>' . __('Choose courses list template: You can have eFront categories displayed on the right, left or top of eFront courses and lessons') . '</li>' .
							'<li>' . __('Items per page: Choose how many items are going to be displayed in each page. You can choose to have a top and a bottom pages navigation.') . '</li>' .
						'</ul>' .
					'</li>' .
					'<li>' . __('Catalog with tree representation  - courses displayed in a tree-like representation ') .
				'</ul>'
		) );
		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://www.efrontlearning.net/" target="_blank">www.efrontlearning.net</a>') . '</p>' .
			'<p>' . __('<a href="http://www.efrontlearning.net/support" target="_blank">Support</a>') . '</p>'
		);		
	}
	if($screen_id == $ef_sync_page){
		get_current_screen()->add_help_tab( array(
			'id'		=> 'about',
			'title'		=> __('About eFront'),
			'content'	=>
				'<p>' . '<strong>' . __('eFront') . '</strong>' . __(' is a robust learning platform, bundled with key enterprise functionality ranging from branch management to tailor-made reports. We have worked with hundreds of organizations to shape a product that meet the training needs of modern enterprises.') . '</p>'
		));
		get_current_screen()->add_help_tab(array(
			'id'		=> 'screen-content',
			'title'		=> __('Screen Content'),
			'content'	=>
				'<p>' . __('eFront and WP Synchronization:') . '</p>' .
				'<ul>' .
					'<li>' . __('You can synchronize your eFront and WP users, by making your WP also users in eFront and vice versa. If you choose to perform a hard sync, all WP users\' details with the same username in eFront will be overwritten by the corresponding eFront details.') . '</li>' .
				'</ul>'
		));
		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://www.efrontlearning.net/" target="_blank">www.efrontlearning.net</a>') . '</p>' .
			'<p>' . __('<a href="http://www.efrontlearning.net/support" target="_blank">Support</a>') . '</p>'
		);
	}
	if($screen_id == $ef_css_page){
		get_current_screen()->add_help_tab( array(
			'id'		=> 'about',
			'title'		=> __('About eFront'),
			'content'	=>
				'<p>' . '<strong>' . __('eFront') . '</strong>' . __(' is a robust learning platform, bundled with key enterprise functionality ranging from branch management to tailor-made reports. We have worked with hundreds of organizations to shape a product that meet the training needs of modern enterprises.') . '</p>'
		));
		get_current_screen()->add_help_tab(array(
			'id'		=> 'screen-content',
			'title'		=> __('Screen Content'),
			'content'	=>
				'<p>' . __('eFront edit CSS:') . '</p>' .
				'<ul>' .
					'<li>' . __('You can edit CSS rules for eFront WordPress plugin to best customize the look and feel of the plugin according to your WordPress theme.') . '</li>' .
				'</ul>'
		));
		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://www.efrontlearning.net/" target="_blank">www.efrontlearning.net</a>') . '</p>' .
			'<p>' . __('<a href="http://www.efrontlearning.net/support" target="_blank">Support</a>') . '</p>'
		);
	}
	
?>