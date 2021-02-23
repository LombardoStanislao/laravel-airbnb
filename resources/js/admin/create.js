import Vue from 'vue';
import tt from '@tomtom-international/web-sdk-services';

var create = new Vue({
    el: '#create-apartment',
    data: {
        title: '',
        roomsNumber: 1,
        sleepsAccomodations: 1,
        bathroomsNumber: 1,
        mq: null,
        streetName: '',
        streetNumber: null,
        municipality: '',
        latitude: null,
        longitude: null,
        address: '',
        pricePerNight: null,
        availableTypes: [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/gif',
            'image/svg'
        ],
        comforts: [],
        description: '',
        submitted: false,
        noAdressFound: false,
        mainImageType: null,
        mainImageValid: true,
        secondaryImagesValid: true,
        numSecondaryImages: 0
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

            if (this.$refs.mainImage.files[0]) {
                this.mainImageType = this.$refs.mainImage.files[0].type;
                this.mainImageValid = this.availableTypes.includes(this.mainImageType);
            } else {
                this.mainImageType = null;
                this.mainImageValid = true;
            }

            this.numSecondaryImages = this.$refs.secondaryImages.files.length;

            if (this.numSecondaryImages) {
                Array.from(this.$refs.secondaryImages.files).forEach(file => {
                    this.secondaryImagesValid = this.availableTypes.includes(file.type);
                });
            }

            var mainImageValid = this.mainImageType && this.mainImageValid;

            var descriptionValid = this.description.length <= 65535;
            var addressValid = this.address.length <= 255;

            var noErrors = titleValid && roomsNumberValid && sleepsAccomodationsValid && bathroomsNumberValid && mqValid && streetNameValid && mucipalityValid && pricePerNightValid && mainImageValid && this.numSecondaryImages <= 4 && this.secondaryImagesValid && descriptionValid;


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

                tt.services.reverseGeocode({
                    key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
                    position: {
                        longitude: this.longitude,
                        latitude: this.latitude
                    }
                }).then(response => {
                    var streetName = response.addresses[0].address.streetName;
                    var streetNumber = response.addresses[0].address.streetNumber;
                    var municipality = response.addresses[0].address.municipality;

                    this.address = `${streetName} ${streetNumber}, ${municipality}`;

                    this.$nextTick(() => {
                        if (noErrors) {
                            this.$refs.createApartment.submit();
                        }
                    });
                });

            }).catch(error => {
                this.noAdressFound = true;
            });
        }
    },
    mounted() {
        // let dropArea = document.getElementById('drop-area');
        //
        // dropArea.addEventListener('dragenter', handlerFunction, false);
        // dropArea.addEventListener('dragleave', handlerFunction, false);
        // dropArea.addEventListener('dragover', handlerFunction, false);
        // dropArea.addEventListener('drop', handlerFunction, false);
    }
});
