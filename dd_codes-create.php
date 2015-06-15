<?php
	
function codeIsValid($code,$date){
	

	 $thisyearnumber = date('y');
	 $thisdaydate    = date('Y-m-d');
	 
	 // Get 2 first digit from code
	 $digit = substr($code, 0, 2);
	 
	 if( $digit >= $thisyearnumber && $date > $thisdaydate)
	 {
		 
		 return true;
	 }
	 
	 return false;
	
}
	
	
function dd_codes_create () 
{
	
	$id_code 	   = $_POST["id_code"];
	$number_code   = $_POST["number_code"];
	$validity_code = $_POST["validity_code"];
	
	//insert
	if(isset($_POST['insert']))
	{
		global $wpdb;
        $message = '';

		if(codeIsValid($number_code,$validity_code))
		{
			
			$wpdb->insert('wp_code', array('number_code' => $number_code, 'validity_code' => $validity_code, 'valid_code' => 1, 'updated' => '0000-00-00', 'user_id' => 0));
		
			$location = admin_url('admin.php?page=dd_codes_list');
			$location = add_query_arg( array( 'insert' => 'insert') , $location );
			
			wp_redirect( $location );
			exit;
		
		}
		else
		{
			$message .= "Ce code n'est pas valide, veuillez vérifier la date ou le format du code (2 premier chiffre = année de validité)";
		}
		
	}
	?>
	
	<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/dd_codes/style-admin.css" rel="stylesheet" />
	
	<div class="wrap">
		<h2>Ajouter un nouveau code</h2>
		
		<?php if (isset($message)): ?><div class="updated"><p><?php echo $message;?></p></div><?php endif;?>
		
		<p><a href="<?php echo admin_url('admin.php?page=dd_codes_list')?>">&laquo; Retour aux codes</a></p>
		
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<table class='wp-list-table widefat fixed striped' style="width: 450px; margin-top: 20px;">
				<tr>
					<th>Code</th>
					<td align="right"><input type="text" name="number_code" value="<?php echo $number_code;?>"/></td>
				</tr>
				<tr>
					<th>Date de validité</th>
					<td align="right"><input id="validity_code" type="text" name="validity_code" value="<?php echo $validity_code;?>"/></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td align="right"><input type='submit' name="insert" value='Ajouter' class='button button-primary'></td>
				</tr>
				
			</table>
		</form>
		
	
	    <script>
		    jQuery(function() {
		        jQuery( "#validity_code" ).datepicker({
		            dateFormat : "yy-mm-dd"
		        });
		    });
	    </script> 
		
	</div>
	
	<?php
}