<?php

/**
 * Member Auto-Activate
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/member_autoactivate
 * @link       https://andrewstevens.consulting
 */


$GLOBALS['TL_HOOKS']['createNewUser'][]	= array('Asc\AutoActivate', 'autoActivate');