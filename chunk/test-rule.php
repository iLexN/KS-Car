<div class="jsDimLayer dim-layer"></div>
    <div class="jsTestRule" style="display:none;width:75%;min-width:750px;border:1px solid #ccc;background-color:#ccc;min-height:500px;z-index:300">
        <div style="padding:30px;">
            <span id="jsLayerClose" style="cursor:pointer;color:red;float:right">close</span>
            <h2>Test Rule </h2>
            <div style="width:50%;float: left;">
                <form id="testRuleForm">
                    <input type="hidden" name="testRule" value="1">
                    <!--<input type="hidden" name="k" value="doreme">
                    <input type="hidden" name="doreme" value="motor.V1.abc">-->

                    Make
                    <select name="carMake" class="jsMakeList">
                        <option value="">select</option>
                        <?php foreach ( $make_ar as $m => $m_ar ) { ?>
                        <option value="<?php echo($m);?>"><?php echo($m_ar['make']);?></option>
                        <?php } ?>
                    </select>
                    => Model
                    <select name="carModel" class="jsModelList" >
                        <option value="">select</option>
                    </select>

                    <br/><br/>
                    dob : <input type="text" name="dob" placeholder="dd-mm-yyyy"><br/><br/>
                    ncd : <select name="ncd" >
                        <?php foreach ( $ncd as $v ) { ?>
                        <option value="<?php echo($v)?>" ><?php echo($v)?></option>
                        <?php } ?>
                    </select>
                    <br/><br/>
                    DrivingExp
                    <select name="drivingExp">
                        <?php foreach ( $driveExp as $k=>$v ) {?>
                        <option value="<?php echo $k?>"><?php echo $v?></option>
                        <?php } ?>
                    </select>
                    <br/><br/>
                    insuranceType :
                    <select name="insuranceType" >
                        <?php foreach ( $insuranceType as $k=>$v ) {?>
                        <option value="<?php echo $k?>"><?php echo $v?></option>
                        <?php } ?>
                    </select>
                    <br/><br/>
                    yearManufacture : <input type="text" name="yearManufacture" placeholder="2010" value="2010" style="width:60%"><br/><br/>
                    occupation : <select name="occupation" class="jsOccList" style="width:200px">
                        <option value="">select</option>
                        <?php foreach ( $occupation_ar as $o => $o_ar ) { ?>
                        <option value="<?php echo($o);?>"><?php echo($o_ar['en']);?></option>
                        <?php } ?>
                    </select>
                    <br/><br/>
                    motor_accident_yrs : <input type="radio" name="motor_accident_yrs" value="1"> Yes
                    <input type="radio" name="motor_accident_yrs" value="0" checked="checked"> No
                    <br/><br/>
                    drive_offence_point : <input type="radio" name="drive_offence_point" value="1"> Yes
                    <input type="radio" name="drive_offence_point" value="0" checked="checked"> No

                    <br/><br/>
                    <input type="button" value="Test" id="testRuleFormBtn">

                    <!--<input type="text" name="drivingExpText" value="doreme">
                    <input type="text" name="occupationText" value="doreme">-->
                     <!--<input type="hidden" value="1" name="skipFindRule">-->
                    <!--<input type="hidden" value="1" name="planID">
                   
                    <input type="hidden" value="1" name="isSave">
                    <input type="hidden" value="name test2" name="name">
                    <input type="hidden" value="a@2a.com" name="email">
                    <input type="hidden" value="31132112" name="contactno">
                    <input type="hidden" value="6" name="subPlanID[]">
                    <input type="hidden" value="7" name="subPlanID[]">-->

                </form>
            </div>
            <div id="testRuleLog" style="width:50%;float: left;height:400px;overflow: auto;">

            </div>
        </div>
    </div>
