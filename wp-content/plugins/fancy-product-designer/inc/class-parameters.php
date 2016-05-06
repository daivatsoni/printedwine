<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if(!class_exists('FPD_Parameters')) {

	class FPD_Parameters {

		public static function convert_parameters_to_string( $parameters, $type = '' ) {

			if( empty($parameters) ) { return '{}'; }

			$params_object = '{';
			foreach($parameters as $key => $value) {

				if( fpd_not_empty($value) ) {

					//convert boolean value to integer
					if(is_bool($value))
						$value = (int) $value;


					switch($key) {
						case 'x': //old
							$params_object .= '"left":'. $value .',';
						break;
						case 'left':
							$params_object .= '"left":'. $value .',';
						break;
						case 'originX':
							$params_object .= '"originX":"'. $value .'",';
						break;
						case 'originY':
							$params_object .= '"originY":"'. $value .'",';
						break;
						case 'y': //old
							$params_object .= '"top":'. $value .',';
						break;
						case 'top':
							$params_object .= '"top":'. $value .',';
						break;
						case 'z':
							$params_object .= '"z":'. $value .',';
						break;
						case 'colors':
							$params_object .= '"colors":"'. (is_array($value) ? implode(", ", $value) : ($value == "0" ? '' : $value)) .'",';
						break;
						case 'removable':
							$params_object .= '"removable":'. $value .',';
						break;
						case 'draggable':
							$params_object .= '"draggable":'. $value .',';
						break;
						case 'rotatable':
							$params_object .= '"rotatable":'. $value .',';
						break;
						case 'resizable':
							$params_object .= '"resizable":'. $value .',';
						break;
						case 'removable':
							$params_object .= '"removable":'. $value .',';
						break;
						case 'zChangeable':
							$params_object .= '"zChangeable":'. $value .',';
						break;
						case 'scale': //old
							$params_object .= '"scaleX":'. $value .',"scaleY":'. $value .',';
						break;
						case 'scaleX':
							$params_object .= '"scaleX":'. $value .',';
						break;
						case 'scaleY':
							$params_object .= '"scaleY":'. $value .',';
						break;
						case 'angle':
							$params_object .= '"degree":'. $value .',';
						break;
						case 'price':
							$params_object .= '"price":'. $value .',';
						break;
						case 'autoCenter':
							$params_object .= '"autoCenter":'. $value .',';
						break;
						case 'replace':
							$params_object .= '"replace":"'. $value .'",';
						break;
						case 'autoSelect':
							$params_object .= '"autoSelect":'. $value .',';
						break;
						case 'topped':
							$params_object .= '"topped":'. $value .',';
						break;
						case 'boundingBoxMode':
							$params_object .= '"boundingBoxMode":"'. $value .'",';
						break;
						case 'opacity':
							$params_object .= '"opacity":'. $value .',';
						break;
						case 'minW':
							$params_object .= '"minW":'. $value .',';
						break;
						case 'minH':
							$params_object .= '"minH":'. $value .',';
						break;
						case 'maxW':
							$params_object .= '"maxW":'. $value .',';
						break;
						case 'maxH':
							$params_object .= '"maxH":'. $value .',';
						break;
						case 'resizeToW':
							$params_object .= '"resizeToW":'. $value .',';
						break;
						case 'resizeToH':
							$params_object .= '"resizeToH":'. $value .',';
						break;
						case 'maxSize':
							$params_object .= '"maxSize":'. $value .',';
						break;
						case 'minDPI':
							$params_object .= '"minDPI":'. $value .',';
						break;
						case 'currentColor'://old
							$params_object .= '"fill":"'. $value .'",';
						break;
						case 'fill':
							$params_object .= '"fill":'. ($value == "0" ? 'false' : '"'.$value.'"') .',';
						break;
						case 'uploadZone':
							$params_object .= '"uploadZone":'. $value .',';
						break;
						case 'filters':
							$params_object .= '"filters":['. $value .'],';
						break;
						case 'filter':
							$params_object .= '"filter":'. ($value == "0" ? 'false' : '"'.$value.'"') .',';
						break;
						case 'replaceInAllViews':
							$params_object .= '"replaceInAllViews":'. $value .',';
						break;
						case 'lockUniScaling':
							$params_object .= '"lockUniScaling":'. $value .',';
						break;
						case 'uniScalingUnlockable':
							$params_object .= '"uniScalingUnlockable":'. $value .',';
						break;
						case 'colorLinkGroup':
							$params_object .= '"colorLinkGroup":'. ($value == "0" ? 'false' : '"'.$value.'"') .',';
						break;
						case 'uploadZoneScaleMode':
							$params_object .= '"uploadZoneScaleMode":"'. $value .'",';
						break;
					}

					if( $type == 'text' ) {

						switch($key) {
							case 'font': //old
								$params_object .= '"fontFamily":"'. $value .'",';
							break;
							case 'fontFamily':
								$params_object .= '"fontFamily":"'. $value .'",';
							break;
							case 'patternable':
								$params_object .= '"patternable":'. $value .',';
							break;
							case 'textSize': //old
								$params_object .= '"fontSize":'. $value .',';
							break;
							case 'fontSize':
								$params_object .= '"fontSize":'. $value .',';
							break;
							case 'editable':
								$params_object .= '"editable":'. $value .',';
							break;
							case 'lineHeight':
								$params_object .= '"lineHeight":'. $value .',';
							break;
							case 'textDecoration':
								$params_object .= '"textDecoration":"'. $value .'",';
							break;
							case 'maxLength':
								$params_object .= '"maxLength":'. $value .',';
							break;
							case 'fontWeight':
								$params_object .= '"fontWeight":"'. $value .'",';
							break;
							case 'fontStyle':
								$params_object .= '"fontStyle":"'. $value .'",';
							break;
							case 'textAlign':
								$params_object .= '"textAlign":"'. $value .'",';
							break;
							case 'curvable':
								$params_object .= '"curvable":'. $value .',';
							break;
							case 'curved':
								$params_object .= '"curved":'. $value .',';
							break;
							case 'curveSpacing':
								$params_object .= '"curveSpacing":'. $value .',';
							break;
							case 'curveRadius':
								$params_object .= '"curveRadius":'. $value .',';
							break;
							case 'curveReverse':
								$params_object .= '"curveReverse":'. $value .',';
							break;
							case 'stroke':
								$params_object .= '"stroke":"'. $value .'",';
							break;
							case 'strokeWidth':
								$params_object .= '"strokeWidth":'. $value .',';
							break;
							case 'maxLines':
								$params_object .= '"maxLines":'. $value .',';
							break;
						}
					}

				}
			}

			if( isset($parameters['uploadZone'])  ) {
				$params_object .= '"customAdds": {';
				if( isset($parameters['adds_uploads']) )
					$params_object .= '"uploads":'.$parameters['adds_uploads'].',';
				if( isset($parameters['adds_texts']) )
					$params_object .= '"texts":'.$parameters['adds_texts'].',';
				if( isset($parameters['adds_designs']) )
					$params_object .= '"designs":'.$parameters['adds_designs'].',';
				if( isset($parameters['adds_facebook']) )
					$params_object .= '"facebook":'.$parameters['adds_facebook'].',';
				if( isset($parameters['adds_instagram']) )
					$params_object .= '"instagram":'.$parameters['adds_instagram'].',';

				$params_object = trim($params_object, ',');
				$params_object .= '},';
			}

			//bounding box
			if( empty($parameters['bounding_box_control']) ) {

				//use custom bounding box
				if(isset($parameters['bounding_box_x']) &&
				   isset($parameters['bounding_box_y']) &&
				   isset($parameters['bounding_box_width']) &&
				   isset($parameters['bounding_box_height'])
				   ) {

					if( fpd_not_empty($parameters['bounding_box_x']) && fpd_not_empty($parameters['bounding_box_y']) && fpd_not_empty($parameters['bounding_box_width']) && fpd_not_empty($parameters['bounding_box_height']) ) {
						$params_object .= '"boundingBox": { "x":'. $parameters['bounding_box_x'] .', "y":'. $parameters['bounding_box_y'] .', "width":'. $parameters['bounding_box_width'] .', "height":'. $parameters['bounding_box_height'] .'}';

					}
				}

			}
			else if ( isset($parameters['bounding_box_by_other']) && fpd_not_empty(trim($parameters['bounding_box_by_other'])) ) {
				$params_object .= '"boundingBox": "'. $parameters['bounding_box_by_other'] .'"';
			}



			$params_object = trim($params_object, ',');
			$params_object .= '}';
			$params_object = str_replace('_', ' ', $params_object);

			return $params_object;

		}

	}

}


?>