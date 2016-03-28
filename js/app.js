
var debug;



$(document).ready(function() {

// 确定文件存在并且可写

    /**
     *  ________________________________________________________
     *  Time & Date functions
     */

    /**
     * get the current tinme sheet
     * @returns {number}
     */
    function noteCurrentSecond(){
        return new Date().getTime();
    }

    /**
     * calculate the time difference
     * @param begin_time
     * @returns {number}
     */
    function giveDifferenceInMS( begin_time){

        var result = new Date().getTime() - begin_time;
        if (result < 0){
            return begin_time - new Date().getTime();
        }

        return result;
    }

    /**
     * show an alert in the browser to display the execution time
     * @param time
     */
    function alertExecutionTime(time){
        alertify.message("The execution time is "+time+" ms");
    }


    /**
     *  ________________________________________________________
     *  Run Scripts functions
     */

    /**
     * reset the error code to 0
     */
    function updateReservoirAvantage() {

        var begin = noteCurrentSecond();

        waitingecheckko();
        var card_number = $("#cardNumberEcheckGen").val();
        console.log('card number' + card_number);

        if (card_number.length != 13) {
            alert("Please give an valid card number with 13 digits!");
            return;
        }

        /**
         * originally no problem ( no error code ) - to check
         */
        $.ajax({
                url: "php/getData.php",
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
                            url: "php/getData.php",
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

    /**
     * check evoucher generation
     */
    function getDataEcheckKo() {

        var begin = noteCurrentSecond();

        waitingecheckko();
        var card_number = $("#cardNumberEcheckGen").val();
        if (card_number.length != 13) {
            alert("Please give an valid card number with 13 digits!");
            return;
        }

        console.log('card number' + card_number);

        $.ajax({
                url: "php/getData.php",
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
     * Till now, the hardest function to write ...
     */
    function displayTheTransferRecord(response){

        var begin = noteCurrentSecond();

        var result = JSON.parse(response);
        /**
         * empty result case
         */
        if(result.length==0){
            /**
             * stop the loading image
             */
            $("#treat").empty();

            alert("No record found");

            /**
             * just stop
             */
            return;
        }


        var table = document.getElementById("displayTransfer");

        // show the table
        table.style = "";

        // clean the old data
        while(table.rows.length>1){
            table.deleteRow(1);
        }

        /**
         * insert new values
         */
        for ( var n = 0;n<result.length;n++){
            var newRow = table.insertRow(table.rows.length);
            var indexNb = newRow.insertCell(0);
            var dateNb = newRow.insertCell(1);
            var storeNb = newRow.insertCell(2);
            var tillNb = newRow.insertCell(3);
            var transNb = newRow.insertCell(4);
            var amountNb = newRow.insertCell(5);
            var destNb = newRow.insertCell(6);

            indexNb.innerHTML = n+1;
            dateNb.innerHTML = result[n][0];
            storeNb.innerHTML = result[n][1];
            tillNb.innerHTML = result[n][2];
            transNb.innerHTML = result[n][3];
            amountNb.innerHTML = result[n][4];
            destNb.innerHTML = result[n][5];
        }

        /**
         * after the insert, stop the loading image
         */
        $("#treat").empty();
    }

    /**
     * find card used for purchase
     */
    function getDataFindCard() {

        var begin = noteCurrentSecond();

        waitingfindcard();
        var till_number = $("#tillNumberFindCard").val();
        var store_number = $("#storeNumFindCard").val();
        var trans_number = $("#transNumberFindCard").val();
        var from_date = $("#fromFindCard").val();
        var to_date = $("#toFindCard").val();
        $.ajax({
                url: 'php/getData.php',
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
     */
    function getDataSubFidelity() {

        var begin = noteCurrentSecond();

        waitingfidelity();
        var card_number = $("#cardNumberfidelity").val();
        $.ajax({
                url: "php/getData.php",
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
                $("#answersubfidelity").empty().append(response).css('color', color);

            });
    }

    /**
     * get the record of transfer
     */
    function getTransfer(){

        var begin = noteCurrentSecond();

        waitingtransfer();
        var card_number = $("#cardTransfer").val();
        if (card_number.length != 13) {
            alert("Please give an valid card number with 13 digits!");
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
                url: "php/getData.php",
                method: "GET",
                data: {
                    cardTransfer: card_number
                }
            })
            .done(function (data) {

                console.log(data);
                debug = data;
                displayTheTransferRecord(data);

                alertExecutionTime(giveDifferenceInMS(begin));
            });
    }

    /**
     *  ________________________________________________________
     *  Waiting functions
     *  And CSS functions
      */
    function waitingdkcard() {
        $("#answer").empty().append('<br/><img src="images/ring.svg" alt="loading" style="width:200px; position: absolute; top: 50px; left: 40%;"/>');
    }

    function waitingecheckko() {
        $("#answerloyaltyecheckko").empty().append('<br/><img src="images/squares.svg" alt="loading" style="width:120px; left: 40%;"/>');
    }

    function waitingfindcard() {
        $("#answerfindcardnumber").empty().append('<img src="images/squares.svg" alt="loading" style="width:80px; left: 40%;"/>');
    }

    function waitingfidelity() {
        $("#answersubfidelity").empty().append('<img src="images/squares.svg" alt="loading" style="width:120px; left: 40%;"/>');
    }

    function waitingtransfer(){
        $("#treat").empty().append('<img src="images/squares.svg" alt="loading" style="width:120px; left: 40%;"/>');
    }

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


    /**
     *  ________________________________________________________
     *  Date functions
     */
    $("#fromFindCard").datepicker().datepicker("option", "dateFormat", "yy-mm-dd");
    $("#toFindCard").datepicker().datepicker("option", "dateFormat", "yy-mm-dd");

})


