<template>
    <div class="main-mobile-menu__sub">
        <template v-if="user">
            <div class="main-mobile-menu__sub-item">
                <a class="main-mobile-menu__sub-item-title" :href="dashboardRoute">
                    <div class="container">{{cabinetText}}</div>
                </a>
            </div>
            <div class="main-mobile-menu__sub-item">
                <a :href="logoutRoute" class="main-mobile-menu__sub-item-title"
                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                >
                    <div class="container">{{logoutText}}</div>
                </a>
            </div>
            <form id="logout-form-mobile"
                  :action="logoutRoute"
                  method="POST"
                  style="display: none;"
            >
                <input type="hidden" name="_token" :value="user.csrfToken">
            </form>
        </template>
        <template v-else>
            <div class="main-mobile-menu__sub-item">
                <div class="main-mobile-menu__sub-item-title" @click="openModal('login')">
                    <div class="container">
                        {{loginText}}
                    </div>
                </div>
            </div>
            <div class="main-mobile-menu__sub-item">
                <div class="main-mobile-menu__sub-item-title" @click="openModal('registration')">
                    <div class="container">
                        {{registrationText}}
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        name: 'user-block-mobile',
        props: {
            'dashboard-route': {
                type: String,
                default: 'cabinet'
            },
            'logout-route': {
                type: String,
                default: 'ru/logout'
            },
            'cabinet-text': {
                type: String,
                default: 'кабинет'
            },
            'login-text': {
                type: String,
                default: 'войти'
            },
            'logout-text': {
                type: String,
                default: 'выйти'
            },
            'registration-text': {
                type: String,
                default: 'зарегистрироватся'
            }
        },
        computed: {
            user() {
                return this.$store.getters.user
            }
        },
        methods: {
            openModal(tab) {
                this.$store.commit('authModalTab', tab)
            }
        },
    }
</script>
