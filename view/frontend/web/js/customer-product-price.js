define([
    'jquery',
    'mage/translate',
    'underscore',
    'Magento_Catalog/js/price-utils',
    'jquery-ui-modules/widget'
], function ($, $t, _, priceUtils) {
    'use strict';

    $.widget('extension.customerPrice', {

        /** @inheritdoc */
        _create: function () {
            var self = this;
            let elements = $('.customer-product-price');
            let params = [];
            let productIds = [];
            _.each(elements, function(e) {
                params[$(e).data('id')] = $(e);
                productIds.push($(e).data('id'));
            });
            $.ajax({
                url: this.options.url,
                method: 'POST',
                data: {productIds:productIds},
                showLoader: true
            }).done(function (data) {
                _.each(data, function (priceData) {
                    let lable = $t('Your Price');
                    params[priceData.product_id].html('<label>' + lable + '</label> ' + self.getFormattedPrice(priceData.price))
                });
            }).fail(function (jqXHR, textStatus) {
                if (window.console) {
                    console.log(textStatus);
                }
                location.reload();
            });
        },

        /**
         * Formats the price according to store
         *
         * @param {number} Price to be formatted
         * @return {string} Returns the formatted price
         */
        getFormattedPrice: function (price) {
            var priceFormat = {
                decimalSymbol: '.',
                groupLength: 3,
                groupSymbol: ",",
                integerRequired: false,
                pattern: "$%s",
                precision: 2,
                requiredPrecision: 2
            };

            return priceUtils.formatPrice(price, priceFormat);
        }
    });

    return $.extension.customerPrice;
});
