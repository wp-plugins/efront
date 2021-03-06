<div class="wrap">
	<?php screen_icon('edit'); ?>

	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>	

	<h2><?php _e('eFront Setup'); ?></h2>

    <h3><?php _e('eFront Domain:'); ?></h3>    
    <form name="ef-domain-form" method="post" action="<?php echo admin_url('admin.php?page=efront'); ?>">
        <input type="hidden" name="action" value="ef-main-config">
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field form-required <?php echo $domain_validation; ?>">
                    <label for="ef-domain"><?php _e("eFront Domain"); ?> <span class="description">(<?php _e("Required"); ?>)</span>:</label>
                </th>
                <td class="form-field form-required <?php echo $domain_validation; ?>">
                    <input id="ef-domain" name="ef-domain" style="width: 25em;" value="<?php echo get_option('efront-domain'); ?>" /><br />
                	<span class="description"><?php _e("eFront domain is your path url to your eFront installation index.php file. It should not contain http://"); ?></span>
                </td>
            </tr>
            <tr>
                <th scope="row" class="form-field form-required <?php echo $domain_validation; ?>">
                    <label for="ef-admin-username"><?php _e("eFront Admin Username"); ?> <span class="description">(<?php _e("Required"); ?>)</span>:</label>
                </th>
                <td class="form-field form-required <?php echo $domain_validation; ?>">
                    <input id="ef-admin-username" name="ef-admin-username" style="width: 25em;" value="<?php echo get_option('efront-admin-username'); ?>" />
                </td>
            </tr>
            <tr>
                <th scope="row" class="form-field form-required <?php echo $domain_validation; ?>">
                    <label for="ef-admin-password"><?php _e("eFront Admin Password"); ?> <span class="description">(<?php _e("Required"); ?>)</span>:</label>
                </th>
                <td class="form-field form-required <?php echo $domain_validation; ?>">
                    <input id="ef-admin-password" name="ef-admin-password" style="width: 25em;" value="<?php echo get_option('efront-admin-password'); ?>" />
                </td>
            </tr>
        </table>
        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Submit' ) ?>" />
            &nbsp;<span class="description"><?php _e("Submitting any changes will force the cache to be cleared"); ?></span>
        </p>        
    </form>
    
    <h3><?php _e('Cache control'); ?></h3>
    <form name="ef-cache-form" method="post" action="<?php echo admin_url('admin.php?page=efront'); ?>">
        <input type="hidden" name="action" value="ef-cache">
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field" style="width: 30em;">
                    <?php _e('Clearing the cache will force contacting your eFront domain'); ?>
                </th>
                <td class="form-field">
                    <input class="button-secondary" type="submit" name="Clear cache" value="<?php _e('Clear cache' ) ?>" style="width: 8.5em;" />
                </td>
            </tr>
        </table>
    </form>
</div>