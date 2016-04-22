/**
 * Created by SZHAO on 4/8/2016.
 */

Date.prototype.yyyymmdd = function() {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
    var dd  = this.getDate().toString();
    return yyyy +"-"+ (mm[1]?mm:"0"+mm[0]) +"-"+ (dd[1]?dd:"0"+dd[0]); // padding
};

function record_execution(fid) {

    var d = new Date();

    // in format yyyy-mm-dd
    var current_date = d.yyyymmdd();

    $.ajax({
            url: '../php/Controllers/nb_execution_record.php',
            method: 'GET',
            data: {
                func_id: fid,
                current_date: current_date
            }
        })
        .done(function (data) {
            console.log(data);
        });

}



