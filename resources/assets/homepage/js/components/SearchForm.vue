<script>
    import SearchExcursionsForm from './SearchExcursionsForm'
    import SearchToursForm from './SearchToursForm'

    export default {
        name: 'search-form',
        components: {SearchExcursionsForm, SearchToursForm},
        data() {
            return {
                component: 'tours',
                dropdown: '',
            }
        },
        computed: {
            background() {
                return this.component === 'tours' ?
                    'static/images/assets/filterform/bg_tours.jpg' :
                    'static/images/assets/filterform/bg_excursions.jpg'
            }
        }
    }
</script>
