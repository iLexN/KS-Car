<?php

include('lib/checkip.php');

session_start();
if ( !isset($_SESSION['login']) && !$_SESSION['login']) {
      header('Location: login.php');
  }

include('db/db_info.php');
include('model/occ.php');
include('model/car.php');
include('model/rule.php');
include('model/details-info.php');
include('model/sub-plans.php');
include('model/calTotalPrice.php');

//get data

$rule = new Rule;
$rule_ar = $rule->getAll();

$car = new Car;
$make_ar = $car->getAllMake();
$ncd = $car->getNCD();
$insuranceType = $car->getInsuranceType(1);
$driveExp = $car->getDriveExp(1);

$occ = new Occ;
$occupation_ar = $occ->getAll();

$detailsInfo = new DetailsInfo;
$detailsInfo_ar = $detailsInfo->getAll();

//output
?>
<!DOCTYPE html>
<html class="no-js">
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <style>

body{
    background-color: #E0ECF1;
    font-size:12px;
}
fieldset{border:1px solid #999;padding:5px}

.row{margin:20px 10px;border-bottom:1px solid #ccc;padding-bottom:20px;}

.c0{float:left;width:3%}
.c1-1{float:left;width:16%}
.c1{float:left;width:8%}
.c2{float:left;width:7%}
.c3{float:left;width:8%}
.c4{float:left;width:8%}
.c5{float:left;width:7%}
.c6{float:left;width:7%}
.c7{float:left;width:11%}
.c8{float:left;width:9%}
.c9{float:left;width:9%}
.c10{float:left;width:8%}

.jsListMM li {float:left;width:25%;margin:0px 0 20px 0;}
.jsListMM li span{color:red;cursor:pointer;padding:0 15px;font-size:14px;}

.jsListOcc li {float:left;width:33%;margin:0px 0 20px 0;}
.jsListOcc li span{color:red;cursor:pointer;padding:0 15px;font-size:14px;}

.jsListDetails li {float:left;width:48%;margin:0px 0 20px 0;}
.jsListDetails li span{color:red;cursor:pointer;padding:0 15px;font-size:14px;}

input[type=text]{width:80%;border:1px solid #ccc;}
input[type=password]{width:80%;border:1px solid #ccc;}

.js-row:last-child{border:none;}

.dim-layer{position:fixed;top:0;left:0;width:100%;height:100%;z-index:200;background-color:#000;opacity:0.7; filter: alpha(opacity=70);display:none}
/*fieldset{min-width:980px;}*/

.detailsValueInput{width:100px !important;}

.rightSlidePanel{background-color:#CCCCCC;position:fixed;height:100%;right:0px;top:0px;padding:15px;display:none;min-width: 220px; }
.rightSlidePanel legend{font-weight:bold;font-size:16px;}
.rightSlidePanel textarea{width:90%;height:130px;}

.subPlansCol1{width:10%;float:left;padding:5px;}
.subPlansCol1-2{width:10%;float:left;padding:5px;}
.subPlansCol2{width:10%;float:left;padding:5px;}
.subPlansCol3{width:9%;float:left;padding:5px;}
.subPlansCol4{width:15%;float:left;padding:5px;}
.subPlansCol5{width:15%;float:left;padding:5px;}
.subPlansCol6{width:9%;float:left;padding:5px;}
.subPlansCol7{width:4%;float:left;padding:5px;}

.subplansPanelSubdiv{width:300px;float:left;}

pre{
    margin:0;
    font-family: arial
}</style>
</head>
<body style="margin-top:10px;position:relative">
    <div style="min-width:980px;">
        <div class="clearfix" style="margin-bottom:10px;">
            <button class="jsLogOutBtn">Logout</button>
            <button class="jsNewVersion">New Version</button>
            <button class="jsShowTestRuleBtn">Test Rule</button>
            ---
            <button class="jsNewRuleBtn">Create News Rule</button>
            <button class="jsDupRuleBtn">Duplicate Rule</button>
            <button class="jsInactiveRuleBtn" data-showhide="show">Show InActive Rule</button>
            ---
            <button class="jsCarPanelBtn">Car Panel</button>
            <button class="jsOccPanelBtn">Occupation Panel</button>
            <button class="jsDetailsPanelBtn">Details Info Panel</button>
            <button class="jsSupPlanPanelBtn">SubPlans Panel</button>
        </div>
    </div>
    <?php include('chunk/slide-panel.php');?>

    <div style="clear:both"></div>

    <div style="height:20px;"></div>
    <fieldset class="jsRuleC" style="min-width:980px;">
        <legend>Rule</legend>
        <div class="row">
            <div class="c0">&nbsp;</div>
            <div class="c1-1">Rule</div>
            <div class="c4">Age</div>
            <div class="c7">DrivingExp</div>
            <div class="c8">Insurance</div>
            <div class="c9">Year of Mfg.</div>
            <div class="c5"></div>
            <div class="clearfix"></div>
        </div>
        <?php foreach ( $rule_ar as $r => $r_ar ){ ?>
        <div id="r_<?php echo($r);?>" class="row js-row">
            <div class="c0"><input type="radio" name="selectRule" class="selectRule" value="<?php echo($r);?>"></div>
            <div class="c1-1">
                <input type="text" value="<?php echo ($r_ar['rule_name']);?>" class="jsRuleName">
            </div>
            <div class="c4"><input type="text" value="<?php echo ($r_ar['age_from']);?>" class="jsAgeFrom" style="width:20px;">-<input type="text" value="<?php echo ($r_ar['age_to']);?>" class="jsAgeTo" style="width:20px;"></div>
            <div class="c7"><select class="jsDrivingExp">

                    <?php foreach ( $driveExp as $k=>$v ) {?>
                    <option value="<?php echo $k?>" <?php if ( $r_ar['DrivingExp'] == $k ){echo('selected="selected"');}  ?> ><?php echo $v?></option>
                    <?php } ?>

                </select></div>
            <div class="c8"><select class="jsInsurance" style="width:80%" >
                    <?php foreach ( $insuranceType as $k=>$v ) {?>
                    <option value="<?php echo $k?>" <?php if ( $r_ar['TypeofInsurance'] == $k ){echo('selected="selected"');}  ?> ><?php echo $v?></option>
                    <?php } ?>
                </select></div>
            <div class="c9"><input type="text" value="<?php echo ($r_ar['Yearofmanufacture_from']);?>" class="jsYearofmanufactureFrom" style="width:20px;">- <input type="text" value="<?php echo ($r_ar['Yearofmanufacture']);?>" class="jsYearofmanufacture" style="width:20px;"> yr</div>
            <!--<div class="c10">
            </div>-->
            <div class="c5"><button class="jsUpdatePrice">Update</button></div>
            <div class="c5"><button class="jsRuleDelete">Delete</button></div>
            <div class="clearfix"></div>
            <div class="jsThird_Party_OnlyDiv">
                <fieldset style="margin:10px 15px">
                    <legend>Calculation</legend>
                    <div style="float:left;margin:10px 15px;">
                        <b>Premium</b>
                        <input type="text" value="<?php echo ($r_ar['premium']);?>" class="jsPremium" style="width:65px;">
                    </div>
                    <div style="float:left;margin:10px 15px;">
                        <b>Loading</b>
                        <input type="text" value="<?php echo ($r_ar['loading']);?>" class="jsLoading" style="width:65px;">%
                    </div>
                    <div style="float:left;margin:10px 15px;">
                        <b>Other Discount %</b>
                        <input type="text" value="<?php echo ($r_ar['otherDiscount']);?>" class="jsOtherDiscount" style="width:65px;">%
                    </div>
                    <div style="float:left;margin:10px 15px;">
                        <b>Client Discount %</b>
                        <input type="text" value="<?php echo ($r_ar['clientDiscount']);?>" class="jsClientDiscount" style="width:65px;">%
                    </div>
                    <div style="float:left;margin:10px 15px;">
                        <b>MIB %</b>
                        <input type="text" value="<?php echo ($r_ar['mib']);?>" class="jsMib" style="width:65px;">%
                    </div>
                    <div style="float:left;margin:10px 15px;">
                        <b>commission</b>
                        <input type="text" value="<?php echo ($r_ar['commission']);?>" class="jsCommission" style="width:65px;">%
                    </div>
                    <div style="float:left;margin:10px 15px;">
                        <b>A2</b>
                        <input type="text" value="<?php echo ($r_ar['a2']);?>" class="jsA2" style="width:65px;">%
                    </div>
                    <div style="float:left;margin:10px 15px;">
                        <b>A3</b>
                        <input type="text" value="<?php echo ($r_ar['a3']);?>" class="jsA3" style="width:65px;">
                    </div>
                </fieldset>
            </div>
            <div class="clearfix"></div>
            <div style="float:left;margin:10px 15px; height: 50px">
                <fieldset>
                    <legend>Make/Model</legend>
                    <button class="jsShowMM">Show</button><button class="jsHideMM">Hide</button>
                </fieldset>
            </div>
            <div style="float:left;margin:10px 15px; height: 50px">
                <fieldset>
                    <legend>Occupation</legend>
                    <button class="jsShowOcc">Show</button><button class="jsHideOcc">Hide</button>
                </fieldset>
            </div>
            <div style="float:left;margin:10px 15px; height: 50px">
                <fieldset>
                    <legend>Details</legend>
                    <button class="jsShowDetails">Show</button><button class="jsHideDetails">Hide</button>
                </fieldset>
            </div>
            <div style="float:left;margin:10px 15px; height: 50px">
                <fieldset>
                    <legend>SubPlans</legend>
                    <button class="jsShowSubPlans">Show</button><button class="jsHideSubPlans">Hide</button>
                </fieldset>
            </div>
            <div style="float:left;margin:10px 15px; height: 50px">
                <fieldset>
                    <legend>motor_accident_yrs</legend>
                    <input type="radio" class="jsMotorAccidentYrs" name="motor_accident_yrs_<?php echo($r);?>" value="1" <?php if ( $r_ar['motor_accident_yrs'] == 1 ) echo('checked="checked"'); ?>  > Yes
                           &nbsp;&nbsp;&nbsp;&nbsp;
                           <input type="radio" class="jsMotorAccidentYrs" name="motor_accident_yrs_<?php echo($r);?>" value="0" <?php if ( $r_ar['motor_accident_yrs'] == 0 ) echo('checked="checked"'); ?>> No
                </fieldset>
            </div>
            <div style="float:left;margin:10px 15px; height: 50px">
                <fieldset>
                    <legend>drive_offence_point</legend>
                    <input type="radio" class="jsDriveOffencePoint" name="drive_offence_point<?php echo($r);?>" value="1" <?php if ( $r_ar['drive_offence_point'] == 1 ) echo('checked="checked"'); ?>> Yes
                           &nbsp;&nbsp;&nbsp;&nbsp;
                           <input type="radio" class="jsDriveOffencePoint" name="drive_offence_point<?php echo($r);?>" value="0" <?php if ( $r_ar['drive_offence_point'] == 0 ) echo('checked="checked"'); ?>> No
                </fieldset>
            </div>
            <div style="float:left;margin:10px 15px; height: 50px">
                <fieldset>
                    <legend>Active</legend>
                    <input type="radio" class="jsActive" name="active<?php echo($r);?>" value="1" <?php if ( $r_ar['active'] == 1 ) echo('checked="checked"'); ?>> Yes
                           &nbsp;&nbsp;&nbsp;&nbsp;
                           <input type="radio" class="jsActive" name="active<?php echo($r);?>" value="0" <?php if ( $r_ar['active'] == 0 ) echo('checked="checked"'); ?>> No
                </fieldset>
            </div>
            <div style="float:left;margin:10px 15px; height: 50px">
                <fieldset>
                    <legend>NCD price add</legend>
                    <button class="jsShowNCD">Show</button><button class="jsHideNCD">Hide</button>
                </fieldset>
            </div>

            <div class="clearfix"></div>
            <div class="jsListOcc"></div>
            <!--<div class="clearfix"></div>-->
            <div class="jsListMM"></div>
            <div class="jsListDetails"></div>
            <div class="jsListNcd" style="display:none">
                <?php if ( empty($r_ar['ncd_rule'])) { ?>
                    <button class="jsCreateNCD">Create</button>
                <?php } else { ?>

                    <form class="jsNcdForm">
                        <table border="1" cellspacing="5" cellpadding="3">
                            <tr>
                                <td>ncd</td>
                                <td>active</td>
                                <td>price add</td>
                                <td>Gross</td>
                                <td>MIB</td>
                                <td>Net w Tax</td>
                                <td>Offer</td>
                                <td><button class="jsUpadeNCD">Update</button></td>
                            </tr>
                            <?php $calTotalPriceArray = array('gross'=>'','mibValue'=>'','price'=>'','total_price'=>'');
                                foreach ( $r_ar['ncd_rule'] as $v=>$b ) {
                                if ( $r_ar['TypeofInsurance'] == 'Third_Party_Only' ) {
                                    $calTotalPriceObj = new CalTotalPrice($r_ar);
                                    $calTotalPriceArray = $calTotalPriceObj->calPrice($b['ncd'],$b['price_add'],$r_ar['TypeofInsurance']);
                                }
                                ?>
                            <tr>
                                <td><?php echo ($b['ncd']);?></td>
                                <td>
                                    <input type="radio" name="ruleNcd[<?php echo($b['id']);?>][active]" value="1" <?php if ( $b['active'] == 1 ) echo('checked="checked"'); ?>> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="ruleNcd[<?php echo($b['id']);?>][active]" value="0" <?php if ( $b['active'] == 0 ) echo('checked="checked"'); ?>> No
                                </td>
                                <td><input type="text" name="ruleNcd[<?php echo($b['id']);?>][price_add]" value="<?php echo($b['price_add']);?>"></td>
                                <td><?php echo ($calTotalPriceArray['gross']);?></td>
                                <td><?php echo ($calTotalPriceArray['mibValue']);?></td>
                                <td><?php echo ($calTotalPriceArray['price']);?></td>
                                <td><?php echo ($calTotalPriceArray['total_price']);?></td>
                            </tr>
                            <?php } unset($calTotalPriceObj);?>
                        </table>
                    </form>


                <?php } ?>
            </div>
            <div class="jsListSubPlans" style="display:none">
                <div style=" overflow: hidden;padding:10px;border-bottom:1px solid #ccc">
                    <div class="subPlansCol1">SubPlansName</div>
                    <div class="subPlansCol1-2">SubPlansNameZh</div>
                    <div class="subPlansCol2">Additional Price</div>
                    <div class="subPlansCol3">GroupID</div>
                    <div class="subPlansCol4">EN Free Text</div>
                    <div class="subPlansCol5">ZH Free Text</div>
                </div>
                <?php foreach ( $r_ar['subPlans'] as $subPlansAr ) {?>
                <div style=" overflow: hidden;padding:10px;border-bottom: 1px solid #ccc" class="jsSubPlansWapper">
                    <div class="jsSubPlansSortOrder" style="display:inline;font-weight:bold;float: left;padding:5px"><?php echo($subPlansAr['sortOrder']);?></div>
                    <div class="subPlansCol1"><span class="jsSubPlansNameValue"><?php echo ($subPlansAr['name']);?></span> - <span class="jsSubPlansNameSubValue"><?php echo ($subPlansAr['name_sub']);?></span></div>
                    <div class="subPlansCol1-2"><span class="jsSubPlansNameZhValue"><?php echo ($subPlansAr['name_zh']);?></span> - <span class="jsSubPlansNameSubZhValue"><?php echo ($subPlansAr['name_sub_zh']);?></span></div>
                    <div class="subPlansCol2 jsSubPlansAddPriceValue"><?php echo ($subPlansAr['add_price']);?></div>
                    <div class="subPlansCol3 jsSubPlansGroupIDValue"><?php echo ($subPlansAr['groupID']);?></div>
                    <div class="subPlansCol4"><pre class="jsSubPlansEnValue"><?php echo ( $subPlansAr['en'] );?></pre></div>
                    <div class="subPlansCol5"><pre class="jsSubPlansZhValue"><?php echo ( $subPlansAr['zh'] );?></pre></div>
                    <div class="subPlansCol6">
                            <?php if ( !empty($subPlansAr['pdf_url_en']) ) {  ?>
                            <a href="<?php echo ( $subPlansAr['pdf_url_en'] );?>" target="_blank" class="jsSubPlansPdfValueEn">PDF(En)</a>
                            <?php } ?>
                            <br/>
                            <?php if ( !empty($subPlansAr['pdf_url_zh']) ) {  ?>
                            <a href="<?php echo ( $subPlansAr['pdf_url_zh'] );?>" target="_blank" class="jsSubPlansPdfValueZh">PDF(Zh)</a>
                            <?php } ?>
                    </div>
                    <div class="subPlansCol6">
                        <button data-spid="<?php echo( $subPlansAr['id'] );?>" class="jsSubPlansLoadBtn">Load for Update</button>
                    </div>
                    <div class="subPlansCol7">
                        <button data-spid="<?php echo( $subPlansAr['id'] );?>" class="jsSubPlansDelBtn">Delete</button>
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php } ?>
    </fieldset>

    <?php include 'chunk/test-rule.php';?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        jQuery.fn.center = function() {
            this.css('position', 'absolute');
            this.css('top', ($(window).height() - this.height()) / 2 + $(window).scrollTop() + 'px');
            this.css('left', ($(window).width() - this.width()) / 2 + $(window).scrollLeft() + 'px');
            return this;
        };

        $(".jsTestRule").center();

        $(".js-row").each(function() {
            var id = $(this).find('.selectRule').val();
            var $RuleName = $(this).find('.jsRuleName');
            var $Price = $(this).find('.jsPrice');
            var $PriceAdd = $(this).find('.jsPriceAdd');
            var $AgeFrom = $(this).find('.jsAgeFrom');
            var $AgeTo = $(this).find('.jsAgeTo');
            var $NCD = $(this).find('.jsNCD');
            var $DrivingExp = $(this).find('.jsDrivingExp');
            var $Insurance = $(this).find('.jsInsurance');
            var $Yearofmanufacture = $(this).find('.jsYearofmanufacture');
            var $YearofmanufactureFrom = $(this).find('.jsYearofmanufactureFrom');
            var $Total = $(this).find('.jsTotal');

            var $ShowMM = $(this).find('.jsShowMM');
            var $HideMM = $(this).find('.jsHideMM');
            var $ShowOcc = $(this).find('.jsShowOcc');
            var $HideOcc = $(this).find('.jsHideOcc');
            var $ShowDetails = $(this).find('.jsShowDetails');
            var $HideDetails = $(this).find('.jsHideDetails');
            var $ShowSubPlans = $(this).find('.jsShowSubPlans');
            var $HideSubPlans = $(this).find('.jsHideSubPlans');

            var $ShowNCD = $(this).find('.jsShowNCD');
            var $HideNCD = $(this).find('.jsHideNCD');
            var $CreateNCD = $(this).find('.jsCreateNCD');
            var $UpadeNCD = $(this).find('.jsUpadeNCD');

            var $UpdatePrice = $(this).find('.jsUpdatePrice');
            var $DeleteRule = $(this).find('.jsRuleDelete');
            var $ListMM = $(this).find('.jsListMM');
            var $ListOcc = $(this).find('.jsListOcc');
            var $ListDetails = $(this).find('.jsListDetails');
            var $ListSubPlans = $(this).find('.jsListSubPlans');
            var $ListNcd = $(this).find('.jsListNcd');
            var $NcdForm = $(this).find('.jsNcdForm');
            //var $UpdateDetailsBtn = $(this).find('.jsUpdateDetailsBtn');
            //var $DetialsTextarea = $(this).find('.jsDetialsTextarea');

            var $Premium = $(this).find('.jsPremium');
            var $Loading = $(this).find('.jsLoading');
            var $otherDiscount = $(this).find('.jsOtherDiscount');
            var $clientDiscount = $(this).find('.jsClientDiscount');
            var $mib = $(this).find('.jsMib');
            var $commission = $(this).find('.jsCommission');
            var $a2 = $(this).find('.jsA2');
            var $a3 = $(this).find('.jsA3');

            $UpdatePrice.click(function() {
                //updateTotalPrice();
                var request = $.ajax({
                    url: "ajax/price-change.php",
                    type: "POST",
                    data: {ruleName: $RuleName.val(),
                        age_from: $AgeFrom.val(),
                        age_to: $AgeTo.val(),
                        NCD: $NCD.val(),
                        DrivingExp: $DrivingExp.val(),
                        TypeofInsurance: $Insurance.val(),
                        Yearofmanufacture: $Yearofmanufacture.val(),
                        Yearofmanufacture_from: $YearofmanufactureFrom.val(),
                        DriveOffencePoint: $("input:radio[name=drive_offence_point" + id + "]:checked").val(),
                        MotorAccidentYrs: $("input:radio[name=motor_accident_yrs_" + id + "]:checked").val(),
                        Active: $("input:radio[name=active" + id + "]:checked").val(),

                        premium: $Premium.val(),
                        loading: $Loading.val(),
                        otherDiscount: $otherDiscount.val(),
                        clientDiscount: $clientDiscount.val(),
                        mib: $mib.val(),
                        commission: $commission.val(),
                        a2: $a2.val(),
                        a3: $a3.val(),

                        id: id
                    }
                });
                request.done(function(msg) {
                    alert(msg);
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });
            $DeleteRule.click(function() {
                var request = $.ajax({
                    url: "ajax/rule-delete.php",
                    type: "POST",
                    data: {
                        id: id
                    }
                });
                request.done(function(msg) {
                    //alert(msg);
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });

            $CreateNCD.click(function() {
                var request = $.ajax({
                    url: "ajax/rule-ncd-create.php",
                    type: "POST",
                    data: {
                        id: id
                    }
                });
                request.done(function(msg) {
                    //alert(msg);
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });
            $UpadeNCD.click(function(e) {
                e.preventDefault();
                var request = $.ajax({
                    url: "ajax/rule-ncd-update.php",
                    type: "POST",
                    data: $NcdForm.serialize()
                });
                request.done(function(msg) {
                    //alert(msg);
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });


            $ShowMM.click(function() {
                $HideOcc.click();
                $HideDetails.click();
                showMM(id);
                $ListSubPlans.hide();
                $HideNCD.click();
            });
            $HideMM.click(function() {
                $ListMM.hide();
            });

            $ShowOcc.click(function() {
                $HideMM.click();
                $HideDetails.click();
                showOcc(id);
                $ListSubPlans.hide();
                $HideNCD.click();
            });
            $HideOcc.click(function() {
                $ListOcc.hide();
            });
            $ShowDetails.click(function() {
                $HideMM.click();
                $HideOcc.click();
                showDeIn(id);
                $ListSubPlans.hide();
                $HideNCD.click();
            });
            $HideDetails.click(function() {
                $ListDetails.hide();
            });
            $ShowSubPlans.click(function() {
                $HideMM.click();
                $HideOcc.click();
                $ListSubPlans.show();
                $HideDetails.click();
                $HideNCD.click();
            });
            $HideSubPlans.click(function() {
                $ListSubPlans.hide();
            });
            $ShowNCD.click(function() {
                $HideMM.click();
                $HideOcc.click();
                $HideSubPlans.click();
                $HideDetails.click();
                $ListNcd.show();
            });
            $HideNCD.click(function() {
                $ListNcd.hide();
            });

            $ListMM.on("click", 'span', function() {
                var mID = $(this).data('mid');
                var $removeMM = $(this).parent();
                var request = $.ajax({
                    url: "ajax/rule-update.php",
                    type: "POST",
                    data: {mID: mID}
                });
                request.done(function(msg) {
                    if (msg !== '1') {
                        alert('something wrong, deleted ' + msg);
                    }
                    //showMM(id);
                    $removeMM.remove();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });
            $ListMM.on("click", 'div', function() {
                var mID = $(this).data('mli');
                $(this).parent().find('li').hide();
                $(this).parent().find('.Mli'+mID).show();
            });
            $ListOcc.on("click", 'span', function() {
                var oID = $(this).data('oid');
                var request = $.ajax({
                    url: "ajax/rule-occ-update.php",
                    type: "POST",
                    data: {oID: oID}
                });
                request.done(function(msg) {
                    if (msg !== '1') {
                        alert('something wrong, deleted ' + msg);
                    }
                    showOcc(id);
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });
            $ListDetails.on("click", 'span', function() {
                var oID = $(this).data('oid');
                var request = $.ajax({
                    url: "ajax/rule-details-info-update.php",
                    type: "POST",
                    data: {oID: oID,
                        type: 'remove'
                    }
                });
                request.done(function(msg) {
                    if (msg !== '1') {
                        alert('something wrong, deleted ' + msg);
                    }
                    showDeIn(id);
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });
            $ListDetails.on("input", '.detailsValueInput', function() {
                var oID = $(this).data('oid');
                var request = $.ajax({
                    url: "ajax/rule-details-info-update.php",
                    type: "POST",
                    data: {oID: oID,
                        type: 'update',
                        value: $(this).val()
                    }
                });
                request.done(function(msg) {
                    if (msg !== '1') {
                        alert('something wrong, deleted ' + msg);
                    }
                    //showDeIn(id);
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });

            $Insurance.change(function(){
                var instype = $(this).val();
                if ( instype == 'Third_Party_Only') {
                    $a2.val('').prop( 'disabled' , true );
                    $a3.val('').prop( 'disabled' , true );
                    $Premium.prop( 'disabled' , false );
                } else {
                    $a2.prop( 'disabled' , false );
                    $a3.prop( 'disabled' , false );
                    $Premium.val('').prop( 'disabled' , true );
                }
            });
            $Insurance.change();

        }); // end .js-row loop

        /// add make/model
        var $MakeList = $(".jsMakeList");
        var $ModelList = $(".jsModelList");
        $MakeList.change(function() {
            var mID = $(this).val();
            var request = $.ajax({
                url: "ajax/model-list.php",
                type: "GET",
                data: {mID: mID},
                dataType: "json",
                cache: false
            });
            request.done(function(msg) {
                var items = [];
                items.push("<option value=''>Select</option>");
                $.each(msg, function(key, val) {
                    items.push("<option value='" + val.id + "'>" + val.model + "</option>");
                });
                $ModelList.find('option').remove().end().append(items.join("")).show();

            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });

        $(".jsDelMake").click(function(){
            var r = confirm("Are you sure to Del ? It will also clear the moeld list and selected rule make/model data");
            if (r == true) {
                if ($MakeList.val() === null) {
                    alert("select Make");
                } else {
                        var request = $.ajax({
                            url: "ajax/make-del.php",
                            type: "POST",
                            data: {
                                make: $MakeList.val()
                            }
                        });
                    request.done(function(msg) {
                        if (msg !== '') {
                            alert(msg);
                        }
                        location.reload();
                    });
                    request.fail(function(jqXHR, textStatus) {
                        alert("Request failed: " + textStatus);
                    });
                }
            } else {

            }
        });

        $(".jsDelModel").click(function(){
            var r = confirm("Are you sure to Del ? It will also clear the selected rule model data");
            if (r == true) {
                if ($ModelList.val() === null) {
                    alert("select model");
                } else {
                    var request = $.ajax({
                        url: "ajax/model-del.php",
                        type: "POST",
                        data: {
                            model: $ModelList.val()
                        }
                    });
                    request.done(function(msg) {
                        if (msg !== '') {
                            alert(msg);
                        }
                        $MakeList.eq(0).change();
                    });
                    request.fail(function(jqXHR, textStatus) {
                        alert("Request failed: " + textStatus);
                    });
                }
            } else {

            }
        });

        $(".jsAddMM").click(function() {

            if ($MakeList.val() === '') {
                alert("select Make");
            } else if ($ModelList.val() === null) {
                alert("select model");
            } else if ($("input:radio[name=selectRule]:checked").val() === undefined) {
                alert("select rule");
            } else {
                var request = $.ajax({
                    url: "ajax/rule-add.php",
                    type: "POST",
                    data: {make: $MakeList.val(),
                        model: $ModelList.val(),
                        rule: $("input:radio[name=selectRule]:checked").val()
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    showMM($("input:radio[name=selectRule]:checked").val());
                    //$MakeList.change();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });

        $(".jsNewMMBtn").click(function() {
            $(".jsNewMMc").show();
        });
        $(".jsNewMM").click(function() {
            var mmDisplayName = $('#mmDisplayName').val();
            var mmNewType = $("input:radio[name=selectMM]:checked").val();

            if (mmDisplayName === '') {
                alert("enter the the name of make/model");
            } else if (mmNewType === undefined) {
                alert("choose the add make/model");
            } else if (mmNewType === 'model' && $MakeList.val() === '') {
                alert("select Make");
            } else {
                var request = $.ajax({
                    url: "ajax/make-model-add.php",
                    type: "POST",
                    data: {displayName: mmDisplayName,
                        newType: mmNewType,
                        make: $MakeList.val()
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    if ( mmNewType === 'model' ) {
                        $MakeList.eq(0).change();
                    }else{
                        location.reload();
                    }
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });
        // end add make/model

        //Occupation
        $OccList = $(".jsOccList");
        $(".jsAddOcc").click(function() {
            if ($OccList.val() === '') {
                alert("select Occupation");
            } else if ($("input:radio[name=selectRule]:checked").val() === undefined) {
                alert("select rule");
            } else {
                var request = $.ajax({
                    url: "ajax/occ-add.php",
                    type: "POST",
                    data: {occ: $OccList.val(),
                        rule: $("input:radio[name=selectRule]:checked").val()
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    showOcc($("input:radio[name=selectRule]:checked").val());
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });

        $(".jsdelOcc").click(function() {
            if ($OccList.val() === '') {
                alert("select Occupation");
            } else {
                var request = $.ajax({
                    url: "ajax/occ-del.php",
                    type: "POST",
                    data: {occ: $OccList.val()}
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });
        $(".jsLoadOcc").click(function() {
            if ( $OccList.val().length != 1) {
                alert("select One Occupation");
            } else {
                $("#occDisplayNameEn").val($OccList.find(":selected").data('en'));
                $("#occDisplayNameZh").val($OccList.find(":selected").data('zh'));
                $("#occDisplayEnOrder").val($OccList.find(":selected").data('enorder'));
                $("#occDisplayZhOrder").val($OccList.find(":selected").data('zhorder'));
                $("#occID").val($OccList.find(":selected").val());
            }
        });

        $(".jsNewOccBtn").click(function() {
            $(".jsNewOccC").show();
        });
        $(".jsNewOcc").click(function() {
            var enText = $("#occDisplayNameEn").val();
            var zhText = $("#occDisplayNameZh").val();
            var enOrder = $("#occDisplayEnOrder").val();
            var zhOrder = $("#occDisplayZhOrder").val();

            if (enText === '' || zhText === '') {
                alert('input en/zh display Text');
            } else {

                var request = $.ajax({
                    url: "ajax/occ-new.php",
                    type: "POST",
                    data: {enText: enText,
                        zhText: zhText,
                        en_order: enOrder,
                        zh_order: zhOrder,
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });

        $(".jsUpdateOcc").click(function() {
            var enText = $("#occDisplayNameEn").val();
            var zhText = $("#occDisplayNameZh").val();
            var enOrder = $("#occDisplayEnOrder").val();
            var zhOrder = $("#occDisplayZhOrder").val();
            var id = $("#occID").val();

            if (enText === '' || zhText === '') {
                alert('input en/zh display Text');
            } else {
                var request = $.ajax({
                    url: "ajax/occ-update.php",
                    type: "POST",
                    data: {enText: enText,
                        zhText: zhText,
                        en_order: enOrder,
                        zh_order: zhOrder,
                        id:id
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });

        //end Occupation

        //details info
        $DeInList = $(".jsDeInList");
        $DeInValue = $(".jsDeInValue");
        $(".jsAddDeIn").click(function() {
            if ($DeInList.val() === '') {
                alert("select details info");
            } else if ($DeInValue.val() === '') {
                alert("select details info value");
            } else if ($("input:radio[name=selectRule]:checked").val() === undefined) {
                alert("select rule");
            } else {
                var request = $.ajax({
                    url: "ajax/details-info-add.php",
                    type: "POST",
                    data: {deIn: $DeInList.val(),
                        deInValue: $DeInValue.val(),
                        rule: $("input:radio[name=selectRule]:checked").val()
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    showDeIn($("input:radio[name=selectRule]:checked").val());
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });
        $(".jsNewDeInBtn").click(function() {
            $(".jsNewDeInC").show();
        });
        $(".jsNewDeIn").click(function() {
            var enText = $("#DeInDisplayNameEn").val();
            var zhText = $("#DeInDisplayNameZh").val();
            var enTextDesc = $("#DeInDisplayNameEnDesc").val();
            var zhTextDesc = $("#DeInDisplayNameZhDesc").val();
            var sortOrder = $("#DeInSortOrder").val();

            if (enText === '' || zhText === '' || enTextDesc === '' || zhTextDesc === '' ) {
                alert('input all display Text');
            } else {

                var request = $.ajax({
                    url: "ajax/details-info-new.php",
                    type: "POST",
                    data: {enText: enText,
                        zhText: zhText,
                        enTextDesc: enTextDesc,
                        zhTextDesc: zhTextDesc,
                        sortOrder: sortOrder
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });
        $(".jsUpdateDeIn").click(function() {
            var enText = $("#DeInDisplayNameEn").val();
            var zhText = $("#DeInDisplayNameZh").val();
            var enTextDesc = $("#DeInDisplayNameEnDesc").val();
            var zhTextDesc = $("#DeInDisplayNameZhDesc").val();
            var sortOrder = $("#DeInSortOrder").val();

            var id = $(".jsDeInID").val();
            if (enText === '' || zhText === '' || enTextDesc === '' || zhTextDesc === '' || id === '' ) {
                alert('something missing eg, have u click load ?');
            } else {
                var request = $.ajax({
                    url: "ajax/details-info-update.php",
                    type: "POST",
                    data: {enText: enText,
                        zhText: zhText,
                        enTextDesc: enTextDesc,
                        zhTextDesc: zhTextDesc,
                        sortOrder: sortOrder,
                        id : id
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });
        $(".jsLoadDeIn").click(function(){
            var id = $(".jsDeInList").val();
            if ( id === '' ) {
                alert('please select');
            } else {
                var request = $.ajax({
                    url: "ajax/details-info-load.php",
                    type: "GET",
                    data: {id: id },
                    dataType: "json"
                });
                request.done(function(msg) {
                    $("#DeInDisplayNameEn").val(msg.en);
                    $("#DeInDisplayNameZh").val(msg.zh);
                    $("#DeInDisplayNameEnDesc").val(msg.en_desc);
                    $("#DeInDisplayNameZhDesc").val(msg.zh_desc);
                    $("#DeInSortOrder").val(msg.sortOrder);
                    $(".jsDeInID").val(msg.id);
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });

           }
        });
        //end details info

        // start sub plan
        $(".jsSubPlansNewBtn").click(function() {
            if ($("input:radio[name=selectRule]:checked").val() === undefined) {
                alert("select rule");
            } else {
                var request = $.ajax({
                    url: "ajax/sub-plans-info-add.php",
                    type: "POST",
                    data: {name: $(".jsSubPlansName").val(),
                        name_zh: $(".jsSubPlansNameZh").val(),
                        name_sub: $(".jsSubPlansNameSub").val(),
                        name_sub_zh: $(".jsSubPlansNameSubZh").val(),
                        add_price: $(".jsSubPlansPrice").val(),
                        zh: $(".jsSubPlansZh").val(),
                        en: $(".jsSubPlansEn").val(),
                        pdf_url_en: $(".jsSubPlansPDFEn").val(),
                        pdf_url_zh: $(".jsSubPlansPDFZh").val(),
                        sortOrder: $(".jsSubPlansSortOrder").val(),
                        groupID: $(".jsSubPlansGroupID").val(),
                        rule: $("input:radio[name=selectRule]:checked").val()
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });
         $(".jsSubPlansUpdateBtn").click(function() {
            if ( $(".jsSubPlansID").val() === '' )  {
                alert("need select sub Plan");
            } else {
                var request = $.ajax({
                    url: "ajax/sub-plans-info-update.php",
                    type: "POST",
                    data: {name: $(".jsSubPlansName").val(),
                        name_zh: $(".jsSubPlansNameZh").val(),
                        name_sub: $(".jsSubPlansNameSub").val(),
                        name_sub_zh: $(".jsSubPlansNameSubZh").val(),
                        add_price: $(".jsSubPlansPrice").val(),
                        zh: $(".jsSubPlansZh").val(),
                        en: $(".jsSubPlansEn").val(),
                        pdf_url_en: $(".jsSubPlansPDFEn").val(),
                        pdf_url_zh: $(".jsSubPlansPDFZh").val(),
                        sortOrder: $(".jsSubPlansSortOrder").val(),
                        groupID: $(".jsSubPlansGroupID").val(),
                        id: $(".jsSubPlansID").val()
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    $(".jsSubPlansID").val('');
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });

        $(".jsSubPlansCleanBtn").click(function(){
            $(".jsSubPlansName").val('');
            $(".jsSubPlansNameZh").val('');
            $(".jsSubPlansSubName").val('');
            $(".jsSubPlansSubNameZh").val('');
            $(".jsSubPlansPrice").val('');
            $(".jsSubPlansZh").val('');
            $(".jsSubPlansEn").val('');
            $(".jsSubPlansPDFEn").val('');
            $(".jsSubPlansPDFZh").val('');
            $(".jsSubPlansID").val('');
            $(".jsSubPlansGroupID").val('');
        });

        $(".jsSubPlansLoadBtn").click(function(){
            $("#subPlansPanel:hidden").slideDown();
            $(".jsSubPlansUpdateWapper").show();

            var $p = $(this).parent().parent();
            $(".jsSubPlansID").val($(this).data('spid'));
            $(".jsSubPlansSortOrder").val($p.find('.jsSubPlansSortOrder').text());
            $(".jsSubPlansGroupID").val($p.find('.jsSubPlansGroupIDValue').text());
            $(".jsSubPlansName").val($p.find('.jsSubPlansNameValue').text());
            $(".jsSubPlansNameZh").val($p.find('.jsSubPlansNameZhValue').text());
            $(".jsSubPlansNameSub").val($p.find('.jsSubPlansNameSubValue').text());
            $(".jsSubPlansNameSubZh").val($p.find('.jsSubPlansNameSubZhValue').text());
            $(".jsSubPlansPrice").val($p.find('.jsSubPlansAddPriceValue').text());
            $(".jsSubPlansEn").val($p.find('.jsSubPlansEnValue').text());
            $(".jsSubPlansZh").val($p.find('.jsSubPlansZhValue').text());
            $(".jsSubPlansPDFEn").val($p.find('.jsSubPlansPdfValueEn').attr('href'));
            $(".jsSubPlansPDFZh").val($p.find('.jsSubPlansPdfValueZh').attr('href'));
        });
        $(".jsSubPlansDelBtn").click(function(){
            var request = $.ajax({
                    url: "ajax/sub-plans-info-del.php",
                    type: "POST",
                    data: {
                        id: $(this).data('spid')
                    }
                });
                request.done(function(msg) {
                    if (msg !== '') {
                        alert(msg);
                    }
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
        });
        // sub plan end


        // test rule
        //default value
        $("select[name='ncd']").val(60);
        $("select[name='drivingExp']").val('gt_2yr');

        $("#testRuleFormBtn").click(function() {
            $testFormData = $("#testRuleForm").serialize();
            var request = $.ajax({
                url: "ajax/test-rule.php",
                type: "POST",
                data: $testFormData
            });
            request.done(function(msg) {
                $("#testRuleLog").html(msg);
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

        });
        // end test rule

        $("#jsLayerClose").click(function() {
            dimOff();
        });
        //top action btn
        $(".jsShowTestRuleBtn").click(function() {
            var $onLayer = $(".jsTestRule");
            dimOn($onLayer);

        });
        $(".jsNewRuleBtn").click(function() {
            var request = $.ajax({
                url: "ajax/rule-new.php",
                type: "GET"
            });
            request.done(function(msg) {
                //alert(msg);
                location.reload();
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });
        $(".jsDupRuleBtn").click(function() {
             if ($("input:radio[name=selectRule]:checked").val() === undefined) {
                alert("select rule");
            } else {
                var request = $.ajax({
                    url: "ajax/rule-dup.php",
                    type: "GET",
                    data: {
                        rule: $("input:radio[name=selectRule]:checked").val()
                    }
                });
                request.done(function(msg) {
                    //alert(msg);
                    location.reload();
                });
                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });

        $(".jsCarPanelBtn").click(function(){
            $("#carPanel").slideToggle();
            $("#occPanel").hide();
            $("#detailsPanel").hide();
            $("#subPlansPanel").hide();
        });
        $(".jsOccPanelBtn").click(function(){
            $("#occPanel").slideToggle();
            $("#detailsPanel").hide();
            $("#carPanel").hide();
            $("#subPlansPanel").hide();
        });
        $(".jsDetailsPanelBtn").click(function(){
            $("#detailsPanel").slideToggle();
            $("#occPanel").hide();
            $("#carPanel").hide();
            $("#subPlansPanel").hide();
        });
        $(".jsSupPlanPanelBtn").click(function(){
            $("#subPlansPanel").slideToggle();
            $("#occPanel").hide();
            $("#carPanel").hide();
            $("#detailsPanel").hide();
        });
        // top action btn end


        // function start
        function dimOff() {
            $(".jsTestRule").hide(200);
            $(".jsDimLayer").hide(200);
        }
        function dimOn(onLayer) {
            onLayer.show(200);
            $(".jsDimLayer").show(200);
        }

        function showMM(id) {
            var request = $.ajax({
                url: "ajax/make-model.php",
                type: "GET",
                data: {id: id},
                dataType: "json"
            });
            request.done(function(msg) {
                var items = [];
                var items2 = [];
                var tmpMake = '';
                items2.push("<div style='clear:both'></div>");
                items2.push("<ul>");
                $.each(msg, function(key, val) {

                    if ( tmpMake != val.makeText  ){
                        items.push( '<div style="float:left;margin:10px;cursor:pointer" data-mli="'+val.make+'">' + val.makeText + '</div>');
                        tmpMake = val.makeText;
                    }

                    items2.push("<li class='Mli"+val.make+"' style='display:none'>" + val.makeText + " - " + val.modelText + "<span data-mid='" + val.id + "'>X</span></li>");

                });
                items2.push("</ul>");
                $("#r_" + id).find(".jsListMM").html(items.join("") + items2.join("")).show();

            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        }
        function showOcc(id) {
            var request = $.ajax({
                url: "ajax/rule-occ-get.php",
                type: "GET",
                data: {id: id},
                dataType: "json"
            });
            request.done(function(msg) {
                var items = [];
                items.push("<ol>");
                $.each(msg, function(key, val) {
                    items.push("<li >" + val.occupation + "<span data-oid='" + val.id + "'>X</span></li>");
                });
                items.push("</ol>");
                $("#r_" + id).find(".jsListOcc").html(items.join("")).show();
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        }
        function showDeIn(id) {
            var request = $.ajax({
                url: "ajax/rule-details-info-get.php",
                type: "GET",
                data: {id: id},
                dataType: "json"
            });
            request.done(function(msg) {
                var items = [];
                items.push("<ul>");
                $.each(msg, function(key, val) {
                    items.push("<li >" + val.details_info + " : <input type='text' value='" + val.value + "' class='detailsValueInput' data-oid='" + val.id + "'>" + "<span data-oid='" + val.id + "'>X</span></li>");
                });
                items.push("</ul>");
                $("#r_" + id).find(".jsListDetails").html(items.join("")).show();
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        }

        $('.jsCloseSlidePanel').css(
            {'cursor':'pointer','color':'red','float':'right'}
        ).click(function(){
            $(this).parent().slideToggle();
        });

        $(".jsLogOutBtn").click(function(){
            location.href = 'logout.php';
        });
        $(".jsNewVersion").click(function(){
            location.href = 'rule2.php';
        });

        $(".jsSubPlansPdfValueEn").click(function(e){
            e.preventDefault();
            window.open('https://kwiksure.com'+$(this).attr('href'));
        });
        $(".jsSubPlansPdfValueZh").click(function(e){
            e.preventDefault();
            window.open('https://kwiksure.com'+$(this).attr('href'));
        });

        $(".jsInactiveRuleBtn").click(function(){
            if ( $(this).data("showhide") == 'show'){
                $(".jsActive[value=0]:checked").parents('.js-row').hide();
                $(this).data("showhide",'hide');
            } else {
                $(".jsActive[value=0]:checked").parents('.js-row').show();
                $(this).data("showhide",'show');
            }
        });
        $(".jsInactiveRuleBtn").click();

    </script>

</body>
</html>
