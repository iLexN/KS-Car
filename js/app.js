var ruleList = new Vue({
    el: '#ruleList',
    data: {
        filterRuleByActive: '1',
        rules: null,
        rule: null,
        drivingExp: null,
        typeofInsurance: null,
        ruleNCD: null,
        disabled: {
            "p": true,
            "a2": true,
            "a3": false
        }
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
                this.rule.premium = '';
            }
        },
        'rule.id': function () {
            this.getRuleNCD();
        }
    },
    methods: {
        fetchRuleListData: function () {
            var self = this;
            axios.get('ajax/rule-get-all.php')
                    .then(function (response) {
                        self.rules = response.data;
                        self.rule = response.data[0];
                        console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getDriverExp: function () {
            var self = this;
            axios.get('ajax/driver-exp-get.php')
                    .then(function (response) {
                        self.drivingExp = response.data;
                        console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getTypeofInsurance: function () {
            var self = this;
            axios.get('ajax/insurance-type-get.php')
                    .then(function (response) {
                        self.typeofInsurance = response.data;
                        console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        getRuleNCD: function () {
            var self = this;
            axios.get('ajax/rule-ncd-get.php', {
                params: {
                    id: this.rule.id
                }
            })
                    .then(function (response) {
                        self.ruleNCD = response.data;
                        console.log(response);
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
        },
        showRule: function (rule, $event) {
            this.rule = rule;
            console.log($event);
        }
    }
});