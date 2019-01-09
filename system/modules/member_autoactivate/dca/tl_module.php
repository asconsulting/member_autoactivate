<?php

/**
 * Member Auto-Activate
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/member_autoactivate
 * @link       https://andrewstevens.consulting
 */


/**
 * Table tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'reg_autoActivate';

$GLOBALS['TL_DCA']['tl_module']['palettes']['registration']	= str_replace('reg_allowLogin', 'reg_allowLogin,reg_autoActivate', $GLOBALS['TL_DCA']['tl_module']['palettes']['registration']);	

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['reg_autoActivate'] = 'reg_autoActivateDomains';

$GLOBALS['TL_DCA']['tl_module']['fields']['reg_autoActivate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['reg_autoActivate'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['reg_autoActivateDomains'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['reg_autoActivateDomains'],
	'inputType'               => 'textarea',
	'eval'                    => array('tl_class'=>'clr'),
	'sql'                     => "text NULL"
);
