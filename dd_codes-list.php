<?php
if ( file_exists('vendor/autoload.php' ) ) require 'vendor/autoload.php';

function dd_codes_list () {

$create = new src\Codes();
?>

<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/dd_codes/style-admin.css" rel="stylesheet" />
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<link type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet" />

<div class="wrap">
	<h2>Codes d'accès</h2>
	
	<p style="margin-bottom: 20px;"><a class="add-new-h2" href="<?php echo admin_url('admin.php?page=dd_codes_create'); ?>">Ajouter nouveau code</a></p>
		<?php
				
			global $wpdb;
			
			$thisyear    = date('Y') + 1;
			$currentDate = (isset($_POST['annee']) ? $_POST['annee'] : date("Y")); 
			
			$rows = $create->getAll($currentDate);
			
		?>
	
		<?php if(isset($_GET['delete'])){?><div class="updated"><p>Code supprimé</p></div><?php } ?>
		<?php if(isset($_GET['update'])){?><div class="updated"><p>Code mis à jour</p></div><?php } ?>
		<?php if(isset($_GET['insert'])){?><div class="updated"><p>Code crée</p></div><?php } ?>
		
		<h3>Année en cours <?php echo $currentDate; ?></h3>
		
		<form action="<?php echo admin_url( 'admin.php?page=dd_codes_list'); ?>" method="post">
			<div class="alignleft actions">
				<label>Filtrer par &nbsp;</label>
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
				if(isset($row->user_id)){
					
					$user_info  = get_userdata($row->user_id);

			        $email      = (isset($user_info->user_email) ? $user_info->user_email : '');
			        $first_name = (isset($user_info->first_name) ? $user_info->first_name : '');
			        $last_name  = (isset($user_info->last_name) ? $user_info->last_name : '');
			        
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
	        jQuery('#myTable').DataTable({
		         "pageLength": 25,
		         language: {
			        processing:     "Traitement en cours...",
			        search:         "Rechercher&nbsp;:",
			        lengthMenu:     "Afficher _MENU_ &eacute;l&eacute;ments",
			        info:           "Affichage de _START_ &agrave; _END_ sur _TOTAL_ lignes",
			        infoEmpty:      "Affichage de 0 &agrave; 0 sur 0 lignes",
			        infoFiltered:   "(filtr&eacute; de _MAX_ lignes au total)",
			        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
			        emptyTable:     "Aucune donnée disponible",
			        paginate: {
			            first:      "Premier",
			            previous:   "Pr&eacute;c&eacute;dent",
			            next:       "Suivant",
			            last:       "Dernier"
			        }
			    }
	        });
	        
	    });
	</script>
</div>

<?php
}