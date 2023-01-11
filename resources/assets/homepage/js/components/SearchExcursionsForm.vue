<script>
    import clickOutside from '../../../directives/clickOutside'
    import {stringify} from 'qs'
    import dateFormat from 'dateformat'

    export default {
        name: 'search-excursions-form',
        props: {
            'action-url': {
                type: String,
                default: ''
            }
        },
        directives: { clickOutside },
        data() {
            return {
                dropdown: false,
                openSelect: false,
                selectedDate: null,
                placeId: null,
                selectPlaceText: '',
            }
        },
        mounted() {
            this.$refs.component.style.display = 'flex'
        },
        methods: {
            selectPlace(event, placeId) {
                this.placeId = placeId;
                this.selectPlaceText = event.target.innerText;
                this.openSelect = false
            },
            closeSelect (event) {
                let flag = true;
                event.path.forEach(function (e) {
                    if (e.className === 'search-block__forms-item-content') {
                        flag = false;
                        return false;
                    }
                })
                if (flag) this.openSelect = false
            },
            submit() {
                if(! this.selectedDate) {
                    this.selectedDate = new Date(Date.now() + 1000*60*60*24) //плюс день
                }
                let params = stringify({
                    place: this.placeId,
                    date: dateFormat(this.selectedDate, 'isoDate'),
                }, {
                    encode: false,
                    arrayFormat: 'indices',
                    addQueryPrefix: true
                });
                window.location.href = this.actionUrl + params
            }
        }
    }
</script>
