<?php
//login, password, name, surname, languages, email, token
if ($_POST['submit']) {
	$post = true;
	if (!$_POST['first-name']) {
		$first_name_error = __('First Name is mandatory');
		$first_name_error_class = 'ef-form-error';
		$post = false;
	}
	if (!$_POST['last-name']) {
		$last_name_error = __('Last Name is mandatory');
		$last_name_error_class = 'ef-form-error';
		$post = false;
	}
	if (!$_POST['email']) {
		$email_error = __('Email is mandatory');
		$email_error_class = 'ef-form-error';
		$post = false;
	}
	if (!$_POST['language']) {
		$email_error = __('Language is mandatory');
		$email_error_class = 'ef-form-error';
		$post = false;
	}
	if (!$_POST['login']) {
		$login_error = __(', Login is mandatory');
		$login_error_class = 'ef-form-error';
		$post = false;
	}
	if (!$_POST['password']) {
		$password_error = __(', Password is mandatory');
		$password_error_class = 'ef-form-error';
		$post = false;
	} else {
		if(strlen($_POST['password']) < 6){
			$password_error_class = 'ef-form-error';
			$post = false;
		}
	}

	if ($post) {
		try {
			$token = eFront::requestToken();
			eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
			$result = eFront_User::createUser($token, $_POST['login'], $_POST['password'], $_POST['first_name'], $_POST['last-name'], $_POST['language'], $_POST['email']);
			
			if (get_option('ef-post-signup') == 'redirect') {
				$output .= "<script type='text/javascript'>window.location = '" . get_option('efront-domain') . "'</script>";
			} else {
				$output .= "<div class=\"alert alert-success\">";
				$output .= "User " . $_POST['login'] . " signed up successfuly. Goto to your learning portal <a target='_blank' href='" . get_option('efront-domain') . "'>" . _('here') . "</a>";
				$output .= "</div>";
			
				//$output .= $output;
			}
		} catch(Exception $e) {
			$output .= "<div class=\"alert alert-error\">";
			$output .= $e -> getMessage();
			$output .= "</div>";
		}
	}
}

$output .= "<form class='ef-form' id='ef-signup-form' action='' method='post'>";

$output .= "<div class='ef-form-group " . $first_name_error_class . "'>";
$output .= "	<label class='ef-form-label' for='first-name'>" . __('First Name') . "</label>";
$output .= "	<div class='ef-form-control'>";
$output .= "		<input type='text' id='first-name' name='first-name' value='" . $_POST['first-name'] . "'>";
$output .= "		<span class='ef-form-help-inline'>" . " " . $first_name_error . "</span>";
$output .= "	</div>";
$output .= "</div>";

$output .= "<div class='ef-form-group " . $last_name_error_class . "'>";
$output .= "	<label class='ef-form-label' for='last-name'>" . __('Last Name') . "</label>";
$output .= "	<div class='ef-form-control'>";
$output .= "		<input type='text' id='last-name' name='last-name' value='" . $_POST['last-name'] . "'>";
$output .= "		<span class='ef-form-help-inline'>" . " " . $last_name_error . "</span>";
$output .= "	</div>";
$output .= "</div>";

$output .= "<div class='ef-form-group " . $email_error_class . "'>";
$output .= "	<label class='ef-form-label' for='email'>" . __('Email') . "</label>";
$output .= "	<div class='ef-form-control'>";
$output .= "		<input type='text' id='email' name='email' value='" . $_POST['email'] . "'>";
$output .= "		<span class='ef-form-help-inline'>" . " " . $email_error . "</span>";
$output .= "	</div>";
$output .= "</div>";

$languages = get_ef_languages();

$output .= "<div class='ef-form-group " . $language_error_class . "'>";
$output .= "	<label class='ef-form-label' for='email'>" . __('Language') . "</label>";
$output .= "	<div class='ef-form-control'>";
$output .= "		<select id='language' name='language'>";
foreach($languages as $key => $language){
	if($_POST['language'] == $key){
		$output .= "		<option value='".$key."' selected='selected'>".$language."</option>";
	} else {
		$output .= "		<option value='".$key."'>".$language."</option>";
	}
}
$output .= "		</select>";
$output .= "		<span class='ef-form-help-inline'>" . " " . $language_error . "</span>";
$output .= "	</div>";
$output .= "</div>";

$output .= "<hr />";

$output .= "<div class='ef-form-group " . $login_error_class . "'>";
$output .= "	<label class='ef-form-label' for='login'>" . __('Login') . "</label>";
$output .= "	<div class='ef-form-control'>";
$output .= "		<input type='text' id='login' name='login' value='" . $_POST['login'] . "'>";
$output .= "		<span class='ef-form-help-inline'>" . __('Only letters and the characters . - _ @ are allowed') . "</span>";
$output .= "		<span class='ef-form-help-inline'>" . " " . $login_error . "</span>";
$output .= "	</div>";
$output .= "</div>";

$output .= "<div class='ef-form-group " . $password_error_class . "'>";
$output .= "	<label class='ef-form-label' for='password'>" . __('Password') . "</label>";
$output .= "	<div class='ef-form-control'>";
$output .= "		<input type='password' id='password' name='password' value='" . $_POST['password'] . "'>";
$output .= "		<span class='ef-form-help-inline'>" . __('Password must be at least 6 characters') . "</span>";
$output .= "		<span class='ef-form-help-inline'>" . " " . $password_error . "</span>";
$output .= "	</div>";
$output .= "</div>";

$output .= "<div class=\"ef-form-actions\">";
$output .= "<input class='btn btn-primary' type='submit' value='" . __("Create account") . "' name='submit'>";
$output .= "</div>";

$output .= "</form>";
?>
