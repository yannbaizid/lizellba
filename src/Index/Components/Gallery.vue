<template>
  <div id="gallery">
    <div
      id="gallery_container"
      class="flexbox_row flexbox_justifystart flexbox_alignstart w_100"
    >
      <div
        class="img_thumbnail"
        v-for="(photo, index) in photos"
        :key="index"
        @click="showPhotoModal(photo.id)"
      >
        <img
          class="gallery_img"
          :src="'/img/expos/' + photo.file_name"
          :alt="photo.img_name"
        />
      </div>
    </div>
    <div>
      <img
        v-show="loadingPhotos"
        src="../../assets/loading.gif"
        width="50"
        alt="loading gif"
      />
    </div>
    <photo-modal ref="PhotoModal" :idRange="idRange"/>
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
      loadingPhoto: false,
      loadingPhotos: false,
      idRange: {},
      currentPage: 0,
      pageCount: 1,
      limit: 1,
    };
  },
  computed: {
    allPhotosLoaded() {
      return this.photos.length == this.idRange.total;
    },
  },
  mounted() {
    this.getIdRange();
  },
  created() {
    window.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    handleScroll() {
      if (!this.loadingPhotos) {
        let bottomOfWindow =
          document.documentElement.scrollTop + window.innerHeight ===
          document.documentElement.scrollHeight;
        if (bottomOfWindow) {
          console.log("t'en as trop pris, mec");
          this.getNextPhotos();
        }
      }
    },
    getNextPhotos() {
      if (this.currentPage <= this.pageCount) {
        this.loadingPhotos = true;
        this.currentPage++;
        api
          .getNextGalleryPhotos(this.limit, this.currentPage)
          .then((photos) => {
            console.log(
              "chargeNextPhotos. Previous page:" +
                (this.currentPage - 1) +
                ",currentPage:" +
                this.currentPage
            );
            console.log(photos);
            this.photos = this.photos.concat(photos);
            console.log(this.photos);
          })
          .catch((error) => {
            alert(
              "erreur lors du chargement de photos supplémentaires" +
                error.message
            );
          })
          .finally(() => {
            this.loadingPhotos = false;
          });
      }
    },

    getIdRange() {
      api
        .getGalleryPhotoIdRange()
        .then((idRange) => {
          console.log(idRange);
          this.idRange = idRange;
          console.log(
            "id range fecthed, min:" + this.idRange.min + ", max:" + idRange.max
          );
          this.pageCount = Math.ceil(this.idRange.total / this.limit);
          console.log("page count:" + this.pageCount);
          this.getNextPhotos();
        })
        .catch((error) => {
          alert("erreur lors du chargement de IdRange" + error.message);
        });
    },
    getGalleryPhotos() {
      this.loadingPhotos = true;
      api
        .getGalleryPhotos()
        .then((photos) => {
          this.photos = photos;
          console.log("photos fetched from api");
          console.log(this.photos);
          console.log("param id in gallery.vue:" + this.$route.params.photoId);
        })
        .catch((error) => {
          alert("erreur lors du chargement des photos" + error.message);
        })
        .finally(() => {
          this.loadingPhotos = false;
        });
    },
    showPhotoModal(photoId) {
      var photoDisplayed = {};
      if (this.photos.find((photo) => photo.id == photoId)) {
        photoDisplayed = this.photos.find((photo) => photo.id == photoId);
        this.$refs.PhotoModal.openModal(photoDisplayed);
        console.log("gallery.vue, showphotomodal, photo found in list");
     
      } else {
        this.loadingPhoto = true;
        api
          .getGalleryPhoto(photoId)
          .then((photo) => {
            photoDisplayed = photo;
            console.log("photo fecthed from api");
            if (photo.id) {
              console.log(photoDisplayed);
              this.$refs.PhotoModal.openModal(photoDisplayed);
            } else {
              console.log("no photo with dat ID");
            }
          })
          .catch((error) => {
            alert("erreur lors du chargement de photo" + error.message);
          })
          .finally(() => {
            this.loadingPhoto = false;
          });
      }
      console.log("gallery.vue, open modal");
    },
  },
  watch: {
    "$route.params.photoId": function (id) {
      console.log(
        "watching fromp gallery, and id is" +
          id +
          ", route id:" +
          this.$route.params.photoId
      );
      this.showPhotoModal(id);
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