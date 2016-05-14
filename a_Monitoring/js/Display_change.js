/**
 * Created by SZHAO on 5/14/2016.
 */

/**
 * change the panel's color according to the result
 * if 0 --> green, checked
 * else --> red, unchecked
 */
function change_subscription_panel_according_to_its_result( data ){

    /**
     * firstly put the value
     */
    document.getElementById("numberThirty").textContent = data;

    var result_gap = data;

    /**
     * which means the result is good, the panel will be green & the icon will be "checked"
     * otherwise the panel will be in red & the icon will be "not corrected"
     */
    if(result_gap == "0"){
        document.getElementById("panel_of_unsubscription").className = "panel panel-green";
        document.getElementById("icon_of_unsubscription").className = "fa fa-check fa-5x";

        // we hide the button of 'fix now' as it's not useful
        document.getElementById("fixnow").style.display = "none";
    }
    else{
        document.getElementById("panel_of_unsubscription").className = "panel panel-red";
        document.getElementById("icon_of_unsubscription").className = "fa fa-close fa-5x";

        // we show the button of 'fix now'
        document.getElementById("fixnow").style.display = "";
    }
}

/**
 * refresh the page by updating the data related to the unsubscription
 */
function refresh_unsubscription_page(){

    // update the data on the top ( panel )
    set30DaysData();

    // update the graph
    get7DaysData();

    // show the refresh of the page has been finished
    setTimeout(function(){
        alertify.success("The Unsubscription Monitoring Data has been refreshed!");
    },1800)
}