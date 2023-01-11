// main
import is from 'is_js'
import * as noUiSlider from 'nouislider'

$(function () {
    (function () {

        var monthNames = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
        var daysOfWeek = ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"];

        if (window.transDates.months) monthNames = Object.values(window.transDates.months).slice(0, 12);
        if (window.transDates.day_of_week) daysOfWeek = Object.values(window.transDates.day_of_week);

        $.fn.exists = function () {
            return this.length > 0;
        };
        const isMobileDevice = is.mobile()
        if (isMobileDevice) {
            $('#desciption-collapse').collapse('hide');
        }
        const isDesktopDevice = is.desktop();
        if (isDesktopDevice == true) {
            $('html').addClass('is-hover');
        }

        "use strict";

        var initWOW = function initWOW() {
        };
        "use strict";
        'use strict';

        var initDatePickers = function initDatePickers() {
            $('.js-date-single').daterangepicker({
                minDate: new Date(),
                autoUpdateInput: true,
                singleDatePicker: true,
                autoApply: true,
                opens: 'center',
                locale: {
                    cancelLabel: 'Отмена',
                    format: 'DD.MM.YYYY',
                    "daysOfWeek": daysOfWeek,
                    "monthNames": monthNames
                }
            });

            $('.js-date-interval').daterangepicker({
                minDate: new Date(),
                autoUpdateInput: true,
                singleDatePicker: false,
                autoApply: true,
                opens: 'center',
                locale: {
                    cancelLabel: 'Отмена',
                    format: 'DD.MM.YYYY',
                    "daysOfWeek": daysOfWeek,
                    "monthNames": monthNames
                }
            });

            $('.js-date-interval').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD.MM.YYYY') + " - " + picker.endDate.format('DD.MM.YYYY'));
            });
            $('.js-date-interval').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
            $('.js-date-single').on('show.daterangepicker', function (ev, picker) {
                $('.daterangepicker').addClass('blue-style')
            });
            $('.js-date-interval').on('show.daterangepicker', function (ev, picker) {
                $('.daterangepicker').addClass('blue-style')
            });

            // $('.timepicker').wickedpicker({
            //     twentyFour: true
            // });
            $(document).on('click', '.dropdown-menu', function (e) {
                e.stopPropagation();
            });

            // $('.js-range-date').daterangepicker({
            //     minDate: new Date(),
            //     autoUpdateInput: false,
            //     weekStart: 1,
            //     "autoApply": true,
            //     opens: 'center',
            //     locale: {
            //         cancelLabel: 'Отмена',
            //         format: 'DD.MM.YYYY',
            //         "daysOfWeek": ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
            //         "monthNames": ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"]
            //     }
            // });
            //
            // $('.js-date').daterangepicker({
            //     minDate: new Date(),
            //     autoUpdateInput: false,
            //     singleDatePicker: true,
            //     autoApply: true,
            //     opens: 'center',
            //     parentEl: $('.picker-parent') || null,
            //     locale: {
            //         cancelLabel: 'Отмена',
            //         format: 'DD.MM.YYYY',
            //         "daysOfWeek": ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
            //         "monthNames": ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"]
            //     }
            // });

            // $('.js-range-date').on('apply.daterangepicker', function (ev, picker) {
            //     $(this).val(picker.startDate.format('DD.MM.YYYY') + '   -   ' + picker.endDate.format('DD.MM.YYYY'));
            // });
            // $('.js-range-date').on('cancel.daterangepicker', function (ev, picker) {
            //     $(this).val('');
            // });
            // $('.js-range-date').on('show.daterangepicker', function (ev, picker) {
            //     $(picker.container).addClass('show');
            // });
            //
            // $('.js-date').on('apply.daterangepicker', function (ev, picker) {
            //     $(this).val(picker.startDate.format('DD.MM.YYYY'));
            // });
            // $('.js-date').on('cancel.daterangepicker', function (ev, picker) {
            //     $(this).val('');
            // });
            // $('.js-date').on('show.daterangepicker', function (ev, picker) {
            //     $(picker.container).addClass('show');
            // });
        };

        var initHomeFiltersTabs = function initHomeFiltersTabs() {
            var $wrapper = $('.home-filters')
            $(document).ready(function () {
                $wrapper.addClass('home-filters--bg-1');
            });
            $('.home-filters-tabs ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');

            $('.home-filters-tabs ul.tabs li a').click(function (g) {
                $wrapper.removeClass()
                $wrapper.addClass('home-filters')

                $wrapper.addClass($(this).data('bg'))

                var tab = $(this).closest('.home-filters-tabs'),
                    index = $(this).closest('li').index();

                tab.find('ul.tabs > li').removeClass('current');
                $(this).closest('li').addClass('current');

                tab.find('.home-filters-tabs__content').find('div.home-filters-tabs__content-item').not('div.home-filters-tabs__content-item:eq(' + index + ')').slideUp({duration: 0});
                tab.find('.home-filters-tabs__content').find('div.home-filters-tabs__content-item:eq(' + index + ')').slideDown({duration: 0});

                g.preventDefault();
            });

            $('.home-filters-form__toggler-button').click(function (event) {
                $(event.target).parents('.home-filters-form__toggler').next('div.home-filters-form__additionally').stop().slideToggle()
            });
        };

        var initPersonCounter = function initPersonCounter() {
            var $quantity = $('.quantity');
            $quantity.each(function () {
                var $this = $(this);
                var $quantityInput = $this.find('.qty');
                var personCounter = $quantityInput.val();

                var adultInfo = document.getElementById('tours-adult')
                var childrenInfo = document.getElementById('tours_children')

                $this.on('click', '.minus', function (e) {
                    if (personCounter >= 1) {
                        personCounter--;
                        $quantityInput.attr('value', personCounter);
                    }
                    if (e.target.classList.contains('check-adult')) {
                        adultInfo.innerHTML = personCounter
                    } else if (e.target.classList.contains('check-children')) {
                        childrenInfo.innerHTML = personCounter
                    }
                });

                $this.on('click', '.plus', function (e) {
                    if (personCounter < 500) {
                        personCounter++;
                        $quantityInput.attr('value', personCounter);
                    }
                    if (e.target.classList.contains('check-adult')) {
                        adultInfo.innerHTML = personCounter
                    } else if (e.target.classList.contains('check-children')) {
                        childrenInfo.innerHTML = personCounter
                    }
                });
            });
        };

        var initLength = function initLength() {
            var $lengthContainer = $('.js-length');
            $lengthContainer.each(function () {
                var $this = $(this);
                $this.on('click', '.length-point', function (e) {
                    e.preventDefault();

                    var valueFrom = $(this).data('value-from');
                    var valueTo = $(this).data('value-to');
                    var idx = $(this).index();
                    var hiddenFrom = $this.find('#days_range_from').attr('value');
                    var hiddenTo = $this.find('#days_range_to').attr('value');


                    if (valueFrom == hiddenFrom && valueTo == hiddenTo) { // Нажали на выбранный айтем
                        $this.find('[data-value], .search-length-value').removeClass('is-active');
                        $(this).removeClass('is-active');
                        $this.find('#days_range_from').attr('value', '');
                        $this.find('#days_range_to').attr('value', '');
                        $this.find('.search-length-value').eq(idx).removeClass('is-active');
                    } else {
                        $this.find('[data-value], .search-length-value').removeClass('is-active');
                        $(this).addClass('is-active');
                        $this.find('#days_range_from').attr('value', valueFrom);
                        $this.find('#days_range_to').attr('value', valueTo);

                        $this.find('.search-length-value').eq(idx).addClass('is-active');
                    }

                });
            });
        };
        "use strict";
        'use strict';

// $(document).on('hidden.bs.modal', '.modal', function () {
//     if ($('.modal:visible').length) {
//         // $(document.body).addClass('modal-open');
//         // $('.modal:visible').removeData('bs.modal');
//         // var scrollWidth = $('.modal:visible').data('bs.modal')._scrollbarWidth;
//         // $(document.body).css({'padding-right': scrollWidth});
//     } else {
//         // $(document.body).css({'padding-right': 0});
//     }
// });
        $('a[aria-controls="login"]').on('click', function () {
            $('#user-modal a[aria-controls="login"]').tab('show');
        });
        $('a[aria-controls="signup"]').on('click', function () {
            $('#user-modal a[aria-controls="signup"]').tab('show');
        });
        $("[data-toggle='tooltip']").tooltip();
        "use strict";
        'use strict';

        var initRange = function initRange() {
            var slider = document.getElementById('range-slider');
            var countMin = document.querySelector('.js-range-min');
            var countMax = document.querySelector('.js-range-max');
            var maxNum = $(slider).data('max');
            var minNum = $(slider).data('min');
            if (slider) {
                noUiSlider.create(slider, {
                    start: [minNum, maxNum],
                    tooltips: false,
                    connect: true,
                    step: 1,
                    range: {
                        'min': minNum,
                        'max': maxNum
                    },
                    format: wNumb({
                        decimals: 0
                    })
                });
                slider.noUiSlider.on('update', function (values, handle) {
                    countMin.innerHTML = values[0];
                    countMax.innerHTML = values[1];
                });
            }
        };
        'use strict';

        var hasClass = function hasClass(element, cls) {
            return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
        }

        var tabNavsControl = function tabNavsControl() {
            var i = 0;
            var links = document.getElementsByClassName('tab-nav-link');
            var wrapper = document.getElementById('places-wrapper');
            var controls = document.getElementById('sidebar-controls');


            for (i; i < links.length; i++) {
                if (hasClass(links[i], 'active')) {
                    wrapper.dataset.activeTab = links[i].dataset.tabName;
                    wrapper.classList.add('now-' + links[i].dataset.tabName);
                    controls.classList.add('now-' + links[i].dataset.tabName);
                }
            }
        };

        var initRating = function initRating() {
            $('.js-rating-star').raty({
                path: 'static/images/assets/rating',
                starOff: 'star-off.svg',
                starOn: 'star-on.svg'
            });
        };
        "use strict";
        'use strict';

        var initHomeFiltersForm = function initHomeFiltersForm() {
            var toursMaxPrice,
                excursionsMaxPrice;

            function selectScroll() {
                var $optionsContainer = $('.select2-dropdown .select2-results__options');
                $optionsContainer.niceScroll({
                    background: '#93a6ae',
                    cursorcolor: "#ffc411",
                    cursoropacitymin: 0,
                    cursoropacitymax: 1,
                    cursorwidth: "6px",
                    cursorborder: 0,
                    cursorborderradius: "3px",
                    cursorminheight: 30,
                    autohidemode: false
                });
            }

            var jsGeneralSelect = $('.js-general-select').select2({
                theme: 'dark',
                width: '100%',
                dropdownAutoWidth: true,
                minimumResultsForSearch: Infinity,
                overflow: 'scroll'
            });

            jsGeneralSelect.on('select2:open', function () {
                selectScroll();
            });

            var jsDaysSelect = $('.js-days-select').select2({
                theme: 'dark',
                width: '100%',
                dropdownAutoWidth: true,
                minimumResultsForSearch: Infinity,
                overflow: 'scroll'
            });

            jsDaysSelect.on('select2:open', function () {
                selectScroll();
            });

            jsDaysSelect.on('select2:select', function (event) {
                var arr = event.target.value.split(',');
                var from = document.getElementById('tourDaysFrom');
                var to = document.getElementById('tourDaysTo');
                from.value = arr[0];
                to.value = arr[1];
            });


            $('.js-general-date').daterangepicker({
                minDate: new Date(),
                autoUpdateInput: true,
                autoApply: true,
                singleDatePicker: false,
                opens: 'center',
                locale: {
                    cancelLabel: 'Отмена',
                    format: 'DD.MM.YYYY',
                    "daysOfWeek": daysOfWeek,
                    "monthNames": monthNames
                }
            });

            $('.js-single-date').daterangepicker({
                minDate: new Date(),
                singleDatePicker: true,
                opens: 'center',
                locale: {
                    cancelLabel: 'Отмена',
                    format: 'DD.MM.YYYY',
                    "daysOfWeek": daysOfWeek,
                    "monthNames": monthNames
                }
            });


            var tourPriceRangeSlider = document.getElementById('tourPriceRangeSlider');
            if (tourPriceRangeSlider) {
                toursMaxPrice = window.tour_filter_max_price ? window.tour_filter_max_price : 10000;
                noUiSlider.create(tourPriceRangeSlider, {
                    start: [1, toursMaxPrice],
                    connect: true,
                    range: {
                        'min': 1,
                        'max': toursMaxPrice
                    }
                });
                tourPriceRangeSlider.noUiSlider.on('update', function (values, handle) {
                    var from,
                        to,
                        fromSpan,
                        toSpan;

                    from = document.getElementById('tourPriceFrom');
                    to = document.getElementById('tourPriceTo');
                    fromSpan = document.getElementById('tourPriceFromSpan');
                    toSpan = document.getElementById('tourPriceToSpan');


                    from.value = parseInt(values[0]).toFixed(0);
                    to.value = parseInt(values[1]).toFixed(0);
                    fromSpan.innerText = parseInt(values[0]).toFixed(0);
                    toSpan.innerText = parseInt(values[1]).toFixed(0);
                });
            }


            var excursionsPriceRangeSlider = document.getElementById('excursionsPriceRangeSlider');
            if (excursionsPriceRangeSlider) {
                excursionsMaxPrice = window.excursion_filter_max_price ? window.excursion_filter_max_price : 10000;
                noUiSlider.create(excursionsPriceRangeSlider, {
                    start: [1, excursionsMaxPrice],
                    connect: true,
                    range: {
                        'min': 1,
                        'max': excursionsMaxPrice
                    }
                });
                excursionsPriceRangeSlider.noUiSlider.on('update', function (values, handle) {
                    var from,
                        to,
                        fromSpan,
                        toSpan;

                    from = document.getElementById('excursionsPriceFrom');
                    to = document.getElementById('excursionsPriceTo');
                    fromSpan = document.getElementById('excursionsPriceFromSpan');
                    toSpan = document.getElementById('excursionsPriceToSpan');


                    from.value = parseInt(values[0]).toFixed(0);
                    to.value = parseInt(values[1]).toFixed(0);
                    fromSpan.innerText = parseInt(values[0]).toFixed(0);
                    toSpan.innerText = parseInt(values[1]).toFixed(0);
                });
            }


        };

        var initSearchForm = function initSearchForm() {
            function selectScroll() {
                var $optionsContainer = $('.select2-dropdown .select2-results__options');
                $optionsContainer.niceScroll({
                    background: '#93a6ae',
                    cursorcolor: "#ffc411",
                    cursoropacitymin: 0,
                    cursoropacitymax: 1,
                    cursorwidth: "6px",
                    cursorborder: 0,
                    cursorborderradius: "3px",
                    cursorminheight: 30,
                    autohidemode: false
                });
            }

            function formatLiving(item) {
                var originalId = item.id,
                    originalOption = item.element,
                    originalText = item.text;
                if (!originalId) return originalText;
                var $icon = $('<svg class="icon ' + $(originalOption).data('icon') + '"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#' + $(originalOption).data('icon') + '"></use></svg>' + '<span class="select2-selection__text">' + originalText + '</span>');
                return $icon;
            };
            var living = $('.js-living').select2({
                theme: 'dark',
                templateResult: formatLiving,
                templateSelection: formatLiving,
                dropdownAutoWidth: true,
                minimumResultsForSearch: Infinity
            });
            living.on('select2:select', function (e) {
                var value = e.params.data.id;
                $('.search').attr('data-active', value);
                $('.search').attr('data-advanced', '');
                document.forms.search.reset();
                living.val(value).trigger("change");
            });
            $('.search-advanced').on('click', function (e) {
                e.preventDefault();
                var activeScreen = $('.search').attr('data-active');
                var activeAdvScreen = $('.search').attr('data-advanced');
                if (activeAdvScreen) {
                    setTimeout(function () {
                        $('.search').attr('data-advanced', '');
                    }, 300);
                    $('.search').find('[class*="field-advanced-"]').removeClass('zoomInSearch animated-search').addClass('zoomOutSearch animated-search');
                } else {
                    $('.search').attr('data-advanced', activeScreen);
                    $('.search').find('.field-advanced-' + activeScreen).removeClass('zoomOutSearch animated-search').addClass('zoomInSearch animated-search');
                }
            });

            function formatLocation(item) {
                return $('<svg class="icon icon--location"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#location"></use></svg><span class="select2-selection__text">' + item.text + '</span>');
            };
            var location = $('.js-location').each(function () {
                $(this).select2({
                    theme: 'dark',
                    dropdownAutoWidth: true,
                    templateSelection: formatLocation,
                    placeholder: $(this).data('placeholder')
                });
            });
            location.on('select2:open', function () {
                selectScroll();
            });

            function formatDinnerIcon(item) {
                var $icon = void 0;
                if ($(item.element).attr('value')) {
                    $icon = $('<svg class="icon icon--food"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#food"></use></svg>' + '<span class="select2-selection__text">' + item.text + '</span>');
                } else {
                    $icon = $('<svg class="icon icon--food"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#food"></use></svg><span class="select2-selection__text">' + item.text + '</span>');
                }
                return $icon;
            };

            function formatDinnerResult(item) {
                if (!$(item.element).attr('value')) return item.text;
                var $icon = $('<span class="select2-selection__text">' + item.text + '</span>');
                return $icon;
            };
            var dinner = $('.js-dinner').each(function () {
                $(this).select2({
                    theme: 'dark',
                    dropdownAutoWidth: true,
                    templateSelection: formatDinnerIcon,
                    templateResult: formatDinnerResult,
                    minimumResultsForSearch: Infinity,
                    placeholder: $(this).data('placeholder')
                });
            });
            $('.js-range-date').daterangepicker({
                autoUpdateInput: false,
                weekStart: 1,
                "autoApply": true,
                opens: 'center',
                locale: {
                    cancelLabel: 'Отмена',
                    format: 'DD.MM.YYYY',
                    "daysOfWeek": daysOfWeek,
                    "monthNames": monthNames
                }
            });
            $('.js-date').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                autoApply: true,
                opens: 'center',
                parentEl: $('.picker-parent') || null,
                locale: {
                    cancelLabel: 'Отмена',
                    format: 'DD.MM.YYYY',
                    "daysOfWeek": daysOfWeek,
                    "monthNames": monthNames
                }
            });
            $('.js-range-date').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD.MM.YYYY') + '   -   ' + picker.endDate.format('DD.MM.YYYY'));
            });
            $('.js-range-date').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
            $('.js-range-date').on('show.daterangepicker', function (ev, picker) {
                $(picker.container).addClass('show');
            });
            $('.js-date').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD.MM.YYYY'));
            });
            $('.js-date').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
            $('.js-date').on('show.daterangepicker', function (ev, picker) {
                $(picker.container).addClass('show');
            });
            // $(".quantity").find("span").click(function (e) {
            //     e.preventDefault();
            //     e.stopPropagation();
            //     var calc = $(this).parent().find(".qty");
            //     var calcText = calc.val();
            //     var calcName = calc.attr('name');
            //     if ($(this).hasClass("minus") && calcText > 0) {
            //         calc.val(+calcText - 1);
            //         if ($(this).closest('.dropdown').find('#' + calcName).length > 0) {
            //             $(this).closest('.dropdown').find('#' + calcName).html(+calcText - 1);
            //         }
            //     } else if ($(this).hasClass("plus")) {
            //         calc.val(+calcText + 1);
            //         if ($(this).closest('.dropdown').find('#' + calcName).length > 0) {
            //             $(this).closest('.dropdown').find('#' + calcName).html(+calcText + 1);
            //         }
            //     }
            //     if (calc.data('target')) {
            //         $('#' + calc.data('target')).html(calc.val());
            //     }
            // });
            $('.timepicker').wickedpicker({
                twentyFour: true
            });
            $(document).on('click', '.dropdown-menu', function (e) {
                e.stopPropagation();
            });
            var selectCity = $('.js-city').each(function () {
                $(this).select2({
                    theme: 'light',
                    dropdownAutoWidth: true,
                    minimumResultsForSearch: Infinity,
                    placeholder: $(this).data('placeholder')
                });
            });
            selectCity.on('select2:open', function () {
                selectScroll();
            });
            var selectSort = $('.js-sort').each(function () {
                $(this).select2({
                    theme: 'white',
                    dropdownAutoWidth: true,
                    minimumResultsForSearch: Infinity,
                    placeholder: $(this).data('placeholder'),
                    dropdownParent: $(this).parent().find('.select-drop') || null
                });
            });
            selectSort.on('select2:open', function () {
                selectScroll();
            });
            $('.js-calendar').map(function (index) {
                var selectedDates = $(this).data('dates-selected').split(',');
                var availableDates = $(this).data('dates-available').split(',');
                var bookingDates = $(this).data('dates-booking').split(',');
                var selectedDatesUTC = selectedDates.map(function (item) {
                    var a = new Date(item);
                    var b = new Date(a.getTime() - a.getTimezoneOffset() * 60000);
                    return b;
                });
                $(this).datepicker({
                    defaultViewDate: {
                        year: new Date().getFullYear(),
                        month: new Date().getMonth() + index,
                        day: 1
                    },
                    beforeShowDay: function beforeShowDay(date) {
                        var allDates = date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
                        if (availableDates.indexOf(allDates) != -1) {
                            return {
                                classes: 'available'
                            };
                        } else if (bookingDates.indexOf(allDates) != -1) {
                            return {
                                enabled: false,
                                classes: 'booking'
                            };
                        }
                        return;
                    },
                    language: $(this).data('lang'),
                    multidate: true,
                    updateViewDate: false
                }).datepicker('setDates', selectedDatesUTC);
            });

            // keep month in sync
            var orderMonth = function orderMonth(e) {
                var target = e.target;
                var date = e.date;
                var calendars = $('.js-calendar');
                var positionOfTarget = calendars.index(target);
                calendars.each(function (index) {
                    if (this === target) {
                        return;
                    }
                    var newDate = new Date(date);
                    newDate.setUTCDate(1);
                    newDate.setMonth(date.getMonth() + index - positionOfTarget);

                    $(this).datepicker('_setDate', newDate, 'view');
                });
            };
            $('.js-calendar').on('changeMonth', orderMonth);

            // keep dates in sync
            $('.js-calendar').on('changeDate', function (e) {
                var calendars = $('.js-calendar');
                var target = e.target;
                var newDates = $(target).datepicker('getUTCDates');
                calendars.each(function () {
                    if (this === e.target) {
                        return;
                    }

                    // setUTCDates triggers changeDate event
                    // could easily run into an infinite loop
                    // therefore we check if currentDates equal newDates
                    var currentDates = $(this).datepicker('getUTCDates');
                    if (currentDates && currentDates.length === newDates.length && currentDates.every(function (currentDate) {
                        return newDates.some(function (newDate) {
                            return currentDate.toISOString() === newDate.toISOString();
                        });
                    })) {
                        return;
                    }

                    $(this).datepicker('setUTCDates', newDates);
                });
            });
            $(".js-scroll-to").on('click', function (e) {
                e.preventDefault();
                var hash = this.hash ? this.hash : 'body';
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 300);
            });
            if (isDesktopDevice) {
                var scrollPosition = function scrollPosition() {
                    var scroll = $(window).scrollTop();
                    var el = $('#adv-search');
                    var position = $('.js-scroll-parent').offset();
                    var width = $('.js-scroll-parent').width();
                    if (el.exists()) {
                        var elPostition = parseFloat(el.offset().top);
                        var elHeight = parseFloat(el.outerHeight());
                        var elBottom = elPostition + elHeight;
                        if (scroll >= elBottom) {
                            el.find('.adv-search').addClass("fixed-top advSearchIn");
                            el.find('.adv-search').css({
                                left: position.left,
                                width: width
                            });
                        } else {
                            el.find('.adv-search').removeClass("fixed-top advSearchIn");
                            el.find('.adv-search').removeAttr('style');
                        }
                    }
                };

                var advSearchHeight = $('#adv-search').outerHeight();
                $('#adv-search').height(advSearchHeight);
                $(window).resize(function () {
                    scrollPosition();
                });
                $(window).scroll(function () {
                    scrollPosition();
                });
            }
        };

        // var initObjectWatch = function initObjectWatch() {
        //     // object.watch
        //     if (!Object.prototype.watch) {
        //         Object.defineProperty(Object.prototype, "watch", {
        //             enumerable: false
        //             , configurable: true
        //             , writable: false
        //             , value: function (prop, handler) {
        //                 var
        //                     oldval = this[prop]
        //                     , newval = oldval
        //                     , getter = function () {
        //                         return newval;
        //                     }
        //                     , setter = function (val) {
        //                         oldval = newval;
        //                         return newval = handler.call(this, prop, oldval, val);
        //                     }
        //                 ;
        //
        //                 if (delete this[prop]) { // can't watch constants
        //                     Object.defineProperty(this, prop, {
        //                         get: getter
        //                         , set: setter
        //                         , enumerable: true
        //                         , configurable: true
        //                     });
        //                 }
        //             }
        //         });
        //     }
        //
        //     // object.unwatch
        //     if (!Object.prototype.unwatch) {
        //         Object.defineProperty(Object.prototype, "unwatch", {
        //             enumerable: false
        //             , configurable: true
        //             , writable: false
        //             , value: function (prop) {
        //                 var val = this[prop];
        //                 delete this[prop]; // remove accessors
        //                 this[prop] = val;
        //             }
        //         });
        //     }
        // };

        var initHomeTabs = function initHomeTabs() {
            $('.tabgroup > div').hide();
            $('.tabgroup > div:first-of-type').show();
            $('.tabs a').click(function (e) {
                e.preventDefault();
                var $this = $(this),
                    tabgroup = '#' + $this.parents('.tabs').data('tabgroup'),
                    others = $this.closest('li').siblings().children('a'),
                    target = $this.attr('href');
                others.removeClass('active');
                $this.addClass('active');
                $(tabgroup).children('div').hide();
                $(target).show();

            })
        }

        "use strict";
        var initMethods = [
            initDatePickers,
            // initObjectWatch,
            initHomeFiltersTabs,
            initHomeFiltersForm,
            initRange,
            initRating,
            initLength,
            initWOW,
            initPersonCounter,
            tabNavsControl,
            initHomeTabs
        ];
        for (var i = 0; i < initMethods.length; i++) {
            if (typeof initMethods[i] == 'function') {
                try {
                    initMethods[i].call(this);
                } catch (e) {
                    if (console && console.error) {
                        console.error(e);
                    }
                }
            }
        }
    })();
});
