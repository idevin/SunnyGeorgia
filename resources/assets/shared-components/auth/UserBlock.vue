<template>
  <div class="mainMenuItem">
    <template v-if="user">
      <a :href="dashboardRoute" class="profile">
        <img v-if="user.avatar && user.avatar.url" :src="user.avatar.url" alt="user avatar" />
        <img v-else src="/assets/app/media/img/users/anonimus.png" alt="user avatar" />
        <span v-if="user.display_name">
          {{ user.display_name }}
        </span>
        <span v-else-if="user.first_name">
          {{ user.first_name }} {{ user.last_name }}
        </span>
        <span v-else>
          {{ user.email }}
        </span>
      </a>
      <div class="mainMenuDropDown hoverLinkAnimate text-left">
        <ul>
          <li>
            <a :href="dashboardRoute">{{ cabinetText }}</a>
          </li>
          <li>
            <a :href="logoutRoute" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ logoutText }}</a>
          </li>
        </ul>
      </div>
      <form id="logout-form" :action="logoutRoute" method="POST" style="display: none;">
        <input type="hidden" name="_token" :value="user.csrfToken" />
      </form>
    </template>
    <template v-else>
      <span @click="openModal('login')">
        {{ loginText }}
      </span>
      <span class="inline-button" @click="openModal('registration')">
        {{ registrationText }}
      </span>
    </template>
  </div>
</template>

<script>
export default {
  name: 'user-block',
  props: {
    'dashboard-route': {
      type: String,
      default: 'cabinet',
    },
    'logout-route': {
      type: String,
      default: 'ru/logout',
    },
    'cabinet-text': {
      type: String,
      default: 'кабинет',
    },
    'login-text': {
      type: String,
      default: 'войти',
    },
    'logout-text': {
      type: String,
      default: 'выйти',
    },
    'registration-text': {
      type: String,
      default: 'зарегистрироватся',
    },
  },
  computed: {
    user() {
      return this.$store.getters.user;
    },
  },
  methods: {
    openModal(tab) {
      this.$store.commit('authModalTab', tab);
    },
  },
};
</script>
