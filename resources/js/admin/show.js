import Vue from 'vue';
import Chart from 'chart.js';
import tt from '@tomtom-international/web-sdk-services';

var show = new Vue({
    el: '#show-apartment',
    data: {
        latitude,
        longitude,
        adress: ''
    },
    mounted() {
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
            type: 'line',
            data: {
                labels: ['Data pubblicazione annuncio', '','','', 'Oggi'],
                datasets: [{
                    label: 'visualizzazioni',
                    data: [0, 15, 3, 5, 2, 3],//valori
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
