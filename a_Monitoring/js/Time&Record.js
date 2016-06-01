/**
 * Created by SZHAO on 4/9/2016.
 */

/**
 *  ________________________________________________________
 *  Time & Date functions
 */

/**
 *  ________________________________________________________
 *  Date functions
 */
//$("#fromFindCard").datepicker().datepicker("option", "dateFormat", "yy-mm-dd");
//$("#toFindCard").datepicker().datepicker("option", "dateFormat", "yy-mm-dd");
//$("#PurchasefromFindCard").datepicker().datepicker("option", "dateFormat", "yy-mm-dd");
//$("#PurchasetoFindCard").datepicker().datepicker("option", "dateFormat", "yy-mm-dd");

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
