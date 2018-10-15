<?php

use Tygh\Addons\MobileAppPayments\Redirect;

defined('BOOTSTRAP') or die('Access denied');

/** @var array $order_info     Order information */
/** @var array $processor_data Payment method information */
/** @var array $pp_response    Payment processing result */

/**
 * Process a payment notification.
 */
if (defined('PAYMENT_NOTIFICATION')) {

    if ($mode === 'cancel') {
        $pp_response = [
            'order_status' => STATUS_INCOMPLETED_ORDER,
        ];
    } elseif ($mode === 'success') {
        $pp_response = [
            'order_status'   => 'P',
            'transaction_id' => $_REQUEST['transaction_id'],
        ];
    } else {
        die('Access denied');
    }

    fn_finish_payment($_REQUEST['order_id'], $pp_response);

    fn_order_placement_routines('route', $_REQUEST['order_id']);
}

/**
 * Perform a payment.
 */
$processor = new Redirect();
$processor->setOrderInfo($order_info);
$processor->setAuthInfo(Tygh::$app['session']['auth']);
$processor->setPaymentInfo($processor_data);

// create a payment form to redirect to the payment gateway
fn_create_payment_form(
    $processor->getPaymentUrl(),
    $processor->getPaymentRequest(),
    'Mobile App Demo Payment: Redirect',
    false,
    $processor::PAYMENT_GATEWAY_REQUEST_METHOD
);