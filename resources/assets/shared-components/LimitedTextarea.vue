<template>
    <div class="limited-textarea-wrapper">
        <textarea :name="name" cols="30" class="form-control"
                  v-model="internalValue"
                  @keydown="$forceUpdate()"
                  @paste="$forceUpdate()"
                  :required="required"
                  :class="className"
                  :placeholder="placeholder"
                  :rows="rows"
        ></textarea>
        <span class="limited-textarea-counter">{{translations[locale]}}: {{charCount}}</span>
    </div>
</template>

<script>
    export default {
        name: 'limited-textarea',
        props: {
            name: {
               type: String,
               default: 'notes'
            },
            value: {
                type: String,
                default: ""
            },
            max: {
                type: Number,
                default: 25
            },
            required: {
                type: Boolean,
                default: false
            },
            className: {
                type: String,
                default: ''
            },
            placeholder: {
                type: String,
                default: ''
            },
            rows: {
                type: Number,
                default: 10
            }
        },
        data() {
            return {
                componentValue: '',
                locale: 'ru',
                translations: {
                    ru: 'Осталось символов',
                    en: 'Characters left',
                    ka: 'სიმბოლო დარჩა'
                }
            }
        },
        computed: {
            internalValue: {
                get: function () {
                    return this.componentValue;
                },
                set: function (aModifiedValue) {
                    this.componentValue = aModifiedValue;
                    this.$emit("input", aModifiedValue.substring(0, this.max));
                }
            },
            charCount() {
                if(this.value) {
                    return this.max - this.value.length
                }
                return this.max
            }
        },
        mounted() {
            this.componentValue = this.value;
            this.locale = window.Laravel.locale || 'ru'
        }
    }
</script>
<style scoped>
    .limited-textarea-wrapper {
        position: relative;
    }

    .limited-textarea-counter {
        position: absolute;
        bottom: -20px;
        left: 5px;
        font-size: 85%;
        color: #989898
    }
</style>
