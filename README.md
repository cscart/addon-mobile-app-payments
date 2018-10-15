# About

This add-on provides samples on how to implement payment methods compatible with the Mobile app.

# Essential components

* The schema that extends the list of Mobile app-compatible payment methods:

    `app/addons/mobile_app_payments/schemas/storefront_rest_api/payment_processors.post.php`
    
* The payment method class that provides data for the payment gateway redirection:

    `app/addons/mobile_app_payments/Tygh/Addons/MobileAppPayments/Redirect.php`
    
* The payment processor script that starts a payment from a storefront:

    `app/addons/mobile_app_payments/payments/redirect.php`
    
* The payment method configuration form:

    `design/backend/templates/addons/mobile_app_payments/views/payments/components/cc_processors/redirect.tpl`
    
* Templates to collect additional payment information when placing an order and to distinct the compatible methods in the Mobile app:

    `design/backend/templates/addons/mobile_app_payments/views/orders/components/payments/redirect.tpl`
    
    `var/themes_repository/responsive/templates/addons/mobile_app_payments/views/orders/components/payments/redirect.tpl`
    