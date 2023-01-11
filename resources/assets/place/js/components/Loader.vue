<template>
    <div class="excursion-loader">
        <div class="shared-loader">
            <div class="fulfilling-bouncing-circle-spinner">
                <div class="circle"></div>
                <div class="orbit"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'excursion-loader',
    }
</script>

<style scoped>
    .shared-loader {
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ccc;
    }
    .fulfilling-bouncing-circle-spinner, .fulfilling-bouncing-circle-spinner * {
        box-sizing: border-box;
    }

    .fulfilling-bouncing-circle-spinner {
        height: 30px;
        width: 30px;
        position: relative;
        animation: fulfilling-bouncing-circle-spinner-animation infinite 4000ms ease;
    }

    .fulfilling-bouncing-circle-spinner .orbit {
        height: 30px;
        width: 30px;
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 50%;
        border: calc(30px * 0.03) solid #FFC411;
        animation: fulfilling-bouncing-circle-spinner-orbit-animation infinite 4000ms ease;
    }

    .fulfilling-bouncing-circle-spinner .circle {
        height: 30px;
        width: 30px;
        color: #FFC411;
        display: block;
        border-radius: 50%;
        position: relative;
        border: calc(30px * 0.1) solid #FFC411;
        animation: fulfilling-bouncing-circle-spinner-circle-animation infinite 4000ms ease;
        transform: rotate(0deg) scale(1);
    }

    @keyframes fulfilling-bouncing-circle-spinner-animation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes fulfilling-bouncing-circle-spinner-orbit-animation {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1);
        }
        62.5% {
            transform: scale(0.8);
        }
        75% {
            transform: scale(1);
        }
        87.5% {
            transform: scale(0.8);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes fulfilling-bouncing-circle-spinner-circle-animation {
        0% {
            transform: scale(1);
            border-color: transparent;
            border-top-color: inherit;
        }
        16.7% {
            border-color: transparent;
            border-top-color: initial;
            border-right-color: initial;
        }
        33.4% {
            border-color: transparent;
            border-top-color: inherit;
            border-right-color: inherit;
            border-bottom-color: inherit;
        }
        50% {
            border-color: inherit;
            transform: scale(1);
        }
        62.5% {
            border-color: inherit;
            transform: scale(1.4);
        }
        75% {
            border-color: inherit;
            transform: scale(1);
            opacity: 1;
        }
        87.5% {
            border-color: inherit;
            transform: scale(1.4);
        }
        100% {
            border-color: transparent;
            border-top-color: inherit;
            transform: scale(1);
        }
    }
    .excursion-loader {
        padding: 15px 30px;
        border-bottom: 1px solid #e8e8e8;
        height: 403px;
        width: 100%;
        display: flex;
        align-items: center;
        flex-flow: column;
    }
</style>
