import './bootstrap';
import './scss/cabinet.scss'

import Vue          from 'vue'
import {store}      from './store'
import tinymce      from 'tinymce'
import Toasted      from 'vue-toasted'
import Vuelidate    from 'vuelidate'
import VueTransmit  from "vue-transmit"
import VueTour      from 'vue-tour'
import 'vue-tour/dist/vue-tour.css';
import VueTinymce   from 'vue-tinymce'
import LimitedTextarea from "../../shared-components/LimitedTextarea";
import Datepicker from "vuejs-datepicker";
import ToggleButton from 'vue-js-toggle-button'

Vue.use(ToggleButton);
Vue.use(VueTour);
Vue.use(VueTinymce);
Vue.use(Vuelidate);
Vue.use(VueTransmit);
Vue.use(Toasted, {
    containerClass: 'notification',
    className: 'notification__item',
    position: 'top-right',
    duration: 4000,
    action: [
        {
            text: 'Close',
            onClick: (e, toastObject) => {
                toastObject.goAway(0);
            }
        },
    ]
});

Vue.component('product-review', require('./components/ProductReview.vue').default);
Vue.component('avatar-component', require('./components/shared/AvatarComponent.vue').default);
Vue.component('bug-reporter',      require('./components/shared/BugReporter.vue').default);
Vue.component('shared-loader',     require('./components/shared/SharedLoader.vue').default);
Vue.component('tour-edit-helper',  require('./components/TourEditHelper.vue').default);
Vue.component('tour-edit',         require('./components/TourEdit.vue').default);
Vue.component('excursion-edit',    require('./components/ExcursionEdit.vue').default);
Vue.component('tour-booking',      require('./components/TourBooking.vue').default);
Vue.component('excursion-booking', require('./components/ExcursionBooking.vue').default);
Vue.component('place-edit',        require('./components/PlaceEdit.vue').default);
Vue.component('place-edit',        require('./components/PlaceEdit.vue').default);
Vue.component('table-data',        require('./components/TableData.vue').default);
Vue.component('reviews-table',     require('./components/ReviewsTable.vue').default);
Vue.component('excursion-order',   require('./components/ExcursionOrder').default);
Vue.component('tour-order',   require('./components/TourOrder').default);
Vue.component('limited-textarea', LimitedTextarea);
Vue.component('datepicker', Datepicker);

export const cabinetApp = new Vue({
    el: '#cabinet-app',
    store,
    created() {
        window.tinymce.baseURL = "/cabinet_js/tinymce/";
        window.tinymce.mceOptions = {
            plugins: [
                'lists preview fullscreen',
                'searchreplace wordcount visualblocks visualchars',
                'insertdatetime save table contextmenu directionality',
                'textpattern  toc code image link help  hr'
            ],
            menubar: false,
            toolbar: 'visualblocks code | undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | fullscreen ',
            block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4;',
            default_link_target: "_blank",
            link_assume_external_targets: true,
            link_title: false,
            link_context_toolbar: true,
            rel_list: [
                {title: 'no follow', value: 'nofollow'},
                {title: 'none', value: ''},
            ],
            min_height: 220,
            image_advtab: false,
            file_picker_types: 'image',
            automatic_uploads: true,
            //images_upload_url: '/cabinet/media/upload_tiny',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function () {

                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        // call the callback and populate the Title field with the file name
                        cb(blobInfo.blobUri(), { title: file.name });

                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },

            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '/cabinet/media/upload_tiny');

                xhr.setRequestHeader("X-CSRF-Token", window.Laravel.csrfToken);

                xhr.onload = function() {
                    var json;

                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
        };
        document.addEventListener("DOMContentLoaded", () => {
            if (window.Laravel) {
                if (window.Laravel.status && window.Laravel.msg) {
                    this.$toasted.show(window.Laravel.msg, {
                        type: window.Laravel.status
                    });
                }
                if (window.Laravel.errors) {
                    for (let i in window.Laravel.errors) {
                        // console.log(window.Laravel.errors[i]);
                        this.$toasted.show(window.Laravel.errors[i], {
                            type: 'error'
                        });
                    }
                }
            }
        });
    }
});
