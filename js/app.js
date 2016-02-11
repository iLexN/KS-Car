var app = new Vue({
    el: '#app',
    data: {
        filterRuleByActive: '1',
        rules: null,
        rule: {},
        drivingExp: null,
        typeofInsurance: null,
        makeList:null,
        carMake:null,
        modelList:null,
        carModel:null,
        detailsInfo:null,
        creatMakeModel:{},
        editDetailsInfo:{
            id:null,
            en:null,
            zh:null,
            sortOrder:null
        },
        occupationList:null,
        editOcc:{
            id:null,
            en:null,
            en_order:null,
            zh:null,
            zh_order:null
        },
        ruleNCD: null,
        ruleCarModel: null,
        ruleCarMake: null,
        ruleOcc: null,
        ruleDetails: null,
        ruleSubPlans: null,
        disabled: {
            "p": true,
            "a2": true,
            "a3": false
        },
        filterModel: null,
        filterOcc: null,
        filterSupPlanGroup: null,
        currentTab: 'setting', // setting , detailsInfo ,subPlan
        currentTab2: null, // DetailsInfoPanel , CarPanel
        copiedSubPlan: null
    },
    ready: function() {//or created?
        this.getRuleList();
        this.getDriverExp();
        this.getTypeofInsurance();
    },
    computed: {
        yfgFrom: function() {
            var d = new Date();
            var n = d.getFullYear();
            return n - this.rule.Yearofmanufacture_from;
        },
        yfgTo: function() {
            var d = new Date();
            var n = d.getFullYear();
            return n - this.rule.Yearofmanufacture;
        }
    },
    watch: {
        'rule.TypeofInsurance': function(val, oldVal) {
            if (val === 'Third_Party_Only') {
                this.disabled.a2 = true;
                this.disabled.a3 = true;
                this.disabled.p = false;
            } else {
                this.disabled.a2 = false;
                this.disabled.a3 = false;
                this.disabled.p = true;
            }
        },
        'rule.id': function() {
            this.getRuleNCD();
            this.getRuleCarModel();
            this.getRuleOcc();
            this.getRuleDetails();
            this.getRuleSubPlans();
        },
        'rule.active' : function(){
            this.filterRuleByActive = this.rule.active;
        },
        'carMake':function(){
            this.getModelList();
        }
    },
    methods: {
        getRuleList: function() {
            var self = this;
            axios.get('ajax2/rule-get-all.php')
                .then(function(response) {
                    self.rules = response.data;
                    self.rule = response.data[0];
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getDriverExp: function() {
            var self = this;
            axios.get('ajax2/driver-exp-get.php')
                .then(function(response) {
                    self.drivingExp = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getTypeofInsurance: function() {
            var self = this;
            axios.get('ajax2/insurance-type-get.php')
                .then(function(response) {
                    self.typeofInsurance = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getDetailsInfoList: function() {
            var self = this;
            axios.get('ajax2/details-info-get.php')
                .then(function(response) {
                    self.detailsInfo = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getOccupationList: function() {
            var self = this;
            axios.get('ajax2/occ-get.php')
                .then(function(response) {
                    self.occupationList = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getMakeList:function(){
            var self = this;
            axios.get('ajax2/make-get.php')
                .then(function(response) {
                    self.makeList = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getModelList:function(){
            var self = this;
            axios.get('ajax2/make-mode-get.php', {
                    params: {
                        id: self.carMake
                    }
                })
                .then(function(response) {
                    self.modelList = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getRuleNCD: function() {
            var self = this;
            axios.get('ajax2/rule-ncd-get.php', {
                    params: {
                        id: this.rule.id
                    }
                })
                .then(function(response) {
                    self.ruleNCD = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getRuleOcc: function() {
            var self = this;
            axios.get('ajax2/rule-occ-get.php', {
                    params: {
                        id: this.rule.id
                    }
                })
                .then(function(response) {
                    self.ruleOcc = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getRuleDetails: function() {
            var self = this;
            axios.get('ajax2/rule-details-info-get.php', {
                    params: {
                        id: self.rule.id
                    }
                })
                .then(function(response) {
                    self.ruleDetails = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getRuleSubPlans: function() {
            var self = this;
            axios.get('ajax2/rule-subplans-get.php', {
                    params: {
                        id: self.rule.id
                    }
                })
                .then(function(response) {
                    self.ruleSubPlans = response.data;
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        getRuleCarModel: function() {
            var self = this;
            axios.get('ajax2/rule-makemodel-get.php', {
                    params: {
                        id: self.rule.id
                    }
                })
                .then(function(response) {
                    self.ruleCarModel = response.data;
                    var makeObj = {};
                    var tmp = null;

                    for (var i = 0; i < response.data.length; i++) {
                        if (tmp != response.data[i].make) {
                            makeObj[i] = {
                                makeID: response.data[i].make,
                                makeText: response.data[i].makeText
                            }
                            tmp = response.data[i].make;
                        }
                    }
                    self.ruleCarMake = makeObj;
                    self.filterModel = '';//response.data[0].makeText;
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        updateRule: function() {
            var rule = this.rule;
            var self = this;
            axios.post('ajax2/rule-update.php', {
                    data: rule
                })
                .then(function(response) {
                    self.getRuleNCD();
                    self.showAlertNote('Saved');
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });

        },
        updateRuleNcd: function() {
            var ncds = this.ruleNCD;
            var self = this;
            axios.post('ajax2/rule-ncd-update.php', {
                    data: ncds
                })
                .then(function(response) {
                    self.getRuleNCD();
                    self.showAlertNote('Saved');
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });

        },
        updateRuleDetials: function() {
            var ruleDetails = this.ruleDetails;
            var self = this;
            axios.post('ajax2/rule-details-info-update.php', {
                    data: ruleDetails
                })
                .then(function(response) {
                    self.showAlertNote('Saved');
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        updateRuleSubPlan: function(Obj) {
            var self = this;
            axios.post('ajax2/rule-subplans-update.php', {
                    data: Obj
                })
                .then(function(response) {
                    self.showAlertNote('Saved');
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        updateDetailInfo: function() {
            if ( this.editDetailsInfo === null || this.editDetailsInfo.id === null  ) {
                this.showAlertNote('Please select ...');
                return;
            }
            
            if ( this.editDetailsInfo.en === null || 
                    this.editDetailsInfo.zh === null ||
                    this.editDetailsInfo.sortOrder === null )
            {
                this.showAlertNote('Please Fill in something ...');
                return;
            }
            
            var self = this;
            axios.post('ajax2/details-info-update.php', {
                    data: self.editDetailsInfo
                })
                .then(function(response) {
                    self.showAlertNote('Saved');
                    self.getDetailsInfoList();
                    self.getRuleDetails();
                    self.changeTab('detailsInfo');
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        updateOccupation:function() {
            if ( this.editOcc === null || this.editOcc.id === null || this.editOcc.id.length > 1) {
                this.showAlertNote('Please select One and click Load...');
                return;
            }
            if ( this.editOcc.en === null || this.editOcc.en_order === null ||
                    this.editOcc.zh === null || this.editOcc.zh_order === null) 
            {
                this.showAlertNote('Please Fill in Something...');
                return;
            }
            var self = this;
            axios.post('ajax2/occ-update.php', {
                    data: self.editOcc
                })
                .then(function(response) {
                    self.showAlertNote('Saved');
                    self.getOccupationList();
                    self.getRuleOcc();
                    self.changeTab('occupation');
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        duplicateRule : function(){
            var self = this;
            axios.post('ajax2/rule-dup.php', {
                    data: self.rule.id
                })
                .then(function(response) {
                    self.showAlertNote(self.rule.rule_name + ' Duplicated');
                    self.getRuleList();
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        removeRule:function(){
            var self = this;
            axios.post('ajax2/rule-remove.php', {
                    data: self.rule.id
                })
                .then(function(response) {
                    self.showAlertNote(self.rule.rule_name + ' Deleted');
                    self.getRuleList();
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        removeRuleOcc: function(Obj) {
            var self = this;
            axios.post('ajax2/rule-occ-remove.php', {
                    data: Obj
                })
                .then(function(response) {
                    self.ruleOcc.$remove(Obj);
                    self.showAlertNote(Obj.occupation + ' Delete From ' + self.rule.rule_name);
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        removeRuleModel: function(Obj) {
            var self = this;
            //console.log(modelObj);
            axios.post('ajax2/rule-model-remove.php', {
                    data: Obj
                })
                .then(function(response) {
                    self.ruleCarModel.$remove(Obj);
                    self.showAlertNote(Obj.makeText + ' - ' + Obj.modelText + ' Delete From ' + self.rule.rule_name);
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        removeRuleDetail: function(Obj) {
            var self = this;
            axios.post('ajax2/rule-details-info-remove.php', {
                    data: Obj
                })
                .then(function(response) {
                    self.ruleDetails.$remove(Obj);
                    self.showAlertNote(Obj.details_info + ' Delete From ' + self.rule.rule_name);
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        removeRuleSubPlan: function(Obj) {
            var self = this;
            axios.post('ajax2/rule-subplans-remove.php', {
                    data: Obj
                })
                .then(function(response) {
                    self.ruleSubPlans.$remove(Obj);
                    self.showAlertNote(Obj.name + ' - ' + Obj.name_sub + ' Delete From ' + self.rule.rule_name);
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        removeOccs : function(Obj){
            if ( this.editOcc === null || this.editOcc.id === undefined ) {
                this.showAlertNote('Please select ...');
                return;
            }
            self = this;
            axios.post('ajax2/occ-remove.php', {
                    data: self.editOcc
                })
                .then(function(response) {
                    //self.showAlertNote(self.copiedSubPlan.name + ' - ' + self.copiedSubPlan.name_sub + ' Copied To ' + self.rule.rule_name);
                    //self.getRuleSubPlans();
                    //console.log(response.data);
                    if (response.data.e == '1'  ) {
                        self.showAlertNote('Error: Already exist');
                    } else {
                        self.showAlertNote('Occupations deleted');
                        self.getRuleOcc();
                        self.getOccupationList();
                        self.changeTab('occupation');
                    }
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        removeCarMake:function(){
            if ( this.carMake === null ) {
                this.showAlertNote('Please select Make...');
                return;
            }
            self = this;
            axios.post('ajax2/make-remove.php', {
                    data: self.carMake
                })
                .then(function(response) {
                        self.showAlertNote('Make deleted');
                        self.getRuleCarModel();
                        self.getMakeList();   
                        self.getModelList();
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        removeCarModel:function(){
            if ( this.carModel === null ) {
                this.showAlertNote('Please select Model...');
                return;
            }
            self = this;
            axios.post('ajax2/model-remove.php', {
                    data: self.carModel
                })
                .then(function(response) {
                        self.showAlertNote('Model deleted');
                        self.getRuleCarModel();
                        self.getModelList();   
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        copyRuleSubPlan: function(Obj) {
            this.copiedSubPlan = Obj;
            this.showAlertNote(Obj.name + ' - ' + Obj.name_sub + ' Copied From ' + this.rule.rule_name);
        },
        addRuleSubPlan: function() {
            self = this;
            //console.log(self.copiedSubPlan);
            if ( self.copiedSubPlan === null ){
                self.showAlertNote('Please Copy First');
                return;
            }
            axios.post('ajax2/rule-subplans-create.php', {
                    data: {
                        subplanInfo: self.copiedSubPlan,
                        rule_id: self.rule.id
                    }
                })
                .then(function(response) {
                    self.showAlertNote(self.copiedSubPlan.name + ' - ' + self.copiedSubPlan.name_sub + ' Copied To ' + self.rule.rule_name);
                    self.getRuleSubPlans();
                    //console.log(response);
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        addRuleDetailInfo:function(){
            if ( this.editDetailsInfo === null || this.editDetailsInfo.id === null ) {
                this.showAlertNote('Please select ...');
                return;
            }
            self = this;
            axios.post('ajax2/rule-details-info-create.php', {
                    data: {
                        detailInfo: self.editDetailsInfo,
                        rule_id: self.rule.id
                    }
                })
                .then(function(response) {
                    //self.showAlertNote(self.copiedSubPlan.name + ' - ' + self.copiedSubPlan.name_sub + ' Copied To ' + self.rule.rule_name);
                    //self.getRuleSubPlans();
                    //console.log(response.data);
                    if (response.data.e == '1'  ) {
                        self.showAlertNote('Error: Already exist');
                    } else {
                        self.showAlertNote('Added to ' + self.rule.rule_name);
                        self.getRuleDetails();
                        self.changeTab('detailsInfo');
                    }
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        addRuleOcc:function(){
            if ( this.editOcc === null || this.editOcc.id === null ) {
                this.showAlertNote('Please select ...');
                return;
            }
            self = this;
            axios.post('ajax2/rule-occ-create.php', {
                    data: {
                        occ: self.editOcc,
                        rule_id: self.rule.id
                    }
                })
                .then(function(response) {
                    //self.showAlertNote(self.copiedSubPlan.name + ' - ' + self.copiedSubPlan.name_sub + ' Copied To ' + self.rule.rule_name);
                    //self.getRuleSubPlans();
                    //console.log(response.data);
                    if (response.data.e == '1'  ) {
                        self.showAlertNote('Error: Already exist');
                    } else {
                        self.showAlertNote('Added to ' + self.rule.rule_name);
                        self.getRuleOcc();
                        self.changeTab('occupation');
                    }
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        addRuleModel:function(){
            if ( this.carModel === null ) {
                this.showAlertNote('Please select Model...');
                return;
            }
            self = this;
            axios.post('ajax2/rule-model-add.php', {
                    data: {
                        model : self.carModel,
                        rule_id: self.rule.id
                    }
                })
                .then(function(response) {
                        self.showAlertNote('Model Added');
                        self.getRuleCarModel();
                        self.changeTab('makeModel')
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        addMakeModel:function(){
            if ( this.creatMakeModel === null ||  this.creatMakeModel.text === '' ) {
                this.showAlertNote('Please input text...');
                return;
            }
            if ( this.creatMakeModel.type === undefined  ){
                this.showAlertNote('Please Select Make/Model...');
                return;
            }
            if ( this.carMake === null && this.creatMakeModel.type === 'addModel') {
                this.showAlertNote('Please select Make...');
                return;
            }
            if ( this.creatMakeModel.type === 'addMake' ) {
                this.addMake();
            } else {
                this.addModel();
            }
        },
        addMake:function(){
            self = this;
            axios.post('ajax2/make-add.php', {
                    data: {
                        edit: self.creatMakeModel
                    }
                })
                .then(function(response) {
                        self.showAlertNote('New Make Added');
                        self.getMakeList();
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        addModel:function(){
            self = this;
            axios.post('ajax2/model-add.php', {
                    data: {
                        edit: self.creatMakeModel,
                        make_id : self.carMake
                    }
                })
                .then(function(response) {
                        self.showAlertNote('New Make Added');
                        self.getModelList();
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        showAlertNote: function(text) {
            $(".alertNote").html(text).slideDown(function() {
                var note = $(this);
                setTimeout(function() {
                    note.fadeOut();
                }, 3500);
            });
        },
        loadOccupation:function(){
            if ( this.editOcc === null || this.editOcc.id === null || this.editOcc.id.length > 1 ) {
                this.showAlertNote('Please select One...');
                return;
            }
            var a =null;
            for (var i = 0; i < this.occupationList.length; i++) {
                if ( this.occupationList[i].id == this.editOcc.id ) {
                    a = this.occupationList[i];
                    break;
                }
            }
            this.editOcc.en = a.en;
            this.editOcc.en_order = a.en_order;
            this.editOcc.zh = a.zh;
            this.editOcc.zh_order = a.zh_order;
            console.log(a);
        },
        loadDetailInfo:function(){
            if ( this.editDetailsInfo === null || this.editDetailsInfo.id === null  ) {
                this.showAlertNote('Please select ...');
                return;
            }
            var id = this.editDetailsInfo.id;
            var a = null;
            for (var i = 0; i < this.detailsInfo.length; i++) {
                if ( this.detailsInfo[i].id === id ) {
                    a = this.detailsInfo[i];
                    break;
                }
            }
            this.editDetailsInfo.en =a.en;
            this.editDetailsInfo.zh =a.zh;
            this.editDetailsInfo.sortOrder =a.sortOrder;
            console.log(this.editDetailsInfo);
        },
        viewPlansFileUrl: function(url) {
            window.open('https://kwiksure.com' + url);
        },
        showRule: function(rule, $event) {
            this.rule = rule;
            //console.log($event);
        },
        changeTab: function(tab) {
            this.currentTab = tab;
        },
        changeTab2: function(tab) {
            switch(tab) {
                case 'DetailsInfoPanel' :
                    if( this.detailsInfo === null ){
                        this.getDetailsInfoList();
                    }
                    break;
                case 'OccupationPanel':
                    if( this.occupationList === null ){
                        this.getOccupationList();
                    }
                    break;
                case 'CarPanel':
                    if( this.makeList === null ){
                        this.getMakeList();
                    }
                    break;
            };
            this.currentTab2 = tab;
        }
    }
});