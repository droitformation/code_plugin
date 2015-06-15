<?php
function dd_codes_update () {
	
global $wpdb;


$id_code 	   = $_GET["id_code"];
$number_code   = $_POST["number_code"];
$validity_code = $_POST["validity_code"];


//update
if(isset($_POST['update'])){	

	$date = ($_POST["user_id"] > 0 ? date('Y-m-d') : '0000-00-00');

	$user_id = ($_POST["user_id"] > 0 ? $_POST["user_id"] : 0);
	
	$wpdb->update(
		'wp_code', //table
		array('number_code' => $number_code, 'validity_code' => $validity_code, 'valid_code' => 0, 'updated' => $date, 'user_id' => $user_id), //data
		array( 'id_code' => $id_code ), //where
		array('%d','%s','%d','%s','%d'), //data format	
		array('%d') //data format	
	);	
	
	$location = admin_url('admin.php?page=dd_codes_list');
	$location = add_query_arg( array( 'updated' => 'updated') , $location );

	wp_redirect( $location );
	exit;
	
}
else if(isset($_POST['delete']))
{	
	
	$wpdb->query($wpdb->prepare("DELETE FROM wp_code WHERE id_code = %s",$id_code));
	
	$location = admin_url('admin.php?page=dd_codes_list');
	$location = add_query_arg( array( 'delete' => 'delete') , $location );
	
	wp_redirect( $location );
	exit;
	
}
else
{
	//selecting value to update	
	$codes = $wpdb->get_results($wpdb->prepare("SELECT * from wp_code where id_code=%s",$id_code));
	
	foreach ($codes as $code )
	{
		$number_code   = $code->number_code;
		$validity_code = $code->validity_code;
		$updated       = $code->updated;
		$user_id       = $code->user_id;
	}
}
?>

<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/dd_codes/style-admin.css" rel="stylesheet" />

<div class="wrap">
	<h2>&Eacute;diter le codes d'accès</h2>
	
	<p><a href="<?php echo admin_url('admin.php?page=dd_codes_list')?>">&laquo; Retour aux codes</a></p>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		
				
		<p>Utilisé le : <?php echo $updated; ?></p>
		
		
		<table class='wp-list-table widefat fixed striped' style="width: 450px;margin-top: 20px;">
			<tr>
				<th>Code</th>
				<td align="right"><input type="text" name="number_code" value="<?php echo $number_code;?>"/></td>
			</tr>
			<tr>
				<th>Date de validité</th>
				<td align="right"><input id="validity_code" type="text" name="validity_code" value="<?php echo $validity_code;?>"/></td>
			</tr>
			<tr>
				
				<?php
					$name = '';
					
					if($user_id)
					{
						
						$user_info  = get_userdata($user_id);
		
				        $email      = $user_info->user_email;
				        $first_name = $user_info->first_name;
				        $last_name  = $user_info->last_name;
				        
				        $name    = (!empty($first_name) && !empty($last_name) ? $first_name.' '.$last_name : $email);
						$user_id = $user_id;
				        
				        echo '<p>Par: <a href="'.admin_url('user-edit.php?user_id=' . $user_id, 'http' ).'">'.$name.'</a></p>';
				  ?>
					  <td>Utilisé par :</td>
						<td align="right">
							<input type='text' id="userFind" value="<?php echo $name; ?>">
							<input type='hidden' id="userFindId" name="user_id" value="<?php echo $user_id; ?>">
						</td>
				        
				  <?php }else{ ?>
				    
		
					<td>Assigner à :</td>
					<td align="right">
						<input type='text' id="userFind" value=''>
						<input type='hidden' id="userFindId" name="user_id" value='0'>
					</td>
				       
				  <?php } ?>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right"><input type='submit' name="update" value='Envoyer' class='button button-primary'></td>
			</tr>
			<tr>
				<td align="left">
					<input type='submit' name="delete" value='Supprimer' class='button button-delete' onclick="return confirm('Voulez-vous vraiment supprimer ce code?')">
					</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		
	</form>
	
	<script>
	    jQuery(function() {
		    
	        jQuery( "#validity_code" ).datepicker({
	            dateFormat : "dd-mm-yy"
	        });
	        
	        var se_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';


	        var url = se_ajax_url + "?action=wpgetall-users";
	        
			jQuery("#userFind").autocomplete({
				source: url,
				delay: 200,
				minLength: 3,
				focus: function( event, ui ) {
			        jQuery( "#userFind" ).val( ui.item.label );
			        return false;
			    },
			    select: function( event, ui ) {
			        jQuery( "#userFind" ).val( ui.item.label );
			        jQuery( "#userFindId" ).val( ui.item.value );
			 
			        return false;
			    }
			});
			

	    });
    </script> 

</div>
<?php
}