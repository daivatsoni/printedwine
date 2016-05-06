<?php

FPD_Admin_Modal::output_header(
	'fpd-modal-edit-view-options',
	__('Fancy View Options', 'radykal'),
	__('Here you can adjust some options for a single view. This allows, among other things to use different prices in different views.', 'radykal')
);

?>

<table class="form-table radykal-settings-form">
	<tbody>

		<?php

		radykal_output_option_item( array(
				'id' => 'stage_width',
				'title' => 'Stage Width',
				'type' => 'number',
				'class' => 'large-text',
				'placeholder' => __('Stage width from UI Layout/Fancy Product Options', 'radykal'),
			)
		);

		radykal_output_option_item( array(
				'id' => 'stage_height',
				'title' => 'Stage Height',
				'type' => 'number',
				'class' => 'large-text',
				'placeholder' => __('Stage height from UI Layout/Fancy Product Options', 'radykal')
			)
		);

		radykal_output_option_item( array(
				'id' => 'designs_parameter_price',
				'title' => 'Custom Image Price',
				'type' => 'number',
				'default' => fpd_get_option( 'fpd_designs_parameter_price' ),
				'description' => __('This price will be used for custom added images.', 'radykal')
			)
		);

		radykal_output_option_item( array(
				'id' => 'custom_texts_parameter_price',
				'title' => 'Custom Text Price',
				'type' => 'number',
				'default' => fpd_get_option( 'fpd_custom_texts_parameter_price' ),
				'description' => __('This price will be used for custom added images.', 'radykal')
			)
		);

		radykal_output_option_item( array(
				'type' => 'section_title',
				'title' => 'What kind of media types can the customer add in this view?',
			)
		);

		radykal_output_option_item( array(
				'id' => 'disable_image_upload',
				'title' => 'Disable Image Upload',
				'type' => 'checkbox',
				'default' => 'no'
			)
		);

		radykal_output_option_item( array(
				'id' => 'disable_custom_text',
				'title' => 'Disable Custom Text',
				'type' => 'checkbox',
				'default' => 'no'
			)
		);

		radykal_output_option_item( array(
				'id' => 'disable_designs',
				'title' => 'Disable Designs',
				'type' => 'checkbox',
				'default' => 'no'
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