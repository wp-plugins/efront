<div class="wrap">
	<?php screen_icon('edit'); ?>
	
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>
	
	<h2><?php _e('eFront and WP Synchronization'); ?></h2>

    <h3><?php _e('Synchronize Users'); ?></h3>
   	<table class="widefat">
   		<tbody>
    		<tr>
    			<th><?php _e('eFront Users'); ?></th>
    			<td><?php echo count($ef_users); ?></td>	    			
    			<th><?php _e('Users to sync from eFront'); ?></th>
    			<td><?php echo count($ef_users_to_wp); ?></td>	    			
    		</tr>
    		<tr>
    			<th><?php _e('WP Users'); ?></th>
    			<td><?php echo count($wp_users); ?></td>
    			<th><?php _e('Users to sync from WP'); ?></th>
    			<td><?php echo count($wp_users_to_ef); ?></td>			
    		</tr>   			    		
   		</tbody>
   	</table>
   	
    <?php if(!empty($sync_errors)) : ?>
	<style type="text/css">
	   #ef-sync-errors{
			background: none repeat scroll 0 0 #F9F9F9;
	        border-color: #DFDFDF;
	        font-family: Consolas,Monaco,monospace;
	        font-size: 12px;
	        outline: 0 none;
	        padding: 10px;
	        width: 97%;
		}
	</style> 
	
	<p><strong><?php _e('Sync errors'); ?></strong></p>  	
	<pre id="ef-sync-errors"><?php foreach($sync_errors as $error) { echo $error . "<br />"; }?></pre>
    <?php endif; ?>   	
   	
    <form name="ef-cache-form" method="post" action="<?php echo admin_url('admin.php?page=efront-sync'); ?>">
        <input type="hidden" name="action" value="ef-sync-users">
        <table class="form-table">
        	<tr>
        		<th scope="row" class="form-field">
        			<label for="hard-sync"><?php _e('Hard sync'); ?></label>
        		</th>
        		<td class="form-field">
        			<input id="hard-sync" name="hard-sync" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" />
        			&nbsp;<span class="description"><?php _e("Using this option will overwrite WP users' details with details stored in eFront"); ?></span>
        		</td>
        	</tr>
        </table>
        <p class="submit">
			<input class="button-primary" type="submit" name="Clear cache" value="<?php _e('Sync') ?>" style="width: 8.5em;" />
			&nbsp;<span class="description"><?php _e('Synchronize your eFront and WP users'); ?></span>
        </p> 
    </form>    	
</div>