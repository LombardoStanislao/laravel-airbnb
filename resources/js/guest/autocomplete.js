import Vue from 'vue';
import tt from '@tomtom-international/web-sdk-services';

const autocomplete = new Vue({
    el: '#header-form',
    data: {
        query: '',
        lastQuery: '',
        suggestions: []
    },
    methods: {
        searchSuggestions(event) {
            if(this.query != this.lastQuery || this.lastQuery == '') {
                this.fuzzySearch();
                this.lastQuery = this.query;
            }
        },
        fuzzySearch() {
            if(this.query) {
                tt.services.fuzzySearch({
                    key: 'uh1InUaJszlyTvCRilNBbn0pPm2ktvmD',
                    query: this.query,
                    countrySet: 'IT',
                    language: 'it-IT',
                    idxSet: 'Geo,Str',
                })
                .then(response => {
                    this.suggestions = [];
                    if(response.results.length) {
                        for (var i = 0; i < 4 && i < response.results.length; i++) {
                            this.suggestions.push({
                                place: response.results[i].address.freeformAddress,
                                type: response.results[i].type == "Geography" ? 'city' : 'road'
                            });
                        }
                    }
                });
            } else {
                this.suggestions = [];
            }
        },
        setQuery(place) {
            this.query = place;
            document.querySelector('#header-form input').focus();
        }
    }
});
