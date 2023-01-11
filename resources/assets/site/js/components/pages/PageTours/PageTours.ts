import Vue       from 'vue';
import Component from 'vue-class-component';
import { Watch } from 'vue-property-decorator';
import axios from "axios"

import './page-tours.scss';

const qs = require('qs');
import vueSlider from 'vue-slider-component'

/*export interface Tour {
    title: string;
    slug: string;
    place: {
        name: string
    };
    days: number;
    nights: number;
    thumb: {
        url: string
    };
    images: String[];
    ribbons: String[];
    food_options: String[];
    accommodations: String[];



}*/

@Component({
    template: require('./page-tours.html'),
    props: {
        toursSrc: String,
        routeView: String,
        routeIndex: String,
        maxPrice: String,
        jsonPlaces: String,
    },
    components: {
        vueSlider
    },
    filters: {
        viewUrl(slug, routeView) {
            return routeView.replace(':slug', slug);
        },
    }

})
export class PageTours extends Vue {
    // Props
    toursSrc;
    routeView;
    routeIndex;
    maxPrice;
    jsonPlaces;


    // Data
    loadingContent: boolean = true;
    totalFound: number = 0;



    //tours: any = this.searchTours();
    tours: any;
    _source: any;



    filterParams: any;

    show: any;
    durations: any;
    price: any;


    checkedDurations: any;
    filterOptions: any;

    //Computed
    get loading() {
        return this.$store.getters.loading
    }

    get currencyCode() {
        return this.$store.getters.currency
    }

    get places() {
        return JSON.parse(this.jsonPlaces);
    }


    get searchstr() {
        return window.location.search.substring(1);
    }


    get gueryobj() {
        return qs.parse(this.searchstr);
    }



    get startDate(){
        let d = new Date();
        return ('0' + d.getDate()).slice(-2) + "." + ('0' + (d.getMonth() + 1)).slice(-2) + "." + d.getFullYear();
    }

    //Methods

    querystr() {
        return "?"+ qs.stringify(this.gueryobj)
    }

    onFilterReset() {

    }

    filterChange() {

    }

    //@Watch('placeFrom')
    locationHref() {
        let url = location.href.split("?");
        window.history.pushState("","", url[0]+ this.querystr());
        this.searchTours();
    }

    changeFormParam(param, value) {
        this.gueryobj[param] = value;
        this.locationHref();
    }


    created() {
        this.filterParams = {
            placeFrom: (this.gueryobj.placeFrom == undefined)? "" : this.gueryobj.placeFrom,
            filterDate: (this.gueryobj.date == undefined)?  this.startDate : this.gueryobj.date,
            checkedDurations: []
        };

        this.tours = [];
        this.show = [];
        this.checkedDurations = [];
        this.filterOptions = {};
        this.durations = {
            short: {
                from: 1,
                    to: 4
            },
            average: {
                from: 5,
                    to: 9
            },
            long: {
                from: 10,
                    to: ''
            }
        };
        
        this.price = {
            options: {
                value: [],
                    tooltipDir: ['bottom', 'top'],
                    min: 1,
                    max: null
            }
        };
        this.searchTours();
    }



    //Translate i18n
    trans(value) {
        return this.$i18n.t(value, this.$store.getters.locale);
    }


    //Search Tours
    searchTours() {
        this.loadingContent = true;
        if (typeof this._source != typeof undefined) {
            this._source.cancel('Operation canceled due to new request.')
        }
        this._source = axios.CancelToken.source();
        console.log(this.querystr());
        axios.get(this.routeIndex + this.querystr(), {
                cancelToken: this._source.token,
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {}
        }).then((response) => {
            if (typeof response != typeof undefined) {
                this.loadingContent = false;
                this.tours = response.data.tours;
                this.totalFound = response.data.totalFound;
            }
        }).catch(error => {
            if (axios.isCancel(error)) {
                console.log('Request canceled', error);
            } else {
                console.log(error);
            }
        });
    }










    tourImg(k) {
        if (this.tours[k].thumb != undefined) {
            if (this.tours[k].thumb.url != undefined) {
                return this.tours[k].thumb.url
            }
        }
        if (this.tours[k].images.length > 0) {
            if (this.tours[k].images[0].url != undefined) {
                return this.tours[k].images[0].url
            }
        }
        return "/static/images/assets/cards/card1.jpg"
    }


    rybbon(k) {
        if (this.tours[k].ribbons.length > 0) {
            return this.tours[k].ribbons[0]
        }
        return false
    }

    tourFood(k) {
        let food = "";
        this.tours[k].food_options.forEach((f) => {
            food += f.title + ', ';
        });
        return food.slice(0, -2);
    }

    tourAccommodation(k) {
        let accommodation = "";
        this.tours[k].accommodations.forEach((a) => {
            accommodation += a.hotel + ', ';
        });
        return accommodation.slice(0, -2);
    }

    tourMinPrice(k) {
        let minPrice = 0;
        this.tours[k].accommodations.forEach((a) => {
            minPrice = (minPrice > a.price_adult || minPrice == 0) ? a.price_adult : minPrice;
        });

        return minPrice
    }

    durs(k) {
        let res = (this.durations.length > 0) ? (this.show.indexOf(k) < 0) ? false : true : true;
        return res;
    }

    opts() {
        let res = true;
        return res;
    }
}