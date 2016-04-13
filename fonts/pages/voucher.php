
<br/>
<div id="loyaltytrigger">
    <div class="row">
        <div class="col-lg-4">
            <div class="loyalcontener" id="triggerEcheck">
                <div class="row" style="margin-top: 25px;">
                    <div class="col-lg-12 demo" style="text-align: center"><h3>E-Check Generation KO ? </h3></div>
                </div>
                <div class="row" style="margin-top: 40px;">
                    <div class="col-lg-2"></div><div class="col-lg-4"><label for="cardNumberEcheckGen" style="font-size: 1.7em">Card No. </label></div><div class="col-lg-4"><input id="cardNumberEcheckGen" class="form-control" type="number" style="text-align: center"></div><div class="col-lg-2"></div>
                </div><hr><br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="answerloyaltyecheckko" style="margin: 0 20px; font-size: 1.5em; text-align: center;"></div>
                    </div>
                </div>
                <hr><br/>
                <div class="row" id="rowReset" style="visibility: hidden;">
                    <div class="col-lg-12">
                        <div id="treat" style="margin: 0 20px; font-size: 1.5em; text-align: center;">
                            <a id="button_treat">Reset to 0</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function hide_reset(){
        document.getElementById("rowReset").style = "visibility:hidden";
    }

    function show_reset(){
        document.getElementById("rowReset").style = "";
    }

</script>