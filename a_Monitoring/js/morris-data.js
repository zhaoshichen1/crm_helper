/**
 * get 30 day's data from RFN's API and display in the front-office
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
            document.getElementById("numberThirty").textContent = data;
            console.log(data);
        });
}

// update the last 30 days - data
set30DaysData();

var BCZ_data,Customer03_data,debug;

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
                    var data_N = (buildUpMorrisArea7Days(BCZ_data,Customer03_data));

                    /**
                     * declare this Morris graph
                     */
                    debug = Morris.Line({
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


