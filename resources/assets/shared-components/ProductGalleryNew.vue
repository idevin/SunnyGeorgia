<script>
import { Slider, SliderItem } from 'vue-easy-slider'
import Lightbox from 'vue-my-photos'

export default {
  name: 'ProductGallery',
  components: {
    Slider,
    SliderItem,
    Lightbox
  },
  props: {
    slider: Array,
    thumbs: Array
  },
  data() {
    return {
      galleryWidth: null,
      galleryTopPosition: 0,
      thumbsData: [],
      lightboxImages: [],
      currentImage: 0
    }
  },
  methods: {
    setSrcset(source) {
      let result = '';
      let counter = 1;
      for (let prop in source) {
        if (counter !== 1) {
          result += ', '
        }
        result += `${source[prop]} ${prop}`;
        counter++;
      }
      return result;
    },
    showLightbox: function (imageName) {
      this.$refs.lightbox.show(imageName);
    },
    scrollImages(direction) {
      if (direction === 'next') {
        if (Math.abs(this.galleryTopPosition) >= this.galleryWidth * (this.slider.length - 1)) {
          this.galleryTopPosition = 0;
          this.currentImage = 0;
        } else {
          this.galleryTopPosition -= this.galleryWidth;
          this.currentImage += 1;
        }
      } else {
        if (this.galleryTopPosition >= 0) {
          this.galleryTopPosition = (this.galleryWidth * (this.slider.length - 1)) * -1
          this.currentImage = this.slider.length - 1;
        } else {
          this.galleryTopPosition += this.galleryWidth
          this.currentImage -= 1;
        }
      }
    },
    setVisibleImage(index) {
      if (index >= this.slider.length) {
        this.galleryTopPosition = (this.galleryWidth * (index - this.slider.length)) * -1
        this.currentImage = index - this.slider.length;
      } else {
        this.galleryTopPosition = (this.galleryWidth * index) * -1
        this.currentImage = index;
      }
    }
  },
  mounted() {
    this.thumbsData = this.thumbs;
    if (this.thumbs.length > 4) {
      this.thumbsData.push(this.thumbs[0], this.thumbs[1], this.thumbs[2]);
    }
    this.lightboxImages = this.slider.map(slide => ({name: slide.origin}));
    this.$nextTick(() => {
      this.galleryWidth = this.$refs.gallery.clientWidth;
    })
  }
}
</script>
<style>
.lightbox {
  z-index: 1000 !important;
}

.lightbox-close {
  font-size: 2.5rem !important;
}
</style>
<style scoped>
.gallery-thumbs_wrapper {
  overflow: hidden;
  position: relative;
  margin-top: 10px;
  height: 58px;
}

.gallery-thumbs {
  display: flex;
  overflow: hidden;
  position: absolute;
  transition: transform ease-in-out .5s;
}


.gallery-thumbs-swiper__picture {
  display: flex;
  align-items: center;
  overflow: hidden;
  justify-content: center;
}

.gallery-thumbs_picture-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 5px;
}

.gallery-thumbs-swiper__img {
  cursor: pointer;
}

.gallery-swiper__img {
  height: 100%;
  display: block !important;
  cursor: pointer;
}

.slider {
  height: 200px !important;
}

.slider-item {
  position: static !important;
}

@media (min-width: 576px) {
  .gallery-thumbs_wrapper {
    height: 101px;
  }

  .slider {
    height: 406px !important;
  }
}

@media (min-width: 768px) {
  .gallery-thumbs_wrapper {
    height: 101px;
  }

  .slider {
    height: 406px !important;
  }
}

@media (min-width: 992px) {
  .gallery-thumbs_wrapper {
    height: 101px;
  }

  .slider {
    height: 406px !important;
  }
}

@media (min-width: 1200px) {
  .gallery-thumbs_wrapper {
    height: 101px;
  }

  .slider {
    height: 406px !important;
  }
}
</style>
