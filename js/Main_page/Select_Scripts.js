/**
 * Created by SZHAO on 4/9/2016.
 */


/**
 *  ________________________________________________________
 *  Run Scripts functions
 */


/**
 * find card used for purchase
 */
function getDuplicate() {

    console.log('in getDuplicate');
    var begin = noteCurrentSecond();
    waitingDup();
    var telephone_nb = 0, accounts_nb = 0;

    $.ajax({
            url: 'php/Controllers/getData_Customer03.php',
            method: 'GET',
            data: {
                tel_dup:'key'
            }
        })
        .done(function (data) {
            telephone_nb = data;
        });

    $.ajax({
            url: 'php/Controllers/getData_Customer03.php',
            method: 'GET',
            data: {
                account_dup:'key'
            }
        })
        .done(function (data) {
            accounts_nb = data;
            $("#answerDup").empty().append(telephone_nb+" tels"+", "+accounts_nb+" accounts");
            alertExecutionTime(giveDifferenceInMS(begin));
        });

}

/**
 * check evoucher generation
 *
 * FUNC_ID = 500002
 */
function getDataEcheckKo() {

    /**
     * record the execution numbers
     */
    record_execution(500002);

    var begin = noteCurrentSecond();

    waitingecheckko();
    var card_number = $("#cardNumberEcheckGen").val();
    if (card_number.length != 13) {
        alert("Please give an valid card number with 13 digits!");
        console.log("why");
        setTimeout(function(){
            $("#answerloyaltyecheckko").empty();
            console.log("go");
        }, 1000);
        return;
    }

    console.log('card number' + card_number);

    $.ajax({
            url: "php/Controllers/getData_BCZ_All.php",
            method: "GET",
            data: {
                loyalty_echeckko_cardnumber: card_number
            }
        })
        .done(function (data) {
            console.log(data);

            alertExecutionTime(giveDifferenceInMS(begin));

            if (data.indexOf("No problem")==0) {
                $("#answerloyaltyecheckko").empty().append("No Problem found for this card");
                hide_reset();

            }
            /**
             * if error code is 0, no need to reset
             */
            else{
                if(data.substring(0,16)=="Code Error is: 0"){
                    $("#answerloyaltyecheckko").empty().append(data);
                    hide_reset();
                }
                else {
                    $("#answerloyaltyecheckko").empty().append(data);
                    show_reset();
                }
            }
        });
}

/**
 * find card used for purchase
 *
 * FUNC_ID = 500003
 */
function getDataFindCard() {

    /**
     * record the execution numbers
     */
    record_execution(500003);

    var begin = noteCurrentSecond();

    waitingfindcard();
    var till_number = $("#tillNumberFindCard").val();
    var store_number = $("#storeNumFindCard").val();
    var trans_number = $("#transNumberFindCard").val();
    var from_date = $("#fromFindCard").val();
    var to_date = $("#toFindCard").val();
    $.ajax({
            url: 'php/Controllers/getData_BCZ_All.php',
            method: 'GET',
            data: {
                storenumberfindcard: store_number,
                tillnumberfindcard: till_number,
                transnumberfindcard: trans_number,
                from: from_date,
                to: to_date
            }
        })
        .done(function (data) {
            alertExecutionTime(giveDifferenceInMS(begin));
            $("#answerfindcardnumber").empty().append(data);
        });

}

/**
 * whether a card is subscribed to loyalty or not
 *
 * FUNC_ID = 500001
 */
function getDataSubFidelity() {

    /**
     * record the execution numbers
     */
    record_execution(500001);

    var begin = noteCurrentSecond();

    waitingfidelity();
    var card_number = $("#cardNumberfidelity").val();
    $.ajax({
            url: "php/Controllers/getData_BCZ_All.php",
            method: "GET",
            data: {numbercardfidelity: card_number}
        })
        .done(function (data) {

            alertExecutionTime(giveDifferenceInMS(begin));

            var response = "No";
            var color = "#FF0000";
            console.log(data);
            if (data == 1) {
                response = "Yes";
                color = "#00FF00";
            }

                // propose the user to repair it
            else{
                alertify.confirm("Be Careful! Launch the script for auto-repair now?",
                    function(){
                        alertify.success('Repair script launched');

                        // use Ajax to call the PHP for the repair, but attention, we need to feed enough values
                        $.ajax({
                                url: 'php/Controllers/getData_BCZ_All.php',
                                method: 'GET',
                                data: {
                                    storenumberfindcard: store_number,
                                    tillnumberfindcard: till_number,
                                    transnumberfindcard: trans_number,
                                    from: from_date,
                                    to: to_date
                                }
                            })
                            .done(function (data) {
                                alertExecutionTime(giveDifferenceInMS(begin));
                                $("#answerfindcardnumber").empty().append(data);
                            });
                    },
                    function(){
                        alertify.error('Repair script cancelled');
                    });
            }
            $("#answersubfidelity").empty().append(response).css('color', color);

        });
}

/**
 * get the record of transfer
 *
 * FUNC_ID = 500004
 */
function getTransfer(){

    /**
     * record the execution numbers
     */
    record_execution(500004);

    var begin = noteCurrentSecond();

    waitingtransfer();
    var card_number = $("#cardTransfer").val();
    if (card_number.length != 13) {
        alert("Please give an valid card number with 13 digits!");
        $("#treat").empty()
        return;
    }


    /**
     * hide this table when we launch the request
     * @type {Element}
     */
    var table = document.getElementById("displayTransfer");
    table.style = "visibility:hidden";

    console.log('card number' + card_number);

    $.ajax({
            url: "php/Controllers/getData_BCZ_All.php",
            method: "GET",
            data: {
                cardTransfer: card_number
            }
        })
        .done(function (data) {

            console.log(data);
            debug = data;
            displayTheTransferRecord(data,card_number);

            alertExecutionTime(giveDifferenceInMS(begin));
        });
}

/**
 * get the complete purchase history of one guy, and generate a csv file to download
 *
 * FUNC_ID = 500006
 */
function getCompletePurchaseHistory() {

    /**
     * record the execution numbers
     */
    record_execution(500006);

    console.log("dsa");

    waitingCompletePurchase();
    var card_number = $("#cardCompletePurchase").val();
    var from = $('#PurchasefromFindCard').val();
    var to = $('#PurchasetoFindCard').val();

    if (card_number.length != 13) {
        alert("Please give an valid card number with 13 digits!");
        $("#answerCompletePurchase").empty();
        return;
    }

    else {



            // wait two seconds and then remove the loading icon
            setTimeout(function(){
                $("#answerCompletePurchase").empty();
            },2000);

            // which means we could choose time
            if(document.getElementById("ChooseTime").style.display == ""){
                window.location = 'php/Controllers/getData_BCZ_PurchaseCompleteCSV.php?numbercardcompletepurchase='+card_number+'&from='+from+'&to='+to;
                if($('#PurchasefromFindCard').val() == ""||$('#PurchasetoFindCard').val() == ""){
                    alert("Please give the valid date!");
                    $("#answerCompletePurchase").empty();
                    return;
                }
            }
                // which means choose from beginning
            else{
                window.location = 'php/Controllers/getData_BCZ_PurchaseCompleteCSV.php?fromBegin=true&numbercardcompletepurchase='+card_number+'&from='+from+'&to='+to;
            }
        }

}