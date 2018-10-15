<?php

use Tygh\Addons\MobileAppPayments\Redirect;
use Tygh\Enum\Addons\StorefrontRestApi\PaymentTypes;

defined('BOOTSTRAP') or die('Access denied');

/** @var array $schema Mobile app payment methods availability schema */

$schema[Redirect::SCRIPT_NAME] = [
    'type'  => PaymentTypes::REDIRECTION,
    'class' => '\Tygh\Addons\MobileAppPayments\Redirect',
];

return $schema;