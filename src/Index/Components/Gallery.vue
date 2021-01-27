<template>
  <div id="gallery">
    <div
      id="gallery_container"
      ref="GalleryContainer"
      class="flexbox_row flexbox_justifystart flexbox_alignstart w_100"
    >
      <div
        class="img_thumbnail"
        v-for="(photo, index) in photos"
        :key="index"
        @click="showPhotoModal(photo.id,false)"
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
    <photo-modal
      ref="PhotoModal"
      :idRange="idRange"
      @previousPhotoEvent="handlePreviousPhoto"
      @nextPhotoEvent="handleNextPhoto"
    />
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
      limit: 8,
      displayedPhoto: {},

    };
  },
  computed: {
    allPhotosLoaded() {
      return this.photos.length == this.idRange.total;
    },
    displayedPhotoIndex() {
      return this.photos.findIndex(
        (photo) => photo.id == this.displayedPhoto.id
      );
    },
  },
  async mounted() {
    await this.getIdRange();
    await this.getNextPhotos();

    if (this.$route.params.photoId) {
      console.log("mounted i show"+this.$route);
      console.log(this.$route.query);
  
      this.showPhotoModal(this.$route.params.photoId,this.$route.query.credits);
      this.$route.query.credits=null;

    }
  },
  created() {
    window.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    async handleNextPhoto() {
      console.log(
        "handle next photo in gallery.vue. Id=" + this.displayedPhotoIndex
      );

      if (this.displayedPhoto.id > this.idRange.min) {
        if (this.displayedPhotoIndex + 1 < this.photos.length) {
          console.log("next photo found in list");
          this.displayedPhoto = this.photos[this.displayedPhotoIndex + 1];
          this.$refs.PhotoModal.openModal(this.displayedPhoto);
        } else {
          this.loadingPhotos = true;
          await this.getNextPhotos();
          console.log('hop jessaye de passer à la suite');
          if (this.displayedPhotoIndex + 1 < this.photos.length) {
             console.log('hop jy arrive en plus');
            this.displayedPhoto=this.photos[this.displayedPhotoIndex+1];
             this.$refs.PhotoModal.openModal(this.displayedPhoto);
          }
        }
      }
    },
    handlePreviousPhoto() {
      console.log(
        "handle previous photo in gallery.vue. Id=" + this.displayedPhoto.id
      );

      var displayedPhotoIndex = this.photos.findIndex(
        (photo) => photo.id == this.displayedPhoto.id
      );
      if (displayedPhotoIndex > 0) {
        console.log("previous photo found in list");
        this.displayedPhoto = this.photos[displayedPhotoIndex - 1];
        this.$refs.PhotoModal.openModal(this.displayedPhoto);
      } else if (this.displayedPhoto.id < this.idRange.max) {
        this.loadingPhoto = true;
        api
          .getPreviousGalleryPhoto(this.displayedPhoto.id)
          .then((photo) => {
            console.log("previous photo fecthed from api");
            if (photo.id) {
              this.displayedPhoto = photo;
              console.log(this.displayedPhoto);
              this.$refs.PhotoModal.openModal(this.displayedPhoto);
            } else {
              console.log("no previous photo found");
            }
          })
          .catch((error) => {
            alert("erreur lors du chargement de la photo" + error.message);
          })
          .finally(() => {
            this.loadingPhoto = false;
          });
      }
    },
    handleScroll() {

      if (!this.loadingPhotos) {
/* 
        let bottomOfWindow= document.documentElement.scrollTop+document.documentElement.offsetHeight> this.$refs.GalleryContainer.offsetTop+this.$refs.GalleryContainer.offsetHeight;
        console.log(bottomOfWindow);
         console.log(document.documentElement);
        console.log(window); 
        console.log(document.documentElement.scrollTop+document.documentElement.offsetHeight);
        console.log(this.$refs.GalleryContainer.offsetTop+this.$refs.GalleryContainer.offsetHeight)
        if (bottomOfWindow) {
            this.getNextPhotos();
        } */
        console.log(document.documentElement);
        console.log(window.innerHeight);
        console.log(document.documentElement.scrollTop+' cH:'+document.documentElement.clientHeight+' sH'+document.documentElement.scrollHeight);

        let bottomOfWindow =
          document.documentElement.scrollTop +document.documentElement.clientHeight>=
          document.documentElement.scrollHeight-20;
        if (bottomOfWindow) {
          console.log("t'en as trop pris, mec");
          console.log(document.documentElement);
          console.log(this.$refs.GalleryContainer);
          this.getNextPhotos();
        }
      }
    },
    async getNextPhotos() {
      if (this.currentPage <= this.pageCount) {
        this.loadingPhotos = true;
        this.currentPage++;
       return api
          .getNextGalleryPhotos(this.limit, this.currentPage)
          .then((photos) => {
            console.log(
              "chargeNextPhotos. Previous page:" +
                (this.currentPage - 1) +
                ",currentPage:" +
                this.currentPage
            );
            this.photos = this.photos.concat(photos);
            console.log(this.photos);

            var img=new Image();
            img.onload=()=>{
              this.loadingPhotos=false;
            }
            img.src=this.photos[this.photos.length-1];
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

    async getIdRange() {
     return api
        .getGalleryPhotoIdRange()
        .then((idRange) => {
          console.log(idRange);
          this.idRange = idRange;
          console.log(
            "id range fecthed, min:" + this.idRange.min + ", max:" + idRange.max
          );
          this.pageCount = Math.ceil(this.idRange.total / this.limit);
          console.log("page count:" + this.pageCount);
         
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
          this.loadingPhotos = false;
        })
        .finally(() => {
         
        });
    },
    showPhotoModal(photoId,showCredits) {
      if (this.photos.find((photo) => photo.id == photoId)) {
        this.displayedPhoto = this.photos.find((photo) => photo.id == photoId);
        this.$refs.PhotoModal.openModal(this.displayedPhoto,showCredits);
        console.log("gallery.vue, showphotomodal, photo found in list");
      } else {
        this.loadingPhoto = true;
        api
          .getGalleryPhoto(photoId)
          .then((photo) => {
            console.log("photo fecthed from api");
            if (photo.id) {
              this.displayedPhoto = photo;
              console.log(this.displayedPhoto);
              this.$refs.PhotoModal.openModal(this.displayedPhoto,showCredits);
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
      this.showPhotoModal(id,false);
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