import Vue from 'vue';

var payment = new Vue({
    el: '#payment-form',
    data: {
        nonce: '',
        dropin: null
    },
    mounted() {
        var self = this;
        axios.get('/api/clientToken').then(response => {
            var clientToken = response.data.results;
            braintree.dropin.create({
                authorization: clientToken,
                selector: '#bt-dropin'
            }, function(createErr, instance) {
                self.dropin = instance;
            });
        });
    },
    methods: {
        submitForm() {
            var self = this;
            self.dropin.requestPaymentMethod(function(err, payload) {
                self.nonce = payload.nonce;
                self.$nextTick(() => {
                    self.$refs.paymentForm.submit();
                });
            });
        }
    }
});
