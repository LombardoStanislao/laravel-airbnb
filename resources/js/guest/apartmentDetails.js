import Vue from 'vue';
import tt from '@tomtom-international/web-sdk-maps';

const APIKEY = 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC';

var app = new Vue({
    el: '#apartment-page',
    data: {
        home: [longitude_js, latitude_js],
        map : {},
        marker: {},
        imgIndex: 0,
        nummberOfImages
    },

    methods: {
        prev() {
            this.imgIndex--;

            if (this.imgIndex < 0) {
                this.imgIndex = this.nummberOfImages-1;
            }
        },
        next() {
            this.imgIndex++;

            if (this.imgIndex > this.nummberOfImages-1) {
                this.imgIndex = 0;
            }
        }
    },
    // methods: {
    //     moveMap(lnglat) {
    //         this.map.flyTo({
    //             center: lnglat,
    //             zoom: 14
    //         });
    //     },
    //     handleResults(response) {
    //         if (response.results) {
    //             var position = response.results[0].position;
    //
    //             this.moveMap(position);
    //
    //             this.marker.remove();
    //
    //             this.marker = new tt.Marker().setLngLat(position).addTo(this.map);
    //         }
    //     },
    //     search() {
    //         TT.services.fuzzySearch({
    //             key: APIKEY,
    //             query: this.searchedAdress,
    //
    //         }).go().then(this.handleResults);
    //     },
    //     convertAdress() {
    //         TT.services.fuzzySearch({
    //             key: APIKEY,
    //             query: this.inputAdress
    //         }).go().then(response => {
    //             if (response.results) {
    //                 var position = response.results[0].position;
    //
    //                 this.latitude = position.lat;
    //                 this.longitude = position.lng;
    //             }
    //         });
    //     }
    // },
    mounted() {
        this.map = tt.map({
            key: APIKEY,
            center: this.home,
            zoom: 14,
            container: 'map'
        });

        this.marker = new tt.Marker().setLngLat(this.home).addTo(this.map);
    }
});
