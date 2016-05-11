<style>
                                          .myButton {
                                              background-color:#44c767;
                                              -moz-border-radius:28px;
                                              -webkit-border-radius:28px;
                                              border-radius:28px;
                                              border:1px solid #18ab29;
                                              display:inline-block;
                                              cursor:pointer;
                                              color:#ffffff;
                                              font-family:inherit;
                                              font-size:20px;
                                              padding:5px 30px;
                                              text-decoration:none;
                                              text-shadow:0px 1px 0px #2f6627;
                                              margin-left:38%;
                                              margin-top:5%
                                          }
    .myButton:hover {
        background-color:#5cbf2a;
    }
    .myButton:active {
        position:relative;
        top:1px;
    }

</style>

<div class="col-lg-4">
    <div class="loyalcontener" id="triggerCustomerCheck">
        <div class="row" style="margin-top: 25px;">
            <div class="col-lg-12 demo" style="text-align: center"><h3>Check Customer </h3></div>
        </div>
        <div class="row" style="margin-top: 25px;">
            <div class="col-lg-1"></div>
            <div class="col-lg-2" style="margin-left:19">
                <label for="time_choice" style="font-size: 1.7em">Search Type?</label>
            </div>
            <div class="col-lg-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle btn-lg"
                            data-toggle="dropdown" style="margin-left:60%;margin-top:20%" id="ButtonCheck">
                        Email <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a onclick="click_on_Email()">Email</a></li>
                        <li><a onclick="click_on_Tel()">Telephone</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 40px;" id="emailRow">
            <div class="col-lg-2"></div>
            <div class="col-lg-4" style="padding-left:2px;padding-right:2px;width:32%">
                <label for="emailCheck" style="font-size: 1.7em">Email </label>
            </div>
            <div class="col-lg-4" style="padding-left:2px;padding-right:2px;width:37%">
                <input id="emailCheck" class="form-control" type="email" style="text-align: center;"></div><div class="col-lg-2"></div>
        </div>
        <div class="row" style="margin-top: 40px;display:none" id="telRow">
            <div class="col-lg-2"></div>
            <div class="col-lg-4" style="padding-left:2px;padding-right:2px;width:32%">
                <label for="telCheck" style="font-size: 1.7em">Tel No. </label>
            </div>
            <div class="col-lg-4" style="padding-left:2px;padding-right:2px;width:37%">
                <input id="telCheck" class="form-control" type="number" style="text-align: center;"></div><div class="col-lg-2"></div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div id="answerCheck" style="margin: 0 20px; font-size: 1.5em; text-align: center;">
                </div>
            </div>
        </div>
    </div>
</div>

<!--
<br/>
<div id="duplicatatedPhoneCheck">
    <div class="row">
        <div class="col-lg-4">
            <div class="loyalcontener">
                <div id="triggerdup">
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-lg-12 demo" style="text-align: center"><h3>Check Duplication</h3></div>
                    </div>
                    <a href="#" class="myButton" id="myButton">Run</a>
                    <hr><br/>
                    <div class="row">
                        <div class="col-lg-12"><div id="answerDup" style="margin: 0 20px; font-size: 2.2em; text-align: center; font-weight: 800"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
