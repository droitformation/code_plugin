<?php
function dd_codes_update () {
	
global $wpdb;


$id_code 	   = $_GET["id_code"];
$number_code   = $_POST["number_code"];
$validity_code = $_POST["validity_code"];

//update
if(isset($_POST['update'])){	
	$wpdb->update(
		'wp_code', //table
		array('number_code' => $number_code, 'validity_code' => $validity_code, 'valid_code' => 0, 'updated' => '0000-00-00', 'user_id' => 0), //data
		array( 'id_code' => $id_code ), //where
		array('%d','%s','%d','%s','%d'), //data format	
		array('%d') //data format	
	);	
}
else if(isset($_POST['delete'])){	
	$wpdb->query($wpdb->prepare("DELETE FROM wp_code WHERE id_code = %s",$id_code));
}
else
{
	//selecting value to update	
	$codes = $wpdb->get_results($wpdb->prepare("SELECT * from wp_code where id_code=%s",$id_code));
	
	foreach ($codes as $code )
	{
		$number_code   = $code->number_code;
		$validity_code = $code->validity_code;
	}
}
?>

<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/dd_codes/style-admin.css" rel="stylesheet" />

<div class="wrap">
	<h2>Codes d'accès</h2>
	
	<?php if($_POST['delete']){?>
	
	<div class="updated"><p>Code supprimé</p></div>
	<a href="<?php echo admin_url('admin.php?page=dd_codes_list')?>">&laquo; Retour aux codes</a>
	
	<?php } else if($_POST['update']) {?>
	
	<div class="updated"><p>Code mis à jour</p></div>
	<a href="<?php echo admin_url('admin.php?page=dd_codes_list')?>">&laquo; Retour aux codes</a>
	
	<?php } else {?>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			
			<table class='wp-list-table widefat fixed striped' style="width: 450px;">
				<tr>
					<th>Code</th>
					<td><input type="text" name="number_code" value="<?php echo $number_code;?>"/></td>
				</tr>
				<tr>
					<th>Date de validité</th>
					<td><input id="validity_code" type="text" name="validity_code" value="<?php echo $validity_code;?>"/></td>
				</tr>
			</table>
			<input type='submit' name="update" value='Envoyer' class='button'> &nbsp;&nbsp;
			<input type='submit' name="delete" value='Supprimer' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
			
		</form>
	<?php }?>
	
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