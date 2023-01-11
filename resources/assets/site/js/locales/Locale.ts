import Vue     from 'vue';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n);

export const i18n = new VueI18n({
  locale: (<any>window).Laravel.locale === null ? 'ru' : (<any>window).Laravel.locale,
  fallbackLocale: 'en',
  silentTranslationWarn: process.env.NODE_ENV !== 'development',
  messages: {
    'en': require('./import/en.json'),
    'ka': require('./import/ka.json'),
    'ru': require('./import/ru.json')
  }
});

export default i18n;
