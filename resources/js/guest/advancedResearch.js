/*
    Numero minimo di stanze
    Numero minimo di posti letto
    Modificare il raggio di default di 20km
    La presenza obbligatoria di uno o più dei servizi aggiuntivi indicat
*/
import Vue from 'vue';
import tt from '@tomtom-international/web-sdk-services';

const advancedResearch = new Vue({
    el: '#root',
    data: {
        radius: 20000,
        minimumRooms: 1,
        minimumSleepsAccomodations: 1,
        locationName: null,
        locationCoordinates: null,
        checkedComfortsId: [],
        apartments: null
    },
    methods: {
        getAddress(long,lat){
            tt.services.reverseGeocode({
                key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
                position: {longitude: long, latitude: lat}
            }).then(response => {
                console.log(response.addresses[0].address);
                address = response.addresses[0].address.freeformAddress;
                return address;
            })

        },
        getOriginalLocationName(){
            const locationData = document.getElementById('location-data').dataset;
            this.locationName = locationData.locationName.replace(/__/g, ' ');
        },
        getApartmentsFiltered() {

            let comfortIdString = '';
            this.checkedComfortsId.forEach(id => {
                comfortIdString += id;
            });
            // Validazione
            if(!this.minimumRooms) {
                this.minimumRooms = 1;
            } else if (this.minimumRooms > 255) {
                this.minimumRooms = 255
            }

            if(!this.minimumSleepsAccomodations) {
                this.minimumSleepsAccomodations = 1;
            } else if (this.minimumSleepsAccomodations > 255) {
                this.minimumSleepsAccomodations = 255
            }

            if(!this.locationName) {
                this.getOriginalLocationName();
            }

            axios({
                url: 'http://localhost:8000/api/filteredSearch',
                method: 'get',
                params: {
                    radius: this.radius,
                    minimumRooms: this.minimumRooms,
                    minimumSleepsAccomodations: this.minimumSleepsAccomodations,
                    locationName: this.locationName,
                    comfortIdString: comfortIdString
                }
            }).then(response => {
                this.apartments = response.data.results;
            });
        }

    },
    mounted() {
        this.getOriginalLocationName()
        //Get the array of the data attributes of the selected element
        const locationData = document.getElementById('location-data').dataset;
        //get the index of the comma in the coordinates
        let commaIndex = locationData.locationCoordinates.indexOf(',');
        this.locationCoordinates = {
            lat: locationData.locationCoordinates.substring(0, commaIndex),
            lon: locationData.locationCoordinates.substring(commaIndex + 1)
        };
    }

})
