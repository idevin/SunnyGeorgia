<template>
    <div v-if="tours.length">
        <tours-list-item
                v-for="tour in tours"
                :tour="tour"
                :route-view="routeView"
                :key="tour.id"
                :currency-code="currencyCode"
        ></tours-list-item>
        <div class="paginator-block"
             v-if="pageCount > 1"
        >
            <span v-if="currentPage > 1"
                  @click="emitChanges(--currentPage)"
                  class="paginator-block__item-prev">
                <svg width="7" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M4.2 247.5L151 99.5c4.7-4.7 12.3-4.7 17 0l19.8 19.8c4.7 4.7 4.7 12.3 0 17L69.3 256l118.5 119.7c4.7 4.7 4.7 12.3 0 17L168 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 264.5c-4.7-4.7-4.7-12.3 0-17z" class=""></path>
                </svg>
            </span>
            <span v-for="page in pageCount"
                  class="paginator-block__item"
                  :class="{'paginator-block__item_active': currentPage === page}"
                  @click="emitChanges(page)"
            >{{page}}</span>
            <span v-if="currentPage < pager.last_page"
                  @click="emitChanges(++currentPage)"
                  class="paginator-block__item-next">
                <svg width="7" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="svg-inline--fa fa-angle-right fa-w-6"><path fill="currentColor" d="M187.8 264.5L41 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 392.7c-4.7-4.7-4.7-12.3 0-17L122.7 256 4.2 136.3c-4.7-4.7-4.7-12.3 0-17L24 99.5c4.7-4.7 12.3-4.7 17 0l146.8 148c4.7 4.7 4.7 12.3 0 17z" class=""></path>
                </svg>
            </span>
        </div>
    </div>
</template>
<script>
import ToursListItem from "./ToursListItem";
import ApiFilter from '../../../api/Filter'
export default {
    components: {ToursListItem},
    props: [
        'routeView',
        'routeIndex',
        'currencyCode'
    ],
    data() {
        return {
            currentPage: null,
            tours: [],
            pager: {}
        }
    },
    computed: {
        pageCount(){
            return Math.ceil(this.pager.total/this.pager.per_page);
        }
    },
    methods: {
        emitChanges(page){
            this.$emit('change', page)
        },
        getTours() {
            ApiFilter.getFilteredTours(window.location.search)
                .then((response) => {
                    if(response.data.total) {
                        const {data, ...pager} = response.data;
                        this.tours = data;
                        this.pager = pager;
                        this.currentPage = this.pager.current_page;
                        this.$emit('total', this.pager.total)
                    } else {
                        console.log('no results');
                        this.tours = [];
                        this.pager = {};
                        this.currentPage = null;
                        this.$emit('total', 0)
                    }
                })
                .catch(error => {
                    console.error(error)
                });
        }
    },
    created() {
        this.getTours()
    }
}
</script>
