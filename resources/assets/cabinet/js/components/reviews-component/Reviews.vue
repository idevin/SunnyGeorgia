<script>
    import ReviewForm from "../reviews-component/ReviewForm";
    import ReviewsTable from "../ReviewsTable";
    export default {
        components: {ReviewsTable, ReviewForm},
        data() {
            return {
                loading: false,
                name: '',
                country: '',
                avatar: '',
                rating: '',
                date: '',
                published: false,
                reviewText: '',
                reviewData: {

                }
            }
        },
        watch: {

        },
        methods: {},
    }
</script>
