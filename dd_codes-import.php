<?php

if ( file_exists('vendor/autoload.php' ) ) require 'vendor/autoload.php';

function dd_codes_import () {

    $reader = new src\Reader();
    $upload = new src\Upload();

?>

<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/dd_codes/style-admin.css" rel="stylesheet" />

<?php if(isset($_GET['erreur'])){?>
    <?php $errors = ['Filetypenotallowed' => 'Le type de fichier n\'est pas correct', 'Ladatenestpasvalide' => 'La date n\'est pas valide'] ?>
    <div class="error">
        <?php $error = (isset($errors[$_GET['erreur']]) ? $errors[$_GET['erreur']] : 'Problème avec le fichier'); ?>
        <p><?php echo $error; ?></p>
    </div>
<?php } ?>

<?php if(isset($_GET['import'])){?><div class="updated"><p>Importation terminée</p></div><?php } ?>

    <div class="wrap">

    <?php  

    if(isset($_POST['upload']))
    {
        if($reader->uploadFile()->readFile())
        {
            $location = admin_url('admin.php?page=dd_codes_import');
            $location = add_query_arg( array('import' => 'import') , $location );

            wp_redirect( $location );
            exit;
        }
    }
    ?>

    <h2>Importer des codes</h2>

    <p><a href="<?php echo admin_url('admin.php?page=dd_codes_list')?>">&laquo; Retour aux codes</a></p>

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
        <table class='wp-list-table widefat fixed striped' style="width: 570px; margin-top: 20px;">
            <tr>
                <th>Codes (fichier excel)</th>
                <td align="right">
                    <input type="file" name="file" value=""/>
                </td>
            </tr>
            <tr>
                <th>Date de validité</th>
                <td align="right"><input id="validity_code" type="text" name="validity_code" value=""/></td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td align="right"><input type='submit' name="upload" value='Télécharger' class='button button-primary'></td>
            </tr>
        </table>
    </form>

    <script>
        jQuery(function() {
            jQuery( "#validity_code" ).datepicker({ dateFormat : "yy-mm-dd"});
        });
    </script>

</div>

<?php
}