<template>
  <div id="gallery">
   
    <div id="gallery_container" class="flexbox_row flexbox_justifystart flexbox_alignstart w_100">
      <div
        class="img_thumbnail"
        v-for="(photo, index) in photos"
        :key="index"
        @click="showPhotoModal(photo)"
      >
        <img
          class="gallery_img"
          :src="'/img/expos/' + photo.file_name"
          :alt="photo.img_name"
        />
      </div>
    </div>
     <photo-modal ref="PhotoModal" />
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
      console.log(this.photos);
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

 width: 24%;
 padding-bottom: 20px;
 padding-right: 0.5%;
 padding-left: 0.5%;
}

.gallery_img {
  width: 100%;
  border-radius: 2%;
}
#gallery_container {
  padding: 0px 20px;
  box-sizing: border-box;
}

#gallery {
  &_container {

    flex-wrap: wrap;
 
  }
}
</style>