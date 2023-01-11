// https://github.com/rmariuzzo/laravel-localization-loader
export default {
    // The key format should be: 'locale.filename'.
    'en.auth': require('../../../lang/en/authModal.php'),
    'ru.auth': require('../../../lang/ru/authModal.php'),
    'ka.auth': require('../../../lang/ka/authModal.php'),

    'en.listItem': require('../../../lang/en/tours-list/listItem.php'),
    'ru.listItem': require('../../../lang/ru/tours-list/listItem.php'),
    'ka.listItem': require('../../../lang/ka/tours-list/listItem.php'),

    'en.search': require('../../../lang/en/tours-list/search.php'),
    'ru.search': require('../../../lang/ru/tours-list/search.php'),
    'ka.search': require('../../../lang/ka/tours-list/search.php'),

    'ka.sort': require('../../../lang/ka/tours-list/sort.php'),
    'en.sort': require('../../../lang/en/tours-list/sort.php'),
    'ru.sort': require('../../../lang/ru/tours-list/sort.php'),

    'ka.filter': require('../../../lang/ka/tours-list/filter.php'),
    'en.filter': require('../../../lang/en/tours-list/filter.php'),
    'ru.filter': require('../../../lang/ru/tours-list/filter.php'),
}
