<?php

defined('BOOTSTRAP') or die('Access denied');

use Tygh\Addons\MobileAppPayments\Redirect;
use Tygh\Tygh;

/**
 * Adds the payment method processor.
 */
function fn_mobile_app_payments_install()
{
    /** @var \Tygh\Database\Connection $db */
    $db = Tygh::$app['db'];

    if (!$db->getField('SELECT type FROM ?:payment_processors WHERE processor_script = ?s', Redirect::SCRIPT_NAME)) {
        $db->query('INSERT INTO ?:payment_processors ?e', [
            'processor'          => __('mobile_app_payments.redirect'),
            'processor_script'   => Redirect::SCRIPT_NAME,
            'processor_template' => 'addons/mobile_app_payments/views/orders/components/payments/redirect.tpl',
            'admin_template'     => 'redirect.tpl',
            'callback'           => 'Y',
            'type'               => 'P',
            'addon'              => 'mobile_app_payments',
        ]);
    }
}

function fn_mobile_app_payments_uninstall()
{
    /** @var \Tygh\Database\Connection $db */
    $db = Tygh::$app['db'];

    $processor_id = $db->getField(
        'SELECT processor_id FROM ?:payment_processors WHERE processor_script = ?s',
        Redirect::SCRIPT_NAME
    );

    if (!$processor_id) {
        return;
    }

    $db->query('DELETE FROM ?:payment_processors WHERE processor_id = ?i', $processor_id);
    $db->query(
        'UPDATE ?:payments SET ?u WHERE processor_id = ?i',
        [
            'processor_id'     => 0,
            'processor_params' => '',
            'status'           => 'D',
        ],
        $processor_id
    );
}