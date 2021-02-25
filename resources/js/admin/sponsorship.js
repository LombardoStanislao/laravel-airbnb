import Vue from 'vue';

var payment = new Vue({
    el: '#payment-form',
    data: {
        nonce: '',
        dropin: null,
        loaded: false,
        selectedSponsorship: undefined
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
                self.loaded = true;
            });
        });
    },
    methods: {
        submitForm() {
            document.getElementById("submitButton").setAttribute('disabled', 'disabled');
            var self = this;
            self.dropin.requestPaymentMethod(function(err, payload) {
                self.nonce = payload.nonce;
                self.$nextTick(() => {
                    self.$refs.paymentForm.submit();
                });
            });
        },
        selectSponsorship(id) {
            document.getElementById('sponsorship-' + id + '-input').checked = true;

            if (this.selectedSponsorship) {
                document.getElementById('sponsorship-' + this.selectedSponsorship + '-card').classList.remove('active');
            }

            document.getElementById('sponsorship-' + id + '-card').classList.add('active');

            this.selectedSponsorship = id;
        }
    }
});
