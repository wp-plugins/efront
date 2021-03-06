<div class="wrap">
	<?php screen_icon('edit'); ?>
	
	<div id='action-message' class='<?php echo $action_status; ?> fade'>
		<p><?php echo $action_message ?></p>
	</div>
	
	<h2><?php _e('eFront Options'); ?></h2>
    <h3><?php _e('Catalog Configuration:'); ?></h3>    
    <form name="ef-catalog-form" method="post" action="<?php echo admin_url('admin.php?page=efront-options'); ?>">
        <input type="hidden" name="action" value="ef-catalog-config">
        <table class="form-table">
        	<tr>
        		<th scope="row" class="form-field">
        			<label for="ef-catalog-template"><?php _e('Choose catalog template'); ?></label>
        		</th>
        		<td class="form-field">
        			<?php if (get_option('ef-catalog-template') == 'ef-catalog-template-pagination'): ?>
        			<input id="ef-catalog-template-pagination" name="ef-catalog-template" type="radio" style="width: 2.5em;" value="ef-catalog-template-pagination" checked="checked" /><?php _e('Catalog with pagination'); ?>
        			<?php else : ?>
        			<input id="ef-catalog-template-pagination" name="ef-catalog-template" type="radio" style="width: 2.5em;" value="ef-catalog-template-pagination" /><?php _e('Catalog with pagination'); ?>
        			<?php endif; ?>
        		</td>
        	</tr>

        	<tr id="ef-template-pagination-options">
        		<th scope="row" class="form-field"></th>
        		<td class="form-field">
					<table class="form-table">
            			<tr>
			                <th scope="row" class="form-field">
			                    <label><?php _e('Choose courses list template: '); ?></label>
			                </th>
			                <td class="form-field">
			                    <?php if(get_option('ef-catalog-template-pagination-opt') == 'categories-right'): ?>
			                    <input type="radio" name="ef-catalog-template-pagination-opt" value="categories-right" style="width: 2.5em;" checked="checked"><?php _e("Courses on the left - Categories on the right"); ?><br />
			                    <?php else: ?>
			                    <input type="radio" name="ef-catalog-template-pagination-opt" value="categories-right" style="width: 2.5em;"><?php _e("Courses on the left - Categories on the right"); ?><br />    
			                    <?php endif; ?>
			
			                    <?php if(get_option('ef-catalog-template-pagination-opt') == 'categories-left'): ?>                    
			                    <input type="radio" name="ef-catalog-template-pagination-opt" value="categories-left" style="width: 2.5em;" checked="checked"><?php _e("Courses on the right - Categories on the left"); ?><br />
			                    <?php else: ?>
			                    <input type="radio" name="ef-catalog-template-pagination-opt" value="categories-left" style="width: 2.5em;"><?php _e("Courses on the right - Categories on the left"); ?><br />    
			                    <?php endif; ?>
			                    
			                    <?php if(get_option('ef-catalog-template-pagination-opt') == 'categories-top'): ?>
			                    <input type="radio" name="ef-catalog-template-pagination-opt" value="categories-top" style="width: 2.5em;" checked="checked"><?php _e("Courses on the bottom - Categories on top"); ?><br />
			                    <?php else: ?>
			                    <input type="radio" name="ef-catalog-template-pagination-opt" value="categories-top" style="width: 2.5em;"><?php _e("Courses on the bottom - Categories on top"); ?><br />                        
			                    <?php endif; ?>
							</td>
						</tr>						
			            <tr>
			                <th scope="row" class="form-field">
			                    <label for="ef-catalog-pagination-per-page"><?php _e('Items per page: '); ?></label>
			                </th>
			                <td class="form-field">
			                    <input id="ef-catalog-pagination-per-page" name="ef-catalog-pagination-per-page" value="<?php echo get_option('ef-catalog-pagination-per-page'); ?>" style="width: 2.5em;" />
			                    <span class="description"><?php _e("Using this will enable pagination"); ?> </span>
			                </td>                
			            </tr>
			            <tr>
			                <th scope="row" class="form-field">
			                </th>
			                <td class="form-field">
			                    <?php _e("Top pagination"); ?>
			                    <?php if (get_option('ef-catalog-pagination-top')): ?>
			                        <input id="ef-catalog-pagination-top" name="ef-catalog-pagination-top" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" checked="checked"/>
			                    <?php else : ?>
			                        <input id="ef-catalog-pagination-top" name="ef-catalog-pagination-top" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" />
			                    <?php endif; ?>
			                    <?php _e("Bottom pagination"); ?>
			                    <?php if (get_option('ef-catalog-pagination-bottom')): ?>
			                        <input id="ef-catalog-pagination-bottom" name="ef-catalog-pagination-bottom" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" checked="checked"/>
			                    <?php else : ?>
			                        <input id="ef-catalog-pagination-bottom" name="ef-catalog-pagination-bottom" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" />
			                    <?php endif; ?>                    
			                </td>                
			            </tr>
					</table> 
				</td>	       		
        	</tr>
        	<tr>
        		<th scope="row" class="form-field"></th>
        		<td class="form-field">
        			<?php if (get_option('ef-catalog-template') == 'ef-catalog-template-tree'): ?>
        			<input id="ef-catalog-template-tree" name="ef-catalog-template" type="radio" style="width: 2.5em;" value="ef-catalog-template-tree" checked="checked" /><?php _e('Catalog with tree representation'); ?>
        			<?php else : ?>
        			<input id="ef-catalog-template-tree" name="ef-catalog-template" type="radio" style="width: 2.5em;" value="ef-catalog-template-tree" /><?php _e('Catalog with tree representation'); ?>
        			<?php endif; ?>	
        		</td>
        	</tr>            
		</table>
		
        <h3><?php _e('Signup Page: '); ?></h3>
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('After a user signs up: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('ef-post-signup') == 'redirect'): ?>
                        <input type="radio" name="post-signup" value="redirect" style="width: 2.5em;" checked="checked"><?php _e("Redirect user to eFront"); ?><br />
                    <?php else: ?>
                        <input type="radio" name="post-signup" value="redirect" style="width: 2.5em;"><?php _e("Redirect user to eFront"); ?><br />
                    <?php endif; ?>
                    <?php if(get_option('ef-post-signup') == 'stay'): ?>
                        <input type="radio" name="post-signup" value="stay" style="width: 2.5em;" checked="checked"><?php _e("Stay in Wordpress"); ?><br />
                    <?php else: ?>
                        <input type="radio" name="post-signup" value="stay" style="width: 2.5em;"><?php _e("Stay in Wordpress"); ?><br />
                    <?php endif; ?>
                </td>                
            </tr>
    		<tr>
    			<th scope="row" class="form-field" style="width: 30em;">
    				<?php _e('Synchronize singup eFront and WP'); ?>
    			</th>
    			<td class="form-field">
				<?php if (get_option('ef-sync-signup-users')): ?>
			    <input id="ef-sync-signup-users" name="ef-sync-signup-users" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" checked="checked"/>
			    <?php else : ?>
			    <input id="ef-sync-signup-users" name="ef-sync-signup-users" value="<?php echo true; ?>" type="checkbox" style="width: 1.5em;" />
			    <?php endif; ?>    				
    			&nbsp;<span class="description"><?php _e("Using this will create a WP user each time a user signs up to eFront"); ?> </span>
    			</td>
    		</tr>            
        </table>
        		
        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Submit') ?>" />
        </p> 		
	</form>

</div>	