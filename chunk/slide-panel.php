
    
        <div class="rightSlidePanel" id="carPanel">
            <a class="jsCloseSlidePanel">Close</a>
            <legend>Car Make/Model</legend>
            <div>
                <p><select class="jsMakeList">
                    <option value="">select</option>
                    <?php foreach ( $make_ar as $m => $m_ar ) { ?>
                    <option value="<?php echo($m);?>"><?php echo($m_ar['make']);?></option>
                    <?php } ?>
                    </select></p>
                <p>=><br />
                <select class="jsModelList" multiple="multiple" style="width:200px;margin-top:5px;height:300px;" >
                    <option value="">select</option>
                </select></p>
                <p>=>
                    <button class="jsAddMM">Add to Rule</button> /  <button class="jsDelMake">Delete Make</button> / <button class="jsDelModel">Delete Model</button></p>
            </div>
            <hr/>
            <legend class="jsNewMMBtn">New Make/Model</legend>

            <div style="margin-top:10px;" class="jsNewMMc">
                <p><input type="text" id="mmDisplayName"  placeholder="enter the make/model name"></p>
                <input type="radio" name="selectMM" class="selectMM" value="make">Make
                <input type="radio" name="selectMM" class="selectMM" value="model">Model
                <p><button class="jsNewMM">Add New</button></p>
            </div>
        </div>
    
    
        <div class="rightSlidePanel" id="occPanel">
            <a class="jsCloseSlidePanel">Close</a>
            <legend>Occupation</legend>
            <div>
                <p><select class="jsOccList" multiple="multiple" style="height:350px;" >
                    <option value="">select</option>
                    <?php foreach ( $occupation_ar as $o => $o_ar ) { ?>
                    <option value="<?php echo($o);?>" data-en="<?php echo($o_ar['en']);?>" data-zh="<?php echo($o_ar['zh']);?>" data-zhorder="<?php echo($o_ar['zh_order']);?>" data-enorder="<?php echo($o_ar['en_order']);?>"><?php echo($o_ar['en']);?> ( <?php echo($o_ar['zh']);?> )</option>
                    <?php } ?>
                    </select></p>
                <p>=><button class="jsAddOcc">Add</button> / 
                    <button class="jsdelOcc">Delete</button> /
                    <button class="jsLoadOcc">Load</button>
                </p>
            </div>
            <hr />
            <legend class="jsNewOccBtn">New Occupation</legend>
            <div style="margin-top:10px;" class="jsNewOccC">
                <p>en : <input type="text" id="occDisplayNameEn" style="width:250px;" placeholder="en occupation text"> 
                   order : <input type="text" id="occDisplayEnOrder" style="width:150px;"  placeholder="large number come first">
                </p>
                <p>zh : <input type="text" id="occDisplayNameZh" style="width:250px;" placeholder="zh occupation text">
                order : <input type="text" id="occDisplayZhOrder" style="width:150px;"  placeholder="large number come first">
                </p>
                <p><span style="color:red">*** ordre large number come first</span></p>
                <input type="hidden" id="occID" value="">
                <button class="jsNewOcc">Add New</button> / <button class="jsUpdateOcc">Update</button>
            </div>
        </div>
    
    <!-- <div style="clear:both;height:15px"></div>-->
    
        <div class="rightSlidePanel" id="detailsPanel">
            <a class="jsCloseSlidePanel">Close</a>
            <legend>Details Info</legend>
            <div>
                <p><select class="jsDeInList" style="width:200px">
                    <option value="">select</option>
                    <?php foreach ( $detailsInfo_ar as $o => $o_ar ) { ?>
                    <option value="<?php echo($o);?>"><?php echo($o_ar['en']);?> ( <?php echo($o_ar['zh']);?> )</option>
                    <?php } ?>
                    </select></p>
                <p>=><input type="text" class="jsDeInValue" style="width:150px;"></p>
                <p>=><button class="jsAddDeIn">Add</button></p>
                
                <p>Remark : <br/>
                empty = empty /
                no = cross /
                yes = tick
                </p>
            </div>
            <hr />
            <button class="jsLoadDeIn" style="float:right">Load</button>
            <legend class="jsNewDeInBtn">New</legend>
            <div style="margin-top:10px;" class="jsNewDeInC">
                <p>en : <input type="text" id="DeInDisplayNameEn" style="width:173px;" placeholder="en details Info text"></p>
                <p>zh : <input type="text" id="DeInDisplayNameZh" style="width:173px;" placeholder="zh details Info text"></p>
                <p>en-desc :<br/><textarea type="text" id="DeInDisplayNameEnDesc" style="width:190px;" placeholder="en details Desc text"></textarea></p>
                <p>zh-desc :<br/><textarea type="text" id="DeInDisplayNameZhDesc" style="width:190px;" placeholder="zh details Desc text"></textarea></p>
                <p>order (small number come first) :<br/> <input type="type" id="DeInSortOrder"></p>
                <button class="jsNewDeIn">Add New</button><button class="jsUpdateDeIn">Update</button>
                <input type="hidden" value="" class="jsDeInID">
            </div>
            
        </div>
    
    
        <div class="rightSlidePanel" id="subPlansPanel">
            <a class="jsCloseSlidePanel">Close</a>
            <legend>Add Sub-Plans Info</legend>
            <div>
                <div class="subplansPanelSubdiv">
                    <p>Name:<br/><input type="text" value="" class="jsSubPlansName"></p>
                    <p>NameSub:<br/><input type="text" value="" class="jsSubPlansNameSub"></p>
                    <p>en:<br/>
                    <textarea class="jsSubPlansEn"></textarea></p>
                    <p>PDF EN URL : <input type="text" value="" class="jsSubPlansPDFEn" style="width:80%"></p>
                </div>
                <div class="subplansPanelSubdiv">
                    <p>Name zh:<br/><input type="text" value="" class="jsSubPlansNameZh"></p>
                    <p>NameSub zh:<br/><input type="text" value="" class="jsSubPlansNameSubZh"></p>
                    <p>zh: <br/>
                    <textarea class="jsSubPlansZh"></textarea></p>
                    <p>PDF ZH URL : <input type="text" value="" class="jsSubPlansPDFZh" style="width:80%"></p>
                </div>
                
                <p>Additional Price: <input type="text" value="" class="jsSubPlansPrice"></p>
                
                <p>order (small number come first) : <input type="type" class="jsSubPlansSortOrder"></p>
                
                <p>GroupID:<input type="type" class="jsSubPlansGroupID"></p>
                
                <button class="jsSubPlansNewBtn">Add New</button> / <button class="jsSubPlansCleanBtn">Clean</button>
                
                <p class="jsSubPlansUpdateWapper" style="display:none">
                    <input type="hidden" value="" class="jsSubPlansID">
                    <button class="jsSubPlansUpdateBtn">Update</button>
                </p>
                    
                
            </div>
        </div>
