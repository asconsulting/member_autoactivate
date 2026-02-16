<?php

/**
 * Member Auto-Activate
 *
 * Copyright (C) 2018-2026 Andrew Stevens Consulting
 *
 * @package    asconsulting/member_autoactivate
 * @link       https://andrewstevens.consulting
 */


namespace AutoActivate\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Idna;
use Contao\MemberModel;
use Contao\Module;
use Contao\System;

#[AsHook('createNewUser')]
class CreateNewUserListener
{
    public function __invoke(int $intId, array $arrData, Module $objModule): void
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
			$objMember = MemberModel::findByIdOrAlias($intId);
			// Update the account
			$objMember->disable = '0';
			$objMember->save();

			// HOOK: post activation callback
			if (isset($GLOBALS['TL_HOOKS']['activateAccount']) && \is_array($GLOBALS['TL_HOOKS']['activateAccount']))
			{
				foreach ($GLOBALS['TL_HOOKS']['activateAccount'] as $callback)
				{
					System::importStatic($callback[0])->{$callback[1]}($objMember, $objModule);
				}
			}

			System::getContainer()->get('monolog.logger.contao.access')->info('User account ID ' . $objMember->id . ' (' . Idna::decodeEmail($objMember->email) . ') has been auto-activated');
		}
    }
}