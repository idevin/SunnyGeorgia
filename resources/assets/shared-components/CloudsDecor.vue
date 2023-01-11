<script>
    export default {
        name: "CloudsDecor",
        methods: {
            handleScroll() {
                let screenHeight = document.documentElement.clientHeight;
                let offsetBottom = this.$refs.mainBlock.getBoundingClientRect().bottom;
                let height = this.$refs.mainBlock.getBoundingClientRect().height;


                let topBorder = height + screenHeight;
                let bottomBorder = height / 2;
                if (offsetBottom < topBorder && offsetBottom > bottomBorder) {
                    this.$refs.decor.style.transform = 'translateY(' + 100 / (offsetBottom / 800) + 'px)';
                }

            }
        },
        mounted() {
            window.addEventListener('scroll', this.handleScroll);
            this.handleScroll()
        }
    }
</script>

<style scoped>

</style>
