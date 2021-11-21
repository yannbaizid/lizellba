<template>
  <div id="gallery">
    <div v-if="showTypeSelection" class="my_20 flexbox_row flexbox_justifycenter flexbox_wrap">
     <div  class="flexbox_row flexbox_justifyend flexbox_wrap type_selector_container">
 
      <div @click="handleTypeSelection(0)" class="mx_02">
        <app-button message="Tous" :active="photoType == 0 ? true : false"  :selector="true" />
      </div>
      <div @click="handleTypeSelection(1)" class="mx_02">
        <app-button
          message="Numérique"
          :active="photoType == 1 ? true : false"  :selector="true"
        />
      </div>

      <div @click="handleTypeSelection(2)" class="mx_02">
        <app-button
          message="Physique"
          :active="photoType == 2 ? true : false"  :selector="true"
        />
      </div>
          </div>
    </div> 
    <div
      id="gallery_container"
      ref="GalleryContainer"
      class="flexbox_row flexbox_justifycenter flexbox_alignstart w_100"
    >
      <div
        class="img_thumbnail"
        v-for="(photo, index) in photos"
        :key="index"
        @click="showPhotoModal(photo.id, false)"
      >
        <img
          class="gallery_img h_100"
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
 <div  class="flexbox_row flexbox_justifycenter">
    <div class="flexbox_row flexbox_justifyend mx_20 type_selector_container">

    <pagination
      :currentPage="currentPage"
      :pageCount="pageCount"
      @pageSelectionEvent="handlePageSelection"
    />
    </div></div>
  </div>
</template>

<script>
import PhotoModal from "./PhotoModal.vue";
import api from "@/services/api/api.js";
import AppButton from "../../services/AppButton.vue";
import Pagination from "./Pagination.vue";

export default {
  components: { PhotoModal, AppButton, Pagination },
  name: "Game",
  data() {
    return {
      photos: [],
      loadingPhoto: false,
      loadingPhotos: false,
      idRange: {},
      currentPage: 1,
      pageCount: 1,
      limit: 16,
      displayedPhoto: {},
      photoType: 0,
      showTypeSelection: true,
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
    //Gather infos :
    await this.loadGallery();
    // await this.getNextPhotos();

    if (this.$route.params.photoId) {
      console.log("mounted i show" + this.$route);
      console.log(this.$route.query);

      this.showPhotoModal(
        this.$route.params.photoId,
        this.$route.query.credits
      );
      this.$route.query.credits = null;
    }
  },
  created() {},
  destroyed() {},
  methods: {
    async loadGallery() {
      let scroll = window.scrollY;
      await this.getIdRange();
      await this.getGalleryPhotos();
      Window.scrollY = scroll;
    },
    /**
     * Change current page
     * takes target page as arg
     */
    handlePageSelection(page) {
      this.currentPage = page;
      this.loadGallery();
    },
    handleTypeSelection(type) {
      if (type != this.photoType) {
        this.photoType = type;
        this.currentPage=1;
        this.loadGallery();
      }
    },
    /***
     * Display next photo if id of actual photo is > to idmin.
     * If photo is in list of photos already loaded, show it.
     * Else, load next batch of photos, and then display next photo.
     * */
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
          console.log("hop jessaye de passer à la suite");
          if (this.displayedPhotoIndex + 1 < this.photos.length) {
            console.log("hop jy arrive en plus");
            this.displayedPhoto = this.photos[this.displayedPhotoIndex + 1];
            this.$refs.PhotoModal.openModal(this.displayedPhoto);
          }
        }
      }
    },

    /**
     *Display previous photo if id of actual photo is < to idmax.
     * If photo is in list of photos already loaded, show it.
     * Else, load previous batch of photos, and then display next photo.
     */
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

    /**
     * load next batch of photos when scroll reached bottom of page
     */
    handleScroll() {
      if (!this.loadingPhotos) {
        if (
          window.innerHeight + window.scrollY >=
          document.documentElement.scrollHeight - 10
        ) {
          console.log("t'en as trop pris, mec");

          this.loadingPhotos = true;
          this.$nextTick().then(() => {
            this.getNextPhotos();
          });
        }
      }
    },

    /**
     *
     */
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

            var img = new Image();
            img.onload = () => {
              this.loadingPhotos = false;
              console.log("inside getNextPhotos, last image loaded");
            };

            console.log(
              "loading :" +
                process.env.VUE_APP_IMGLINK +
                "expos/" +
                this.photos[this.photos.length - 1].file_name
            );
            img.src =
              process.env.VUE_APP_IMGLINK +
              "expos/" +
              this.photos[this.photos.length - 1].file_name;
          })
          .catch((error) => {
            alert(
              "erreur lors du chargement de photos supplémentaires" +
                error.message
            );
          })
          .finally(() => {
            //  this.loadingPhotos = false;
          });
      } else {
        this.loadingPhotos = false;
      }
    },

    /**
     * gather data:
     * total number of photos in DB
     * maxId and minId.
     * Calculates total number of pages based on number of photos and limit
     */
    async getIdRange() {
      return api
        .getGalleryPhotoIdRange(this.photoType)
        .then((idRange) => {
          console.log(idRange);
          this.idRange = idRange;
          this.idRange.max = Number(this.idRange.max);
          this.idRange.min = Number(this.idRange.min);
          this.idRange.total = Number(this.idRange.total);
          console.log(
            "id range fecthed, min:" +
              this.idRange.min +
              ", max:" +
              idRange.max +
              ",total:" +
              idRange.total
          );

          this.pageCount = Math.ceil(this.idRange.total / this.limit);
          console.log("page count:" + this.pageCount);
        })
        .catch((error) => {
          alert("erreur lors du chargement de IdRange" + error.message);
        })
        .finally(() => {
          console.log("get id range finally");
        });
    },
    async getGalleryPhotos() {
      api
        .getGalleryPhotos(this.photoType, this.currentPage, this.limit)
        .then((photos) => {
          this.photos=new Array(photos.length);
          this.photos = photos;
          console.log("photos fetched from api");
          console.log(this.photos);
        })
        .catch((error) => {
          alert("erreur lors du chargement des photos" + error.message);
        })
        .finally(() => {});
    },

    /**
     * Display specific photo.
     * Args:
     * photoId = id of photo displayed.
     * showCredits = Show a text to explain the end of the game. Default = false. Put true when called from game.
     * if photo is among photos loaded, dispay it.
     * Else, load this photo from database and display it.
     */
    showPhotoModal(photoId, showCredits) {
      if (this.photos.find((photo) => photo.id == photoId)) {
        this.displayedPhoto = this.photos.find((photo) => photo.id == photoId);
        this.$refs.PhotoModal.openModal(this.displayedPhoto, showCredits);
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
              this.$refs.PhotoModal.openModal(this.displayedPhoto, showCredits);
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
      this.showPhotoModal(id, false);
    },
  },
};
</script>

<style lang="scss" scoped>


.type_selector_container {
  width: 91vw;
}
.img_thumbnail {
  width: 22vw;
  height: 13.5vw;
  min-width: 120px;
  min-height: 67.5px;
  padding-bottom: 20px;
  padding-right: 0.5vw;
  padding-left: 0.5vw;
}

.gallery_img {
  width: 100%;
  border-radius: 2%;
  object-fit: cover;
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