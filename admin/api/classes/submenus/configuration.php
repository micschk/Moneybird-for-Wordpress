<?php

if ( is_admin() ){ // admin actions
	add_action('admin_menu', 'moneybird_admin_menu');
	add_action('admin_init', 'register_moneybird_settings' );
} else {
// non-admin enqueues, actions, and filters
}

function register_moneybird_settings(){
  register_setting( 'moneybird', 'moneybird_domain' );
  register_setting( 'moneybird', 'moneybird_email' );
  register_setting( 'moneybird', 'moneybird_pass' );
  register_setting( 'moneybird', 'moneybird_key' );
}

function moneybird_admin_menu() {
	moneybird_load_menu();
}
function moneybird_load_menu() {
	add_submenu_page('plugins.php', __('Moneybird Configuratie'), __('Moneybird Configuratie'), 'manage_options', 'moneybird-config', 'moneybird_conf');
}

function moneybird_conf() {

?>
	<div class="wrap">
		<form action="options.php" method="post" class="custom_made_fields small" id="moneybird-config">
			<?php settings_fields( 'moneybird' ); ?>
			<h3 class="moneybird"><label for="key"><?php _e('Moneybird configuratie'); ?></label><span>Vul hieronder uw Moneybird gegevens in.</span></h3>
			<p><label style="font-weight:normal;">Uw domein-naam https://<strong style="color:red;">moneybird</strong>.moneybird.nl</label><input type="text" name="moneybird_domain" id="moneybird_domain" value="<?php echo get_option('moneybird_domain'); ?>"/></p>
			<p><label style="font-weight:normal;">Uw email adres</label><input type="text" name="moneybird_email" id="moneybird_email" value="<?php echo get_option('moneybird_email'); ?>"/></p>
			<p><label style="font-weight:normal;">Uw wachtwoord</label><input type="password" name="moneybird_pass" id="moneybird_pass" value="<?php echo get_option('moneybird_pass'); ?>"/></p>
			
			<?php
			
			$domain = get_option('moneybird_domain');
			$email = get_option('moneybird_email');
			$pass = get_option('moneybird_pass');
			$key = get_option('moneybird_key');
			
			if(isset($domain) && isset($email) && isset($pass)) : 
				$moneybird_key = create_moneybird_settings($domain,$email,$pass,$key);
				if($moneybird_key == 'error1') : $error1 = true; elseif($moneybird_key == 'error2') : $error2 = true; elseif($moneybird_key == 'error3'): $error3 = true; endif;
				if($moneybird_key == 'error1' || $moneybird_key == 'error2' || $moneybird_key == 'error3'):
					$moneybird_key = '';
				endif;
			endif;
			
			?>
			<input type="hidden" name="moneybird_key" id="moneybird_key" value="<?php echo $moneybird_key; ?>"/>
			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
	<?php
		if($error1 == true):
			$error = 'Er is iets misgegaan met het koppelen van uw Moneybird account, heeft u wel de juiste gegevens ingevuld?';
		elseif($error2 == true):
			$error = 'Er is iets misgegaan met het zoeken naar een contact.';
		elseif($error3 == true):
			$error = 'Er is iets misgegaan met het aanmaken van een contact';
		else :
			$error = 'Uw moneybird account is gekoppeld aan Wordpress';
		endif;
		if($error):
			echo '<div class="warning">'.$error.'</div>';
		endif;
	?>
<?php

}

?>