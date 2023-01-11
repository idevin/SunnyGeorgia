<template>
    <div class="main-content">
        <h1> !!!! WARNING !!!! </h1>
        <h3> {{ test }} </h3>
    </div>
</template>

<script>
    export default {
        name: 'test-test',
        data: () => ({
            test: '.|.',
        }),
    }
</script>

<style scoped>
    .main-content {
        margin: 0 auto;
        font-family: sans-serif;
        background-color: #ccf7e2;
        padding: 10px;
        border-radius: 5px;
        max-width: 500px;
    }
</style>