
jQuery(document).ready(function() {
    jQuery('.home-tabs .home-tab-links a').on('click', function(e)  {

        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery('.home-tab' + currentAttrValue).siblings().slideUp(400);
		jQuery('.home-tab' + currentAttrValue).delay(400).slideDown(400);
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
 

    });

});