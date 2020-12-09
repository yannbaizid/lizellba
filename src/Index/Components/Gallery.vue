<template>
  <div id="gallery_container">
    <photo-modal ref="PhotoModal" />
    gallery avec plein plein d'images YOLO LOLOLO!
    <div
      v-for="(photo, index) in photos"
      :key="index"
      @click="showPhotoModal(photo)"
    >
      {{ photo.image }}
    </div>
  </div>
</template>

<script>
import PhotoModal from "./PhotoModal.vue";
export default {
  components: { PhotoModal },
  name: "Game",
  data() {
    return {
      photos: [],
    };
  },
  mounted() {
    this.photos.push({ image: "image1", description: "description 1" });
    this.photos.push({ image: "image2", description: "description 2" });
  },
  methods: {
    showPhotoModal(photo) {
      console.log("je suis gallery.vue j'essaye d'ouvrir une photomodal");
      this.$refs.PhotoModal.openModal(photo);
    },
  },
};
</script>

<style>
</style>