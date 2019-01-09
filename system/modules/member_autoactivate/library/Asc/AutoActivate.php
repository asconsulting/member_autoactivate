<?php

/**
 * Member Auto-Activate
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/member_autoactivate
 * @link       https://andrewstevens.consulting
 */

 
namespace Asc;

class AutoActivate extends \Frontend
{
	
	public function autoActivate($intId, $arrData, $objModule)
	{
		$boolActivate = FALSE;
		
		if ($objModule->reg_autoActivate) {
			if ($objModule->reg_autoActivateDomains != '') {
				list($emailUser, $emailDomain) = explode("@", $arrData['email']);
				$arrDomains = preg_split("/\\r\\n|\\r|\\n/", $objModule->reg_autoActivateDomains);
				foreach($arrDomains as $domain) {
					if (strtolower(trim($domain)) == strtolower(trim($emailDomain))) {
						$boolActivate = TRUE;
					}
				}
			} else {
				$boolActivate = TRUE;
			}
		}
		
		if ($boolActivate) {
			$objMember = \MemberModel::findByIdOrAlias($intId);
			// Update the account
			$objMember->disable = '';
			$objMember->activation = '';
			$objMember->save();

			// HOOK: post activation callback
			if (isset($GLOBALS['TL_HOOKS']['activateAccount']) && is_array($GLOBALS['TL_HOOKS']['activateAccount']))
			{
				foreach ($GLOBALS['TL_HOOKS']['activateAccount'] as $callback)
				{
					$this->import($callback[0]);
					$this->{$callback[0]}->{$callback[1]}($objMember, $this);
				}
			}

		}
		
	}
	
}