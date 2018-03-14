<div class="wrap">
	<h2>Settings</h2>

	<form method="post" action="options.php">
	    <?php settings_fields( 'wra-settings-group' ); ?>
	    <?php do_settings_sections( 'wra-settings-group' ); ?>
	    <table class="form-table">
	        <tr valign="top">
	        <th scope="row">Number of posts</th>
	        <td><input type="number" min="1" name="wra_number_of_posts" value="<?php echo get_option('wra_number_of_posts'); ?>" /></td>
	        </tr>

			<tr valign="top">
			<th scope="row">Select category to show the posts on</th>
			<td>
				<select id='wra_category' name='wra_category' class='selectize'>
					<option value='-1'>None</option>
					<?php
						foreach($categories as $category) { ?>
							<option value="<?php echo $category->term_id; ?>" <?php if( $category->term_id == get_option('wra_category')) echo 'selected'; ?>><?php echo $category->name; ?></option>
					<?php }
					?>
				</select>
			</td>
			</tr>
	    </table>
	    <?php submit_button(); ?>
	</form>
</div>