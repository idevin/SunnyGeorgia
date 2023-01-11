<template>
    <div class="sort-block">
        <div class="sort-block__selector-wrap">
            <select class="sort-block__selector"
                v-model="sort"
                    @change="emitChanges()"
            >
                <option value="price">{{'sort.Price: low' | trans}}</option>
                <option value="-price">{{'sort.Price: high' | trans}}</option>
                <option value="discount">{{'sort.Discounts' | trans}}</option>
                <option value="created_at">{{'sort.New' |trans}}</option>
                <option value="duration">{{'sort.Duration' |trans}}</option>
                <option value="-duration">{{'sort.-Duration' |trans}}</option>
            </select>
        </div>
        <div class="sort-block__result">{{'sort.Found' | trans}}: <strong>{{total}}</strong></div>
    </div>
</template>
<script>

export default {
    props: ['total', 'params'],
    data() {
        return {
            sort: 'price',
        }
    },
    methods: {
        emitChanges(){
            this.$emit('change', this.sort)
        },
    },
    created() {
        if(this.params) {
            this.sort = this.params
        }
    }
}
</script>
