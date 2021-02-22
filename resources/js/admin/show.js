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
        messages,
        apartmentViews: [],
        views_labels: [],
        views_data: [],
        data: [],
        chartselected: '',
        views_data_month: [],
        chartType: 'line',
        apartmentMessages: [],
        messages_labels: [],
        messages_data: [],
        data_m: [],
        messages_data_month: [],
    },
    methods: {

        yearOnChart(){

            this.views_labels=[];
            this.views_data=[];
            this.data=[];

            this.messages_labels=[];
            this.messages_data=[];

            this.apartmentViews.forEach((view, i) => {
                var year = parseInt(view.date_view.substr(0, 4));
                if (this.views_labels.includes(year)) {
                    var yearPosition = this.views_labels.indexOf(year);
                    this.views_data[yearPosition] = this.views_data[yearPosition]+1;
                }else{
                    this.views_labels.push(year);
                    var yearPosition = this.views_labels.indexOf(year);
                    this.views_data[yearPosition]= 1;
                }
            });

            var currentYear = new Date().getFullYear();
            if (!this.views_labels.includes(currentYear)) {
                this.views_labels.push(currentYear);
                this.views_data.push(0);
            }

            for (var i = 0; i < this.views_labels.length; i++) {
                for (var j = 0; j < this.views_labels.length-1; j++) {
                    if(this.views_labels[j + 1] < this.views_labels[j]) {
                        let tempYear = this.views_labels[j + 1];
                        let tempData = this.views_data[j + 1]
                        this.views_labels[j + 1]=this.views_labels[j];
                        this.views_data[j + 1]=this.views_data[j];
                        this.views_labels[j]=tempYear;
                        this.views_data[j]=tempData;
                    }
                }
            }

            this.data = this.views_data.map(function(view_data){
                return view_data;
            });

            this.apartmentMessages.forEach((message, i) => {
                var year = parseInt(message.date_message.substr(0, 4));
                var yearPosition = this.views_labels.indexOf(year);
                if (this.messages_data[yearPosition] == null) {
                    this.messages_data[yearPosition] = 1;
                }else{
                    this.messages_data[yearPosition] = this.messages_data[yearPosition]+1;
                }

            });

            for (var i = 0; i < this.views_labels.length; i++) {
                if(this.messages_data[i]==null){
                    this.messages_data[i]=0;
                }
            }
            this.data_m = this.messages_data.map(function(message_data){
                    return message_data;
            });

            this.yearChart();
        },

        monthsOnChart(yearSelected){
            this.views_data_month=[0,0,0,0,0,0,0,0,0,0,0,0];
            this.messages_data_month=[0,0,0,0,0,0,0,0,0,0,0,0];

            this.apartmentViews.forEach((view, i) => {
                var year = parseInt(view.date_view.substr(0, 4));
                if (yearSelected==year) {
                    let monthPosition = parseInt(view.date_view.substr(5, 7));
                    this.views_data_month[monthPosition-1]++;
                }
            });

            this.apartmentMessages.forEach((message, i) => {
                var year = parseInt(message.date_message.substr(0, 4));
                if (yearSelected==year) {
                    let monthPosition = parseInt(message.date_message.substr(5, 7));
                    this.messages_data_month[monthPosition-1]++;
                }
            });

            var data_views = this.views_data_month.map(function(view_data_month){
                return view_data_month;
            });
            var data_messages = this.messages_data_month.map(function(message_data_month){
                return message_data_month;
            });

            this.monthChart(data_views, data_messages);
        },

        yearChart(){


            var ctx = document.getElementById('chart').getContext('2d');
            if(window.bar != undefined)
            window.bar.destroy();
            window.bar = new Chart(ctx, {
                type: this.chartType,
                data: {
                    labels: this.views_labels,
                    datasets: [
                        {
                        label: 'visualizzazioni',
                        data: this.data,
                        backgroundColor: 'rgba(155, 255, 55, 0.2)',

                        borderColor:'rgba(155, 255, 55, 1)',
                        borderWidth: 1
                        },
                        {
                            label: 'messaggi',
                            data: this.data_m,
                            backgroundColor:'rgba(155, 99, 255, 0.2)',
                            borderColor:'rgba(155, 99, 255, 1)',
                            borderWidth: 1
                        }
                    ],
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
        },

        monthChart(data_views, data_messages){

            var ctx_2 = document.getElementById('monthchart').getContext('2d');
            if(window.bar != undefined)
            window.bar.destroy();
            window.bar = new Chart(ctx_2, {
                type: this.chartType,
                data: {
                    labels: [ "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre","Ottobre", "Novembre", "Dicembre" ],
                    datasets: [
                        {
                        label: 'visualizzazioni',
                        data: data_views,
                        backgroundColor:'rgba(155, 255, 55, 0.2)',
                        borderColor:'rgba(155, 255, 55, 1)',
                        borderWidth: 1
                        },
                        {
                            label: 'messaggi',
                            data: data_messages,
                            backgroundColor:'rgba(155, 99, 255, 0.2)',
                            borderColor:'rgba(155, 99, 255, 1)',
                            borderWidth: 1
                        },
                    ],
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
        },

        ChangeChartFilter(event) {
           console.log(event.target.value);
           if(event.target.value==''){
               this.yearOnChart();
           }else{
               this.monthsOnChart(event.target.value)
           }
       },

       changeChartType(){
           if (this.chartselected=='') {
               this.yearChart();
           }else{
               this.monthsOnChart(this.chartselected);
           }
       },
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

        //SEZIONE STATISTICHE

        this.apartmentViews = JSON.parse(this.views.replace(/&quot;/g,'"'));
        console.log(this.apartmentViews);
        this.apartmentMessages= JSON.parse(this.messages.replace(/&quot;/g,'"'));
        console.log(this.apartmentMessages);

        this.yearOnChart();
    }
});
