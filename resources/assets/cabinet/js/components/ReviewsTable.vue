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
                            <input type="checkbox" v-model="params.author"
                                   :true-value="true"
                                   :false-value="null"
                            >
                            Пользовательские
                            <span></span>
                        </label>
                    </div>
                    <div class="btn btn-clean">
                        <label class="m-checkbox">
                            <input type="checkbox" v-model="params.generated"
                                   :true-value="true"
                                   :false-value="null"
                            >
                            Сгенерированные
                            <span></span>
                        </label>
                    </div>
                    <div class="btn btn-clean">
                        <label class="m-checkbox">
                            <input type="checkbox" v-model="params.not_published"
                                   :true-value="true"
                                   :false-value="null"
                            >
                            Не проверенные
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
                        <template v-else-if="th === 'Имя'">
                            <a href=""
                               class="m-btn--link"
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
                    <th>Автор</th>
                    <th>Одобрен</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="tr in data">
                    <td v-for="td in fields">
                        <span v-if="td === 'Дата'" style="white-space: nowrap">
                            {{tr['updated_at'].split(' ')[0]}}
                        </span>
                        <div v-else-if="td === 'Имя'">
                            <template v-if="tr['author']">
                                {{tr['author']['display_name'] ? tr['author']['display_name'] : tr['author']['first_name']}}
                                <br>
                                {{tr['author']['email']}}
                            </template>
                            <template v-else>
                                {{tr['author_name']}}
                            </template>

                        </div>
                        <div v-else-if="td === 'Страна'">
                            <template v-if="tr['author']">
                                {{tr['author']['country']}}
                            </template>
                            <template v-else>
                                {{tr['author_country']}}
                            </template>

                        </div>
                        <div v-else-if="td === 'Текст'" style="word-break: break-word">
                            {{tr['body']}}
                        </div>
                        <div v-else-if="td === 'Оценка'">
                            {{tr['rating']}}
                        </div>
                    </td>
                    <td>
                        <span class="badge btn btn-lg"
                              :class="tr.author ? 'badge-success' : 'badge-warning'"
                        >{{tr.author ? 'Пользователь' : 'Сгенерирован'}}</span>
                    </td>
                    <td>
                        <toggle-button :value="tr.published"
                                       @change="publishedToggle($event, tr)"
                                       :sync="true"
                                       id="input_published"
                                       :labels="{checked: 'Да', unchecked: 'Нет'}"
                        />
                    </td>
                    <td>
                        <div class="btn-group">
                            <a :href="route + '/' + tr.id"
                               class="m--margin-right-10"
                            >
                                <i class="fa fa-pencil-alt"></i>
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
        props: ["route", "fields"],
        data() {
            return {
                loading: false,
                places: [],
                emails: [],
                data: [],
                params: {
                    not_published: null,
                    generated: null,
                    author: null
                },
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
            "params.not_published" () {
                this.getData();
            },
            'params.generated' () {
                this.getData();
            },
            'params.author' () {
                this.getData();
            }
        },
        methods: {
            deleteConfirm: function (id) {
                this.id = id;
                this.$refs.confirm_modal.click();
            },
            publishedToggle(event, row) {
                axios.get(this.route + '/' + row.id + '/toggle')
                .then(response => {
                    this.$toasted.success('Отзыв обновлен');
                    this.getData();
                }).catch(error => {
                    this.$toasted.error('Ошибка сервера, повторите запросс')
                })
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
                    this.data = response.data.reviews.concat(response.data.generatedReviews);
                    // this.pages.last = response.data.last_page;
                    // if (this.params.page > this.pages.last) {
                    //     this.params.page = this.pages.last
                    // }
                    this.totalFound = response.data.reviews.length + response.data.generatedReviews.length;
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
        }
    }
</script>

<style scoped>
    thead th {
        font-weight: bold;
    }
</style>
