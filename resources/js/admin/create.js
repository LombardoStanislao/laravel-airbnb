import Vue from 'vue';
import tt from '@tomtom-international/web-sdk-services';

if (document.getElementById('create-apartment')) {
    var create = new Vue({
        el: '#create-apartment',
        data: {
            streetName,
            streetNumber,
            municipality,
            latitude,
            longitude,
            errorAdress: false
        },
        methods: {
            convertAdress() {
                tt.services.structuredGeocode({
                    key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
                    countryCode: 'IT',
                    bestResult: true,
                    streetName: this.streetName,
                    streetNumber: this.streetNumber,
                    municipality: this.municipality
                }).then(response => {
                    this.errorAdress = false;
                    this.latitude = response.position.lat;
                    this.longitude = response.position.lng;
                    this.$nextTick(() => {
                        this.$refs.createApartment.submit();
                    });
                }).catch(error => {
                    this.errorAdress = true;
                });
            }
        }
    });
}
