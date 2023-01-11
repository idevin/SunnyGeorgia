<template>
  <div class="tour-info-manager">
    <div class="text-center" v-if="loading">
      <shared-loader></shared-loader>
    </div>
    <div v-if="!loading">
      <form method="POST" ref="tourForm">
        <div class="m-portlet">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <h3 class="m-portlet__head-title">1. {{ localization['Tour content'] }}</h3>
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
                      :labels="{
                        checked: localization['Yes'],
                        unchecked: localization['No'],
                      }"
                      id="input_published"
                      v-model="tour.published"
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
                <!-- START Tab Content-->
                <div class="tab-content">
                  <div
                    :class="{ active: activeTab === lang.locale }"
                    :id="'m_portlet_tab_' + lang.locale"
                    class="tab-pane"
                    v-for="(lang, index) in languages"
                  >
                    <!-- START: Title -->
                    <div class="form-group row">
                      <label :for="'input_title_' + lang.locale" class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label"
                        >{{ localization['Title'] }}:<span style="color: red;" v-if="lang.locale === 'ru'"> *</span></label
                      >
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
                      <label :for="'input_intro_' + lang.locale" class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
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

                    <!-- START: SEO -->
                    <template v-if="userRole && userRole === 'admin' && can('tours-meta-edit')">
                      <!-- START: Title -->
                      <div class="form-group row">
                        <label :for="'input_meta_title_' + lang.locale" class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
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
                        <label :for="'input_meta_description_' + lang.locale" class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
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
                    <!-- END: SEO -->
                    <div class="m-separator"></div>
                    <!-- START: Description -->
                    <!-- todo удалить после переноса описания в дни-->
                    <div class="form-group row">
                      <label :for="'input_description_' + lang.locale" class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                        {{ localization['Description'] }}
                        <template v-if="lang.locale === 'ru'">
                          <span style="color: red;"> *</span>
                          <input :checked="!!translations[lang.locale].description" required style="height:1px;width:1px" type="checkbox" />
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
                    <!-- START: Days -->
                    <div class="form-group row">
                      <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                        Дни тура
                      </label>
                      <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <div class="form-group row align-items-center">
                          <div class="col-md-12">
                            <ul class="nav nav-tabs" role="tablist">
                              <li class="nav-item m-tabs__item" v-for="(day, index) in tour.parts">
                                <template v-for="(translation, trIndex) in day.translations">
                                  <a
                                    :class="{
                                      active: activeDay === day.day_order,
                                    }"
                                    @click.prevent.stop="activeDay = day.day_order"
                                    class="nav-link m-tabs__link"
                                    role="tab"
                                    v-if="day.translations[trIndex].locale === lang.locale"
                                  >
                                    {{ translation.name ? translation.name : day.day_order }}
                                  </a>
                                </template>
                              </li>
                              <div style="margin-left: 10px;">
                                <button @click.prevent="addTourDay" class="btn btn-bold btn-sm btn-label-brand">
                                  <i class="la la-plus"></i> Добавить день
                                </button>
                              </div>
                            </ul>
                          </div>
                          <div class="col-md-12">
                            <div class="tab-content">
                              <div
                                :class="{ active: activeDay === day.day_order }"
                                :id="'tour_day_' + day.day_order"
                                :key="day.day_order"
                                class="tab-pane"
                                v-for="(day, index) in tour.parts"
                              >
                                <template v-for="(translation, trIndex) in day.translations">
                                  <div v-if="day.translations[trIndex].locale === lang.locale">
                                    <div class="row form-group">
                                      <div class="col-md-6">
                                        <div class="m-form__group--inline">
                                          <div class="m-form__label">
                                            <label>Название дня:</label>
                                          </div>
                                          <div class="m-form__control">
                                            <input
                                              class="form-control"
                                              placeholder="например: День 1"
                                              type="text"
                                              v-model="translation.name"
                                            />
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="m-form__group--inline">
                                          <div class="m-form__label">
                                            <label>Заголовок дня:</label>
                                          </div>
                                          <div class="m-form__control">
                                            <input
                                              class="form-control"
                                              placeholder="например: Прибытие, заселение"
                                              type="text"
                                              v-model="translation.title"
                                            />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row form-group">
                                      <div class="col-md-12">
                                        <tinymce
                                          :content="translation.description"
                                          :id="'editor_day_' + day.day_order + lang.locale"
                                          :options="mceOptions"
                                          v-model="translation.description"
                                        ></tinymce>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-2">
                                        <button
                                          @click.prevent="deleteTourDay(tour.parts, index)"
                                          class="btn-sm btn btn-label-danger btn-bold"
                                        >
                                          Удалить день
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                </template>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- END: Days -->
                    <div class="m-separator"></div>
                    <!-- START: Price options -->
                    <div class="form-group row">
                      <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                        Опции тура <br />
                        (добавьте все возможные опции)
                      </label>

                      <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                        <div :key="index" class="form-group row align-items-center" v-for="(option, index) in tour.price_options">
                          <template v-for="(translation, trIndex) in option.translations">
                            <div :key="trIndex" class="col-md-6" v-if="option.translations[trIndex].locale === lang.locale">
                              <div class="m-form__control">
                                <input class="form-control" placeholder="Укажите название опции" type="text" v-model="translation.name" />
                              </div>
                            </div>
                          </template>
                          <div class="col-md-4">
                            <label class="m-checkbox">
                              <input type="checkbox" v-model="option.included" />
                              Включено в стоимость
                              <span></span>
                            </label>
                          </div>
                          <div class="col-md-2">
                            <button @click.prevent="$delete(tour.price_options, index)" class="btn-sm btn btn-label-danger btn-bold">
                              Удалить
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group form-group-last row">
                      <label class="col-lg-2 col-form-label"></label>
                      <div class="col-lg-4">
                        <button @click.prevent="addPriceOption(lang)" class="btn btn-bold btn-sm btn-label-brand">
                          <i class="la la-plus"></i> Добавить опцию
                        </button>
                      </div>
                    </div>
                    <!-- END: Price options -->
                  </div>
                </div>
                <!-- END Tab Content-->
              </div>
            </div>
          </div>
        </div>
        <div class="m-portlet">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <h3 class="m-portlet__head-title">2. Детали тура</h3>
            </div>
          </div>
          <div class="m-portlet__body">
            <div class="m-section">
              <div class="m-section__content">
                <!-- START: Option Groups -->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                    Тип тура
                  </label>
                  <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                    <div class="m-checkbox-inline">
                      <label class="m-checkbox" v-for="type in tourTypes">
                        <input :value="type.id" type="checkbox" v-model="tour.types" />
                        {{ type.name }}
                        <span></span>
                      </label>
                    </div>
                  </div>
                </div>
                <!-- END: Option Groups -->

                <!-- START FromPlace -->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_place">
                    {{ localization['Place of departure'] }}
                    <span style="color: red;"> *</span>
                    <input :checked="!!selectedStartPlaceObject" name="input_place" required style="height:1px;width:1px" type="checkbox" />
                  </label>
                  <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                    <multiselect
                      :allow-empty="false"
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
                <!-- END FromPlace -->

                <!-- START Days/Night -->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label"
                    >{{ localization['Days / Nights'] }}<span style="color: red;"> *</span></label
                  >
                  <div class="col-xm-12 col-sm-4 col-md-5 col-lg-4">
                    <input class="form-control m-input" max="365" min="0" name="days" required type="number" v-model="tour.days" />
                  </div>
                  <div class="col-xm-12 col-sm-4 col-md-5 col-lg-4">
                    <input class="form-control m-input" max="365" min="0" name="nights" required type="number" v-model="tour.nights" />
                  </div>
                </div>
                <!-- END Days/Night -->

                <!-- START Food -->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_place">Питание</label>
                  <div class="col-xm-4 col-sm-2 col-md-2 col-lg-2">
                    <toggle-button :height="25" :labels="{ checked: 'Да', unchecked: 'Нет' }" :width="65" v-model="foodOption" />
                  </div>
                  <div class="col-xm-4 col-sm-6 col-md-6 col-lg-6" v-if="foodOption">
                    <select class="form-control mx-1" required v-model="tour.food_option_id">
                      <option :key="index" :value="option.id" v-for="(option, index) in foodOptions">{{ option.name }} </option>
                    </select>
                  </div>
                </div>
                <!-- END Food -->
              </div>
            </div>
          </div>
        </div>
        <div class="m-portlet">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <h3 class="m-portlet__head-title">3. Галлерея</h3>
            </div>
          </div>
          <div class="m-portlet__body">
            <div class="m-section">
              <div class="m-section__content">
                <!-- START: Uploader Gallery Images -->
                <div class="form-group row" v-if="formRole === 'edit'">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                    {{ localization['Gallery'] }}
                  </label>
                  <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                    <!--<i class="fa fa-spinner fa-pulse fa-fw"></i>-->
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
                          <button :data-id="image.id" @click.prevent="onImageDelete">
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
                      :params="transmit.paramsGallery"
                      :url="filesActionMany"
                      @error="onFileuploadError"
                      @success="onFileuploadSuccess"
                      class="col-12 image-uploader"
                      paramName="image[]"
                      ref="uploader"
                      tag="section"
                      upload-area-classes="bg-faded"
                      v-bind="transmitGallery"
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
                                <div :style="{ width: file.upload.progress + '%' }" class="progress-bar bg-success"></div>
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
                <div class="form-group row" v-else>
                  добавьте изображения после создания тура
                </div>
                <!-- END: Uploader Gallery Images -->
              </div>
            </div>
          </div>
        </div>
        <div class="m-portlet">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <h3 class="m-portlet__head-title">4. Платежи</h3>
            </div>
          </div>
          <div class="m-portlet__body">
            <div class="m-section">
              <div class="m-section__content">
                <!-- START Currency -->
                <div class="form-group row">
                  <label class="col-xm-8 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_currency"
                    >{{ localization['Currency'] }}: <span style="color: red;">*</span></label
                  >
                  <div class="col-2">
                    <select class="form-control m-input" id="input_currency" name="currency" required v-model="currency">
                      <option :value="curr" v-for="curr in acceptableCurrencies">{{ curr.code }} </option>
                    </select>
                  </div>
                </div>
                <!-- END Currency -->
                <!-- START: Commission proposal for admins-->
                <div class="form-group row" v-if="userRole && userRole === 'admin' && tour.commission_proposal">
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
                        v-model="tour.commission_proposal"
                      />
                      <div class="input-group-append">
                        <span class="input-group-text">%</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-xm-12 col-sm-12 col-md-6 col-lg-6">
                    <button @click.prevent="commissionProposalAccept" class="btn btn-success">
                      Подтвердить
                    </button>
                    <button @click.prevent="commissionProposalReject" class="btn btn-danger">
                      Отклонить
                    </button>
                  </div>
                </div>
                <!-- END: Commission proposal for admins -->
                <!-- START: Commission -->
                <div class="form-group row">
                  <label class="  col-xm-8 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_currency">
                    {{ localization['commission'] }}:
                    <span style="color: red;">*</span>
                  </label>
                  <template v-if="userRole && userRole === 'partner'">
                    <template v-if="formRole === 'edit'">
                      <template v-if="tour.commission_proposal">
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
                              v-model="tour.commission_proposal"
                            />
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-xm-8 col-sm-8 col-md-4 col-lg-4 align-self-center">
                          <span class="m-badge m-badge--warning m-badge--wide">Ожидайте подтверждение администратора</span>
                        </div>
                        <div class="col-xm-4 col-sm-4 col-md-2 col-lg-2">
                          <button @click.prevent="commissionProposalUndo" class="btn btn-primary">
                            Отменить
                          </button>
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
                              v-model="tour.commission"
                            />
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-xm-6 col-sm-6 col-md-3 col-lg-3">
                          <button @click.prevent="commissionProposalMake" class="btn btn-primary">
                            Изменить коммиссию
                          </button>
                        </div>
                      </template>
                    </template>
                    <template v-else>
                      <div class="col-xm-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="input-group">
                          <input class="form-control m-input" max="99" min="1" required step="1" type="number" v-model="tour.commission" />
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
                        <input class="form-control m-input" disabled max="99" min="1" step="1" type="number" v-model="tour.commission" />
                        <div class="input-group-append">
                          <span class="input-group-text">%</span>
                        </div>
                      </div>
                    </div>
                  </template>
                </div>
                <!-- END: Commission -->

                <!-- START Prepay -->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label" for="input_prepay">
                    Предоплата
                    <span style="color: red;">*</span>
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
                        v-model="tour.prepay"
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
                      <input class="form-control m-input" disabled type="number" v-model="tour.commission" />
                      <div class="input-group-append">
                        <span class="input-group-text">%</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END: Prepay -->

                <!-- START Free Cancel Before -->
                <div class="form-group row">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">
                    За сколько дней до начала можно сделать отмену
                  </label>
                  <div class="col-xm-12 col-sm-8 col-md-10 col-lg-8">
                    <input
                      class="form-control m-input"
                      max="365"
                      min="0"
                      name="free_cancel_before"
                      type="number"
                      v-model="tour.free_cancel_before"
                    />
                  </div>
                </div>
                <!-- END Free Cancel Before -->
                <!-- START Transfer -->
                <div class="form-group row">
                  <div class="col-4">
                    <div class="m-checkbox-list">
                      <label class="m-checkbox">
                        <input name="transfer_included" type="checkbox" v-model="tour.transfer_included" />
                        {{ localization['Transfer is included in the price'] }}
                        <span></span>
                        <span></span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group row" v-if="!tour.transfer_included">
                  <label class="col-xm-12 col-sm-4 col-md-2 col-lg-2 col-form-label">{{ localization['Additional transfer fee'] }}</label>
                  <div class="col-xm-12 col-sm-4 col-md-5 col-lg-4">
                    <div class="input-group">
                      <input
                        class="form-control m-input"
                        max="99999999"
                        min="0"
                        name="transfer_price"
                        step="0.01"
                        type="number"
                        v-model.number="transferPriceInCurrency"
                      />
                      <div class="input-group-append">
                        <span class="input-group-text">{{ tour.currency_code }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END Transfer -->
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-10">
            <button
              :class="{
                'm-loader': formIsSent,
                'm-loader--light': formIsSent,
                'm-loader--right': formIsSent,
              }"
              :disabled="formIsSent"
              @click.prevent="onFormSubmit"
              class="btn btn-primary"
              type="submit"
            >
              {{ localization['Save'] }}
            </button>
          </div>
        </div>
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
    'tourSrc',
    'permissions',
    'formRole',
    'userRole',
    'previousUrl',
    'filesAction',
    'filesActionMany',
    'filesDelete',
    'formAction',
    'dataLanguages',
    'dataCurrencies',
    'localization',
    'userCurrency',
    'composerCurrencies',

    'defaultCurrency',
    'defaultLanguage',
    'languages',
    'foodOptions',
    'partner',
    'tourTypes',
    'currentTourTypes',
    'gallery',
  ],
  data() {
    return {
      images: [],
      mainImage: null,
      activeTab: 'ru',
      activeDay: 1,
      formIsSent: false,
      transmitThmb: '',
      transmitGallery: '',
      tour: {
        currency_id: null,
        currency_code: null,
        start_place_id: null,
        places: [],
        days: null,
        nights: null,
        transfer_included: undefined,
        transfer_price: undefined,
        options: {},
        free_cancel_before: 0,
        published: undefined,
        prepay: 10,
        commission: 10,
        commission_proposal: null,
        food_option_id: null,
        types: [],
        parts: [],
        price_options: [],
      },
      foodOption: null,
      translations: {
        ru: {
          title: '',
          intro: '',
          description: '',
        },
        en: {
          title: '',
          intro: '',
          description: '',
        },
        ka: {
          title: '',
          intro: '',
          description: '',
        },
      },
      descriptionContent: {
        en: {
          description: '',
        },
        ru: {
          description: '',
        },
        ka: {
          description: '',
        },
      },
      mceOptions: window.tinymce.mceOptions,
      content: 'fgs dfg dsfg sdfg ',
      editor: {
        ru: {},
        en: {},
        ka: {},
      },
      // Form sending data right now (server response waiting flag)
      queryLoading: false,
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
          model: 'Tours',
          model_id: null,
        },
        paramsThumb: {
          model: 'Tours',
          tour_id: null,
          thmb: true,
          maxFilesize: 1,
        },
      },
      checkedOptions: [],
      checkedOptionsFree: {},
      checkedOptionsPrices: {},
      places: [],
      startPlaceArr: [],
      free: {},
      ifThumbs: false,
      ifImages: false,
      selectedStartPlaceObject: {},
      startPlace: {
        options: [],
      },
      route: {
        options: [],
      },
      currency: {},
    };
  },
  computed: {
    loading() {
      return this.$store.getters.loading;
    },
    composerPlaces() {
      return this.$store.getters.composerPlaces;
    },
    optionGroups() {
      return this.$store.getters.optionGroups;
    },
    isPaidOptionsHavePrice() {
      var flag = true;
      for (let i in this.checkedOptionsFree) {
        if (this.checkedOptionsFree[i] === 'false' && !this.checkedOptionsPrices[i]) {
          flag = false;
        }
      }
      return flag;
    },
    acceptableCurrencies() {
      let cures = this.composerCurrencies;
      return cures.filter(function(item) {
        if (item.acceptable) return item;
      });
    },
    transferPriceInCurrency: {
      get() {
        return this.convertCurrency(this.tour.transfer_price, 'USD', this.tour.currency_code);
      },
      set(val) {
        this.tour.transfer_price = this.convertCurrency(val, this.tour.currency_code, 'USD');
      },
    },
  },
  methods: {
    convertCurrency(amount, fromCode, toCode) {
      if (!amount) {
        return null;
      }

      const rates = {
        from: 'USD',
        to: 'USD',
      };
      this.composerCurrencies.forEach(cur => {
        if (cur.code === fromCode) {
          rates.from = +cur.exchange_rate;
        }
        if (cur.code === toCode) {
          rates.to = +cur.exchange_rate;
        }
      });
      return rates.from === rates.to ? amount : (amount * rates.to) / rates.from;
    },
    addPriceOption() {
      this.tour.price_options.push({
        included: false,
        tour_id: this.tour.id,
        translations: [{ locale: 'ru', name: '' }, { locale: 'en', name: '' }, { locale: 'ka', name: '' }],
      });
    },
    addTourDay() {
      let daysExist = this.tour.parts ? this.tour.parts.length : 0;
      this.tour.parts.push({
        day_order: ++daysExist,
        translations: [
          { locale: 'ru', title: '', name: '', description: '' },
          { locale: 'en', title: '', name: '', description: '' },
          { locale: 'ka', title: '', name: '', description: '' },
        ],
      });
      this.activeDay = daysExist;
    },
    deleteTourDay(tourParts, index) {
      this.$delete(tourParts, index);
      this.activeDay = index;
    },
    maxFilesExceeded(e) {
      this.$refs.thumbUploader.removeAllFiles(); // all files
      this.$refs.thumbUploader.addFile(e._nativeFile);
    },
    can(permission) {
      //console.log(this.permissions);
      for (let index in this.permissions) {
        if (this.permissions[index].name === permission) return true;
      }
      return false;
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
      console.log(error);
      this.$toasted.error(this.localization['Error loading file']);
    },
    onThumbDelete(event) {
      var HTMLEl = document.getElementById('thumb-preview');
      var image_id = event.target.dataset.id;
      var url = this.filesDelete.replace(':id', image_id);
      axios
        .delete(url)
        .then(response => {
          this.$toasted.success(this.localization['File successfully deleted']);
          HTMLEl.style.display = 'none';
        })
        .catch(error => {
          this.$toasted.error(this.localization['Error deleting file']);
          // submitButton.disabled = false
        });
    },
    onImageDelete(event) {
      $(event.target).prop('disabled', true);
      let image_id = event.target.dataset.id;
      let url = this.filesDelete.replace(':id', image_id);
      axios
        .delete(url)
        .then(response => {
          this.removeImage(Number(image_id));
          this.$toasted.success(this.localization['File successfully deleted']);
        })
        .catch(error => {
          this.$toasted.error(this.localization['Error deleting file']);
          // submitButton.disabled = false
          $(event.target).prop('disabled', false);
        });
    },
    removeImage(id) {
      for (let i in this.images) {
        if (this.images[i].id === id) {
          this.images.splice(i, 1);
        }
      }
    },
    onFormSubmit() {
      // проверяет наличие русского описание и тайтла, если нет переключает на вкладку с русским валидирует
      if (
        !this.translations['ru'].title ||
        !this.translations['ru'].intro ||
        (this.userRole && this.userRole === 'admin' && !this.translations['ru'].meta_title) ||
        (this.userRole === 'admin' && !this.translations['ru'].meta_description)
      ) {
        this.activeTab = 'ru';
        this.$nextTick(() => {
          this.$refs.tourForm.reportValidity();
        });
      } else if (!this.$refs.tourForm.checkValidity()) {
        this.$refs.tourForm.reportValidity();
      } else {
        this.sendForm();
      }
    },
    sendForm() {
      this.formIsSent = true;
      if (!this.isPaidOptionsHavePrice) {
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
      if (!this.partner.vat) {
        this.tour.prepay = this.tour.commission;
      }
      let data = Object.assign(
        {},
        {
          main_image: this.mainImage,
          images: this.images,
          options: formattedOptions,
        },
        this.tour,
        this.translations
      );
      axios
        .post(this.formAction, data)
        .then(response => {
          if (this.formRole === 'create') {
            this.$toasted.success(this.localization['Tour successfully created']);
            setTimeout(() => {
              this.$toasted.info(this.localization['Now you will be redirected to the tour editing page']);
            }, 2000);
            setTimeout(() => {
              this.formIsSent = false;
              window.location.href = response.data.redirect;
            }, 3000);
          } else {
            // if (response.data.tour) {
            //     this.tour = response.data.tour;
            //     this.setValuesFromSrc()
            // }
            this.$toasted.success(this.localization['Changes in the tour are saved']);
            this.formIsSent = false;
            window.location.reload();
          }
        })
        .catch(error => {
          this.$toasted.error(error.message);
          this.formIsSent = false;
        });
    },
    setValuesFromSrc() {
      if (this.gallery && this.gallery.length > 0) {
        this.images = this.gallery.sort((a, b) => {
          if(a.mainImage) {
            this.mainImage = a.id
          }
          return a.order - b.order
        });
      }
      // set Translations and descriptionContent (for TinyMCE content)
      if (this.tour.translations && this.tour.translations.length > 0) {
        for (let i in this.tour.translations) {
          this.translations[this.tour.translations[i].locale] = this.tour.translations[i];
          this.descriptionContent[this.tour.translations[i].locale].description = this.tour.translations[i].description;
        }
      }
      // set selectedStartPlaceObject
      if (this.tour.start_place_id) {
        for (let i in this.composerPlaces) {
          if (this.composerPlaces[i].id == this.tour.start_place_id) {
            this.selectedStartPlaceObject = this.composerPlaces[i];
          }
        }
      }
      if (this.tour.food_option_id) {
        this.foodOption = true;
      }
      // set Checked Options
      if (this.tour.options.length > 0) {
        for (let i = 0; i < this.tour.options.length; i++) {
          this.checkedOptions.push(this.tour.options[i].id);
          this.$set(this.checkedOptionsFree, this.tour.options[i].id, this.tour.options[i].pivot.free + '');
          this.$set(
            this.checkedOptionsPrices,
            this.tour.options[i].id,
            this.tour.options[i].pivot.price ? this.tour.options[i].pivot.price : ''
          );
        }
      }

      this.transmit.paramsGallery.model_id = this.transmit.paramsThumb.tour_id = this.tour.id;

      if (!this.tour.currency_id) {
        this.tour.currency_id = this.acceptableCurrencies.find(cur => cur.code === 'USD').id;
      }
      for (let index in this.acceptableCurrencies) {
        if (this.acceptableCurrencies[index].id === this.tour.currency_id) {
          this.currency = this.acceptableCurrencies[index];
        }
      }

      if (this.currentTourTypes && this.currentTourTypes.length) {
        this.tour.types = this.currentTourTypes;
      }
    },
    commissionProposalMake() {
      if (!this.tour.commission_proposal) {
        this.tour.commission_proposal = 15;
      }
    },
    commissionProposalUndo() {
      this.$set(this.tour, 'commission_proposal', null);
    },
    commissionProposalReject() {
      this.commissionProposalUndo();
    },
    commissionProposalAccept() {
      this.$set(this.tour, 'commission', this.tour.commission_proposal);
      this.commissionProposalUndo();
    },
  },
  watch: {
    currency: function(item) {
      this.tour.currency_code = item.code;
      this.tour.currency_id = item.id;
    },
    selectedStartPlaceObject: function(item) {
      this.tour.start_place_id = item.id;
    },
    foodOption(val) {
      if (val && !this.tour.food_option_id) {
        this.tour.food_option_id = this.foodOptions[0].id;
      }
      if (!val) {
        this.tour.food_option_id = null;
      }
    },
  },
  created() {
    this.$store.dispatch('receiveLoading', true);
    if (this.tourSrc) {
      this.tour = this.tourSrc;
    }
    document.addEventListener('DOMContentLoaded', () => {
      this.transmit.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
      this.$store.dispatch('receiveComposerPlaces', window.composer_places);
      this.$store.dispatch('receiveOptionGroups', window.optionGroups);
      this.$store.dispatch('receiveLoading', false);
      this.setValuesFromSrc();
      // заполняет все языки в переводах
      ['ru', 'en', 'ka'].forEach(lang => {
        if (this.tour.price_options) {
          this.tour.price_options.forEach((option, index) => {
            let exist = option.translations.filter(trans => trans.locale === lang);
            if (!exist.length) {
              this.tour.price_options[index].translations.push({
                locale: lang,
                name: '',
              });
            }
          });
        }
      });
    });
  },
};
</script>

<style>
.vue-js-switch {
  margin: 7px;
}

.vue-js-switch .v-switch-label {
  font-size: 14px;
  color: #000 !important;
}

.mce-fullscreen {
  z-index: 9999 !important;
}

.col-4--custom {
  padding-left: 10px;
}

.m-radio-inline--custom {
  padding-left: 30px;
}

.images-list {
  display: flex;
position: relative;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

.image-uploader .mt-5 {
  margin: 5px 0 0 0 !important;
}

.image-uploader .media {
  border-top: 1px solid #ebedf2 !important;
  background: #f5f5f5 !important;
  margin: 0 !important;
  padding: 5px !important;
}

.image-uploader {
  border: 1px solid #ebedf2;
  padding: 5px;
}

.image-uploader__zone {
  background: repeating-radial-gradient(circle, #ffffff, #ffffff 10px, #f5f5f5 10px, #f5f5f5 20px);
  height: 70px;
  cursor: pointer;
}

.images-list__item {
  display: flex;
  flex-flow: column;
  padding: 20px 5px 10px;
  position: relative;
  border: 1px solid #ebedf2;
  border-radius: 5px;
  margin: 5px;
  background-color: #f7f8fa;
}

.images-list__item_title {
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  font-weight: bold;
}

.images-list button {
  position: absolute;
  top: 5px;
  right: 5px;
  background: none;
  color: #ff9696;
  border: none;
  cursor: pointer;
}

.images-list button:hover {
  color: #ff0000;
}

.images-list button:focus {
  outline: none;
}

.img-thumbnail {

}

.img-thumbnail-wrapper {
  height: 150px;
  width: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.row__border {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  padding: 1em 0;
}

fieldset[disabled] .multiselect {
  pointer-events: none;
}

.multiselect__spinner {
  position: absolute;
  right: 1px;
  top: 1px;
  width: 48px;
  height: 35px;
  background: #fff;
  display: block;
}

.multiselect__spinner:after,
.multiselect__spinner:before {
  position: absolute;
  content: '';
  top: 50%;
  left: 50%;
  margin: -8px 0 0 -8px;
  width: 16px;
  height: 16px;
  border-radius: 100%;
  border-color: #41b883 transparent transparent;
  border-style: solid;
  border-width: 2px;
  box-shadow: 0 0 0 1px transparent;
}

.multiselect__spinner:before {
  animation: a 2.4s cubic-bezier(0.41, 0.26, 0.2, 0.62);
  animation-iteration-count: infinite;
}

.multiselect__spinner:after {
  animation: a 2.4s cubic-bezier(0.51, 0.09, 0.21, 0.8);
  animation-iteration-count: infinite;
}

.multiselect__loading-enter-active,
.multiselect__loading-leave-active {
  transition: opacity 0.4s ease-in-out;
  opacity: 1;
}

.multiselect__loading-enter,
.multiselect__loading-leave-active {
  opacity: 0;
}

.multiselect,
.multiselect__input,
.multiselect__single {
  font-family: inherit;
  font-size: 14px;
  -ms-touch-action: manipulation;
  touch-action: manipulation;
}

.multiselect {
  box-sizing: content-box;
  display: block;
  position: relative;
  width: 100%;
  min-height: 40px;
  text-align: left;
  color: #35495e;
}

.multiselect * {
  box-sizing: border-box;
}

.multiselect:focus {
  outline: none;
}

.multiselect--disabled {
  opacity: 0.6;
}

.multiselect--active {
  z-index: 1;
}

.multiselect--active:not(.multiselect--above) .multiselect__current,
.multiselect--active:not(.multiselect--above) .multiselect__input,
.multiselect--active:not(.multiselect--above) .multiselect__tags {
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

.multiselect--active .multiselect__select {
  transform: rotate(180deg);
}

.multiselect--above.multiselect--active .multiselect__current,
.multiselect--above.multiselect--active .multiselect__input,
.multiselect--above.multiselect--active .multiselect__tags {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.multiselect__input,
.multiselect__single {
  position: relative;
  display: inline-block;
  min-height: 20px;
  line-height: 20px;
  border: none;
  border-radius: 5px;
  background: #fff;
  padding: 0 0 0 5px;
  width: 100%;
  transition: border 0.1s ease;
  box-sizing: border-box;
  margin-bottom: 8px;
  vertical-align: top;
}

.multiselect__tag ~ .multiselect__input,
.multiselect__tag ~ .multiselect__single {
  width: auto;
}

.multiselect__input:hover,
.multiselect__single:hover {
  border-color: #cfcfcf;
}

.multiselect__input:focus,
.multiselect__single:focus {
  border-color: #a8a8a8;
  outline: none;
}

.multiselect__single {
  padding-left: 6px;
  margin-bottom: 8px;
}

.multiselect__tags-wrap {
  display: inline;
}

.multiselect__tags {
  min-height: 40px;
  display: block;
  padding: 8px 40px 0 8px;
  border-radius: 5px;
  border: 1px solid #e8e8e8;
  background: #fff;
}

.multiselect__tag {
  position: relative;
  display: inline-block;
  padding: 4px 26px 4px 10px;
  border-radius: 5px;
  margin-right: 10px;
  color: #fff;
  line-height: 1;
  background: #41b883;
  margin-bottom: 5px;
  white-space: nowrap;
  overflow: hidden;
  max-width: 100%;
  text-overflow: ellipsis;
}

.multiselect__tag-icon {
  cursor: pointer;
  margin-left: 7px;
  position: absolute;
  right: 0;
  top: 0;
  bottom: 0;
  font-weight: 700;
  font-style: normal;
  width: 22px;
  text-align: center;
  line-height: 22px;
  transition: all 0.2s ease;
  border-radius: 5px;
}

.multiselect__tag-icon:after {
  content: '\D7';
  color: #266d4d;
  font-size: 14px;
}

.multiselect__tag-icon:focus,
.multiselect__tag-icon:hover {
  background: #369a6e;
}

.multiselect__tag-icon:focus:after,
.multiselect__tag-icon:hover:after {
  color: #fff;
}

.multiselect__current {
  min-height: 40px;
  overflow: hidden;
  padding: 8px 12px 0;
  padding-right: 30px;
  white-space: nowrap;
  border-radius: 5px;
  border: 1px solid #e8e8e8;
}

.multiselect__current,
.multiselect__select {
  line-height: 16px;
  box-sizing: border-box;
  display: block;
  margin: 0;
  text-decoration: none;
  cursor: pointer;
}

.multiselect__select {
  position: absolute;
  width: 40px;
  height: 38px;
  right: 1px;
  top: 1px;
  padding: 4px 8px;
  text-align: center;
  transition: transform 0.2s ease;
}

.multiselect__select:before {
  position: relative;
  right: 0;
  top: 65%;
  color: #999;
  margin-top: 4px;
  border-style: solid;
  border-width: 5px 5px 0;
  border-color: #999 transparent transparent;
  content: '';
}

.multiselect__placeholder {
  color: #adadad;
  display: inline-block;
  margin-bottom: 10px;
  padding-top: 2px;
}

.multiselect--active .multiselect__placeholder {
  display: none;
}

.multiselect__content-wrapper {
  position: absolute;
  display: block;
  background: #fff;
  width: 100%;
  max-height: 240px;
  overflow: auto;
  border: 1px solid #e8e8e8;
  border-top: none;
  border-bottom-left-radius: 5px;
  border-bottom-right-radius: 5px;
  z-index: 1;
  -webkit-overflow-scrolling: touch;
}

.multiselect__content {
  list-style: none;
  display: inline-block;
  padding: 0;
  margin: 0;
  min-width: 100%;
  vertical-align: top;
}

.multiselect--above .multiselect__content-wrapper {
  bottom: 100%;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  border-bottom: none;
  border-top: 1px solid #e8e8e8;
}

.multiselect__content::webkit-scrollbar {
  display: none;
}

.multiselect__element {
  display: block;
}

.multiselect__option {
  display: block;
  padding: 12px;
  min-height: 40px;
  line-height: 16px;
  text-decoration: none;
  text-transform: none;
  vertical-align: middle;
  position: relative;
  cursor: pointer;
  white-space: nowrap;
}

.multiselect__option:after {
  top: 0;
  right: 0;
  position: absolute;
  line-height: 40px;
  padding-right: 12px;
  padding-left: 20px;
}

.multiselect__option--highlight {
  background: #41b883;
  outline: none;
  color: #fff;
}

.multiselect__option--highlight:after {
  content: attr(data-select);
  background: #41b883;
  color: #fff;
}

.multiselect__option--selected {
  background: #f3f3f3;
  color: #35495e;
  font-weight: 700;
}

.multiselect__option--selected:after {
  content: attr(data-selected);
  color: silver;
}

.multiselect__option--selected.multiselect__option--highlight {
  background: #ff6a6a;
  color: #fff;
}

.multiselect__option--selected.multiselect__option--highlight:after {
  background: #ff6a6a;
  content: attr(data-deselect);
  color: #fff;
}

.multiselect--disabled {
  background: #ededed;
  pointer-events: none;
}

.multiselect--disabled .multiselect__current,
.multiselect--disabled .multiselect__select,
.multiselect__option--disabled {
  background: #ededed;
  color: #a6a6a6;
}

.multiselect__option--disabled {
  cursor: text;
  pointer-events: none;
}

.multiselect__option--disabled.multiselect__option--highlight {
  background: #dedede !important;
}

.multiselect-enter-active,
.multiselect-leave-active {
  transition: all 0.15s ease;
}

.multiselect-enter,
.multiselect-leave-active {
  opacity: 0;
}

.multiselect__strong {
  margin-bottom: 8px;
  line-height: 20px;
  display: inline-block;
  vertical-align: top;
}

[dir='rtl'] .multiselect {
  text-align: right;
}

[dir='rtl'] .multiselect__select {
  right: auto;
  left: 1px;
}

[dir='rtl'] .multiselect__tags {
  padding: 8px 8px 0 40px;
}

[dir='rtl'] .multiselect__content {
  text-align: right;
}

[dir='rtl'] .multiselect__option:after {
  right: auto;
  left: 0;
}

[dir='rtl'] .multiselect__clear {
  right: auto;
  left: 12px;
}

[dir='rtl'] .multiselect__spinner {
  right: auto;
  left: 1px;
}

@keyframes a {
  0% {
    transform: rotate(0);
  }
  to {
    transform: rotate(2turn);
  }
}

.ql-toolbar.ql-snow,
.ql-container.ql-snow {
  border: 1px solid #ebedf2 !important;
}

.quill-editor {
  min-height: 100px;
}

.ql-editor {
  min-height: 300px;
  max-height: 800px;
  overflow: auto;
}

b,
strong {
  font-weight: 700;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
