<script>
    export default {
        data() {
            return {
                usefulLinksHover: false,
            };
        },
        created() {
            document.addEventListener('scroll', () => {
                let cms_content = document.getElementById('cms_content')
                if (cms_content) {
                    this.usefulLinksHover = cms_content.getBoundingClientRect().top + 250 < 1;
                } else {
                    if (this.$refs['useful-links']) {
                        document.addEventListener('scroll', () => {
                            this.usefulLinksHover = this.$refs['useful-links'].getBoundingClientRect().bottom < 1;
                        });
                    }
                }
            });
        },
        mounted() {
            this.$refs.aside.classList.remove('hidden-until-load');
        }
    };
</script>
<style lang="scss">
    .aside {
        &__block {
            border-radius: 10px;
            background: #fff;
            margin-bottom: 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .fixed-position {
            position: fixed;
            top: 0;
            z-index: 1;
        }
    }

    .useful-links {
        font-weight: bold;
        font-size: 18px;
        padding: 10px;

        &_hover {
            max-width: 226px;
            width: 100%;
            display: flex;
            position: fixed;
            z-index: 1;
            top: 0;
            background-color: white;
            padding: 0;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);

            &__arrow {
                color: #007bff;
                margin-left: auto;
                margin-right: 15px;
            }

            .useful-links__item {
                border-top: none;
                padding: 5px 15px;
            }
        }

        &__title {
            padding: 10px 20px;
        }

        &__item {
            display: block;
            padding: 10px 20px;
            border-top: 1px solid #e8e8e8;
            position: relative;
            transition: all ease 0.3s;
            color: #007bff;

            svg {
                position: absolute;
                right: 10px;
                top: 50%;
                opacity: 0.6;
                transform: translateY(-50%);
            }

            &:hover {
                background: #ffd961;
                color: #000;

                svg {
                    opacity: 1;
                }
            }
        }
    }

    .event-block {
        &__image {
            position: relative;
            overflow: hidden;
            border-radius: 7px;

            &-title {
                position: absolute;
                z-index: 10;
                top: 10px;
                left: 10px;
                color: #fff;
                font-weight: bold;
                font-size: 20px;
                text-shadow: 0 3px 6px rgba(0, 0, 0, 0.5);
            }

            &-hover {
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                background: rgba(0, 0, 0, 0.4);
                transition: opacity 0.3s ease;
                opacity: 0;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;

                &:hover {
                    opacity: 1;
                }

                &-zoom {
                    display: inline-block;
                    background: #ffc411;
                    width: 42px;
                    height: 42px;
                    line-height: 42px;
                    text-align: center;
                    border-radius: 50%;
                    color: #fff;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                }
            }

            img {
                width: 100%;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
            }
        }

        &__content {
            padding: 10px 15px 0;
        }

        &__title {
            font-weight: bold;
            color: #000;
            font-size: 18px;
            transition: color ease 0.3s;

            &:hover {
                color: #ffc411;
                text-decoration: none;
            }
        }

        &__params {
            padding: 15px 0;
            color: #424242;
            font-weight: bold;
            font-size: 15px;
            display: flex;
            justify-content: space-between;

            &-separate {
                width: 1px;
                height: 22px;
                background: #999;
            }

            &-place {
                padding-right: 15px;
            }

            svg {
                width: 14px;
                /*margin-right: 5px;*/
                vertical-align: 0;
            }
        }

        &__footer {
            display: flex;
            justify-content: flex-end;

            &-price {
                font-size: 16px;
                padding-right: 10px;
                text-align: right;
                line-height: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;

                .big-letter {
                    font-weight: bold;
                    font-size: 28px;
                }

                .old-price {
                    display: block;
                    text-decoration: line-through;

                    .big-letter {
                        font-size: 16px;
                    }
                }

                .new-price {
                    display: block;
                    color: #3cb878;
                }
            }
        }

        &__more-button {
            display: block;
            background: #ffe181;
            text-align: center;
            font-size: 18px;
            color: #5c593b;
            font-weight: 700;
            border-bottom-right-radius: 5px;
            border-top-left-radius: 5px;
            padding: 10px 15px;
            max-height: 47px;
            transition: all 0.3s ease;

            &:hover {
                background: #ffd961;
                color: #031526;
                text-decoration: none;
            }

            &-icon {
                display: none;
            }
        }

        &__route {
            padding: 0 15px 15px;
            line-height: 1.2;
        }
    }
</style>
