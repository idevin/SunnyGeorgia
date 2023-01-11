<script>
    export default {
        name: 'legal-information',
        data() {
            return {
                show: 'policy',
            };
        },
        watch: {
            show(val) {
                ['policy', 'rules', 'terms'].forEach(section => {
                    if (section === val) {
                        this.$refs[section].classList.remove('hidden');
                    } else {
                        this.$refs[section].classList.add('hidden')
                    }
                });
            },
        },
    };
</script>

<style>

    ol {
        margin-bottom: 15px;
        padding: 0 0 0 15px;
    }

    ol li {
        margin-bottom: 10px;
    }

    .conditions-buttons {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        user-select: none;
    }

    .conditions-buttons__item {
        font-family: 'Open Sans', sans-serif;
        font-weight: bold;
        font-size: 18px;
        border-radius: 10px;
        background-color: white;
        box-shadow: 0 0 4.75px 0.25px rgba(0, 0, 1, 0.3);
        cursor: pointer;
        padding: 10px 20px;
        white-space: nowrap;
        transition: all ease .3s;
    }

    .conditions-buttons__item:hover, .conditions-buttons__item_active {
        box-shadow: none;
        background: #ffe180;
    }

    .conditions-description {
        text-align: center;
        padding: 40px 0;
    }

    .conditions-title, .conditions-title.h1 {
        font-size: 24px;
        font-family: 'Open Sans', sans-serif;
        margin-top: 55px;
        margin-bottom: 16px;
    }

    .conditions-title_no-margin, .conditions-title.h1_no-margin {
        margin-top: 0;
    }

    .conditions-content {
        margin-top: 50px;
    }
</style>