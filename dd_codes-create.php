<?php
function dd_codes_create () 
{
	
	$id_code 	   = $_POST["id_code"];
	$number_code   = $_POST["number_code"];
	$validity_code = $_POST["validity_code"];
	
	//insert
	if(isset($_POST['insert']))
	{
		global $wpdb;
		
		$wpdb->insert(
			'wp_code', //table
			array('number_code' => $number_code, 'validity_code' => $validity_code, 'valid_code' => 0, 'updated' => '0000-00-00', 'user_id' => 0), //data
			array('%d','%s','%d','%s','%d') //data format			
		);
		
		$message .= "Code ajouté";
	}
	?>
	
	<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/dd_codes/style-admin.css" rel="stylesheet" />
	
	<div class="wrap">
		<h2>Ajouter un nouveau code</h2>
		
		<?php if (isset($message)): ?><div class="updated"><p><?php echo $message;?></p></div><?php endif;?>
		
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<table class='wp-list-table widefat fixed'>
				<tr>
					<th>Code</th>
					<td><input type="text" name="number_code" value="<?php echo $number_code;?>"/></td>
				</tr>
				<tr>
					<th>Date de validité</th>
					<td><input id="validity_code" type="text" name="validity_code" value="<?php echo $validity_code;?>"/></td>
				</tr>
			</table>
			<input type='submit' name="insert" value='Envoyer' class='button'>
		</form>
		
	
	    <script>
	    jQuery(function() {
	        jQuery( "#validity_code" ).datepicker({
	            dateFormat : "dd-mm-yy"
	        });
	    });
	    </script> 
		
	</div>
	
	<?php
}