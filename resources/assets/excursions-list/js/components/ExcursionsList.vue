<template>
  <div v-if="excursions.length">
    <excursions-list-item
      :currency-code="currencyCode"
      :excursion="excursion"
      :key="excursion.id"
      :route-view="routeView"
      v-for="excursion in excursions"
      :current-place="currentPlace"
    ></excursions-list-item>
    <div class="paginator-block" v-if="pageCount > 1">
      <span @click="emitChanges(--currentPage)" class="paginator-block__item-prev" v-if="currentPage > 1">
        <svg aria-hidden="true" focusable="false" role="img" viewBox="0 0 192 512" width="7"
             xmlns="http://www.w3.org/2000/svg">
          <path
            class=""
            d="M4.2 247.5L151 99.5c4.7-4.7 12.3-4.7 17 0l19.8 19.8c4.7 4.7 4.7 12.3 0 17L69.3 256l118.5 119.7c4.7 4.7 4.7 12.3 0 17L168 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 264.5c-4.7-4.7-4.7-12.3 0-17z"
            fill="currentColor"
          ></path>
        </svg>
      </span>
      <span
        :class="{ 'paginator-block__item_active': currentPage === page }"
        @click="emitChanges(page)"
        class="paginator-block__item"
        v-for="page in pageCount"
      >{{ page }}</span
      >
      <span @click="emitChanges(++currentPage)" class="paginator-block__item-next" v-if="currentPage < pager.last_page">
        <svg
          aria-hidden="true"
          class="svg-inline--fa fa-angle-right fa-w-6"
          focusable="false"
          role="img"
          viewBox="0 0 192 512"
          width="7"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            class=""
            d="M187.8 264.5L41 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 392.7c-4.7-4.7-4.7-12.3 0-17L122.7 256 4.2 136.3c-4.7-4.7-4.7-12.3 0-17L24 99.5c4.7-4.7 12.3-4.7 17 0l146.8 148c4.7 4.7 4.7 12.3 0 17z"
            fill="currentColor"
          ></path>
        </svg>
      </span>
    </div>
  </div>
</template>
<script>
import ExcursionsListItem from './ExcursionsListItem';
import ApiFilter from '../../../api/Filter';

export default {
  components: { ExcursionsListItem },
  props: ['routeView', 'routeIndex', 'currencyCode', 'currentPlace'],
  data() {
    return {
      currentPage: null,
      excursions: [],
      pager: {},
    };
  },
  computed: {
    pageCount() {
      return Math.ceil(this.pager.total / this.pager.per_page);
    },
  },
  methods: {
    emitChanges(page) {
      this.$emit('change', page);
    },
    getExcursions() {
      ApiFilter.getFilteredExcursions(window.location.search)
        .then(response => {
          if (response.data.total) {
            const { data, ...pager } = response.data;
            this.excursions = data;
            this.pager = pager;
            this.currentPage = this.pager.current_page;
            this.$emit('total', this.pager.total);
          } else {
            console.log('no results');
            this.excursions = [];
            this.pager = {};
            this.currentPage = null;
            this.$emit('total', 0);
          }
        })
        .catch(error => {
          console.error(error);
        });
    },
  },
  created() {
    this.getExcursions();
  },
};
</script>
