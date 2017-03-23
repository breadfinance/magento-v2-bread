/**
 * Populates checkout config data when shipping step
 * in checkout is completed
 *
 * @author  Bread   copyright   2016
 * @author  Miranda @Mediotype
 */
/*global define*/
define(
    [
        'Magento_Checkout/js/view/shipping',
        'jquery',
        'Magento_Checkout/js/model/quote'
    ],
    function (Shipping, $, quote) {
        'use strict';
        return Shipping.extend({
            setShippingInformation: function() {
                /** Call parent method */
                Shipping.prototype.setShippingInformation.call(this);

                this.updateConfigData();
                this.invalidateToken();
            },

            /**
             * Add updated shipping option data to window.checkoutConfig global variable
             *
             * @see Bread\BreadCheckout\Model\Ui\ConfigProvider
             */
            updateConfigData: function() {
                window.checkoutConfig.payment.breadcheckout.breadConfig.shippingOptions = {
                    type: quote.shippingMethod().carrier_title + ' - ' + quote.shippingMethod().method_title,
                    typeId: quote.shippingMethod().carrier_code + '_' + quote.shippingMethod().method_code,
                    cost: this.round(quote.shippingMethod().base_amount)
                };
            },

            /**
             * Invalidate existing transaction ID (in case user filled out payment
             * form and then went back a step)
             */
            invalidateToken: function() {
                if (window.checkoutConfig.payment.breadcheckout.transactionId !== null) {
                    window.checkoutConfig.payment.breadcheckout.transactionId = null;
                }
            },

            /**
             * Round float to 2 decimal plates and convert to integer
             *
             * @param value
             * @returns {Number}
             */
            round: function(value) {
                return parseInt(
                    Number(Math.round(parseFloat(value)+'e'+2)+'e-'+2)
                    * 100
                );
            }
        });
    }
);