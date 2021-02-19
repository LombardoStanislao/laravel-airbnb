import Vue from 'vue';
import Chart from 'chart.js';
import tt from '@tomtom-international/web-sdk-services';

var show = new Vue({
    el: '#show-apartment',
    data: {
        latitude,
        longitude,
        adress: '',
        views,
        views_labels: [],
        views_data: [],
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

        //SEZIONE STATISTICHE

        var apartmentViews = JSON.parse(this.views.replace(/&quot;/g,'"'));
        console.log(apartmentViews);

        var months = [ "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre","Ottobre", "Novembre", "Dicembre" ];

        apartmentViews.forEach((view, i) => {

            var monthNumber = parseInt(view.created_at.substr(5, 2));
            var viewMonth = months[monthNumber-1];

            if (this.views_labels.includes(viewMonth)) {

                var monthPosition = this.views_labels.indexOf(viewMonth);
                this.views_data[monthPosition] = this.views_data[monthPosition]+1;

            }else{

                this.views_labels.push(viewMonth);
                var monthPosition = this.views_labels.indexOf(viewMonth);
                this.views_data[monthPosition]= 1;

            }

        });

        console.log(this.views_labels);
        console.log(this.views_data);
        var data = this.views_data.map(function(view_data){
            return view_data;
        });
        console.log(data);

        var ctx = document.getElementById('chart').getContext('2d');
        var Mychart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Data pubblicazione annuncio', '','','', 'Oggi'],
                datasets: [{
                    label: 'visualizzazioni',
                    data: [0, 15, 3, 5, 2, 3],//valori
                    backgroundColor: [
                        'rgba(155, 255, 55, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(155, 255, 55, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                    },
                    // {
                    //     label: 'messaggi',
                    //     data: [0, 15, 3, 5, 2, 3],
                    //     backgroundColor: [
                    //         'rgba(155, 99, 255, 0.2)',
                    //         'rgba(54, 162, 235, 0.2)',
                    //         'rgba(255, 206, 86, 0.2)',
                    //         'rgba(75, 192, 192, 0.2)',
                    //         'rgba(153, 102, 255, 0.2)',
                    //         'rgba(255, 159, 64, 0.2)'
                    //     ],
                    //     borderColor: [
                    //         'rgba(155, 99, 255, 1)',
                    //         'rgba(54, 162, 235, 1)',
                    //         'rgba(255, 206, 86, 1)',
                    //         'rgba(75, 192, 192, 1)',
                    //         'rgba(153, 102, 255, 1)',
                    //         'rgba(255, 159, 64, 1)'
                    //     ],
                    //     borderWidth: 1
                    // }
                ],
            },
            options: {                
                onClick: console.log('cliccato'),
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
