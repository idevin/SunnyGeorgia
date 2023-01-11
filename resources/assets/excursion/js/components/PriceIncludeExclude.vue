<script>
    export default {
        name: "PriceIncludeExclude",
        data() {
            return {
                activeTab: 0
            }
        }
    }
</script>

<style scoped>
    .p-short-description__options-mobile {
        display: flex;
        justify-content: space-between;
        padding-bottom: 10px;
    }

    .p-short-description__include-mobile, .p-short-description__exclude-mobile {
        width: 47%;
        font-size: 18px;
        font-weight: bold;
        color: #161616;
        padding: 10px 0;
        line-height: 1;
        cursor: pointer
    }

    .p-short-description__mobile_active-tab {
        border-bottom: 2px solid #000
    }

    .p-short-description__include, .p-short-description__exclude {
        width: 100%;
        display: none;
    }

    .p-short-description__mobile_active-content {
        display: block;
    }

    @media (min-width: 768px) {
        .p-short-description__include, .p-short-description__exclude {
            width: 50%;
            display: block;
        }
    }
</style>