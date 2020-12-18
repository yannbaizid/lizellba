<template>
  <div id="gallery_container">
    <photo-modal ref="PhotoModal" />
    <div
      v-for="(photo, index) in photos"
      :key="index"
      @click="showPhotoModal(photo)"
    >
    <img class="img_thumbnail "  :src="require('@/assets/img/photo/'+photo.img_name)" :alt="photo.img_name">
    </div>
  </div>
</template>

<script>
import PhotoModal from "./PhotoModal.vue";
import axios from 'axios';

export default {
  components: { PhotoModal },
  name: "Game",
  data() {
    return {
      photos: [],
    };
  },
  mounted() {
       axios.get("http://localhost/testphp/getgalleryphotos.php").then((response) => {
       //axios.get("http://yannbaizid.fr/yann/lizellba/getgalleryphotos.php").then((response) => {
        this.photos = response.data;
        console.log(this.photos);
      });
  },
  methods: {
    showPhotoModal(photo) {
      console.log("je suis gallery.vue j'essaye d'ouvrir une photomodal");
      console.log(this.photo);
      this.$refs.PhotoModal.openModal(photo);
    },
  },
};
</script>

<style lang="scss" scoped>
.img_thumbnail {
    max-width: 90%;
}

#gallery {
  &_container {
    display: flex;
    flex-wrap: wrap;
      justify-content: space-around;
  }
}

</style>