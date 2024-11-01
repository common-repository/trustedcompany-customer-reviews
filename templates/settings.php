<div class="wrap"> 

<h2>TrustedCompany Customer Reviews for WooCommerce <?php echo __('Settings','woocommerceTrustedCompany');?></h2> 

<form method="post" action="options.php"> 
<?php @settings_fields('woocommerce-trustcompany'); ?> 
<?php @do_settings_fields('woocommerce-trustcompany'); ?> 
<table class="form-table"> 
<tr valign="top"> 
<th scope="row">
<label for="trustedCompanyEmail"><?php echo __('Your unique Trustcompany e-mail-address','woocommerceTrustedCompany');?></label></th> 
<td>
	
	
	<?php
	
	$trustedCompanyEmail = get_option('trustedCompanyEmail');
	?>
	<input type="text" name="trustedCompanyEmail" value="<?php  echo $trustedCompanyEmail; ?>" />
	
</td> 
</tr> 

<tr valign="top"> 
<th scope="row">
<label for="sendwhen"><?php echo __('Sending','woocommerceTrustedCompany');?></label></th> 
<td>
	<?php
	$sendwhen = get_option('sendwhen','complete');
	?>
	<input type="radio" value="process" name="sendwhen" <?php echo ($sendwhen==='process')?' checked="checked"':''?>><?php echo __('After processing','woocommerceTrustedCompany');?><br>
	<input type="radio" value="complete" name="sendwhen"<?php echo ($sendwhen==='complete')?' checked="checked"':''?>><?php echo __('After complete','woocommerceTrustedCompany');?><br>
</td> 
</tr> 

</table> 
<?php @submit_button(); ?> </form> 
</div>
