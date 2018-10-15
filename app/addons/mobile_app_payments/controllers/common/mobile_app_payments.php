<?php
/**
 * Stub file to render the payment gateway page.
 */

defined('BOOTSTRAP') or die('Access denied');

use Tygh\Tygh;

if ($mode === 'gateway') {

    $_REQUEST = array_merge([
        'order_id'   => '',
        'cancel_url' => '',
        'return_url' => '',
        'account_id' => '',
        'amount'     => 0,
    ], $_REQUEST);

    $return_url = fn_link_attach($_REQUEST['return_url'], 'transaction_id=' . TIME);

    /** @var \Tygh\SmartyEngine\Core $view */
    $view = Tygh::$app['view'];

    $view->assign([
        'return_url' => $return_url,
        'cancel_url' => $_REQUEST['cancel_url'],
        'account_id' => $_REQUEST['account_id'],
        'amount'     => $_REQUEST['amount'],
    ]);

    $view->display('addons/mobile_app_payments/views/mobile_app_payments/gateway.tpl');
    exit;
}

return [CONTROLLER_STATUS_OK];