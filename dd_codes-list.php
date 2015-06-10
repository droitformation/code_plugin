<?php
function dd_codes_list () {
?>

<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/dd_codes/style-admin.css" rel="stylesheet" />


<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<link type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet" />

<div class="wrap">
	<h2>Codes d'accès</h2>
	
	<p><a class="add-new-h2" href="<?php echo admin_url('admin.php?page=dd_codes_create'); ?>">Ajouter nouveau code</a></p>
	<?php
			
		global $wpdb;
		
		$thisyear = date('Y');
		
				
		if(isset($_POST['annee'])) 
		{ 
			$currentDate = $_POST['annee']; 
		} 
		else
		{ 
			$currentDate = date("Y"); 
		}
		
		$rows = $wpdb->get_results('SELECT * from wp_code WHERE validity_code BETWEEN "'.$currentDate.'-01-01" AND "'.$currentDate.'-12-31" ORDER BY number_code ASC,validity_code ASC'); 
		
		
	?>
		
		<h4>Année en cours <?php echo $currentDate; ?></h4>
		
		<form action="<?php echo admin_url( 'admin.php?page=dd_codes_list'); ?>" method="post">
			<div class="alignleft actions">
				<select name='annee'>
					<option value='' selected='selected'>Année</option>
					<?php
						for ($i = $thisyear; $i >= 2013; $i--) 
						{
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<input type="submit" class="button action" value="Appliquer"  />
			</div>	
		</form>
		<div style="clear: both; display: block;height: 20px;"></div>	
		<table id="myTable" width="100%" class='wp-list-table widefat fixed striped '>
		
		<thead>
			<tr>
				<th>ID</th>
				<th>Code</th>
				<th>Validité</th>
				<th>Valide</th>
				<th>Utilisé par</th>
				<th>&nbsp;</th>
			</tr>
		</thead>	
		
	<?php
		
		echo "<tbody>";
			
		foreach ($rows as $row ){
			echo "<tr>";
				echo "<td>$row->id_code</td>";
				echo "<td>$row->number_code</td>";	
				echo "<td>$row->validity_code</td>";
				echo '<td>'.($row->user_id ? 'non' : 'oui').'</td>';	
				echo '<td>';
				if($row->user_id){
					
					$user_info  = get_userdata($row->user_id);

			        $email      = $user_info->user_email;
			        $first_name = $user_info->first_name;
			        $last_name  = $user_info->last_name;
			        
			        if(!empty($first_name) && !empty($last_name))
			        {
				        $name = $first_name.' '.$last_name;
			        }
			        else
			        {
				        $name = $email;
			        }
			        
	
			        echo '<a href="'.admin_url('user-edit.php?user_id=' . $row->user_id, 'http' ).'">'.$name.'</a>';
			        
				}
				
				echo '</td>';	
				echo "<td style='text-align:right;'><a class='button button-primary' href='".admin_url('admin.php?page=dd_codes_update&id_code='.$row->id_code)."'>&Eacute;diter</a></td>";
			echo "</tr>";
		}
		
		echo "</tbody>";
			
		echo "</table>";
		
	
	?>
	
	<script>
		 jQuery(function() {
	        jQuery('#myTable').DataTable();
	    });
	</script>
</div>

<?php
}