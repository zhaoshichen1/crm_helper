/**
 * Created by SZHAO on 4/9/2016.
 */

/**
 * Till now, the hardest function to write ...
 */
function displayTheTransferRecord(response,card_number){

    var begin = noteCurrentSecond();

    var result = JSON.parse(response);

    var display_length;

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

        // if the record has more than 5 lines, propose user to download a CSV
        // else we display directly on the front-office
    else{
        if(result.length > 5){
            display_length = 5;
        }
        else
            display_length = result.length;
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
    for ( var n = 0;n<display_length;n++){
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



    // ask user whether he needs to download CSV file or not
    if(display_length < result.length){

        var newRow = table.insertRow(6
        );
        var indexNb = newRow.insertCell(0);
        var dateNb = newRow.insertCell(1);
        var storeNb = newRow.insertCell(2);
        var tillNb = newRow.insertCell(3);
        var transNb = newRow.insertCell(4);
        var amountNb = newRow.insertCell(5);
        var destNb = newRow.insertCell(6);

        indexNb.innerHTML = "...";
        dateNb.innerHTML = "...";
        storeNb.innerHTML = "...";
        tillNb.innerHTML = "...";
        transNb.innerHTML = "...";
        amountNb.innerHTML = "...";
        destNb.innerHTML = "...";

        alertify.confirm("The customer has "+result.length+" records. Do you need to download the complete file?",
            function(){

                // wait two seconds and then remove the loading icon
                setTimeout(function(){
                    $("#answerCompletePurchase").empty();
                },2000);
                window.location = 'php/Controllers/getData_BCZ_PurchaseTransferCSV.php?cardTransfer='+card_number;

            },
            function(){
                // alertify.error('Cancel');
            });
    }

    /**
     * after the insert, stop the loading image
     */
    $("#treat").empty();
}

var debug;

/**
 * the function to show the result
 * @param json_result
 */
function display_customer_type(json_result){

    debug = json_result;

    var real_result = JSON.parse(json_result);

    if(real_result.length ==0 ){
        $("#answerCheck").empty().append("No information has been found");
        return;
    }

    var string_to_show = "";

        switch(real_result[0][0]){
            case "1":
                string_to_show+= "Temp Customers - No Loyalty, Not recommended to use";
                break;
            case "2":
                string_to_show+="Offline Customers - Need to activate on .CN";
                break;
            case "3":
                string_to_show+="Complete Customers";
                break;
            default:
                string_to_show+=real_result[0][0];
                break;
        }
    string_to_show+=" --> "+real_result[0][1];

    $("#answerCheck").empty().append(string_to_show);
}

/**
 * time range choice functions for purchase
 */
function click_on_custom(){
    document.getElementById("ChooseTime").style.display = "";
    document.getElementById("ButtonTime").textContent = "Custom Range"
}

function click_on_From_Begin(){
    document.getElementById("ChooseTime").style.display = "none";
    document.getElementById("ButtonTime").textContent = "From Beginning";
}

/**
 * Email/Tel choice function
 */
function click_on_Email(){
    document.getElementById("emailRow").style.display = "";
    document.getElementById("telRow").style.display = "none";
    document.getElementById("ButtonCheck").textContent = "Email"
}

function click_on_Tel(){
    document.getElementById("emailRow").style.display = "none";
    document.getElementById("telRow").style.display = "";
    document.getElementById("ButtonCheck").textContent = "Telephone";
}