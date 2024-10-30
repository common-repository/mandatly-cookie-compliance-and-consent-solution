<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.mandatly.com
 *
 * @package    Mandatly_Cookie_Compliance
 * @subpackage Mandatly_Cookie_Compliance/admin/partials
 */

?>
<div id="mdt-settings-area">
	<div class="mdt-settings-area">
		<div class="mdt-header">
			<div class="mdt-container">
				<div class="mdt-header-content"><img src="<?php echo esc_html( plugin_dir_url( dirname( __FILE__ ) ) ); ?>assets/w-logo.svg" alt="">
				</div>
			</div>
		</div>
		<div class="mdt-sub-header">
			<div class="mdt-container">
				<div class="mdt-sub-header-content">
					<h1><?php echo esc_html( TXT_HEADING ); ?></h1>
					<p><?php echo esc_html( TXT_DESCRIPTION ); ?></p>
				</div>
			</div>
		</div>
		<div id="activation-notice" class="success-msg" hidden>
			<p id="msg-notice"></p>
			<button type="button"class="notice-dismiss vc-notice-dismiss" id="dismiss"></button>
		</div>
		<div id="mdt-settings-box">
			<div class="banner_desc_content active-banner  ">
				<strong><?php echo esc_html( TXT_ACTIVE_BANNER ); ?></strong>
				<label class="tooltip" > <img src="<?php echo esc_html( plugin_dir_url( dirname( __FILE__ ) ) ); ?>assets/icon-small-info.png" /><span class="tooltiptext">
														<?php
															echo esc_html( TXT_ACTIVE_OPT );
														?>
				</span></label>
				<label class="switch demo-mode tooltip">
					<?php
					$dchecked = '';
					if ( 'true' == $banner_status ) {
						$dchecked = 'checked';
					} else {
						$dchecked = '';
					}
					?>
					<input type="checkbox" id="slider-status" name="slider-status" <?php echo esc_attr( $dchecked ); ?>>
					<span class="slider round"></span>
				</label>
			</div>
			<div class="banner_desc_content ">
			<strong><?php echo esc_html( TXT_DEMO_TITLE ); ?></strong>
			<label class="tooltip" > <img src="<?php echo esc_html( plugin_dir_url( dirname( __FILE__ ) ) ); ?>assets/icon-small-info.png" /><span class="tooltiptext">
														<?php
															echo esc_html( TXT_ACTIVE_DEMO_OPT );
														?>
			</span></label>
			<label class="switch demo-mode tooltip">
				<input type="checkbox" id="server_mode" name="server_mode" <?php echo 'true' == $mcc_server_mode ? 'checked' : ''; ?>>
				<span class="slider round"></span>
			</label>
			</div>
			<div class="active-banner mcc_demo_content" >
					<p class="demo-detail"><?php echo esc_html( TXT_DEMO_DETAIL ); ?></p>
				</div>
			<form method="post" id="cookie" class="mcc_live_content">
				<?php wp_nonce_field( 'cookies_settings_fields', 'cookies_settings_fields_values' ); ?>
				<div class="mdt-settings-box-body">                
					<div class="label-text">
						<label><?php echo esc_html( TXT_GUID ); ?></label>
						<a href="<?php echo esc_url( home_url() ); ?>" class="ab-item" target="_blank"><?php echo esc_html( TXT_PREVIEW_BANNER ); ?><img src="<?php echo esc_html( plugin_dir_url( dirname( __FILE__ ) ) ); ?>assets/icon-up-arrow.png">
						</a>                       
					</div>
					<div>
						<input type="text" autocomplete="off" id="gidbox" name="gid" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" maxlength="50" value="<?php echo esc_html( $banner_guid ); ?>" required>
						<p><span class="not_validated_msg mcc_error_msg mcc_hide"><?php echo esc_html( TXT_NOT_VALIDATE_GUID ); ?></span>
						<span class="not_exists_msg mcc_error_msg mcc_hide"><?php echo esc_html( TXT_NOT_EXISTS_GUID ); ?></span></p>
						<a class="help_guid_link" href="https://help.mandatly.net/HowtogetWebsiteGUID.html" target="_blank"><?php echo esc_html( TXT_GET_GUID ); ?></a>
					</div>
					<div class="btn-sec">                        
						<div class="btn-grp">                           
							<button type="submit" name="submit" class="mdt-settings-button"><?php echo esc_html( TXT_SAVE ); ?></button>
							<span class="deactivate_msg mcc_hide"><?php echo esc_html( TXT_BANNER_DEACTIVE ); ?></span>
							<span class="activate_msg mcc_hide"><?php echo esc_html( TXT_BANNER_ACTIVE ); ?> <a href="<?php echo esc_url( home_url() ); ?>" class="ab-item" target="_blank"><?php echo esc_html( TXT_BANNER_ACTIVE_LINK ); ?></a><?php echo esc_html( TXT_BANNER_JOINT ); ?></span>
							<span class="deactivate_msg_live_opt mcc_hide"><?php echo esc_html( TXT_BANNER_DEACTIVE_LIVE_OPT ); ?></span>
							<span class="activate_msg_live_opt mcc_hide"><?php echo esc_html( TXT_BANNER_ACTIVE_LIVE_OPT ); ?></span>
							<span class="deactivate_msg_demo_opt mcc_hide"><?php echo esc_html( TXT_BANNER_DEACTIVE_DEMO_OPT ); ?></span>
							<span class="activate_msg_demo_opt mcc_hide"><?php echo esc_html( TXT_BANNER_ACTIVE_DEMO_OPT ); ?></span>
							<span class="deactivate_msg_live_load mcc_hide"><?php echo esc_html( TXT_BANNER_LIVE_DEACTIVE_LOAD ); ?></span>
							<span class="activate_msg_live_load mcc_hide"><?php echo esc_html( TXT_BANNER_LIVE_ACTIVE_LOAD ); ?></span>
							<span class="deactivate_msg_demo_load mcc_hide"><?php echo esc_html( TXT_BANNER_DEMO_DEACTIVE_LOAD ); ?></span>
						</div>
					</div>
				</div>
			</form>
			<div class="mdt-settings-box-footer">
<?php echo esc_html( TXT_PLUGIN_HELP ); ?><br /><?php echo esc_html( TXT_SIGNUP_ASK ); ?> <a href="https://www.mandatly.com/pricing/by-solutions#Cookie-Compliance"target="_blank"><?php echo esc_html( TXT_SIGN_UP ); ?></a>
			</div>			
		</div>
	</div>
</div>
