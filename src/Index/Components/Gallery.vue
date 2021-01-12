<template>
  <div id="gallery">
    <photo-modal ref="PhotoModal" />
    <div id="gallery_container">
      <div
        class="img_thumbnail"
        v-for="(photo, index) in photos"
        :key="index"
        @click="showPhotoModal(photo)"
      >
        <img
          class="gallery_img"
          :src="require('@/assets/img/photo/' + photo.img_name)"
          :alt="photo.img_name"
        />
      </div>
    </div>
  </div>
</template>

<script>
import PhotoModal from "./PhotoModal.vue";
import api from "@/services/api/api.js";

export default {
  components: { PhotoModal },
  name: "Game",
  data() {
    return {
      photos: [],
    };
  },
  mounted() {
    api.getGalleryPhotos().then((photos) => {
      this.photos = photos;
      console.log("photos fetched from api");
    });
  },
  methods: {
    showPhotoModal(photo) {
      console.log("gallery.vue, open modal");
      this.$refs.PhotoModal.openModal(photo);
    },
  },
};
</script>

<style lang="scss" scoped>
.img_thumbnail {
  width: 300px;
  max-width: 30%;
}

.gallery_img {
  width: 100%;
  border-radius: 5%;
}

#gallery {
  &_container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
  }
}
</style>