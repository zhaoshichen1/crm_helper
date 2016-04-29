/**
 * Created by SZHAO on 4/9/2016.
 */

/**
 *  ________________________________________________________
 *  Trigger functions
 */
$("#buttonDkcardFind").click(function () {
    getDataDkcard();
});

$("#triggerEcheck").keypress(function (e) {
    if (e.which == 13) {
        getDataEcheckKo();
    }
});

$("#triggerFindCard").keypress(function (e) {
    if (e.which == 13) {
        getDataFindCard();
    }
});

/**
 * trigger the transfer function
 */
$("#triggerTransfer").keypress(function (e) {
    if (e.which == 13) {
        getTransfer();
    }
});

/**
 * defined like when the button is clicked, we will call the function of reset
 */
$('#button_treat').click(function () {
    updateReservoirAvantage();
});

$("#triggerfidelity").keypress(function (e) {
    if (e.which == 13) {
        getDataSubFidelity();
    }
});

$("#triggerCompletePurchase").keypress(function (e) {
    if (e.which == 13) {
        getCompletePurchaseHistory();
    }
});

$("#triggerCustomerCheck").keypress(function (e) {
    if (e.which == 13) {
        getCustomerCheckType();
    }
});


$('#myButton').click(function(){
    // clean last result
    $("#answerDup").empty();
    getDuplicate();

});