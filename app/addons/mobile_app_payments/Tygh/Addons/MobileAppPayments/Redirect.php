<?php

namespace Tygh\Addons\MobileAppPayments;

use Tygh\Addons\StorefrontRestApi\Payments\IRedirectionPayment;
use Tygh\Addons\StorefrontRestApi\Payments\RedirectionPaymentDetailsBuilder;
use Tygh\Common\OperationResult;
use Tygh\Tools\Url;

class Redirect implements IRedirectionPayment
{
    const PAYMENT_GATEWAY_REQUEST_METHOD = 'POST';
    const SCRIPT_NAME = 'redirect.php';
    const PROCESSOR = 'redirect';

    /**
     * @var array $order_info Order information
     */
    protected $order_info;

    /**
     * @var array $auth_info Payer's authentication information
     */
    protected $auth_info;

    /**
     * @var array $payment_info Payment method information.
     *                          Payment method settings are located in the 'processor_params' field of this property
     */
    protected $payment_info;

    /**
     * @var \Tygh\Addons\StorefrontRestApi\Payments\RedirectionPaymentDetailsBuilder $details_builder
     */
    protected $details_builder;

    /**
     * @var \Tygh\Common\OperationResult $preparation_result
     */
    protected $preparation_result;

    /**
     * ExampleRedirect constructor.
     */
    public function __construct()
    {
        $this->details_builder = new RedirectionPaymentDetailsBuilder();
        $this->preparation_result = new OperationResult();
    }

    /** @inheritdoc */
    public function setOrderInfo(array $order_info)
    {
        $this->order_info = $order_info;

        return $this;
    }

    /** @inheritdoc */
    public function setAuthInfo(array $auth_info)
    {
        $this->auth_info = $auth_info;

        return $this;
    }

    /** @inheritdoc */
    public function setPaymentInfo(array $payment_info)
    {
        $this->payment_info = $payment_info;

        return $this;
    }

    /** @inheritdoc */
    public function getDetails(array $request)
    {
        $this->preparation_result->setSuccess(true);

        $payment_url = $this->getPaymentUrl();
        $this->details_builder->setPaymentUrl($payment_url);

        $this->details_builder->setMethod(self::PAYMENT_GATEWAY_REQUEST_METHOD);

        $query_parameters = $this->getPaymentRequest();
        $this->details_builder->setQueryParameters($query_parameters);

        $cancel_url = $this->getCancelUrl();
        $this->details_builder->setCancelUrl($cancel_url);

        $return_url = $this->getReturnUrl();
        $this->details_builder->setReturnUrl($return_url);

        $this->preparation_result->setData($this->details_builder->asArray());

        return $this->preparation_result;
    }

    /**
     * Gets the URL of a payment gateway to send payment data to.
     *
     * @return string
     */
    public function getPaymentUrl()
    {
        return fn_url(Url::buildUrn(['mobile_app_payments', 'gateway']));
    }

    /**
     * Gets the URL a customer will be redirected to from a payment gateway if he/she decides to cancel a payment and
     * return to the store.
     *
     * @return string
     */
    public function getCancelUrl()
    {
        return fn_url(Url::buildUrn(['payment_notification', 'cancel'], [
            'order_id' => $this->order_info['order_id'],
            'payment'  => self::PROCESSOR,
        ]));
    }

    /**
     * Gets the URL a customer will be redirected to from a payment gateway after a payment is performed.
     *
     * @return string
     */
    public function getReturnUrl()
    {
        return fn_url(Url::buildUrn(['payment_notification', 'success'], [
            'order_id' => $this->order_info['order_id'],
            'payment'  => self::PROCESSOR,
        ]));
    }

    /**
     * Gets all specific parameters that are required by a payment gateway.
     *
     * @return array
     */
    public function getPaymentRequest()
    {
        return [
            'order_id'   => $this->order_info['order_id'],
            'amount'     => $this->order_info['total'],
            'account_id' => $this->payment_info['processor_params']['account_id'],
            'cancel_url' => $this->getCancelUrl(),
            'return_url' => $this->getReturnUrl(),
        ];
    }
}