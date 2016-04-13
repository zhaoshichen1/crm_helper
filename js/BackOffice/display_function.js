/**
 * Created by zhaoshichen on 4/8/16.
 */


var debug;

/**
 * parse the result got from DB and show them
 * @param result
 */
function treatResult(result) {
    var nn = JSON.parse(result);
    debug = nn;
    /**
     * empty result case
     */
    if (nn.length == 0) {

        console.log("No record found");

        /**
         * just stop
         */
        return;
    }

    var table = document.getElementById("function_list");

    // clean the old data
    while (table.rows.length > 1) {
        table.deleteRow(1);
    }

    /**
     * insert new values
     */
    for (var n = 0; n < nn.length; n++) {
        var newRow = table.insertRow(table.rows.length);
        var func_idNb = newRow.insertCell(0);
        var func_nameNb = newRow.insertCell(1);
        var page_idNb = newRow.insertCell(2);
        var page_nameNb = newRow.insertCell(3);
        var operationsNb = newRow.insertCell(4);

        func_idNb.innerHTML = nn[n][0];
        func_nameNb.innerHTML = nn[n][1];
        page_idNb.innerHTML = nn[n][2];
        page_nameNb.innerHTML = nn[n][3];

        var edit = document.createElement("i");
        var editHTML = "<i class=\"icon-pencil\" onclick=edit_func_name("+nn[n][0]+",'"+nn[n][2]+"') \/i>";
        edit.innerHTML = editHTML;

        var add = document.createElement("i");
        add.className = "icon-plus";
        add.style = "margin-left:15%"

        operationsNb.appendChild(edit);
        operationsNb.appendChild(add);
    }
}

/**
 * connect to the db and show the result
 */
function displayFuncs(){

    var n;
    /**
     * firstly pass a request of ajax to the back-end
     **/
    $.ajax({
            url: '../../php/Controllers/getData3_internalData.php',
            method: 'GET',
            data: {
                key_func: "func"
            }
        })
        .done(function (data) {
            console.log(data);
            treatResult(data);
        });

}

/**
 * the function to be called when the pencil is clicked by user to modify the page's name
 * @param id
 * @param old_name
 */
function edit_func_name(id,old_name){

    var new_name = '';

    alertify.prompt("What's the new name for the functionality with ID: "+id, old_name,
        function(evt, value ){
            new_name = value;

            if(new_name!=''){
                /**
                 * ask PHP to update the page name
                 **/
                $.ajax({
                        url: '../../php/Controllers/getData3_internalData.php',
                        method: 'POST',
                        data: {
                            func_id: id,
                            func_name: new_name
                        }
                    })
                    .done(function (data) {
                        console.log(data);
                        alertify.message(data);
                    });
            }
            else{
                alertify.error('Please give an invalid name!');
            }
        },
        function(){
            alertify.error('Operation cancelled');
        })
    ;

}

window.onload = function(){
    displayFuncs();
}