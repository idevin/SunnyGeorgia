<script>
    import FadeTransition from "vue2-transitions/src/Fade/FadeTransition";
    import SlideXLeftTransition from 'vue2-transitions/src/Slide/SlideXLeftTransition';

    export default {
        props: ['days'],
        components: {SlideXLeftTransition, FadeTransition},
        data() {
            return {
                activeTab: 1
            }
        },
        methods: {
            prev() {
                if (this.activeTab > 1) {
                    --this.activeTab
                    const position = document.getElementById('dayItemWrap').offsetTop
                    window.scrollTo({
                        top: position,
                        behavior: "smooth"
                    });
                }
            },
            next() {
                if (this.activeTab < this.days) {
                    ++this.activeTab
                    const position = document.getElementById('dayItemWrap').offsetTop
                    window.scrollTo({
                        top: position,
                        behavior: "smooth"
                    });
                }
            }
        }
    }
</script>

<style lang="scss">
    .text-center {
        text-align: center;
    }
</style>
