var ruleList = new Vue({
    el: '#ruleList',
    data: {
        filterRuleByActive: '1',
        rules: null,
        rule: null,
        drivingExp: null,
        typeofInsurance: null,
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
        currentTab: 'setting',
    },
    created: function () {
        this.fetchRuleListData();
        this.getDriverExp();
        this.getTypeofInsurance();
    },
    computed: {
        yfgFrom: function () {
            var d = new Date();
            var n = d.getFullYear();
            return n - this.rule.Yearofmanufacture_from;
        },
        yfgTo: function () {
            var d = new Date();
            var n = d.getFullYear();
            return n - this.rule.Yearofmanufacture;
        }
    },
    watch: {
        'rule.TypeofInsurance': function (val, oldVal) {
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
        'rule.id': function () {
            this.getRuleNCD();
            this.getRuleCarModel();
            this.getRuleOcc();
            this.getRuleDetails();
            this.getRuleSubPlans();
        }
    },
    methods: {
        fetchRuleListData: function () {
            var self = this;
            axios.get('ajax2/rule-get-all.php')
                    .then(function (response) {
                        self.rules = response.data;
                        self.rule = response.data[0];
                        //console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getDriverExp: function () {
            var self = this;
            axios.get('ajax2/driver-exp-get.php')
                    .then(function (response) {
                        self.drivingExp = response.data;
                        //console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getTypeofInsurance: function () {
            var self = this;
            axios.get('ajax2/insurance-type-get.php')
                    .then(function (response) {
                        self.typeofInsurance = response.data;
                        //console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getRuleNCD: function () {
            var self = this;
            axios.get('ajax2/rule-ncd-get.php', {
                params: {
                    id: this.rule.id
                }
            })
                    .then(function (response) {
                        self.ruleNCD = response.data;
                        //console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getRuleOcc: function () {
            var self = this;
            axios.get('ajax2/rule-occ-get.php', {
                params: {
                    id: this.rule.id
                }
            })
                    .then(function (response) {
                        self.ruleOcc = response.data;
                        //console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getRuleDetails: function () {
            var self = this;
            axios.get('ajax2/rule-details-info-get.php', {
                params: {
                    id: this.rule.id
                }
            })
                    .then(function (response) {
                        self.ruleDetails = response.data;
                        //console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getRuleSubPlans: function () {
            var self = this;
            axios.get('ajax2/rule-subplans-get.php', {
                params: {
                    id: this.rule.id
                }
            })
                    .then(function (response) {
                        self.ruleSubPlans = response.data;
                        //console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getRuleCarModel: function () {
            var self = this;
            axios.get('ajax2/rule-makemodel-get.php', {
                params: {
                    id: this.rule.id
                }
            })
                    .then(function (response) {
                        self.ruleCarModel = response.data;
                        var makeObj = {};
                        var tmp = null;
                        
                        for (var i = 0; i < response.data.length; i++) {
                            if (tmp != response.data[i].make) {
                                makeObj[i] = {makeID: response.data[i].make,
                                    makeText: response.data[i].makeText
                                }
                                tmp = response.data[i].make;
                            }
                        }
                        self.ruleCarMake = makeObj;
                        self.filterModel = 'zzzzzzzzzz'//response.data[0].makeText;
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        showRule: function (rule, $event) {
            this.rule = rule;
            //console.log($event);
        },
        changeTab: function (tab) {
            this.currentTab = tab;
        },
        updateRule: function () {
            var rule = this.rule;
            axios.post('ajax2/rule-update.php', {
                data: rule})
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (response) {
                        console.log(response);
                    });

        },
                updateSubPlan: function (index) {
                    var newObj = this.ruleSubPlans[index]
                    /*
                    console.log(newObj.sortOrder);
                    console.log(newObj.name);
                    console.log(newObj.name_sub);
                    console.log(newObj.add_price);
                    console.log(newObj.groupID);
                    console.log(newObj.en);
                    console.log(newObj.pdf_url_en);
                    console.log(newObj.name_zh);
                    console.log(newObj.name_sub_zh);
                    console.log(newObj.zh);
                    console.log(newObj.pdf_url_zh);
                    */
                }
    }
});