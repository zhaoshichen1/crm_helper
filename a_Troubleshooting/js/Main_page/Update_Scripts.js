/**
 * Created by SZHAO on 4/9/2016.
 */

/**
 * reset the error code to 0
 *
 * FUNC_ID = 500005
 */
function updateReservoirAvantage() {

    /**
     * record the execution numbers
     */
    record_execution(500005);

    var begin = noteCurrentSecond();

    waitingecheckko();
    var card_number = $("#cardNumberEcheckGen").val();
    console.log('card number' + card_number);

    if (card_number.length != 13) {
        alert("Please give an valid card number with 13 digits!");
        $("#answerloyaltyecheckko").empty();
        return;
    }

    /**
     * originally no problem ( no error code ) - to check
     */
    $.ajax({
            url: "php/Controllers/getData_BCZ_All.php",
            method: "GET",
            data: {
                loyalty_echeckko_cardnumber: card_number
            }
        })
        .done(function (data) {
            console.log("data="+data);
            if (data.substring(0,10) == 'No problem') {
                alert("There is no problem for this card!");
                $("#answerloyaltyecheckko").empty().append("");
                hide_reset();
            }
            else {
                $.ajax({
                        url: "php/Controllers/getData_BCZ_All.php",
                        method: "GET",
                        data: {
                            loyalty_reset: card_number
                        }
                    })
                    .done(function (data) {
                        console.log(data);
                        $("#answerloyaltyecheckko").empty().append("Reset done!");

                        // hide this information in some seconds
                        setTimeout(function () {
                            $("#answerloyaltyecheckko").empty().append("");
                        }, 2000);
                        hide_reset();

                        alertExecutionTime(giveDifferenceInMS(begin));
                    });
            }
        });
}