<script>
    import clickOutside from '../../../directives/clickOutside'
    import {stringify} from 'qs'
    import dateFormat from 'dateformat'

    export default {
        name: 'search-tours-form',
        props: {
            'action-url': {
                type: String,
                default: 'ru/tours'
            }
        },
        directives: {clickOutside},
        data() {
            return {
                dropdown: false,
                openSelect: false,
                selectedDate: null,
                days: [],
                selectDaysText: '',
            }
        },
        methods: {
            selectDays(event, from, to) {
                if (!from) {
                    this.days = []
                } else {
                    this.days[0] = from;
                    this.days[1] = to ? to : '';
                }
                this.selectDaysText = event.target.innerText;
                this.openSelect = false
            },
            closeSelect(event) {
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
              let params = {};
              if(this.selectedDate) {
                params.date =  [
                  dateFormat(this.selectedDate.start, 'isoDate'),
                  dateFormat(this.selectedDate.end, 'isoDate')
                ]
              }
              if(this.days[0] || this.days[1]) {
                params.duration = [this.days[0], this.days[1]];
              }
                const query = stringify(params, {
                    encode: false,
                    arrayFormat: 'indices',
                    addQueryPrefix: true
                });
                window.location.href = this.actionUrl + query
            }
        }
    }
</script>
