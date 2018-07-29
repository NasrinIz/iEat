/*=====================================================
				Login / Register Page
======================================================*/
$(document).ready(function () {
    $('.message a').click(function () {
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });
    calculatePercentage();
    $('.customSelect2').select2();

    $('.menu-trigger').click(function() {
        $('nav ul').slideToggle(500);
    });//end slide toggle

    $(window).resize(function() {
        if (  $(window).width() > 500 ) {
            $('nav ul').removeAttr('style');
        }
    });//end resize





});


function calculatePercentage() {
    // Number of mandatory items
    let mandatoryItems = $('.menu_field').length;
    // Divide 100 by the number of items to get the % width
    let mandatoryItemsPC = 100 / mandatoryItems;
    // Number of completed items in the list
    let completedItems = $('.menu_field').parent().find('.menu_field_completed').length;
    // Number of completed items times by the mandatory items percentage
    let percentageComplete = completedItems * mandatoryItemsPC;
    // Round percentage to nearest integer (removing the decimal place)
    let percentageRounded = Math.round(percentageComplete);

    /*    console.log("mandatoryItems:" + mandatoryItems);
        console.log("completedItems:" + completedItems);
        console.log("mandatoryItemsPC:" + mandatoryItemsPC);
        console.log("percentageComplete:" + percentageComplete);
        console.log("percentageRounded:" + percentageRounded);*/

    let circle = $('svg circle');
    let text = $('svg text tspan');

    let radius = circle.attr('r');
    let circumference = Math.PI * (radius * 2);

    circle.css({'stroke-dashoffset': ((100 - percentageRounded) / 100) * circumference});
    text.text(percentageRounded + '%');
}
