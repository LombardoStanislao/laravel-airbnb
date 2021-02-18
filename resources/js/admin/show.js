import Vue from 'vue';
import Chart from 'chart.js';
import tt from '@tomtom-international/web-sdk-services';

var show = new Vue({
    el: '#show-apartment',
    data: {
        latitude,
        longitude,
        adress: '',
        apartmentId
    },
    mounted() {
        axios
        .get('/api/showViews', {
            params : {
                id : this.apartmentId
            }
        })
        .then((response) => {
            console.log(response.data.results);

            // var startingDate = new Date();
            //
            // startingDate.setMonth(startingDate.getMonth() - 5);
            //
            // startingDate = startingDate.getFullYear() + " " + ("0" + (startingDate.getMonth() + 1)).slice(-2);
            //
            // console.log(startingDate);
        });

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

            this.adress = `${streetName} ${streetNumber}, ${municipality}`;
        });

        var ctx = document.getElementById('chart').getContext('2d');
        var Mychart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Settembre',
                    'Ottobre',
                    'Novembre',
                    'Dicembre',
                    'Gennaio',
                    'Febbraio'
                ],
                datasets: [{
                    label: 'visualizzazioni',
                    data: [8, 15, 3, 5, 9, 3],//valori
                    backgroundColor: [
                        'rgba(155, 99, 255, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(155, 99, 255, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
});
