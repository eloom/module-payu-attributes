define(["jquery","mage/utils/wrapper","Magento_Checkout/js/model/quote"],function(d,e,f){return function(g){return e.wrap(g,function(h,k){var a=f.billingAddress();void 0===a.extension_attributes&&(a.extension_attributes={});void 0!==a.customAttributes&&d.each(a.customAttributes,function(b,c){b=c.attribute_code;var l=c.value;a.customAttributes[b]=c;a.extension_attributes[b]=l});return h(k)})}});