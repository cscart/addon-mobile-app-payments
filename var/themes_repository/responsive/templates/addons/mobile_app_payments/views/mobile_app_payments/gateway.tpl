<!Doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{__("mobile_app_payments.gateway_title")}</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: sans-serif;
        }

        .payment-form {
            margin: 0 auto;
            max-width: 420px;
            padding: 0 10px;
        }

        .button {
            padding: 10px;
            background: #eee;
            text-decoration: none;
            color: black;
            border-radius: 4px;
            box-shadow: silver 2px 2px;
            margin: 20px 0;
            display: block;
            text-align: center;
        }

        .button:hover {
            background: #ccc;
        }
    </style>
</head>
<body>
<div class="payment-form">
    <h1>{__("mobile_app_payments.gateway_header")}</h1>

    <p>
        {__("mobile_app_payments.placing_order", [
            "[account_id]" => $account_id
        ])}
    </p>

    <p>
        {capture name="total"}
            <b>{include file="common/price.tpl" value=$amount}</b>
        {/capture}

        {__("mobile_app_payments.total", [
            "[total]" => $smarty.capture.total
        ])}
    </p>

    <p>{__("mobile_app_payments.next_step")}</p>

    <p>
        <a href="{$cancel_url|fn_url}"
           class="button"
        >{__("mobile_app_payments.cancel_and_return")}</a>

        <a href="{$return_url|fn_url}"
           class="button"
        >{__("mobile_app_payments.finish_payment")}</a>
    </p>
</div>
</body>
</html>