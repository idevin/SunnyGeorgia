<template>
    <div class="p-short-description__social">
        <social-sharing
            :url="url"
            :title="title"
            :description="description"
            :quote="quote"
            inline-template
        >
            <div class="social-sharing">
                <network network="facebook"
                         class="social-sharing__item social-sharing__item--facebook">
                    <svg aria-hidden="true" width="10" height="20" focusable="false"
                         data-prefix="fab"
                         data-icon="facebook-f" role="img"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                         class="svg-inline--fa fa-facebook-f fa-w-10">
                        <path fill="currentColor"
                              d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                              class=""></path>
                    </svg>
                </network>
                <network network="vk"
                         class="social-sharing__item social-sharing__item--vk">
                    <svg aria-hidden="true" height="20" focusable="false"
                         data-prefix="fab"
                         data-icon="vk" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 576 512" class="svg-inline--fa fa-vk fa-w-18">
                        <path fill="currentColor"
                              d="M545 117.7c3.7-12.5 0-21.7-17.8-21.7h-58.9c-15 0-21.9 7.9-25.6 16.7 0 0-30 73.1-72.4 120.5-13.7 13.7-20 18.1-27.5 18.1-3.7 0-9.4-4.4-9.4-16.9V117.7c0-15-4.2-21.7-16.6-21.7h-92.6c-9.4 0-15 7-15 13.5 0 14.2 21.2 17.5 23.4 57.5v86.8c0 19-3.4 22.5-10.9 22.5-20 0-68.6-73.4-97.4-157.4-5.8-16.3-11.5-22.9-26.6-22.9H38.8c-16.8 0-20.2 7.9-20.2 16.7 0 15.6 20 93.1 93.1 195.5C160.4 378.1 229 416 291.4 416c37.5 0 42.1-8.4 42.1-22.9 0-66.8-3.4-73.1 15.4-73.1 8.7 0 23.7 4.4 58.7 38.1 40 40 46.6 57.9 69 57.9h58.9c16.8 0 25.3-8.4 20.4-25-11.2-34.9-86.9-106.7-90.3-111.5-8.7-11.2-6.2-16.2 0-26.2.1-.1 72-101.3 79.4-135.6z"
                              class=""></path>
                    </svg>
                </network>
                <network network="telegram"
                         class="social-sharing__item social-sharing__item--telegram">
                    <svg width="15" aria-hidden="true" focusable="false"
                         data-prefix="fab" data-icon="telegram" role="img"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"
                         class="svg-inline--fa fa-telegram fa-w-16">
                        <path fill="currentColor"
                              d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm121.8 169.9l-40.7 191.8c-3 13.6-11.1 16.9-22.4 10.5l-62-45.7-29.9 28.8c-3.3 3.3-6.1 6.1-12.5 6.1l4.4-63.1 114.9-103.8c5-4.4-1.1-6.9-7.7-2.5l-142 89.4-61.2-19.1c-13.3-4.2-13.6-13.3 2.8-19.7l239.1-92.2c11.1-4 20.8 2.7 17.2 19.5z"
                              class=""></path>
                    </svg>
                </network>
                <network network="twitter"
                         class="social-sharing__item social-sharing__item--twitter">
                    <svg width="15" aria-hidden="true" focusable="false"
                         data-prefix="fab" data-icon="twitter" role="img"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                         class="svg-inline--fa fa-twitter fa-w-16">
                        <path fill="currentColor"
                              d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
                              class=""></path>
                    </svg>
                </network>
                <network network="odnoklassniki"
                         class="social-sharing__item social-sharing__item--odnoklassniki">
                    <svg width="10" height="20" aria-hidden="true" focusable="false"
                         data-prefix="fab"
                         data-icon="odnoklassniki" role="img"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                         class="svg-inline--fa fa-odnoklassniki fa-w-10">
                        <path fill="currentColor"
                              d="M275.1 334c-27.4 17.4-65.1 24.3-90 26.9l20.9 20.6 76.3 76.3c27.9 28.6-17.5 73.3-45.7 45.7-19.1-19.4-47.1-47.4-76.3-76.6L84 503.4c-28.2 27.5-73.6-17.6-45.4-45.7 19.4-19.4 47.1-47.4 76.3-76.3l20.6-20.6c-24.6-2.6-62.9-9.1-90.6-26.9-32.6-21-46.9-33.3-34.3-59 7.4-14.6 27.7-26.9 54.6-5.7 0 0 36.3 28.9 94.9 28.9s94.9-28.9 94.9-28.9c26.9-21.1 47.1-8.9 54.6 5.7 12.4 25.7-1.9 38-34.5 59.1zM30.3 129.7C30.3 58 88.6 0 160 0s129.7 58 129.7 129.7c0 71.4-58.3 129.4-129.7 129.4s-129.7-58-129.7-129.4zm66 0c0 35.1 28.6 63.7 63.7 63.7s63.7-28.6 63.7-63.7c0-35.4-28.6-64-63.7-64s-63.7 28.6-63.7 64z"
                              class=""></path>
                    </svg>
                </network>
                <network network="email"
                         class="social-sharing__item social-sharing__item--google-plus">
                    <svg height="15" aria-hidden="true" focusable="false"
                         data-prefix="fas"
                         data-icon="envelope" role="img"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                         class="svg-inline--fa fa-envelope fa-w-16">
                        <path fill="currentColor"
                              d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"
                              class=""></path>
                    </svg>
                </network>
            </div>
        </social-sharing>
    </div>
</template>

<script>
    import SocialSharing from 'vue-social-sharing';
    import '../common-styles/social-sharing.scss'
    import Vue from 'vue'
    Vue.use(SocialSharing);

    export default {
        name: 'shared-social-sharing',
        props: ['url', 'title', 'description', 'quote']
    }
</script>
