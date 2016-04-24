$(function() {

    /**
     * simulation datas got from API
     * @type {Array}
     */
    var testLoyalty = new Array(new Array("2016-04-17",30000),new Array("2016-04-18",8000),new Array("2016-04-19",24000),
        new Array("2016-04-20",7800),new Array("2016-04-21",20000)
        ,new Array("2016-04-22",82222),new Array("2016-04-23",9333));
    
    var testCustomer = new Array(new Array("2016-04-17",20044),new Array("2016-04-18",18000),new Array("2016-04-19",4000),
        new Array("2016-04-20",7000),new Array("2016-04-21",12000)
        ,new Array("2016-04-22",8222),new Array("2016-04-23",19333));

    /**
     * build up the array of data for the graph
     * @param loyalty_result
     * @param customer_result
     * @returns {Array}
     */
    function buildUpMorrisArea7Days(loyalty_result,customer_result){
        var xkeys = 'day';
        var ykeys = ['OneID', 'Loyalty', 'Gap'];
        var labels = ykeys;
    
        var data = new Array();
    
        /**
         * build up the array of data with the data from Loyalty Result & Customer Result
         */
        for(var i=0;i<loyalty_result.length;i++){
            var oneDay = {
                day:customer_result[i][0],
                OneID:customer_result[i][1],
                Loyalty:loyalty_result[i][1],
                Gap:Math.abs(customer_result[i][1]-loyalty_result[i][1])
            };
            data.push(oneDay);
        }
    
        return data;
    }
    
    var data_n = buildUpMorrisArea7Days(testLoyalty,testCustomer);

    /**
     * declare this Morris graph
     */
    var graph = Morris.Area({
        element: 'morris-area-chart',
        data: data_n,
        xkey: 'day',
        ykeys: ['OneID', 'Loyalty', 'Gap'],
        labels: ['OneID', 'Loyalty', 'Gap'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

});
