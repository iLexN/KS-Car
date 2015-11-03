var ruleList = new Vue({
    el: '#ruleList',
    data: {
        filterRuleByActive: '1',
        rules: null,
        rule: null,
        drivingExp: null,
        typeofInsurance: null,
        detailsInfo:null,
        editDetailsInfo:null,
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
        currentTab2: null, // DetailsInfoPanel
        copiedSubPlan: null
    },
    created: function() {
        this.fetchRuleListData();
        this.getDriverExp();
        this.getTypeofInsurance();
        this.getDetailsInfoList();
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
                //this.rule.premium = '';
            }
        },
        'rule.id': function() {
            this.getRuleNCD();
            this.getRuleCarModel();
            this.getRuleOcc();
            this.getRuleDetails();
            this.getRuleSubPlans();
        }
    },
    methods: {
        fetchRuleListData: function() {
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
                        id: this.rule.id
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
                        id: this.rule.id
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
                        id: this.rule.id
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
                    self.filterModel = 'zzzzzzzzzz' //response.data[0].makeText;
                })
                .catch(function(response) {
                    //console.log(response);
                });
        },
        showRule: function(rule, $event) {
            this.rule = rule;
            //console.log($event);
        },
        changeTab: function(tab) {
            this.currentTab = tab;
        },
        changeTab2: function(tab) {
            this.currentTab2 = tab;
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
            if ( this.editDetailsInfo === null || this.editDetailsInfo.id === undefined ) {
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
                    console.log(response.data);
                    if (response.data.e == '1'  ) {
                        self.showAlertNote('Error: Already exist');
                    } else {
                        self.showAlertNote('Added to ' + self.rule.rule_name);
                        self.getRuleDetails();
                    }
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
        viewPlansFileUrl: function(url) {
            window.open('https://kwiksure.com' + url);
        }
    }
});