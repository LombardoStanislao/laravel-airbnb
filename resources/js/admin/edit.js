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
        address,
        pricePerNight,
        availableTypes: [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/gif',
            'image/svg'
        ],
        description,
        submitted: false,
        noAdressFound: false,
        mainImageValid: true,
        numOldSecondaryImages: parseInt(numOldSecondaryImages),
        oldSecondaryImagesValid: true,
        newSecondaryImagesValid: true,
        numNewSecondaryImages: 0,
        allComforts: [],
        invalidComforts: []
    },
    mounted() {
        axios.get('/api/getAllComforts').then((response) => {
            this.allComforts = response.data.results;
        });

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

            this.invalidComforts = [];

            var titleValid = this.title && this.title.length <= 255;
            var roomsNumberValid = this.roomsNumber && this.roomsNumber >= 1 && this.roomsNumber <= 255;
            var sleepsAccomodationsValid = this.sleepsAccomodations && this.sleepsAccomodations >= 1 && this.sleepsAccomodations <= 255;
            var bathroomsNumberValid = this.bathroomsNumber && this.bathroomsNumber >= 1 && this.bathroomsNumber <= 255;
            var mqValid = this.mq && this.mq >= 1 && this.mq <= 255;
            var streetNameValid = this.streetName;
            var streetNumberValid = this.streetNumber && this.streetNumber >= 1;
            var mucipalityValid = this.municipality;
            var pricePerNightValid = this.pricePerNight && this.pricePerNight >= 0 && this.pricePerNight <= 9999.99;
            var descriptionValid = this.description.length <= 65535;

            if (this.$refs.mainImage.files[0]) {
                this.mainImageValid = this.availableTypes.includes(this.$refs.mainImage.files[0].type);
            }

            for (var i = 0; i < this.numOldSecondaryImages; i++) {
                if (this.$refs['oldSecondaryImages' + i].files[0]) {
                    this.oldSecondaryImagesValid = this.availableTypes.includes(this.$refs['oldSecondaryImages' + i].files[0].type);
                }
            }

            if (this.$refs.newSecondaryImages) {
                this.numNewSecondaryImages = this.$refs.newSecondaryImages.files.length;

                if (this.numNewSecondaryImages) {
                    Array.from(this.$refs.newSecondaryImages.files).forEach(file => {
                        this.newSecondaryImagesValid = this.availableTypes.includes(file.type);
                    });
                }
            }

            for (var i = 0; i < this.allComforts.length; i++) {
                if (this.$refs['comfort' + i].checked && this.allComforts[i].id != this.$refs['comfort' + i].value) {
                    this.invalidComforts.push(i);
                }
            }

            var comfortsValid = !this.invalidComforts.length;

            var noErrors = titleValid && roomsNumberValid && sleepsAccomodationsValid && bathroomsNumberValid && mqValid && streetNameValid && mucipalityValid && pricePerNightValid && this.mainImageValid && this.oldSecondaryImagesValid && this.newSecondaryImagesValid && this.numNewSecondaryImages <= (4-this.numOldSecondaryImages) && comfortsValid && descriptionValid;

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
                            this.$refs.editApartment.submit();
                        }
                    });
                });

            }).catch(error => {
                this.noAdressFound = true;
            });
        }
    },
    mounted() {

        document.querySelectorAll(".drop-zone__input").forEach(inputElement =>{

            const dropZoneElement = inputElement.closest(".drop-zone");

            dropZoneElement.addEventListener("click", e =>{
                inputElement.click();
            });

            dropZoneElement.addEventListener("change", e =>{
                if(inputElement.files.length){
                    updateThumbnail(dropZoneElement, inputElement.files[0]);
                }
            });

            dropZoneElement.addEventListener("dragover", e =>{
                e.preventDefault();
                dropZoneElement.classList.add("drop-zone--over");
            });

            ["dragleave", "dragend"].forEach(type => {
                dropZoneElement.addEventListener(type, e =>{
                    dropZoneElement.classList.remove('drop-zone--over');
                });
            });

            dropZoneElement.addEventListener("drop", e =>{
                e.preventDefault();

                if(e.dataTransfer.files.length){
                    inputElement.files = e.dataTransfer.files;
                    console.log(inputElement.files);
                    updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                }

                dropZoneElement.classList.remove("drop-zone--over");

            });

        });

        function updateThumbnail(dropZoneElement, file){
            console.log(dropZoneElement);
            console.log(file);
            let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

            if(dropZoneElement.querySelector(".drop-zone__prompt")){
                dropZoneElement.querySelector(".drop-zone__prompt").remove();
            }

            //add file in drop-area
            if(!thumbnailElement){
                thumbnailElement = document.createElement("div");
                thumbnailElement.classList.add("drop-zone__thumb");
                dropZoneElement.appendChild(thumbnailElement);
                var imgTag = document.createElement("img");
                thumbnailElement.appendChild(imgTag);

            }

            //show file name
            thumbnailElement.dataset.label = file.name;

            //show image
            if(file.type.startsWith("image/")){
                var reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload=()=>{

                    imgTag.src = reader.result;

                };

            }else{
                imgTag.src = null;
            }

        };

    }
});
