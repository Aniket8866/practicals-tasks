define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'underscore',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/url-builder',
        'mage/url'
    ],
    function (
        $, 
        ko,
        Component,
        _,
        stepNavigator,
        customer,
        quote,
        urlBuilder, 
        urlFormatter
    ) {
        'use strict';
        /**
        * check-login - is the name of the component's .html template
        */
        return Component.extend({
            defaults: {
                template: 'Magento360_Practical/check-login'
            },

            //add here your logic to display step,
            isVisible: ko.observable(true),
            isLogedIn: customer.isLoggedIn(),
            //step code will be used as step content id in the component template
            stepCode: 'additionalInformation',
            //step title value
            stepTitle: 'Additional Information',

            /**
            *
            * @returns {*}
            */
            initialize: function () {
                this._super();
                // register your step
                stepNavigator.registerStep(
                    this.stepCode,
                    //step alias
                    null,
                    this.stepTitle,
                    //observable property with logic when display step or hide step
                    this.isVisible,

                    _.bind(this.navigate, this),

                    /**
                    * sort order value
                    * 'sort order value' < 10: step displays before shipping step;
                    * 10 < 'sort order value' < 20 : step displays between shipping and payment step
                    * 'sort order value' > 20 : step displays after payment step
                    */
                    15
                );

                return this;
            },

            /**
            * The navigate() method is responsible for navigation between checkout step
            * during checkout. You can add custom logic, for example some conditions
            * for switching to your custom step
            */
            navigate: function () {

            },

            /**
            * @returns void
            */
            navigateToNextStep: function () {
                var additional_number = document.getElementById("additional_number").value;
                var additional_name = document.getElementById("additional_name").value;
                var quoteId = quote.getQuoteId();
                var url = urlFormatter.build('additional_information/quote/save');
                var isCustomer = customer.isLoggedIn();
                // Mobile number validation logic
                if(additional_number.length != 10){
                    document.getElementById("number_validation_error").innerHTML = "Please Enter Valid Mobile Number!";
                    return false;
                }else{
                    document.getElementById("number_validation_error").innerHTML = "";
                }

                if (additional_name && additional_number) {

                var payload = {
                    'cartId': quoteId,
                    'additional_name': additional_name,
                    'additional_number': additional_number,
                    'is_customer': isCustomer
                };

                if (!payload.additional_name && !payload.additional_number) {
                    return true;
                }

                var result = true;

                $.ajax({
                    url: url,
                    data: payload,
                    dataType: 'text',
                    type: 'POST',
                }).done(
                    function (response) {
                        result = true;
                    }
                ).fail(
                    function (response) {
                        result = false;
                        errorProcessor.process(response);
                    }
                );
            }
                
                stepNavigator.next();
            }
        });
    }
);