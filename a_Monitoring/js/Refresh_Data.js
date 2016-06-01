/**
 * Created by SZHAO on 5/14/2016.
 */

/**
 * it's called when User really wants to update the data of the total gap ( normally it's updated once per day )
 * we should also notify our user the risk, so alertify is used in this part
 */
function forceUpdate(){

    // alert the risk
    alertify.confirm("The subscription data is updated once per day, do you really need to force udpate it now ??",
        function(){

            // we tell the user to be patient
            // after user clicks at "ok", we launch the action and the progress bar
            alertify.alert("The Refresh process may take 1 minute, please be patient.", function(){

                // during the operation of force Update, we disable the possibility of re-asking another trial of force update
                document.getElementById("forceupdate").onclick = function(){
                    alertify.error("The operation is in progress !");
                };

                // progress begin to run, normally it will run 60s
                progressBarRunning("progress_bar_force_update",60);

                // launch the action to force update the data in MySQL
                $.ajax({
                    url: 'php/Controllers/getData_Monitor_Unsubscription.php',
                    method: "GET",
                    data: {
                        unsubscribed_all: true,
                        force_update:'true'
                    }
                }).done(

                    // when the action is done, we close the progress bar
                    // and refresh the page data
                    function(){

                        // we show the progress is finished, and make the bar disappear
                        set_bar_progress("progress_bar_force_update",100);

                        alertify.message("Refresh finished successfully. Updating the display .. ");

                        // refresh the data shown on the page
                        refresh_unsubscription_page();

                        // enable the force refresh trial
                        document.getElementById("forceupdate").onclick = function(){
                            forceUpdate();
                        }
                    }
                )
            })
        },
        function(){
            // do nothing when user selects 'cancel'
        });
}

/**
 *
 * @param id_bar
 * @param time_in_seconds
 */
function progressBarRunning(id_bar,time_in_seconds){

    // call it out / display it
    var bar = document.getElementById(id_bar);
    bar.style.display = "";

    // start from 1 %
    var current_step = 1;
    set_bar_progress(id_bar,current_step);

    // calculate our step value per second
    var step = 98/time_in_seconds;

    // check each 1 second
    for(var i = 0;i<time_in_seconds;i++){

        // some random step to make the progress more real
        var random_step = Math.random()*step;
        setTimeout( "set_bar_progress(\""+id_bar+"\","+(1+step*i+random_step)+")"
                ,1000*i);
    }

}

/**
 *
 * @param id_bar
 * @param progress
 */
function set_bar_progress(id_bar,progress){

    var bar = document.getElementById(id_bar);
    bar.childNodes[1].childNodes[1].style.width = progress+"%";

    // when it's 100, we make it disappear in 1 seconds
    if(progress == 100){
        setTimeout(function(){
            bar.style.display = "none";
        },1000)
    }
}