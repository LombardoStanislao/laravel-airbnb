import Vue from 'vue';
import tt from '@tomtom-international/web-sdk-services';

var create = new Vue({
    el: '#edit-apartment',
    data: {
        title,
        roomsNumber,
        sleepsAccomodations,
        bathroomsNumber,
        mq,
        streetName: '',
        streetNumber: null,
        municipality: '',
        latitude,
        longitude,
        pricePerNight,
        availableTypes: [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/gif',
            'image/svg'
        ],
        comforts: [],
        description,
        submitted: false,
        noAdressFound: false,
        imageValid: true,
    },
    mounted() {
        tt.services.reverseGeocode({
            key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
            position: {
                longitude: this.longitude,
                latitude: this.latitude
            }
        }).then(response => {
            this.streetName = response.addresses[0].address.streetName;
            this.streetNumber = response.addresses[0].address.streetNumber;
            this.municipality = response.addresses[0].address.municipality;
        })
    },
    methods: {
        submitForm() {
            this.submitted = true;

            window.scrollTo(0, 0);

            var titleValid = this.title && this.title.length <= 255;
            var roomsNumberValid = this.roomsNumber && this.roomsNumber >= 1 && this.roomsNumber <= 255;
            var sleepsAccomodationsValid = this.sleepsAccomodations && this.sleepsAccomodations >= 1 && this.sleepsAccomodations <= 255;
            var bathroomsNumberValid = this.bathroomsNumber && this.bathroomsNumber >= 1 && this.bathroomsNumber <= 255;
            var mqValid = this.mq && this.mq >= 1 && this.mq <= 255;
            var streetNameValid = this.streetName;
            var streetNumberValid = this.streetNumber && this.streetNumber >= 1;
            var mucipalityValid = this.municipality;
            var pricePerNightValid = this.pricePerNight && this.pricePerNight >= 0 && this.pricePerNight <= 9999.99;
            if (this.$refs.inputFile.files[0]) {
                this.imageValid = this.availableTypes.includes(this.$refs.inputFile.files[0].type);
            }
            var descriptionValid = this.description.length <= 65535;

            var noErrors = titleValid && roomsNumberValid && sleepsAccomodationsValid && bathroomsNumberValid && mqValid && streetNameValid && mucipalityValid && pricePerNightValid && this.imageValid && descriptionValid;

            tt.services.structuredGeocode({
                key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
                countryCode: 'IT',
                bestResult: true,
                streetName: this.streetName,
                streetNumber: this.streetNumber,
                municipality: this.municipality
            }).then(response => {
                this.noAdressFound = false;
                this.latitude = response.position.lat;
                this.longitude = response.position.lng;
                this.$nextTick(() => {
                    if (noErrors) {
                        this.$refs.editApartment.submit();
                    }
                });
            }).catch(error => {
                this.noAdressFound = true;
            });
        }
    }
});