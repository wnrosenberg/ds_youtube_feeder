<?php
/*
Plugin Name: Youtube Feeder
Plugin URI: https://github.com/wnrosenberg/ds_youtube_feeder
Description: Outputs a Youtuve Feed.
Version: 0.1b
Author: Will Rosenberg (Digital Surgeons) <will.rosenberg@gmail.com>
License: DBAD (http://philsturgeon.co.uk/code/dbad-license/)
*/

/* ACTIONS */
if ( is_admin() ){
	add_action( 'admin_menu', 'dsytf_my_plugin_menu' );       // creates a new menu item under 'Settings'
	add_action( 'admin_init', 'dsytf_register_mysettings' );  // register plugin settings
	add_option( 'ds-yt-user' );
}

/*** BEGIN ADMIN SECTION ***/

/* Creates a new menu item under 'Settings' for Options Page */
function dsytf_my_plugin_menu() {
	add_options_page( 'Youtube Feeder Options', 'Youtube Feeder', 'manage_options', 'ds-youtube-feeder', 'dsytf_my_plugin_options' );
}

/* Generate Options Page */
function dsytf_my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	/** start output **/
	?>

<div class="wrap">
<h2>Youtube Feeder Options</h2>
<p>This plugin accesses YouTube feeds using the following request:<br>
	<code>http://gdata.youtube.com/feeds/api/users/<b>USERNAME</b>/uploads?v=2&alt=json&format=5&max-results=<b>#</b></code><br>
	Where "USERNAME" is the <b>Youtube Username</b> supplied below, and "#" is the number of results to pull, set in the template tag.</p>
<form method="post" action="options.php">
	<?php settings_fields( 'ds-youtube-feeder-group' ); ?>
	<?php do_settings_fields( 'ds-youtube-feeder-group' ); ?>
	<table class="form-table">
	<tr valign="top">
		<th scope="row">Youtube Username</th> <td><input type="text" name="ds-yt-user" value="<?php echo get_option('ds-yt-user'); ?>" /></td>
	</tr>
	</table>
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
</form>
</div>

	<?
	/** end output **/
}

/* Register Settings used on Options Page */
function dsytf_register_mysettings() { // whitelist options
  register_setting( 'ds-youtube-feeder-group', 'ds-yt-user' );
}

/*** END ADMIN SECTION ***/


/* Output */
function wordpress_feeder($max_results = 0) {

	// sanitize $max_results
	$max_results = intval($max_results);
	if ($max_results <= 0) {
		$max_results = "";
	} else {
		$max_results = "&max-results=$max_results";
	}

	// grab youtube feed
	$feed_url = "http://gdata.youtube.com/feeds/api/users/" . get_option('ds-yt-user') . "/uploads?v=2&alt=json&format=5" . $max_results ;

}

?>