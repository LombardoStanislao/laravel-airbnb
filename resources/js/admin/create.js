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
        allComforts: [],
        invalidComforts: [],
        noErrors: true
    },
    methods: {
        submitForm() {
            this.submitted = true;

            this.noErrors = true;

            window.scrollTo(0, 0);

            this.invalidComforts = [];

            this.secondaryImagesValid = true;

            var titleValid = this.title && this.title.length <= 255;
            var roomsNumberValid = this.roomsNumber && !isNaN(parseInt(this.roomsNumber)) && Number.isInteger(Number(this.roomsNumber)) && this.roomsNumber >= 1 && this.roomsNumber <= 255;
            var sleepsAccomodationsValid = this.sleepsAccomodations && !isNaN(parseInt(this.sleepsAccomodations)) && Number.isInteger(Number(this.sleepsAccomodations)) && this.sleepsAccomodations >= 1 && this.sleepsAccomodations <= 255;
            var bathroomsNumberValid = this.bathroomsNumber && !isNaN(parseInt(this.bathroomsNumber)) && Number.isInteger(Number(this.bathroomsNumber)) && this.bathroomsNumber >= 1 && this.bathroomsNumber <= 255;
            var mqValid = this.mq && !isNaN(parseInt(this.mq)) && Number.isInteger(Number(this.mq)) && this.mq >= 1 && this.mq <= 255;
            var streetNameValid = this.streetName;
            var streetNumberValid = this.streetNumber && !isNaN(parseInt(this.streetNumber)) && Number.isInteger(Number(this.streetNumber)) && this.streetNumber >= 1;
            var mucipalityValid = this.municipality;
            var pricePerNightValid = this.pricePerNight && !isNaN(parseInt(this.pricePerNight)) && this.pricePerNight >= 0 && this.pricePerNight <= 9999.99;

            if (this.$refs.mainImage.files[0]) {
                this.mainImageType = this.$refs.mainImage.files[0].type;
                this.mainImageValid = this.availableTypes.includes(this.mainImageType);
            } else {
                this.mainImageType = null;
                this.mainImageValid = true;
            }

            for (var i = 0; i < 4; i++) {
                if (this.$refs['secondaryImage' + i].files[0] && !this.availableTypes.includes(this.$refs['secondaryImage' + i].files[0].type)) {
                    this.secondaryImagesValid = false;
                }
            }

            var mainImageValid = this.mainImageType && this.mainImageValid;

            var descriptionValid = this.description.length <= 65535;


            for (var i = 0; i < this.allComforts.length; i++) {
                if (this.$refs['comfort' + i].checked && this.allComforts[i].id != this.$refs['comfort' + i].value) {
                    this.invalidComforts.push(i);
                }
            }

            var comfortsValid = !this.invalidComforts.length;

            this.noErrors = titleValid && roomsNumberValid && sleepsAccomodationsValid && bathroomsNumberValid && mqValid && streetNameValid && streetNumberValid && mucipalityValid && pricePerNightValid && mainImageValid && this.secondaryImagesValid && comfortsValid && descriptionValid;


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
                        if (this.noErrors) {
                            this.$refs.createApartment.submit();
                        }
                    });
                });

            }).catch(error => {
                this.noAdressFound = true;
                this.noErrors = false;
            });
        },
    },
    mounted() {
        axios.get('/api/getAllComforts').then((response) => {
            this.allComforts = response.data.results;
        });

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
            }else{
                dropZoneElement.removeChild(thumbnailElement);
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
