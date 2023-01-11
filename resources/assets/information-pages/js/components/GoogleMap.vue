<template>
  <iframe :src="`https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2979.074991598132!2d44.80430161521507!3d41.69731677923701!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40440ce467152383%3A0xa9967a645332a35!2zTmlrb2xveiBiYXJhdGFzaHZpbGkgLywgMTIvMiBOaWtvbG96IEJhcmF0YXNodmlsaSBTdCwgVCdiaWxpc2ksINCT0YDRg9C30LjRjw!5e0!3m2!1s${locale}!2s${locale}!4v1576440547624!5m2!1s${locale}!2s${locale}`"
          frameborder="0" style="width:100%;height:500px;border:0;" allowfullscreen=""
  ></iframe>
</template>
<script>
export default {
  name: 'google-map',
  data() {
    return {
      locale: window.Laravel.locale
    };
  },
  watch: {

  },
};
</script>

<style>
@import url('https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=cyrillic');

</style>