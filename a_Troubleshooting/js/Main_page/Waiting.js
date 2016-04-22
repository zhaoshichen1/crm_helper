/**
 * Created by SZHAO on 4/9/2016.
 */

/**
 *  ________________________________________________________
 *  Waiting functions
 *  And CSS functions
 */
function waitingdkcard() {
    $("#answer").empty().append('<br/><img src="images/ring.svg" alt="loading" style="width:200px; position: absolute; top: 50px; left: 40%;"/>');
}

function waitingecheckko() {
    $("#answerloyaltyecheckko").empty().append('<br/><img src="../images/squares.svg" alt="loading" style="width:120px; left: 40%;"/>');
}

function waitingDup() {
    $("#answerDup").empty().append('<br/><img src="../images/squares.svg" alt="loading" style="width:120px; left: 40%;"/>');
}

function waitingfindcard() {
    $("#answerfindcardnumber").empty().append('<img src="../images/squares.svg" alt="loading" style="width:80px; left: 40%;"/>');
}

function waitingfidelity() {
    $("#answersubfidelity").empty().append('<img src="../images/squares.svg" alt="loading" style="width:120px; left: 40%;"/>');
}

function waitingtransfer(){
    $("#treat").empty().append('<img src="../images/squares.svg" alt="loading" style="width:120px; left: 40%;"/>');
}

function waitingCompletePurchase(){
    $("#answerCompletePurchase").empty().append('<img src="../images/squares.svg" alt="loading" style="width:120px; left: 40%;"/>');
}