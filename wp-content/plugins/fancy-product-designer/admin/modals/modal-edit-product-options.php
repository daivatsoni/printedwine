<?php

FPD_Admin_Modal::output_header(
	'fpd-modal-edit-product-options',
	__('Fancy Product Options', 'radykal'),
	''
);

?>

<table class="form-table">
	<tbody>

		<?php

		radykal_output_option_item( array(
				'id' => 'stage_width',
				'title' => 'Stage Width',
				'type' => 'number',
				'class' => 'large-text',
				'placeholder' => __('Stage width from UI Layout', 'radykal'),
			)
		);

		radykal_output_option_item( array(
				'id' => 'stage_height',
				'title' => 'Stage Height',
				'type' => 'number',
				'class' => 'large-text',
				'placeholder' => __('Stage height from UI Layout', 'radykal')
			)
		);

		?>

	</tbody>
</table>

<?php
	FPD_Admin_Modal::output_footer(
		__('Set', 'radykal')
	);
?>
