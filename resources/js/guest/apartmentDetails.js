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
        nummberOfImages,
        showMessageForm: false,
        sliderVisible: false,
        slidingDirection: ''
    },
    methods: {
        prev() {
            this.imgIndex--;

            this.slidingDirection = 'prev';

            if (this.imgIndex < 0) {
                this.imgIndex = this.nummberOfImages-1;
            }
        },
        next() {
            this.imgIndex++;

            this.slidingDirection = 'next';

            if (this.imgIndex > this.nummberOfImages-1) {
                this.imgIndex = 0;
            }
        },
        showSlider(index) {
            this.sliderVisible = true;
            this.imgIndex = index;
        },
        watchViewport() {
            if (window.innerWidth < 992) {
                this.sliderVisible = false;
            }
        },
        preventClosure() {
            event.stopPropagation();
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
        window.onresize = this.watchViewport;

        this.map = tt.map({
            key: APIKEY,
            center: this.home,
            zoom: 14,
            container: 'map'
        });

        this.marker = new tt.Marker().setLngLat(this.home).addTo(this.map);
    }
});

document.getElementById('user-icon').addEventListener("click", openMenu);

function openMenu() {
    document.getElementById('user-dropdown-menu').classList.toggle("open");
}
