/*
    Numero minimo di stanze
    Numero minimo di posti letto
    Modificare il raggio di default di 20km
    La presenza obbligatoria di uno o più dei servizi aggiuntivi indicat
*/
import Vue from 'vue'

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
        getApartmentsFiltered() {

            let comfortIdString = '';
            this.checkedComfortsId.forEach(id => {
                comfortIdString += id;
            });

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
        //Get the array of the data attributes of the selected element
        const locationData = document.getElementById('location-data').dataset;

        //get the index of the comma in the coordinates
        const commaIndex = locationData.locationCoordinates.indexOf(',');

        this.locationName = locationData.locationName.replace(/__/g, ' ');
        this.locationCoordinates = {
            lat: locationData.locationCoordinates.substring(0, commaIndex),
            lon: locationData.locationCoordinates.substring(commaIndex + 1)
        };
    }

})
