<?php
/**
 * eFront login widget
 *
 * @since 1.0
 */
class eFront_login extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_efront_login', 'description' => __('Login form to eFront'));
		parent::__construct('efront-login', __('Login to eFront'), $widget_ops);
	}

	function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';

		echo "<p>";
		echo "<label for='" . $this -> get_field_id('title') . "'>" . _('Title:') . "</label>";
		echo "<input class='widefat' id='" . $this -> get_field_id('title') . "' name='" . $this -> get_field_name('title') . "' type='text' value='" . $title . "' />";

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function widget($args, $instance) {
		global $wpdb;
		extract($args, EXTR_SKIP);
		$loggin_error = false;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

		$output = '';

		$output .= $before_widget;
		if ($title)
			$output .= $before_title . $title . $after_title;

		if ($_POST['ef-login-widget'] == 'logout') {
			session_start();
			unset($_SESSION['ef-user-id']);
			unset($_SESSION['ef-user-login']);
			unset($_SESSION['ef-user-password']);
		}
		
		if($_POST['ef-login-widget'] == 'login'){
			if ($_POST['ef-login'] && $_POST['ef-password']) {
				try {
					$token = eFront::requestToken();
					eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
					eFront::login($token, $_POST['ef-login']);
					session_start();
					$_SESSION['ef-user-login'] = $_POST['ef-login'];
					$_SESSION['ef-user-password'] = $_POST['ef-password'];
				} catch (Exception $e) {
					$loggin_error = true;
				}
			} else {
				$output .= "<div class=\"alert alert-error\">";
				$output .= __('Login/Password cannot be empty');
				$output .= "</div>";				
			}
		}
		if (isset($_SESSION['ef-user-login']) && $_SESSION['ef-user-login'] != '' && isset($_SESSION['ef-user-password']) && $_SESSION['ef-user-password'] != '') {
			try {
				session_start();
				$token = eFront::requestToken();
				eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
				$user = eFront_User::getInfo($token, $_SESSION['ef-user-login']);
				$user_autologin_key = xml2array(eFront_User::getAutologinKey($token, $_SESSION['ef-user-login']));
				if(!$user_autologin_key['autologin_key']){
					eFront_User::setAutologinKey($token, $_SESSION['ef-user-login']);
					$user_autologin_key = xml2array(eFront_User::getAutologinKey($token, $_SESSION['ef-user-login']));
				}			
				$output .= "<div class='alert alert-success'>";
				$output .= "<span style='display:block'>" . _('Welcome back') . "<br /> <b>" . $user -> general_info -> name . "</b></span>";
				$output .= "<span style='display:block'>" . _('You can visit your learning portal') . " <a target='_blank' href='" . get_option('efront-domain') . "www/index.php?autologin=".$user_autologin_key['autologin_key']."'>" . _('here') . "</a></span>";
				$output .= "</div>";
				$output .= "<form class='form-horizontal' method='post' action='" . current_page_url() . "'>";
				$output .= "<input id='ef-login-widget' name='ef-login-widget' type='hidden' value='logout'>";
				$output .= "<button class='btn' type='submit'>" . _('Logout') . "</button>";
				$output .= "</form>";
			} catch (Exception $e) {
				if ($e instanceof TalentLMS_ApiError) {
					$output .= $e -> getMessage();
				}
			}
		} else {
			if ($loggin_error) {
				$output .= "<div class=\"alert alert-error\">";
				$output .= $e -> getMessage();
				$output .= "</div>";
			}

			$output .= "<form class='ef-widget-form' method='post' action='" . current_page_url() . "'>";
			$output .= "<input id='ef-login-widget' name='ef-login-widget' type='hidden' value='login'>";
			$output .= "<div class='ef-widget-form-group'>";
			$output .= "	<label class='ef-widget-form-label' for='ef-login'>" . _('Login') . "</label>";
			$output .= "	<div class='ef-widget-form-control'>";
			$output .= "		<input class='span' id='ef-login' name='ef-login' type='text'>";
			$output .= "	</div>";
			$output .= "</div>";
			$output .= "<div class='ef-widget-form-group'>";
			$output .= "	<label class='ef-widget-form-label' for='ef-password'>" . _('Password') . "</label>";
			$output .= "	<div class='ef-widget-form-control'>";
			$output .= "		<input class='span' id='ef-password' name='ef-password' type='password'>";
			$output .= "	</div>";
			$output .= "</div>";
			$output .= "<div class='ef-widget-form-actions' style='text-align:right;'>";
			$output .= "	<input type='submit' value='" . _('Login') . "'>";
			$output .= "</div>";
			$output .= "</form>";
		}

		$output .= $after_widget;
		echo $output;

	}

}
?>