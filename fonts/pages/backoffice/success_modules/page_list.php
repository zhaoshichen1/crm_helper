<?php
/**
 * Created by PhpStorm.
 * User: zhaoshichen
 * Date: 4/4/16
 * Time: 5:40 PM
 */

?>

<div class="component">
    <table id="page_list">
        <thead>
        <tr>
            <th>Page ID</th>
            <th>Page Name</th>
            <th>Operations</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="user-name">1</td>
            <td class="user-email">Loyalty</td>
            <td class="operations">
                <!-- edit this line -->
                <i class="icon-pencil"></i>

                <!-- add a new line -->
                <i style="margin-left:15%" class="icon-plus"></i>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">

    var debug;
    function displayPages(){

        var response;

        /**
         * firstly pass a request of ajax to the back-end
         **/
        $.ajax({
                url: '../../php/Controllers/getData3_internalData.php',
                method: 'GET',
                data: {
                    key_page: "page"
                }
            })
            .done(function (data) {
                console.log(data);
                response = data;
            });

        debug = response;
        var result = JSON.parse(response);
//        debug = result;
//        /**
//         * empty result case
//         */
//        if(result.length==0){
//
//            alert("No record found");
//
//            /**
//             * just stop
//             */
//            return;
//        }
//
//        var table = document.getElementById("page_list");
//
//        // clean the old data
//        while(table.rows.length>1){
//            table.deleteRow(1);
//        }
//
//        /**
//         * insert new values
//         */
//        for ( var n = 0;n<result.length;n++){
//            var newRow = table.insertRow(table.rows.length);
//            var idNb = newRow.insertCell(0);
//            var nameNb = newRow.insertCell(1);
//            var operationsNb = newRow.insertCell(2);
//
//            idNb.innerHTML = result[n][0];
//            nameNb.innerHTML = result[n][1];
//        }
    }
</script>

