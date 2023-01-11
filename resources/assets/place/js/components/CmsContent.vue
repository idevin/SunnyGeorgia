<template>
  <div class="cms-content" id="cms_content">
    <slot></slot>
  </div>
<!--  <loader v-else ></loader>-->
</template>

<script>
  // import Loader from './Loader'
  export default {
    // components: [Loader],
    name: 'cms-content',
    data() {
      return {
        show: false,
      };
    },
    mounted() {
      this.show = true
    }
  }
</script>

<style>
.cms-content img {
  max-width: 100%;
  height: auto;
  padding: 10px 0;
}
</style>
