<?php

FPD_Admin_Modal::output_header(
	'fpd-modal-load-demo',
	__('Load an example demo', 'radykal'),
	''
);

?>

<ul class="fpd-modal-list">
<?php

	//load demos in a list
	$demo_url = 'http://assets.fancyproductdesigner.com/fpd-demos.json';
	$json = fpd_admin_get_file_content($demo_url);
	$json = json_decode($json);

	foreach($json as $key => $value) {
		echo '<li><a href="'.$value.'" class="button-primary">'.__('Load', 'radykal').'</a>'.$key.'</li>';
	}

?>
</ul>

<?php
	FPD_Admin_Modal::output_footer();
?>