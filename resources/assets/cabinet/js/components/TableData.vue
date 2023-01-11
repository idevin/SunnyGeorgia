<template>
    <div class="m-portlet--last m-portlet--head m-portlet--responsive-mobile m-portlet" id="m_page_portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-checkbox-inline" v-if="loading">
                    <shared-loader></shared-loader>
                </div>
                <div class="m-checkbox-inline">
                    <div class="btn btn-clean">
                        <label class="m-checkbox">
                            <input type="checkbox" v-model="params.not_published"
                                   :true-value="true"
                                   :false-value="null"
                            >
                            Не опубликованные
                            <span></span>
                        </label>
                    </div>
                    <div class="btn btn-clean">
                        <label class="m-checkbox">
                            <input type="checkbox" v-model="params.not_reviewed"
                                   :true-value="true"
                                   :false-value="null"
                            >
                            Не проверенные
                            <span></span>
                        </label>
                    </div>
                    <div class="btn btn-clean">
                        <label class="m-checkbox">
                            <input type="checkbox" v-model="params.with_trashed"
                                   :true-value="true"
                                   :false-value="null"
                            >
                            Показывать удаленные
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <div class="btn-group m--margin-right-20">
                    <span class="filter_result_details__label m--margin-right-5">Всего найдено:</span>
                    <span class="filter_result_details__content">{{totalFound}}</span>
                </div>
                <div class="btn-group" role="group" v-if="pages.last > 1">
                    <a href="#" class="btn btn-light text-dark" v-if="params.page > 1" @click="params.page -= 1">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    <a href="#" class="btn btn-light"
                       v-for="i in pages.last"
                       :class="[params.page == i ? 'active' : (i - params.page > 3) || (params.page - i > 3)  ? 'd-none' : '']"
                       @click="params.page = i">
                        {{i}}
                    </a>
                    <a href="#" class="btn btn-light text-dark" v-if="params.page < pages.last"
                       @click="params.page += 1">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-md-4 form">
                    <select class="form-control ml-2" v-model="params.search_email" v-if="emails.length > 1">
                        <option :value="null">Email владельца</option>
                        <option :value="email" v-for="email in emails">{{email}}</option>
                    </select>
                    <input class="form-control ml-2" v-if="emails.length == 1" :value="emails[0]" disabled>
                </div>
                <div class="col-md-4 form">
                    <input type="text" class="form-control ml-2" v-model="params.search_title" placeholder="Заголовок">
                </div>
                <div class="col-md-4 form pr-5">
                    <select class="form-control" v-model="params.search_place_id">
                        <option :value="null">Город</option>
                        <option :value="place.id" v-for="place in places">{{place.name}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="m-portlet__body m-portlet__body--no-top-padding">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th v-for="th in fields" class="">
                        <template v-if="th === 'id'">
                            <a href=""
                               class="m-btn--link"
                               :style="{'min-width': order[0] === 'id' ? '40px' : '0'}"
                               style="display: block"
                               @click.prevent="order = (order[1] === 'asc')? ['id', 'desc'] : ['id', 'asc']"
                            >
                                {{th}}
                                <i class="la la-arrow-down" v-if="order[0] === 'id' && order[1] === 'desc'"></i>
                                <i class="la la-arrow-up" v-if="order[0] === 'id' && order[1] === 'asc'"></i>
                            </a>
                        </template>
                        <template v-else-if="th === 'Дата'">
                            <a href=""
                               class="m-btn--link"
                               @click.prevent="order = (order[1] === 'asc')? ['updated_at', 'desc'] : ['updated_at', 'asc']"
                            >
                                {{th}}
                                <i class="la la-arrow-down" v-if="order[0] === 'updated_at' && order[1] === 'desc'"></i>
                                <i class="la la-arrow-up" v-if="order[0] === 'updated_at' && order[1] === 'asc'"></i>
                            </a>
                        </template>
                        <template v-else-if="th === 'Вес'">
                            <a href=""
                               class="m-btn--link"
                               :style="{'min-width': order[0] === 'score' ? '60px' : '0'}"
                               style="display: block"
                               @click.prevent="order = (order[1] === 'asc')? ['score', 'desc'] : ['score', 'asc']"
                            >
                                {{th}}
                                <i class="la la-arrow-down" v-if="order[0] === 'score' && order[1] === 'desc'"></i>
                                <i class="la la-arrow-up" v-if="order[0] === 'score' && order[1] === 'asc'"></i>
                            </a>
                        </template>
                        <template v-else>{{th}}</template>
                    </th>
                    <th>Статус</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="tr in data">
                    <td v-for="td in fields">
                        <span v-if="td === 'Дата'" style="white-space: nowrap">
                            {{tr['updated_at'].split(' ')[0]}}
                        </span>
                        <div v-else-if="td === 'Владелец'">
                            {{tr['user']['email']}}
                            <br>
                            {{tr['user']['first_name']}} {{tr['user']['last_name']}}
                        </div>
                        <div v-else-if="td === 'Картинка'">
                            <img :src="tr.new_thumb.jpg" width="80" v-if="tr.new_thumb != null">
                        </div>
                        <div v-else-if="td === 'Город'">
                            {{tr['place_name']}}
                        </div>
                        <span v-else-if="td === 'Вес'">
                            {{tr['score']}}
                        </span>
                        <span v-else-if="td === 'Заголовок'">
                            {{tr['title']}}
                        </span>
                        <span v-else>{{tr[td]}}</span>
                    </td>
                    <td>
                        <span class="badge badge-success" v-if="tr.published == true">Опубликован</span>
                        <span class="badge badge-warning" v-else>Не опубликован</span>
                        <br>
                        <span class="badge badge-success" v-if="tr.reviewed == true">Проверен</span>
                        <span class="badge badge-warning" v-else>Не проверен</span>
                        <br>
                        <!--                       <span class="badge badge-success" v-if="tr.published == true && tr.reviewed == true">Отображается</span>-->
                        <!--                       <span class="badge badge-primary" v-else>Скрыт</span>-->
                        <!--                       <br>-->
                        <span class="badge badge-danger" v-if="tr.deleted_at">Удалено</span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a :href="route+'/'+tr['id']"
                               class="m--margin-right-10"
                            >
                                <i class="fa fa-pencil-alt"></i>
                            </a>

                            <a :href="route+'/'+tr['id']+'/calendar'"
                               class="m--margin-right-10"
                            >
                                <i class="fa fa-calendar-alt"></i>
                            </a>
                            <!--todo implement restore-->
                            <a v-if="tr.deleted_at" class="">
                                <i class="fa fa-arrow-up"></i>
                            </a>
                            <a href="" v-else class="" @click.prevent="deleteConfirm(tr['id'])">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Confirm modal -->
        <div class="btn btn-default hidden" style="display:none;" ref="confirm_modal" data-toggle="modal"
             data-target=".confirm-modal-sm"></div>
        <div class="modal fade confirm-modal-sm" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <h4>Confirm the deletion of the line with id {{id}}</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="id = null">Close
                        </button>
                        <button type="button" class="btn btn-primary" @click="deleteRow()">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center">
                <div class="btn-group my-2 px-2 mx-auto" role="group" v-if="pages.last > 1">
                    <a href="#" class="btn btn-light text-dark" v-if="params.page > 1" @click="params.page -= 1">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    <a href="#" class="btn btn-light"
                       v-for="i in pages.last"
                       :class="[params.page == i ? 'active' : (i - params.page > 3) || (params.page - i > 3)  ? 'd-none' : '']"
                       @click="params.page = i">
                        {{i}}
                    </a>
                    <a href="#" class="btn btn-light text-dark" v-if="params.page < pages.last"
                       @click="params.page += 1">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["route", "places_groups", "users", "fields"],
        data() {
            return {
                loading: false,
                places: [],
                emails: [],
                data: [],
                params: {
                    search_title: "",
                    search_place_id: null,
                    search_email: null,
                    not_published: null,
                    not_reviewed: null,
                    with_trashed: null,
                    page: 1,
                    order: "updated_at__desc",
                },
                field_search: "Title",
                pages: {
                    last: 0,
                    limit: 20
                },
                order: ["updated_at", "desc"],
                totalFound: 0,
                id: null
            }
        },
        watch: {
            "params.search_title": function () {
                this.getData();
            },
            "params.search_place_id": function () {
                this.getData();
            },
            "params.search_email": function () {
                this.getData();
            },
            'params.not_published': function () {
                this.getData();
            },
            'params.not_reviewed': function () {
                this.getData();
            },
            'params.with_trashed': function () {
                this.getData();
            },
            "params.page"() {
                this.getData();
            },
            "order"() {
                this.getData();
            }
        },
        methods: {
            deleteConfirm: function (id) {
                this.id = id;
                this.$refs.confirm_modal.click();
            },
            deleteRow: function () {
                this.$refs.confirm_modal.click();
                if (this.id) {
                    axios.post(this.route + '/' + this.id, {
                        _method: 'delete'
                    }).then((response) => {
                        this.id = null;
                        this.getData();
                    });
                }

            },
            getData: function () {
                if (typeof this._source != typeof undefined) {
                    this._source.cancel('Operation canceled due to new request.')
                }
                this.loading = true;
                this._source = axios.CancelToken.source();
                this.params.order = this.order.join('__');
                axios.get(this.route, {
                    cancelToken: this._source.token,
                    params: this.params
                }).then((response) => {
                    this.data = response.data.data;
                    this.pages.last = response.data.last_page;

                    if (this.params.page > this.pages.last) {
                        this.params.page = this.pages.last
                    }
                    this.totalFound = response.data.total;
                    this.loading = false;
                }).catch(error => {
                    if (axios.isCancel(error)) {
                        console.log('Request canceled', error);
                        this.$toasted.error('Дождитесь загрузки!')
                    } else {
                        this.loading = false;
                        console.log(error);
                    }
                });
            }
        },
        created() {
            this.getData();
            JSON.parse(this.places_groups).forEach((plg) => {
                plg.places.forEach((place) => {
                    this.places.push(place);
                })
            });

            JSON.parse(this.users).forEach((usr) => {
                this.emails.push(usr.email);
            })
        }

    }
</script>

<style scoped>
    thead th {
        font-weight: bold;
    }
</style>
