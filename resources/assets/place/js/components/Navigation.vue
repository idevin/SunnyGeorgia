<template>
    <div class="box-wrap" :class="position">
        <div class="container">
            <div class="box" ref="box">
                <div class="box__pannel" @click="toggle">
                    <span class="label">Оглавление</span>
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="17px" height="15px">
                        <path fill-rule="evenodd" fill="rgb(0, 123, 255)"
                              d="M15.500,9.000 L1.500,9.000 C0.672,9.000 -0.000,8.328 -0.000,7.500 C-0.000,6.672 0.672,6.000 1.500,6.000 L15.500,6.000 C16.328,6.000 17.000,6.672 17.000,7.500 C17.000,8.328 16.328,9.000 15.500,9.000 ZM15.500,3.000 L1.500,3.000 C0.672,3.000 -0.000,2.328 -0.000,1.500 C-0.000,0.672 0.672,-0.000 1.500,-0.000 L15.500,-0.000 C16.328,-0.000 17.000,0.672 17.000,1.500 C17.000,2.328 16.328,3.000 15.500,3.000 ZM1.500,12.000 L15.500,12.000 C16.328,12.000 17.000,12.672 17.000,13.500 C17.000,14.328 16.328,15.000 15.500,15.000 L1.500,15.000 C0.672,15.000 -0.000,14.328 -0.000,13.500 C-0.000,12.672 0.672,12.000 1.500,12.000 Z"/>
                    </svg>
                </div>
                <div class="box__popup" :class="{ open: listToggle }">
                    <div class="box__popup-content">
                        <div class="box__popup-close" @click="toggle">
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path fill="currentColor"
                                      d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z"></path>
                            </svg>
                        </div>
                        <div class="box__popup-title">Оглавление</div>
                        <div class="box__popup-item" v-for="(item, i) in items">
                            <a :href="`#header_${i}`" @click.prevent="goToHeader(i)" class="box__popup-item-link">{{
                                item }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['page'],
        data() {
            return {
                listToggle: false,
                position: 'absolute',
                nav: null,
                items: null
            };
        },
        computed: {},
        methods: {
            toggle() {
                this.listToggle = !this.listToggle
            },
            goToHeader(i) {
                this.toggle()
                const position = document.getElementById('header_'+i).offsetTop
                window.scrollTo({
                    top: position,
                    behavior: "smooth"
                });
            }
        },
        mounted() {
            const nav = document.querySelector('nav');
            document.addEventListener('scroll', () => {
                this.position = nav.getBoundingClientRect().bottom < 1 ? 'fixed' : 'absolute'
            });
        },
        created() {
            let headers = document.querySelectorAll('h2');
            let items = [];
            headers.forEach((header, i) => {
                items.push(header.textContent); //You can modify this accordingly
                header.id = 'header_' + i;
            });
            this.items = items;
        }
    };
</script>

<style lang="scss" scoped>
    .fixed {
        top: 50px !important;
        position: fixed !important;

        .box__pannel {
            padding: 15px;
        }

        .label {
            max-width: 0;
            padding: 0;
        }
    }

    .label {
        display: inline-block;
        overflow: hidden;
        max-width: 200px;
        box-sizing: border-box;
        padding-right: 10px;
        transition: max-width ease .5s, padding ease .5s;
    }

    .box {
        &-wrap {
            position: absolute;
            top: calc(100% + 60px);
            z-index: -1;
            width: 100%;
            text-align: right;
            visibility: hidden;
        }

        display: inline-block;
        visibility: visible;
        background-color: rgba(255, 255, 255, 0.83);

        &__pannel {
            cursor: pointer;
            background: #fff;
            padding: 15px 20px 15px 25px;
            border-top: 1px solid #e8e8e8;
            color: #007bff;
            font-weight: bold;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            position: relative;
            top: 0;
            transition: top ease .5s, padding ease .5s;
        }

        &__popup {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            visibility: hidden;
            display: flex;
            transition: all ease .3s;
            background: rgba(0, 0, 0, .1);

            &-item-link {
                color: #000;
                font-weight: bold;
                font-size: 16px;
                display: inline-block;

                &:hover {
                    text-decoration: underline;
                }

                &:before {
                    content: '';
                    display: inline-block;
                    width: 10px;
                    height: 10px;
                    background-position: 0 0;
                    background-repeat: no-repeat;
                    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQ1IDc5LjE2MzQ5OSwgMjAxOC8wOC8xMy0xNjo0MDoyMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkZDRTQxNjZFMTU0NTExRUFBMDE0OUYzNzdBMTE3OUQ4IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkZDRTQxNjZGMTU0NTExRUFBMDE0OUYzNzdBMTE3OUQ4Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6RkNFNDE2NkMxNTQ1MTFFQUEwMTQ5RjM3N0ExMTc5RDgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6RkNFNDE2NkQxNTQ1MTFFQUEwMTQ5RjM3N0ExMTc5RDgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7tkZ8aAAAATElEQVR42mJgYGBYAsRLgZiZAQKOA3E7AxYQDcR/kRSDFP0H4g5iFHeQrZgFSeFSKL0ISSMIlAPxbyYG4gAjye4kSxHO4CEqwAECDAB1pSCoO1wxGAAAAABJRU5ErkJggg==');
                    margin-right: 5px;
                }
            }

            &-title {
                font-weight: bold;
                font-size: 30px;
                padding-bottom: 20px;
            }

            &-close {
                position: absolute;
                top: 0;
                right: 0;
                padding: 15px;
                cursor: pointer;
                opacity: .8;
                transition: opacity ease .3s;

                &:hover {
                    opacity: 1
                }
            }

            &-content {
                margin: auto;
                background-color: rgb(255, 255, 255);
                padding: 40px;
                position: relative;
                box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
                text-align: left;
            }

            &.open {
                opacity: 1;
                visibility: visible;
            }
        }
    }
</style>
