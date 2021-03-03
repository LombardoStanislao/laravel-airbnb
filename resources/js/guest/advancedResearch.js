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
        minimumRooms: 0,
        minimumSleepsAccomodations: 0,
        minimumBathrooms: 0,
        locationName: null,
        locationCoordinates: null,
        checkedComfortsId: [],
        apartments: null,
        sponsoredApartments: []
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
            if(this.minimumRooms < 0) {
                this.minimumRooms = 0;
            } else if (this.minimumRooms > 255) {
                this.minimumRooms = 255
            }

            if(this.minimumBathrooms < 0) {
                this.minimumBathrooms = 0;
            } else if (this.minimumBathrooms > 255) {
                this.minimumBathrooms = 255
            }

            if(this.minimumSleepsAccomodations < 0) {
                this.minimumSleepsAccomodations = 0;
            } else if (this.minimumSleepsAccomodations > 255) {
                this.minimumSleepsAccomodations = 255
            }

            if(!this.locationName) {
                this.getOriginalLocationName();
            }

            if(!this.radius || this.radius < 0) {
                this.radius = 500;
            }

            axios({
                url: 'http://localhost:8000/api/filteredSearch',
                method: 'get',
                params: {
                    radius: this.radius,
                    minimumRooms: this.minimumRooms,
                    minimumSleepsAccomodations: this.minimumSleepsAccomodations,
                    minimumBathrooms: this.minimumBathrooms,
                    locationName: this.locationName,
                    comfortIdString: comfortIdString
                }
            }).then(response => {
                this.apartments = response.data.results;

                this.sponsoredApartments = [];

                this.apartments.forEach(apartment => {
                    this.isSponsored(apartment.id);
                });

                this.toggleFilterDropdown();
            });

        },
        toggleFilterDropdown() {
            let element = document.getElementById('dropdown-filters-menu');
            element.classList.toggle('d-none');
        },
        clearFilters() {
            this.radius = 20000;
            this.minimumRooms = 0;
            this.minimumBathrooms = 0;
            this.minimumSleepsAccomodations = 0;
            this.checkedComfortsId = [];
        },
        async isSponsored(apartmentId) {
            await axios({
                url: 'http://localhost:8000/api/isSponsored',
                method: 'get',
                params: {
                    apartmentId: apartmentId
                }
            }).then(response => {
                if (response.data.result) {
                    this.sponsoredApartments.push(apartmentId);
                }
            });
        },
        openMenu() {
            document.getElementById('user-dropdown-menu').classList.toggle("open");
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

        document.getElementById('user-icon').addEventListener("click", this.openMenu);
    }

})
