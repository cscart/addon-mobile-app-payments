{$suffix = $payment_id|default:0}

<div class="control-group">
    <label for="elm_account_id{$suffix}"
           class="control-label cm-required"
    >{__("mobile_app_payments.account_id")}:</label>

    <div class="controls">
        <input type="text"
               name="payment_data[processor_params][account_id]"
               id="elm_account_id{$suffix}"
               value="{$processor_params.account_id|default:$smarty.const.TIME}"
        />
    </div>
</div>