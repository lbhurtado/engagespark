<?php

namespace LBHurtado\EngageSpark\Classes;

use Eloquent\Enumeration\AbstractEnumeration;

final class ServiceMode extends AbstractEnumeration
{
	const SMS = 'sms';
	const TOPUP = 'topup';
}