<template>
    <div class="place-info-manager">
        <div v-if="loading" class="place-info-manager__state" style="text-align: center;">
            <shared-loader></shared-loader>
        </div>
        <div v-if="!loading" class="place-info-manager__state">
            <form class="pim-form" @submit.prevent="onSubmit">

                <ul class="nav nav-tabs"
                    role="tablist">
                    <li class="nav-item m-tabs__item" v-for="lang in languages">
                        <a class="nav-link m-tabs__link"
                           :class="{'active': tabIsActive(lang.locale)}"
                           data-toggle="tab"
                           :href="'#m_portlet_tab_' + lang.locale" role="tab">
                            {{ lang.name }}
                            <span v-if="lang.locale === defaultLanguage">({{localization['Default']}})</span>
                        </a>
                    </li>
                </ul>
                <!-- START Tab Content-->
                <div class="tab-content">
                    <div class="tab-pane"
                         :class="{'active': tabIsActive(lang.locale)}"
                         :id="'m_portlet_tab_' + lang.locale"
                         v-for="lang in languages">

                        <div class="form-group row">
                            <div class="col-xm-12 col-sm-4 col-md-2 col-lg-2"></div>
                            <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                                <h3 class="m-form__section">
                                    1. {{localization['Place content']}}
                                </h3>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">{{localization['Title']}}:
                                <span
                                        style="color: red;"
                                        v-if="lang.locale == defaultLanguage"
                                >*</span></label>
                            <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                                <input class="form-control m-input"
                                       maxlength="255"
                                       type="text"
                                       :name="lang.locale + '[name]'"
                                       :required="lang.locale == defaultLanguage"
                                       v-model="translations[lang.locale].name"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">{{localization['Page content']}}:</label>
                            <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                                <tinymce
                                        :id="'editor_description_'+lang.locale"
                                        v-model="localTranslations[lang.locale].page"
                                        :options="tinymceOptions"
                                        :content="translations[lang.locale].page"
                                ></tinymce>
                            </div>
                        </div>

                        <template>

                            <hr>

                            <div class="form-group row">
                                <div class="col-xm-12 col-sm-4 col-md-2 col-lg-2">
                                </div>
                                <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                                    <h3 class="m-form__section">
                                        2. {{localization['Place meta fields']}}
                                    </h3>
                                </div>
                            </div>

                            <!-- START: Title -->
                                <div class="form-group row">
                                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" :for="'input_meta_title_'+lang.locale">
                                        Meta title:</label>
                                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                                        <input class="form-control m-input"
                                               :id="'input_meta_title_'+lang.locale"
                                               maxlength="254"
                                               type="text"
                                               v-model="meta[lang.locale].meta_title.main"
                                        >
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" :for="'input_meta_description_'+lang.locale">
                                        Meta description:</label>
                                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                                        <input class="form-control m-input"
                                               :id="'input_meta_description_'+lang.locale"
                                               maxlength="254"
                                               type="text"
                                               v-model="meta[lang.locale].meta_description.main"
                                        >
                                    </div>
                                </div>
                        </template>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-xm-12 col-sm-4 col-md-2 col-lg-2">
                    </div>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <h3 class="m-form__section">
                            3. {{localization['Place details']}}
                        </h3>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2">{{localization['Published']}}:</label>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <toggle-button v-model="place.published"
                                       :labels="{checked: localization['Yes'], unchecked: localization['No']}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="places_group_id"
                           class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">{{localization['Place group']}}:</label>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <select class="form-control m-input" name="places_group_id" id="places_group_id"
                                v-model="place.places_group_id">
                            <option :value="item.id" v-for="item in placesGroup">{{item.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">{{localization['Gallery']}}:</label>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <div v-if="true" class="images-list">
                            <div v-for="image in media" class="images-list__item">
                                <img
                                        :src="image.url"
                                        :alt="image.url"
                                        class="img-thumbnail" style="max-width: 100px; max-height: 100px">
                                <button @click.prevent="imageDelete(image)">
                                    ❌
                                </button>
                            </div>

                        </div>
                        <vue-transmit class="col-12 image-uploader"
                                      tag="section"
                                      :url="filesAction"
                                      :headers="transmit.headers"
                                      :params="transmit.params"
                                      v-bind="transmit.options"
                                      paramName="image[]"
                                      upload-area-classes="bg-faded"
                                      @success="onFileuploadSuccess"
                                      @error="onFileuploadError"
                                      :acceptedFileTypes="transmit.fileTypes"
                                      ref="uploader">
                            <div class="image-uploader__zone d-flex align-items-center justify-content-center w-100">
                                <span>{{localization['Click to download files or just drag them here']}}</span>
                            </div>
                            <!-- Scoped slot -->
                            <template slot="files" slot-scope="props">
                                <div v-for="(file, i) in props.files" :key="file.id" :class="{'mt-5': i === 0}">
                                    <div class="media">
                                        <img :src="file.dataUrl" class="img-fluid d-flex mr-3">
                                        <div class="media-body">
                                            <h4>{{ file.name }}</h4>
                                            <div class="progress" style="width: 100%">
                                                <div class="progress-bar bg-success"
                                                     :style="{width: file.upload.progress + '%'}"></div>
                                            </div>
                                            <div>{{ file.status }}</div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </vue-transmit>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lat"
                           class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">{{localization['Latitude']}}:</label>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <input
                                class="form-control m-input"
                                maxlength="10"
                                type="text"
                                id="lat"
                                name="lat"
                                v-model="place.lat"
                        >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="long"
                           class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">{{localization['Longitude']}}:</label>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <input
                                class="form-control m-input"
                                maxlength="10"
                                type="text"
                                id="long"
                                name="long"
                                v-model="place.long"
                        >
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-xm-12 col-sm-4 col-md-2 col-lg-2">
                    </div>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <button
                                class="btn btn-primary"
                                :class="{ 'm-loader' : sending, 'm-loader--light' : sending, 'm-loader--right' : sending }"
                                :disabled="sending"
                        >{{localization['Save']}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'formAction',
            'filesAction',
            'filesDelete',
            'localization'
        ],
        data() {
            return {
                localTranslations: {
                    en: {
                        page: ""
                    },
                    ru: {
                        page: ""
                    },
                    ka: {
                        page: ""
                    },
                },
                tinymceOptions: window.tinymce.mceOptions,
                transmit: {
                    headers: {"X-CSRF-TOKEN": ''},
                    fileTypes: ['.jpg', '.png', '.jpeg'],
                    maxFiles: 50,
                    maxFileSize: 2,
                    options: {
                        clickable: true
                    },
                    params: {
                        model: 'Place',
                        model_id: null
                    }
                },
                placesGroup: [],
                media: [],
                place: {},
                languages: [],
                translations: {
                    ru: {
                        name: ''
                    },
                    en: {
                        name: ''
                    },
                    ka: {
                        name: ''
                    }
                },
                meta: {
                    ru: {
                        meta_title: {main: "", excursion: "", tour:""},
                        meta_description: {main: "", excursion: "", tour:""}
                    },
                    en: {
                        meta_title: {main: "", excursion: "", tour:""},
                        meta_description: {main: "", excursion: "", tour:""}
                    },
                    ka: {
                        meta_title: {main: "", excursion: "", tour:""},
                        meta_description: {main: "", excursion: "", tour:""}
                    }
                },
                defaultLanguage: null,
                sending: false
            }
        },
        computed: {
            loading() {
                return this.$store.getters.loading
            },
        },
        watch: {
            place() {
                this.setTranslations();
                this.transmit.params.model_id = this.place.id;
            }
        },
        methods: {
            onSubmit() {
                var self = this
                self.sending = true


                for (let item in this.translations) {
                    if (this.localTranslations[item].page) {
                        this.translations[item].page = this.localTranslations[item].page
                    }

                    this.translations[item]["meta_title"] = JSON.stringify(this.meta[item]["meta_title"]);
                    this.translations[item]["meta_description"] = JSON.stringify(this.meta[item]["meta_description"]);
                }


                let formData = Object.assign({}, this.translations, this.place);
                delete formData.name;
                delete formData.page;
                delete formData.meta_title;
                delete formData.meta_description;


                axios.post(self.formAction, formData)
                    .then((response) => {
                        self.$toasted.success(this.localization['Changes saved'])
                        self.sending = false

                        if (response.data.place) {
                            self.place = response.data.place;
                        }
                    })
                    .catch((error) => {
                        self.$toasted.error(error)
                        self.sending = false
                    })
            },
            tabIsActive(lang) {
                return this.defaultLanguage === lang ? true : false
            },
            setTranslations() {
                for (let index in this.place.translations) {
                    this.translations[this.place.translations[index].locale] = this.place.translations[index];
                    this.meta[this.place.translations[index].locale]["meta_title"] = JSON.parse(this.place.translations[index]["meta_title"]);
                    this.meta[this.place.translations[index].locale]["meta_description"] = JSON.parse(this.place.translations[index]["meta_description"]);
                }
            },
            onFileuploadSuccess(event) {
                this.$toasted.success(this.localization['File successfully uploaded'])
            },
            onFileuploadError(error) {
                console.log(error)
                this.$toasted.error(this.localization['Error loading file'])
            },
            imageDelete(image) {
                let url = this.filesDelete.replace(':id', image.id);

                axios.delete(url)
                    .then((response) => {
                        this.$toasted.success(this.localization['File successfully deleted']);
                        this.media.splice(this.media.indexOf(image), 1)
                    })
                    .catch((error) => {
                        this.$toasted.error(error.response.data.message)
                    })
            },
            setTransmitToken() {
                this.transmit.headers["X-CSRF-TOKEN"] = document.getElementById('csrf-token').content
            }
        },
        created() {
            this.$store.dispatch('receiveLoading', true);
            document.addEventListener("DOMContentLoaded", () => {
                this.placesGroup = window.placesGroup;
                this.place = window.place;
                this.media = window.place.images;
                this.languages = window.languages;
                this.defaultLanguage = window.default_language;
                this.setTransmitToken();
                this.$store.dispatch('receiveLoading', false)
            })
        }
    }
</script>
