<template>
  <div class="creating-and-editing-excursion">
    <div style="text-align: center;" v-if="loading">
      <shared-loader></shared-loader>
    </div>
    <div v-if="!loading">
      <form method="POST" ref="excursionForm" enctype="multipart/form-data">
        <template v-if="can('excursions-content-edit')">
          <div class="m-portlet">
            <div class="m-portlet__head">
              <div class="m-portlet__head-caption">
                <h3 class="m-portlet__head-title">1. {{ localization['Excursion content'] }}</h3>
              </div>
            </div>
            <div class="m-portlet__body">
              <div class="m-section">
                <div class="m-section__content">
                  <!-- Start Publish -->
                  <div class="form-group row">
                    <label class="col-md-2">Опубликовать</label>
                    <div class="col-md-10">
                      <toggle-button
                        :labels="{ checked: localization['Yes'], unchecked: localization['No'] }"
                        id="input_published"
                        v-model="excursion.published"
                      />
                    </div>
                  </div>
                  <!-- END Publish -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item m-tabs__item" v-for="lang in languages">
                      <a
                        :class="{ active: activeTab === lang.locale }"
                        @click="activeTab = lang.locale"
                        class="nav-link m-tabs__link"
                        role="tab"
                      >
                        {{ lang.name }}
                        <span v-if="lang.locale === 'ru'">({{ localization['Default'] }})</span>
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div
                      :class="{ active: activeTab === lang.locale }"
                      :id="'m_portlet_tab_' + lang.locale"
                      class="tab-pane"
                      v-for="(lang, index) in languages"
                    >
                      <template v-if="userRole && userRole === 'admin' && can('excursions-meta-edit')">
                        <!-- START: Title -->
                        <div class="form-group row">
                          <label :for="'input_meta_title_' + lang.locale"
                                 class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                            SEO заголовок
                            <span style="color: red;" v-if="lang.locale === 'ru'"> *</span>
                          </label>
                          <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                            <input
                              :id="'input_meta_title_' + lang.locale"
                              :name="'input_meta_title_' + lang.locale"
                              :required="lang.locale === 'ru'"
                              class="form-control m-input"
                              maxlength="254"
                              type="text"
                              v-model="translations[lang.locale].meta_title"
                            />
                          </div>
                        </div>
                        <div class="form-group row">
                          <label :for="'input_meta_description_' + lang.locale"
                                 class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                            SEO описание
                            <span style="color: red;" v-if="lang.locale === 'ru'"> *</span>
                          </label>
                          <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                            <limited-textarea
                              :id="'input_meta_description_' + lang.locale"
                              :max="254"
                              :name="'input_meta_description_' + lang.locale"
                              :required="lang.locale === 'ru'"
                              class-name="form-control m-input"
                              v-model="translations[lang.locale].meta_description"
                            ></limited-textarea>
                          </div>
                        </div>
                      </template>

                      <!-- START: Title -->
                      <div class="form-group row">
                        <label :for="'input_title_' + lang.locale"
                               class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label"
                        >{{ localization['Title'] }}:
                          <span style="color: red;" v-if="lang.locale === 'ru'"> *</span>
                        </label>
                        <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                          <input
                            :id="'input_title_' + lang.locale"
                            :name="'input_title_' + lang.locale"
                            :required="lang.locale === 'ru'"
                            class="form-control m-input"
                            maxlength="254"
                            type="text"
                            v-model="translations[lang.locale].title"
                          />
                        </div>
                      </div>
                      <!-- END: Title -->
                      <!-- START: Intro -->
                      <div class="form-group row">
                        <label :for="'input_intro_' + lang.locale"
                               class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                          {{ localization['Short description'] }}
                          <span style="color: red;" v-if="lang.locale === 'ru'"> *</span>
                        </label>
                        <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                          <textarea
                            :id="'input_intro_' + lang.locale"
                            :name="'input_intro_' + lang.locale"
                            :required="lang.locale === 'ru'"
                            class="form-control m-input"
                            rows="10"
                            v-model="translations[lang.locale].intro"
                          ></textarea>
                        </div>
                      </div>
                      <!-- END: Intro -->
                      <!-- START: Description -->
                      <div class="form-group row">
                        <label :for="'input_description_' + lang.locale"
                               class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                          {{ localization['Description'] }}
                          <template v-if="lang.locale === 'ru'">
                            <span style="color: red;"> *</span>
                            <input
                              :checked="!!translations[lang.locale].description"
                              required
                              style="height:1px;width:1px"
                              type="checkbox"
                            />
                          </template>
                        </label>
                        <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                          <tinymce
                            :content="descriptionContent[lang.locale].description"
                            :id="'editor_description_' + lang.locale"
                            :options="mceOptions"
                            v-model="translations[lang.locale].description"
                          ></tinymce>
                        </div>
                      </div>
                      <!-- END: Description -->

                      <!-- START: Start Place Name -->
                      <div class="form-group row">
                        <label :for="'input_start_place' + lang.locale"
                               class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                          {{ localization['Location of the excursion start'] }}
                          <span style="color: red;" v-if="lang.locale === 'ru'"> *</span>
                        </label>
                        <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                          <input
                            :id="'input_start_place' + lang.locale"
                            :name="'excursion_start_place' + lang.locale"
                            :required="lang.locale === 'ru'"
                            class="form-control m-input"
                            maxlength="254"
                            type="text"
                            v-model="translations[lang.locale].start_place"
                          />
                        </div>
                      </div>
                      <!-- END: Start Place Name -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template v-if="can('excursions-details-edit')">
          <div class="m-portlet">
            <div class="m-portlet__head">
              <div class="m-portlet__head-caption">
                <h3 class="m-portlet__head-title">2. {{ localization['Excursion details'] }}</h3>
              </div>
            </div>
            <div class="m-portlet__body">
              <div class="m-section">
                <div class="m-section__content">
                  <!-- START: Start Place Id -->
                  <div class="form-group row">
                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_place">
                      {{ localization['Departure point of the excursion'] }}
                      <span style="color: red;"> *</span>
                      <input
                        :checked="!!selectedStartPlaceObject"
                        name="input_place"
                        required
                        style="height:1px;width:1px"
                        type="checkbox"
                      />
                    </label>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                      <multiselect
                        :allow-empty="false"
                        :multiple="false"
                        :deselect-label="localization['Selected']"
                        :options="composerPlaces"
                        :searchable="true"
                        id="input_place"
                        label="name"
                        track-by="id"
                        v-model="selectedStartPlaceObject"
                      ></multiselect>
                    </div>
                  </div>
                  <!-- END: Start Place Id -->

                  <!-- START: Min/Max Peoples -->
                  <div class="form-group row">
                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">{{ localization['Number of participants'] }}</label>
                    <div class="col-xm-12 col-sm-4 col-md-5 col-lg-4">
                      <label for="input_participants_min">
                        {{ localization['Min'] }}
                        <span style="color: red;"> *</span>
                      </label>
                      <input
                        class="form-control m-input"
                        id="input_participants_min"
                        max="999"
                        min="1"
                        required
                        step="1"
                        type="number"
                        v-model="excursion.min_people"
                      />
                    </div>
                    <div class="col-xm-12 col-sm-4 col-md-5 col-lg-4">
                      <label for="input_participants_max">{{ localization['Max'] }}</label>
                      <input
                        class="form-control m-input"
                        id="input_participants_max"
                        min="0"
                        step="1"
                        type="number"
                        v-model="excursion.max_people"
                      />
                    </div>
                  </div>
                  <!-- END: Min/Max Peoples -->
                  <!-- START: Duration in Days and Hours -->
                  <div class="form-group row">
                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2">
                      {{ localization['Duration'] }}
                    </label>
                    <div class="col-xm-12 col-sm-4 col-md-5 col-lg-4">
                      <label for="input_duration_days">{{ localization['Days'] }}</label>
                      <input class="form-control m-input" id="input_duration_days" min="0" step="1" type="number"
                             v-model="durationDays" />
                    </div>
                    <div class="col-xm-12 col-sm-4 col-md-5 col-lg-4">
                      <label for="input_duration_hours">
                        {{ localization['Hours'] }}
                        <span style="color: red;"> *</span>
                      </label>
                      <input
                        class="form-control m-input"
                        id="input_duration_hours"
                        min="0"
                        required
                        step="0.5"
                        type="number"
                        v-model="durationHours"
                      />
                    </div>
                  </div>
                  <!-- END: Duration in Days and Hours -->

                  <template v-if="can('excursions-options-edit')">
                    <!-- START: Option Groups -->
                    <div class="form-group row">
                      <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                        Категория экскурсии
                      </label>
                      <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <div class="m-checkbox-inline">
                          <label class="m-checkbox" v-for="type in excursionTypes">
                            <input :value="type.id" type="checkbox" v-model="excursion.types" />
                            {{ type.name }}
                            <span></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- END: Option Groups -->
                  </template>

                  <!-- START: Uploader Gallery Images -->
                  <div class="form-group row" v-if="formRole === 'edit'">
                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                      {{ localization['Gallery'] }}
                    </label>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                      <div class="images-list">

                        <div :key="image.id" class="images-list__item" v-for="image in images">
                            <span class="images-list__item_title" v-if="mainImage === image.id">Main image</span>
                            <label class="m-radio">
                              <input :value="image.id"
                                     type="radio"
                                     v-model="mainImage"
                                     :checked="mainImage === image.id"
                              />
                              <div class="img-thumbnail-wrapper">
                                <img :src="image.url" class="img-thumbnail" />
                              </div>
                              <button :data-id="image.id" @click.prevent="mediaDelete">
                                ❌
                              </button>
                              <span></span>
                            </label>
                            <div class="input-group">
                              <input
                                type="text"
                                v-model.number="image.alt"
                                placeholder="Alt"
                              />
                            </div>
                        </div>
                      </div>
                      <vue-transmit
                        :acceptedFileTypes="transmit.fileTypes"
                        :headers="transmit.headers"
                        :maxFiles="transmit.maxFilesGallery"
                        :params="transmit.paramsGallery"
                        :url="filesActionMany"
                        @error="onFileuploadError"
                        @success="onFileuploadSuccess"
                        class="col-12 image-uploader"
                        paramName="image[]"
                        ref="uploaderGallery"
                        tag="section"
                        upload-area-classes="bg-faded"
                        v-bind="transmit.options"
                      >
                        <div class="image-uploader__zone d-flex align-items-center justify-content-center w-100">
                          <span>{{ localization['Click to download files or just drag them here'] }}</span>
                        </div>
                        <!-- Scoped slot -->
                        <template slot="files" slot-scope="props">
                          <div :class="{ 'mt-5': i === 0 }" :key="file.id" v-for="(file, i) in props.files">
                            <div class="media">
                              <img :src="file.dataUrl" class="img-fluid d-flex mr-3" />
                              <div class="media-body">
                                <h4>{{ file.name }}</h4>
                                <div class="progress" style="width: 100%">
                                  <div :style="{ width: file.upload.progress + '%' }"
                                       class="progress-bar bg-success"></div>
                                </div>
                                <div>{{ file.status }}</div>
                              </div>
                            </div>
                          </div>
                        </template>
                      </vue-transmit>
                      <div class="alert m-alert m-alert--default" role="alert">
                        {{ localization['Max File size 2 Mb'] }}
                      </div>
                    </div>
                  </div>
                  <!-- END: Uploader Gallery Images -->
                  <!-- START: Route Length -->
                  <div class="form-group row">
                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_route_length">{{
                      localization['Length of the excursion route']
                    }}</label>
                    <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                      <input class="form-control m-input" id="input_route_length" type="text"
                             v-model="excursion.route_length" />
                    </div>
                  </div>
                  <!-- END: Route Length -->
                  <!-- START: Lat and Long -->
                  <div class="form-group row">
                    <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2">
                      {{ localization['Coordinates of the beginning of the excursion'] }}
                    </label>
                    <div class="col-xm-12 col-sm-4 col-md-5 col-lg-4">
                      <label for="input_latitude">{{ localization['Latitude'] }}</label>
                      <input class="form-control m-input" id="input_latitude" maxlength="10" type="text"
                             v-model="excursion.lat" />
                    </div>
                    <div class="col-xm-12 col-sm-4 col-md-5 col-lg-4">
                      <label for="input_longitude">{{ localization['Longitude'] }}</label>
                      <input class="form-control m-input" id="input_longitude" maxlength="10" type="text"
                             v-model="excursion.long" />
                    </div>
                  </div>
                  <!-- END: Lat and Long -->
                </div>
              </div>
            </div>
          </div>
        </template>
        <div class="m-portlet">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <h3 class="m-portlet__head-title">3. Платежи</h3>
            </div>
          </div>
          <div class="m-portlet__body">
            <div class="m-section">
              <div class="m-section__content">
                <!-- START: Included - non included-->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2"></label>
                  <div class="col-xm-12 col-sm-4 col-md-5 col-lg-5">
                    <h5 class="text-uppercase mb-2">{{ localization['price include'] }}</h5>
                    <div v-for="(option, key) in optionsIncluded" v-if="checkedNotIncluded.indexOf(option.id) < 0">
                      <label class="m-checkbox">
                        <input :value="option.id" type="checkbox" v-model="checkedIncluded" />
                        <span></span>
                        {{ option.title }}
                      </label>
                    </div>
                  </div>
                  <div class="col-xm-12 col-sm-4 col-md-5 col-lg-5">
                    <h5 class="text-uppercase mb-2">{{ localization['Not'] }} {{ localization['price include'] }}</h5>
                    <div v-for="(option, key) in optionsIncluded" v-if="checkedIncluded.indexOf(option.id) < 0">
                      <label class="m-checkbox">
                        <input :value="option.id" type="checkbox" v-model="checkedNotIncluded" />
                        <span></span>
                        {{ option.title }}
                      </label>
                    </div>
                  </div>
                </div>
                <!-- END: Included - non included-->
                <!-- START Currency -->
                <div class="form-group row">
                  <label class="col-xm-8 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_currency"
                  >{{ localization['Currency'] }}: <span style="color: red;">*</span></label
                  >
                  <div class="col-2">
                    <select class="form-control m-input" id="input_currency" name="currency" required
                            v-model="currency">
                      <option :selected="curr.code === 'USD'" :value="curr" v-for="curr in acceptableCurrencies">{{ curr.code }} </option>
                    </select>
                  </div>
                </div>
                <!-- END Currency -->
                <!-- START: Commission -->
                <div class="form-group row">
                  <label class="  col-xm-8 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_currency">
                    {{ localization['commission'] }}: <span style="color: red;">*</span>
                  </label>
                  <template v-if="userRole && userRole === 'partner'">
                    <template v-if="formRole === 'edit'">
                      <template v-if="excursion.commission_proposal">
                        <div class="col-xm-12 col-sm-12 col-md-4 col-lg-4">
                          <div class="input-group">
                            <input
                              class="form-control m-input"
                              id="commission_propasal"
                              max="99"
                              min="1"
                              required
                              step="1"
                              type="number"
                              v-model="excursion.commission_proposal"
                            />
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-xm-8 col-sm-8 col-md-4 col-lg-4 align-self-center">
                          <span
                            class="m-badge m-badge--warning m-badge--wide">Ожидайте подтверждение администратора</span>
                        </div>
                        <div class="col-xm-4 col-sm-4 col-md-2 col-lg-2">
                          <button @click.prevent="commissionProposalUndo" class="btn btn-primary">Отменить</button>
                        </div>
                      </template>
                      <template v-else>
                        <div class="col-xm-12 col-sm-12 col-md-4 col-lg-4">
                          <div class="input-group">
                            <input
                              class="form-control m-input"
                              disabled
                              id="commission"
                              max="99"
                              min="1"
                              step="1"
                              type="number"
                              v-model="excursion.commission"
                            />
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-xm-6 col-sm-6 col-md-3 col-lg-3">
                          <button @click.prevent="commissionProposalMake"
                                  class="btn btn-primary">Изменить коммиссию</button>
                        </div>
                      </template>
                    </template>
                    <template v-else>
                      <div class="col-xm-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="input-group">
                          <input
                            class="form-control m-input"
                            max="99"
                            min="1"
                            required
                            step="1"
                            type="number"
                            v-model="excursion.commission"
                          />
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </div>
                    </template>
                  </template>
                  <template v-if="userRole && userRole === 'admin'">
                    <div class="col-xm-12 col-sm-12 col-md-4 col-lg-4">
                      <div class="input-group">
                        <input
                          class="form-control m-input"
                          disabled
                          max="99"
                          min="1"
                          step="1"
                          type="number"
                          v-model="excursion.commission"
                        />
                        <div class="input-group-append">
                          <span class="input-group-text">%</span>
                        </div>
                      </div>
                    </div>
                  </template>
                </div>
                <!-- END: Commission -->
                <!-- START: Commission proposal for admins-->
                <div class="form-group row" v-if="userRole && userRole === 'admin' && excursion.commission_proposal">
                  <label class="  col-xm-8 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_currency">
                    Предложение комисии: <span style="color: red;">*</span>
                  </label>
                  <div class="col-xm-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="input-group">
                      <input
                        class="form-control m-input"
                        disabled
                        max="99"
                        min="1"
                        step="1"
                        type="number"
                        v-model="excursion.commission_proposal"
                      />
                      <div class="input-group-append">
                        <span class="input-group-text">%</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-xm-12 col-sm-12 col-md-6 col-lg-6">
                    <button @click.prevent="commissionProposalAccept" class="btn btn-success">Подтвердить</button>
                    <button @click.prevent="commissionProposalReject" class="btn btn-danger">Отклонить</button>
                  </div>
                </div>
                <!-- END: Commission proposal for admins -->

                <!-- START Prepay -->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_prepay">
                    Предоплата
                  </label>
                  <div class="col-xm-12 col-sm-8 col-md-6 col-lg-6">
                    <div class="input-group" v-if="partner.vat">
                      <input
                        class="form-control m-input"
                        id="input_prepay"
                        max="100"
                        min="5"
                        name="prepay"
                        required
                        type="number"
                        v-model="excursion.prepay"
                      />
                      <div class="input-group-append">
                        <span class="input-group-text">%</span>
                      </div>
                    </div>
                    <div class="input-group" v-else>
                      <label for="input_prepay"
                      >Размер предоплаты равен комисии (Только плательщик НДС может регулировать предоплату)</label
                      >
                      <br />
                      <input class="form-control m-input" disabled type="number" v-model="excursion.commission" />
                      <div class="input-group-append">
                        <span class="input-group-text">%</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END: Prepay -->

                <!-- START: Price by Person and General -->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2"
                  >{{ localization['Price'] }}:
                    <span style="color: red;">*</span>
                  </label>
                  <div class="col-xm-12 col-sm-4 col-md-5 col-lg-3">
                    <div class="form-group">
                      <label for="input_price_type">Тип цены</label>
                      <select class="form-control m-input" id="input_price_type" name="transfer_currency"
                              required v-model="excursion.type">
                        <option :value="'person'">Цена за человека</option>
                        <option :value="'group'">Цена за экскурсию</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-xm-12 col-sm-4 col-md-4 col-lg-3" v-if="excursion.type == 'person'">
                    <div class="row form-group" v-for="epr in excursion.prices" v-if="epr.price_type != 'group'">
                      <div class="col">
                        <label v-if="epr.price_type != 'child'">
                          {{ localization['Price'] }}&nbsp;{{ localization[epr.price_type] }}:
                        </label>
                        <input
                          class="form-control m-input mb-2"
                          max="999999999"
                          min="0"
                          required
                          step="1"
                          type="number"
                          v-model="epr.price"
                        />
                      </div>
                      <div class="col" v-if="epr.price_type == 'baby'">
                        <label> {{ localization['Age'] }}&nbsp;{{ localization['to'] }}: </label>

                        <select class="form-control m-input mb-2" required v-model="epr.price_to">
                          <option :value="i" v-for="i in 10">{{ i }}</option>
                        </select>
                      </div>
                      <div class="col" v-if="epr.price_type == 'child'">
                        <select class="form-control m-input mb-2" required v-model="epr.price_to">
                          <option :value="i" v-for="i in 16"
                                  v-if="i >= excursion.prices[1].price_to + 1">{{ i }}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END: Price by Person and General -->
                <!-- Start NEW Price Groups -->
                <div
                  class="form-group row"
                  v-for="(epr, k) in excursion.prices"
                  v-if="excursion.type == 'group' && epr.price_type == 'group'"
                >
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" style="padding-top: 20px">
                    {{ localization['Number of participants'] }}
                  </label>
                  <div class="col-xm-11 col-sm-9 col-md-9 col-lg-7">
                    <div class="row">
                      <div class="col-xm-12 col-sm-6 col-md-4 col-lg-4 form-group ">
                        <label>{{ localization['from'] }}:&nbsp;</label>
                        <input class="form-control m-input" max="400" min="0" required step="1" type="number"
                               v-model="epr.price_from" />
                      </div>
                      <div class="col-xm-12 col-sm-6 col-md-4 col-lg-4 form-group ">
                        <label>{{ localization['to'] }}:&nbsp;</label>
                        <input class="form-control m-input" max="400" min="0" required step="1" type="number"
                               v-model="epr.price_to" />
                      </div>
                      <div class="col-xm-12 col-sm-12 col-md-4 col-lg-4 form-group ">
                        <label>{{ localization['Total'] }}&nbsp;{{ localization['price'] }}&nbsp;{{ localization[epr.price_type] }}</label>
                        <input class="form-control m-input" max="999999999" min="0" required step="1" type="number"
                               v-model="epr.price" />
                      </div>
                    </div>
                  </div>
                  <div class="col-xm-1 col-sm-1 col-md-1 col-lg-1">
                    <div>
                      <label>&nbsp;</label>
                    </div>
                    <a @click="deletePriceGroup(k)" href="javascript:" style="line-height: 3" v-if="k > 3">&#9747;</a>
                  </div>
                </div>
                <div class="form-group row" v-if="excursion.type == 'group'">
                  <div class="col-xm-12 col-md-2 col-lg-2">&nbsp;</div>
                  <div class="col-xm-12 col-sm-10 col-md-10 col-lg-8">
                    <a @click="addPriceGroup()" href="javascript:" v-if="excursion.prices.length < 7">+{{ localization['add more'] }}</a>
                    <br /><br />
                  </div>
                </div>
                <!-- END NEW Price Groups -->
                <!-- START Free Cancel Before -->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_free_cancel">{{
                    localization['Free cancel before']
                  }}</label>
                  <div class="col-xm-12 col-sm-8 col-md-4 col-lg-4">
                    <div class="input-group">
                      <input
                        class="form-control m-input"
                        id="input_free_cancel"
                        max="365"
                        min="0"
                        name="free_cancel_before"
                        type="number"
                        v-model="excursion.free_cancel_before"
                      />
                      <div class="input-group-append">
                        <span class="input-group-text">{{ localization['Hours'] }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END: Free Cancel Before -->
              </div>
            </div>
          </div>
        </div>
        <!-- START: Submit Button -->
        <div class="form-group row">
          <div class="col-sm-10">
            <button
              :class="{ 'm-loader': formIsSent, 'm-loader--light': formIsSent, 'm-loader--right': formIsSent }"
              :disabled="formIsSent"
              @click.prevent="onFormSubmit"
              class="btn btn-primary"
              type="submit"
            >
              {{ localization['Save'] }}
            </button>
          </div>
        </div>
        <!-- END: Submit Button -->
      </form>
    </div>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import LimitedTextarea from '../../../shared-components/LimitedTextarea';

export default {
  components: {
    LimitedTextarea,
    Multiselect,
  },
  props: [
    'permissions',
    'formRole',
    'userRole',
    'formAction',
    'filesAction',
    'filesActionMany',
    'filesDelete',
    'defaultCurrency',
    'defaultLanguage',
    'localization',
    'composerCurrencies',
    'composerPlaces',
    'languages',
    'partner',
    'gallery',
    'excursionSrc',
    'excursionTypes',
    'currentExcursionTypes',
  ],
  data() {
    return {
      images: [],
      mainImage: null,
      activeTab: 'ru',
      checkedIncluded: [],
      checkedNotIncluded: [],
      formIsSent: false,
      checkedOptions: [],
      checkedOptionsFree: {},
      checkedOptionsPrices: {},
      selectedStartPlaceObject: null,
      durationDays: '',
      durationHours: '',
      excursion: {
        route_length: null,
        id: null,
        options: {},
        place_id: null,
        start_time: [],
        duration: 0,
        free_cancel_before: 0,
        min_people: 1,
        max_people: null,
        currency_id: null,
        price_excursion: null,
        price_adult: null,
        price_kid: null,
        type: null,
        prices: [
          {
            price_type: 'adult',
            price: null,
          },
          {
            price_type: 'baby',
            price: null,
            price_from: 0,
            price_to: 10,
          },
          {
            price_type: 'child',
            price: null,
            price_from: 10,
            price_to: 14,
          },
          {
            price_type: 'group',
            price: null,
            price_from: 2,
            price_to: null,
          },
        ],
        lat: null,
        long: null,
        calendar_use: false,
        translations: [],
        commission: 10,
        commission_proposal: null,
        prepay: null,
        types: [],
      },
      translations: {
        ru: {
          title: '',
          intro: '',
          description: '',
          start_place: '',
        },
        en: {
          title: '',
          intro: '',
          description: '',
          start_place: '',
        },
        ka: {
          title: '',
          intro: '',
          description: '',
          start_place: '',
        },
      },
      descriptionContent: {
        ru: {
          description: '',
        },
        en: {
          description: '',
        },
        ka: {
          description: '',
        },
      },
      mceOptions: window.tinymce.mceOptions,
      transmit: {
        headers: { 'X-CSRF-TOKEN': '' },
        fileTypes: ['.jpg', '.png', '.jpeg'],
        maxFilesGallery: 50,
        maxFilesThumb: 1,
        maxFileSize: 2,
        options: {
          clickable: true,
        },
        paramsGallery: {
          model: 'Excursions',
          model_id: null,
        },
        paramsThumb: {
          model: 'Excursions',
          model_id: null,
        },
      },
      currency: {},
    };
  },
  computed: {
    optionsIncluded() {
      for (var key in this.optionGroups) {
        if (this.optionGroups[key].id == 26) {
          return this.optionGroups[key].options_collection;
        }
      }
      return [];
    },
    loading() {
      return this.$store.getters.loading;
    },
    optionGroups() {
      return this.$store.getters.optionGroups;
    },
    priceIsOnlyOne() {
      return ! (this.excursion.price_adult && this.excursion.price_excursion);
    },
    isPaidOptionsHavePrice() {
      var flag = true;
      for (let i in this.checkedOptionsFree) {
        if (this.checkedOptionsFree[i] === 'false' && ! this.checkedOptionsPrices[i]) {
          flag = false;
        }
      }
      return flag;
    },
    totalDurationHours() {
      let parseDays = parseInt(this.durationDays) || 0;
      let parseHours = parseFloat(this.durationHours) || 0;
      return parseDays * 24 + parseHours;
    },
    acceptableCurrencies() {
      let cures = this.composerCurrencies;
      return cures.filter(function(item) {
        if (item.acceptable) return item;
      });
    },
  },
  methods: {
    addPriceGroup() {
      this.excursion.prices.push({
        price_type: 'group',
        price: null,
        price_from: this.excursion.prices[this.excursion.prices.length - 1].price_to,
        price_to: null,
      });
    },
    deletePriceGroup(k) {
      this.excursion.prices.splice(k, 1);
    },
    can(permission) {
      for (let index in this.permissions) {
        if (this.permissions[index].name === permission) return true;
      }
      return false;
    },
    onFormSubmit() {
      // проверяет наличие русского описание и тайтла, если нет переключает на вкладку с русским валидирует
      if (
        ! this.translations['ru'].title ||
        ! this.translations['ru'].intro ||
        (this.userRole && this.userRole === 'admin' && ! this.translations['ru'].meta_title) ||
        (this.userRole === 'admin' && ! this.translations['ru'].meta_description)
      ) {
        this.activeTab = 'ru';
        this.$nextTick(() => {
          this.$refs.excursionForm.reportValidity();
        });
      } else if ( ! this.$refs.excursionForm.checkValidity()) {
        this.$refs.excursionForm.reportValidity();
      } else {
        this.sendForm();
      }
    },
    sendForm() {
      this.formIsSent = true;
      if ( ! this.isPaidOptionsHavePrice) {
        this.$toasted.info(this.localization['Some of the paid options do not have a price']);
        this.formIsSent = false;
        return false;
      }
      let formattedOptions = {};
      for (let i in this.checkedOptions) {
        formattedOptions[this.checkedOptions[i]] = {
          id: this.checkedOptions[i],
          free: this.checkedOptionsFree[this.checkedOptions[i]],
          price: this.checkedOptionsPrices[this.checkedOptions[i]],
        };
      }
      for (let i in this.checkedIncluded) {
        formattedOptions[this.checkedIncluded[i]] = {
          id: this.checkedIncluded[i],
          free: true,
          price: '',
        };
      }
      for (let i in this.checkedNotIncluded) {
        formattedOptions[this.checkedNotIncluded[i]] = {
          id: this.checkedNotIncluded[i],
          free: true,
          price: '',
          value: 'not_included',
        };
      }
      let excursionData = Object.assign({}, this.excursion, this.translations, {
        options: formattedOptions,
        place_id: this.selectedStartPlaceObject.id,
        duration: this.totalDurationHours,
        main_image: this.mainImage,
        images: this.images,
      });
      axios
        .post(this.formAction, excursionData)
        .then(response => {
          if (this.formRole === 'create') {
            this.$toasted.success(this.localization['Excursion successfully created']);
            setTimeout(() => {
              this.$toasted.success(this.localization['Now you will be redirected to excursion edit page']);
            }, 2000);
            setTimeout(() => {
              this.formIsSent = false;
              window.location.href = response.data.redirect;
            }, 3000);
          } else {
            // if (response.data.excursion) {
            //     this.excursion = response.excursion;
            //     this.setValuesFromSrc()
            // }
            // this.$toasted.success(this.localization['Changes in excursion saved']);
            // this.formIsSent = false
            window.location.reload();
          }
        })
        .catch(error => {
          this.$toasted.error(error.message);
          this.formIsSent = false;
        });
    },
    onOptionChange(event) {
      if (this.checkedOptions.includes(+event.target.value)) {
        this.$set(this.checkedOptionsFree, event.target.value, true);
        this.$set(this.checkedOptionsPrices, event.target.value, '');
      } else {
        delete this.checkedOptionsFree[event.target.value];
        delete this.checkedOptionsPrices[event.target.value];
      }
    },
    onOptionFreeChange(event) {
      if (event.target.value === 'true') {
        this.checkedOptionsPrices[event.target.name] = '';
      }
    },
    onFileuploadSuccess(event) {
      this.$toasted.success(this.localization['File successfully uploaded']);
    },
    onFileuploadError(error) {
      this.$toasted.error(this.localization['Error loading file']);
    },
    deleteExcursionImage(id) {
      for (let i in this.images) {
        if (this.images[i].id === id) {
          this.images.splice(i, 1);
        }
      }
    },
    mediaDelete(event) {
      $(event.target).prop('disabled', true);
      let image_id = event.target.dataset.id;
      let url = this.filesDelete.replace(':id', image_id);
      axios
        .delete(url)
        .then(response => {
          this.deleteExcursionImage(Number(image_id));
          this.$toasted.success(this.localization['File successfully deleted']);
        })
        .catch(error => {
          this.$toasted.error(this.localization['Error deleting file']);
          $(event.target).prop('disabled', false);
        });
    },
    setValuesFromSrc() {
      if (this.gallery.length > 0) {
        this.images = this.gallery.map((image, i) => {
          if(image.mainImage) {
            this.mainImage = image.id
          }
          return image;
        });
      }
      // set Translations and descriptionContent (for TinyMCE content)
      if (this.excursion.translations.length > 0) {
        for (let i in this.excursion.translations) {
          this.translations[this.excursion.translations[i].locale] = this.excursion.translations[i];
          this.descriptionContent[this.excursion.translations[i].locale].description = this.excursion.translations[i].description;
        }
      }
      // set selectedStartPlaceObject
      if (this.excursion.place_id) {
        for (let i in this.composerPlaces) {
          if (this.composerPlaces[i].id == this.excursion.place_id) {
            this.selectedStartPlaceObject = this.composerPlaces[i];
          }
        }
      }
      // set durationDays and durationHours
      if (this.excursion.duration) {
        let duration = parseFloat(this.excursion.duration).toFixed(2);
        this.durationDays = Math.trunc(duration / 24);
        this.durationHours = Math.floor((duration % 24) * 100) / 100;
      }
      // set Checked Options

      if (this.excursion.options.length > 0) {
        for (let i = 0; i < this.excursion.options.length; i++) {
          if (this.excursion.options[i].options_group_id == 26) {
            if (this.excursion.options[i].pivot.value) {
              this.checkedNotIncluded.push(this.excursion.options[i].id);
            } else {
              this.checkedIncluded.push(this.excursion.options[i].id);
            }
          } else {
            this.checkedOptions.push(this.excursion.options[i].id);
            this.$set(this.checkedOptionsFree, this.excursion.options[i].id, this.excursion.options[i].pivot.free + '');
            this.$set(
              this.checkedOptionsPrices,
              this.excursion.options[i].id,
              this.excursion.options[i].pivot.price ? this.excursion.options[i].pivot.price : '',
            );
          }
        }
      }

      for (let index in this.acceptableCurrencies) {
        if (this.acceptableCurrencies[index].id == this.excursion.currency_id) {
          this.currency = this.acceptableCurrencies[index];
        }
      }

      if (this.currentExcursionTypes.length) {
        this.excursion.types = this.currentExcursionTypes;
      }
    },
    commissionProposalMake() {
      if ( ! this.excursion.commission_proposal) {
        this.excursion.commission_proposal = 15;
      }
    },
    commissionProposalUndo() {
      this.$set(this.excursion, 'commission_proposal', null);
    },
    commissionProposalReject() {
      this.commissionProposalUndo();
    },
    commissionProposalAccept() {
      this.$set(this.excursion, 'commission', this.excursion.commission_proposal);
      this.commissionProposalUndo();
    },
  },
  watch: {
    currency: function(item) {
      this.excursion.currency_code = item.code;
      this.excursion.currency_id = item.id;
    },
  },
  created() {
    this.$store.dispatch('receiveLoading', true);
    document.addEventListener('DOMContentLoaded', () => {
      this.transmit.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
      this.$store.dispatch('receiveOptionGroups', window.optionGroups);
      if (this.excursionSrc) {
        this.excursion = this.excursionSrc;
        this.transmit.paramsGallery.model_id = this.excursion.id;
        this.setValuesFromSrc();
      }
      this.$store.dispatch('receiveLoading', false);
    });
  },
};
</script>
<style scoped>
.nav-link {
  cursor: pointer;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
