<style type="text/css">
   #ef-edit-css{
		background: none repeat scroll 0 0 #F9F9F9;
        font-family: Consolas,Monaco,monospace;
        font-size: 12px;
        outline: 0 none;
        width: 97%;
	}
</style>
<div class="wrap">
	<?php screen_icon('edit'); ?>
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>
	
	<h2><?php echo __('Edit eFront CSS'); ?></h2>
		
	<div class="fileedit-sub">
		<div class="alignleft"><h3><?php _e('Editing'); ?>: <span><strong><?php echo _BASEURL_ . 'css/efront-style.css'; ?></strong></span></h3></div>
		<br class="clear">
		
	</div>	
		
	<form name="ef-edit-css-form" method="post" action="<?php echo admin_url('admin.php?page=efront-edit-css'); ?>">
		<input type="hidden" name="action" value="ef-edit-css">
		<?php $css_file_content = file_get_contents(_BASEURL_ . 'css/efront-style.css'); ?>
		<textarea cols="70" rows="25" name="ef-edit-css" id="ef-edit-css"><?php echo $css_file_content ; ?></textarea>
        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update') ?>" />
        </p>	
	</form>
</div>