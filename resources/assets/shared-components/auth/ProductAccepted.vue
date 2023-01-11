<template>
    <div>
        <div class="padding">
            <div class="title">
                <div class="tick">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                         class="svg-inline--fa fa-check fa-w-16 fa-3x">
                        <path fill="currentColor"
                              d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"
                              class=""></path>
                    </svg>
                </div>
                {{'auth.your request accepted!' | trans}}
            </div>
            <div class="message">
                {{'auth.after checking details' | trans}}
            </div>
            <div class="form-group text-right">
                <button class="register-btn"
                        @click="$store.commit('authModalTab', '')"
                >Ok</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "product-accepted"
    }
</script>

<style scoped>
    .padding {
        /*padding: 100px 0 120px 0;*/
        color: #000;
        text-align: center;
    }

    .title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 35px;
        text-indent: -30px;
    }

    .message {
        margin-bottom: 20px;
    }

    .tick {
        color: #25d425;
        width: 30px;
        display: inline-block;
        vertical-align: 3px;
        text-indent: 0;
    }

    button.register-btn {
        border: 1px solid #ffc412;
        border-radius: 3px;
        height: 45px;
        line-height: 45px;
        padding: 0 18px;
        background: #fff;
        cursor: pointer;
        outline: none;
        font-weight: bold;
        transition: all ease .3s;
    }

    button.register-btn:hover {
        background: #ffc412;
        color: #fff;
    }

    button.register-btn:hover.disabled {
        cursor: not-allowed !important;
        background: none;
        color: #767676;
    }
</style>
