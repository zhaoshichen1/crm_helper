<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{font-family:Arial, sans-serif;font-size:12px;padding:2px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:2px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg .tg-s6z2{text-align:center}
    .tg .tg-baqh{text-align:center;vertical-align:top}
    .tg .tg-yw4l{vertical-align:top}
    .tg .tg-yw4l-2{vertical-align:top;width:25%}
    .tg .tg-yw4l-7{vertical-align:top;width:25%}

    #answerTransfer {
        margin: 0 3px;
    }
</style>

<br/>
<div id="loyaltytrigger">
    <div class="row">
        <div class="col-lg-4">
            <div class="loyalcontener" id="triggerFindCard">
                <div class="row" style="margin-top: 25px;">
                    <div class="col-lg-12 demo" style="text-align: center"><h3>Which card was used ? </h3></div>
                </div>
                <div class="row" style="margin-top: 25px;">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2">
                        <label for="fromFindCard" style="font-size: 1.7em">From:</label>
                    </div>
                    <div class="col-lg-3">
                        <input id="fromFindCard" class="form-control" type="text" style="text-align: center">
                    </div>
                    <div class="col-lg-2">
                        <label for="toFindCard" style="font-size: 1.7em">To:</label>
                    </div>
                    <div class="col-lg-3">
                        <input id="toFindCard" class="form-control" type="text" style="text-align: center">
                    </div>
                    <div class="col-lg-1"></div>
                </div>
                <div class="row" style="margin-top: 25px;">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-5">
                        <label for="storeNumFindCard" style="font-size: 1.7em">Store N°</label>
                    </div>
                    <div class="col-lg-3">
                        <input id="storeNumFindCard" class="form-control" type="text" style="text-align: center">
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="row" style="margin-top: 25px;">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-5">
                        <label for="tillNumberFindCard" style="font-size: 1.7em">Till N°</label>
                    </div>
                    <div class="col-lg-3">
                        <input id="tillNumberFindCard" class="form-control" type="text" style="text-align: center">
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="row" style="margin-top: 25px;">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-5">
                        <label for="transNumberFindCard" style="font-size: 1.7em">Trans N°</label>
                    </div>
                    <div class="col-lg-3">
                        <input id="transNumberFindCard" class="form-control" type="text" style="text-align: center">
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-12"><div id="answerfindcardnumber" style="margin: 0 20px; font-size: 2.2em; text-align: center;color: #6C7A89;font-weight: 700"></div></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="loyalcontener" id="triggerTransfer">
                <div class="row" style="margin-top: 25px;">
                    <div class="col-lg-12 demo" style="text-align: center"><h3>Transferred to where? </h3></div>
                </div>
                <div class="row" style="margin-top: 40px;">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4">
                        <label for="cardTransfer" style="font-size: 1.7em">Card No. </label>
                    </div>
                    <div class="col-lg-4">
                        <input id="cardTransfer" class="form-control" type="number" style="text-align: center"></div><div class="col-lg-2"></div>
                </div><hr><br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="answerTransfer" style="margin: 0 20px; font-size: 1.5em; text-align: center;">
                            <table class="tg" id="displayTransfer" style="visibility: hidden">
                                <tr>
                                    <th class="tg-s6z2"></th>
                                    <th class="tg-yw4l-2">Date</th>
                                    <th class="tg-yw4l">Store</th>
                                    <th class="tg-yw4l">Till</th>
                                    <th class="tg-yw4l">No</th>
                                    <th class="tg-yw4l">$</th>
                                    <th class="tg-yw4l-7">Dest</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <hr><br/>
                <div class="row" id="rowReset">
                    <div class="col-lg-12">
                        <div id="treat" style="margin: 0 20px; font-size: 1.5em; text-align: center;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
