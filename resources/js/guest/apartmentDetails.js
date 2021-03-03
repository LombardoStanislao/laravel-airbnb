import Vue from 'vue';
import tt from '@tomtom-international/web-sdk-maps';

const APIKEY = 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC';

var app = new Vue({
    el: '#apartment-page',
    data: {
        apartmentId,
        home: [],
        map : {},
        marker: {},
        imgIndex: 0,
        nummberOfImages: 0,
        showMessageForm: false,
        sliderVisible: false,
        slidingDirection: ''
    },
    methods: {
        openMenu() {
            document.getElementById('user-dropdown-menu').classList.toggle("open");
        },
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
            document.getElementById('footer-apartment-details').classList.add('d-none');
            this.imgIndex = index;
        },
        hideSlider() {
            this.sliderVisible = false;
            document.getElementById('footer-apartment-details').classList.remove('d-none');
        },
        watchViewport() {
            if (window.innerWidth < 992) {
                this.sliderVisible = false;
                document.getElementById('footer-apartment-details').classList.remove('d-none');
            }
        },
        preventClosure() {
            event.stopPropagation();
        }
    },
    mounted() {
        document.getElementById('user-icon').addEventListener("click", this.openMenu);

        window.onresize = this.watchViewport;

        axios.get('/api/getApartment', {params: {id: this.apartmentId}}).then((response) => {
            this.home = [
                response.data.results.apartment.longitude,
                response.data.results.apartment.latitude
            ];

            this.nummberOfImages = response.data.results['apartment_secondary_images'].length + 1;

            this.map = tt.map({
                key: APIKEY,
                center: this.home,
                zoom: 14,
                container: 'map'
            });

            this.marker = new tt.Marker().setLngLat(this.home).addTo(this.map);
        });
    }
});
