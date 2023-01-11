<script>
    import UserBlock from './auth/UserBlock'
    import UserBlockMobile from './auth/UserBlockMobile'

    export default {
        name: 'header-navigation',
        components: {UserBlock,UserBlockMobile},
        data() {
            return {
                mobileMenu:false
            }
        },
        methods:{
            mobileSubOpen(id){

                for(let key in this.$refs){
                    if(key==='mobile'+id) continue;
                    this.$refs[key].classList.remove('main-mobile-menu__item_visible');
                    this.$refs[key].classList.remove('main-mobile-menu__sub-item_visible');
                }
                this.$refs['mobile'+id].classList.toggle('main-mobile-menu__item_visible');
            },
            mobileSubSubOpen(id){
                for(let key in this.$refs){
                    if(key==='mobile-sub'+id) continue;
                    this.$refs[key].classList.remove('main-mobile-menu__sub-item_visible');
                }
                this.$refs['mobile-sub'+id].classList.toggle('main-mobile-menu__sub-item_visible');
            }
        }
    }
</script>
