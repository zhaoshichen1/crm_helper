/**
 * get 30 day's data from RFN's API and display in the front-office
 * without force update --> Update Frequency is 1 time per day if not demanded by other operations
 */
function set30DaysData(){

    $.ajax({
            url: 'php/Controllers/getData_Monitor_Unsubscription.php',
            method: 'GET',
            data: {
                unsubscribed_all: true
            }
        })
        .done(function (data) {

            /**
             * show the result by changing also the style of the panel to say good or not
             */
            change_subscription_panel_according_to_its_result(data);
        });
}

// update the last 30 days - data
set30DaysData();

var BCZ_data,Customer03_data,debug_Moris_Line;

function get7DaysData(){

    // get BCZ 7 days - data
    $.ajax({
            url: 'php/Controllers/getData_Monitor_Unsubscription.php',
            method: 'GET',
            data: {
                unsubscribed_all: false,
                DataType: "BCZ"
            }
        })
        .done(function (data) {
            BCZ_data = JSON.parse(data);

            // get Customer03 7 days - data
        $.ajax({
                url: 'php/Controllers/getData_Monitor_Unsubscription.php',
                method: 'GET',
                data: {
                    unsubscribed_all: false,
                    DataType: "Customer03"
                }
            })
			
			
            .done(function (data) {
                Customer03_data = JSON.parse(data);
				var data_N = buildUpMorrisArea7Days(BCZ_data,Customer03_data);

                // which means the chart doesn't exist, we need to create it
                if(debug_Moris_Line == null){
                    /**
                     * declare this Morris graph
                     */
                    debug_Moris_Line = Morris.Line({
                        element: 'morris-area-chart',
                        data: data_N,
                        xkey: 'day',
                        ykeys: ['OneID', 'Loyalty', 'Gap'],
                        labels: ['OneID', 'Loyalty', 'Gap'],
                        pointSize: 2,
                        hideHover: 'auto',
                        parseTime:false,
                        resize: true
                    });
                }

                    // otherwise, we will just update its value
                else{
                    debug_Moris_Line.setData(data_N);
                }
            });
        });

}

// set up the graph part of gaps
get7DaysData();

    /**
     * build up the array of data for the graph
     * @param loyalty_result
     * @param customer_result
     * @returns {Array}
     */
    function buildUpMorrisArea7Days(lr,cr){
        var xkeys = 'day';
        var ykeys = ['OneID', 'Loyalty', 'Gap'];
        var labels = ykeys;

        var data = new Array();
    
        /**
         * build up the array of data with the data from Loyalty Result & Customer Result
         */
        for(var i=0;i<lr.length;i++){
            var oneDay = {
                day:lr[i][0],
                OneID:cr[i][1],
                Loyalty:lr[i][1],
                Gap:Math.abs(cr[i][1]-lr[i][1])
            };
            data.push(oneDay);
        }

        for(var i=lr.length;i<7;i++){
            var oneDay = {
                day:'--',
                OneID:0,
                Loyalty:0,
                Gap:0
            };
            data.push(oneDay);
        }

        return data;
    }

