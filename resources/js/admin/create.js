import Vue from 'vue';
import tt from '@tomtom-international/web-sdk-services';

if (document.getElementById('create-apartment')) {
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
            errors: []
        },
        methods: {
            submitForm() {
                this.errors = [];

                window.scrollTo(0, 0);

                if (!this.title) {
                    this.errors.push('Il titolo è un campo obbligatorio');
                } else if (this.title.length > 255) {
                    this.errors.push('Il titolo non può essere più lungo di 255 caratteri');
                }

                if (!this.roomsNumber) {
                    this.errors.push('Il numero di stanze è un campo obbligatorio');
                } else if (this.roomsNumber <= 0) {
                    this.errors.push('Il numero di stanze dev\'essere maggiore di zero');
                } else if (this.roomsNumber > 255) {
                    this.errors.push('Il numero di stanze non può essere maggiore di 255');
                }

                if (!this.sleepsAccomodations) {
                    this.errors.push('Il numero di posti letto è un campo obbligatorio');
                } else if (this.sleepsAccomodations <= 0) {
                    this.errors.push('Il numero di posti letto dev\'essere maggiore di zero');
                } else if (this.sleepsAccomodations > 255) {
                    this.errors.push('Il numero di posti letto non può essere maggiore di 255');
                }

                if (!this.bathroomsNumber) {
                    this.errors.push('Il numero di bagni è un campo obbligatorio');
                } else if (this.bathroomsNumber <= 0) {
                    this.errors.push('Il numero di bagni dev\'essere maggiore di zero');
                } else if (this.bathroomsNumber > 255) {
                    this.errors.push('Il numero di bagni non può essere maggiore di 255');
                }

                if (!this.mq) {
                    this.errors.push('Il numero di metri quadrati è un campo obbligatorio');
                } else if (this.mq <= 0) {
                    this.errors.push('Il numero di metri quadrati dev\'essere maggiore di zero');
                } else if (this.mq > 255) {
                    this.errors.push('Il numero di metri quadrati non può essere maggiore di 255');
                }

                if (!this.streetName) {
                    this.errors.push('Il nome della via è un campo obbligatorio');
                }

                if (!this.streetNumber) {
                    this.errors.push('Il numero della via è un campo obbligatorio');
                } else if (this.streetNumber <= 0) {
                    this.errors.push('Il numero della via dev\'essere maggiore di zero');
                }

                if (!this.municipality) {
                    this.errors.push('La città è un campo obbligatorio');
                }

                if (!this.pricePerNight) {
                    this.errors.push('Il prezzo per notte è un campo obbligatorio');
                } else if (this.pricePerNight < 0) {
                    this.errors.push('Il prezzo per notte non può essere negativo');
                } else if (this.pricePerNight > 9999.99) {
                    this.errors.push('Il prezzo per notte non può superare i 9999.99 euro');
                }

                if (!this.availableTypes.includes(this.$refs.inputFile.files[0].type)) {
                    this.errors.push('L\'immagine deve essere di uno dei seguenti tipi: jpeg, png, jpg, gif, svg');
                }

                if (this.description.length > 65535) {
                    this.errors.push('La descrizione non può superare i 65535 caratteri');
                }

                tt.services.structuredGeocode({
                    key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
                    countryCode: 'IT',
                    bestResult: true,
                    streetName: this.streetName,
                    streetNumber: this.streetNumber,
                    municipality: this.municipality
                }).then(response => {
                    this.latitude = response.position.lat;
                    this.longitude = response.position.lng;
                    this.$nextTick(() => {
                        if (!this.errors.length) {
                            this.$refs.createApartment.submit();
                        }
                    });
                }).catch(error => {
                    this.errors.push('L\'indirizzo non è valido');
                });
            }
        }
    });
}
