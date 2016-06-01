/**
 * Created by SZHAO on 5/14/2016.
 */


const password_massive_subscription = 'Decathlon_DKT'

/**
 * launch massive repair of loyalty subscription by calling API of recovery_subscription
 *
 * FUNC_ID = ?
 */
function recoverSubscription() {

    /**
     * we ask the user the password to carry out this operation as there may have some risk
     */
    alertify.prompt("Please enter the password for the operation", "Default value",
        function(evt, value ){
            if( value == password_massive_subscription ){

                // when the ip is well noted thanks to external API, we record the operator's IP in the base
                if( myip !=null){
                    $.ajax({
                            url: 'php/Controllers/getData_Monitor_Unsubscription.php',
                            method: "GET",
                            data: {
                                please_note_IP: myip
                            }
                        })
                        .done(function () {});
                }

                alertify.alert('The operation will last around 3 minutes, please be patient.');

                // Disable the button during the repair
                document.getElementById("fixnow").onclick = function(){
                    alertify.error("The operation is in progress !");
                };

                // We begin the operator by calling out our progress bar
                progressBarRunning("progress_bar_recovery",180);

                // Call the API for the recovery and asking for a force update before the operation
                $.ajax({
                        url: 'php/Controllers/getData_Monitor_Unsubscription.php',
                        method: "GET",
                        data: {
                            unsubscribed_all: false,
                            force_update:'true',
                            DataType: 'Recovery'
                        }
                    })
                    .done(function () {

                        console.log("Recovery done");

                        //Force update after repair
                        $.ajax({
                                url: 'php/Controllers/getData_Monitor_Unsubscription.php',
                                method: "GET",
                                data: {
                                    unsubscribed_all: true,
                                    force_update:'true'
                                }
                            })
                            .done(function () {

                                set_bar_progress("progress_bar_recovery",100);

                                alertify.message("Operation finished successfully. Updating the display .. ");

                                refresh_unsubscription_page();

                                // enable the button again
                                document.getElementById("fixnow").onclick = function(){
                                    recoverSubscription();
                                };
                            });
                    });
            }
            else{
                alertify.error("Authentication failed");
            }
        },
        function(){
            alertify.message('Authentication cancelled');
        })
    ;
}
