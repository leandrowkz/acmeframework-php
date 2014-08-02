<?php
/**
* --------------------------------------------------------------------------------------------------
*
* module_action.php
* 
* This HTML component build an action (icon, link) that will be placed on each row of module 
* list (sql_list).
*
* An $action is something like:
*
*		$action = array(
*			[id_module_action] => 2
*			[id_module] => 0
*			[label] => 
*			[link] => {URL_ROOT}/app_dashboard
*			[target] => 
*			[url_img] => <i class="fa fa-fw fa-home"></i>
*		)
*
* @param    array $action
* @since    28/06/2013
*
* --------------------------------------------------------------------------------------------------
*/
?>

<?php 

// Adjust target
$target = (get_value($action, 'target') != '') ? ' target="' . get_value($action, 'target') . '"' : ''; 

// Image also can be a font-awesome - know more on fontawesome.github.io/Font-Awesome/
if(stristr(get_value($action, 'url_img'), 'class="fa'))
	$img = get_value($action, 'url_img');
else
	$img = (file_exists(tag_replace(get_value($action, 'url_img'))) && get_value($action, 'url_img') != '') ? '<img src="' . tag_replace(get_value($action, 'url_img')) . '" style="display:block !important;" />' : '';

?>

<a href="<?php echo tag_replace(get_value($action, 'link')) ?>" <?php echo $target ?>>
	<?php echo $img ?>
	<?php echo get_value($action, 'label') ?>
</a>