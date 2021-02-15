<template>
  <modal
    ref="PhotoModal"
    id="photo_modal"
    class="w_100"
    :type="'content_size'"
    @closeModalEvent="handleCloseModalEvent"
  >
    <div class="flexbox_col flexbox_spacebetween flexbox_alignstart h_100">
      <div
        class="flexbox_row flexbox_spacebetween w_100 flex_grow"
        id="photo_container"
      >
        <div
          v-if="showEndCredits"
          @click="showEndCredits = false"
          ref="endCredits"
          id="endCredits"
          class="bold font_size_big flexbox_col flexbox_justifycenter"
        >
          Votre exposition a bien été validée,<br />Vous pouvez la retouver sur
          la page d'accueil
        </div>
        <div
          id="previous_button"
          class="navigation_button"
          v-if="photo.id < idRange.max"
          @click="onPrevious()"
        >
          <svg
            width="17"
            height="34"
            viewBox="0 0 17 34"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              class="navigation_svg"
              transform="rotate(180,9,17)"
              d="M1 1L15.6667 17L1 33"
              stroke="black"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </div>
        <img
          class="img_rnd photo_modal_img w_100 flex_shrink"
          :src="imgLink + 'expos/' + photo.file_name"
          :alt="photo.img_name"
        />
        <div
          v-if="photo.id > idRange.min"
          id="next_button"
          class="navigation_button"
          @click="onNext()"
        >
          <svg
            width="39"
            height="39"
            viewBox="0 0 17 34"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M1 1L15.6667 17L1 33"
              stroke="black"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </div>
      </div>
      <div class="flexbox_row flexbox_spacebetween w_100">
        <div
          id="exposition_description"
          class="flexbox_col flexbox_spacebetween flexbox_alignstart"
        >
          <div id="exposition_curator">{{ photo.curator_name }}</div>
          <div id="exposition_name" class="font_style_italic">
            {{ photo.expo_name }}
          </div>
        </div>
        <div class="m_20">
          <a
            :download="'lizellba_expo' + photo.id"
            :href="imgLink + '/expos/' + photo.file_name"
            ><svg
              width="27"
              height="28"
              viewBox="0 0 27 28"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M19.8197 12.4501L13.1437 18.7008L6.78052 12.1683"
                stroke="black"
                stroke-width="1.2"
                stroke-miterlimit="10"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M13.3 1.53699V17.7785"
                stroke="black"
                stroke-width="1.2"
                stroke-miterlimit="10"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M25.0355 26.4629H1.56494"
                stroke="black"
                stroke-width="1.2"
                stroke-miterlimit="10"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </a>
          <div v-if="shareApi" @click="handleShare">
            <svg
              width="39"
              height="39"
              viewBox="0 0 39 39"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M21.4351 9.2699C21.2101 9.04448 20.8735 8.97702 20.5801 9.10004C20.2875 9.22307 20.0963 9.51118 20.0963 9.83105V14.0568C15.8575 14.2266 13.7345 16.0006 13.4104 16.2951C11.2717 18.0658 9.81186 20.5343 9.28092 23.2742C9.01585 24.5981 8.96786 25.9569 9.14091 27.2959L9.1417 27.3007C9.14327 27.3126 9.14484 27.3245 9.1472 27.3364L9.31396 28.3039C9.3698 28.6294 9.62151 28.8865 9.94322 28.9469C10.2657 29.0072 10.5914 28.8595 10.7597 28.5754L11.2592 27.7349C12.7946 25.1585 14.7075 23.4512 16.9469 22.6591C17.9569 22.2987 19.0266 22.1408 20.0963 22.1931V26.5697C20.0963 26.8903 20.2883 27.1793 20.5817 27.3015C20.8758 27.4237 21.2133 27.3555 21.4375 27.1277L29.7311 18.7159C30.0371 18.4055 30.0355 17.9047 29.728 17.596L21.4351 9.2699Z"
                stroke="black"
                stroke-miterlimit="10"
              />
              <circle cx="19.5" cy="19.5" r="19" stroke="black" />
            </svg>
          </div>
<!--      <ShareNetwork
    network="facebook"
    :url="photo.id? 'http://lizellba.la-criee.org/#/gallery/photo/143' : 'https://lizellba.la-criee.org/'"
    title="Lizellba!"
    description="et zou, une belle expo pour lizellba"
    quote="The hot reload is so fast it\'s near instant. - Evan You"
    hashtags="La_criee"
  >
    Share on Facebook
</ShareNetwork> -->
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import Modal from "../../services/Modal.vue";
export default {
  components: { Modal },
  name: "PhotoModal",

  data() {
    return {
      show: false,
      photo: {},
      imgLink: process.env.VUE_APP_IMGLINK,
      showEndCredits: false,
    };
  },
  computed: {
    shareApi() {
      return navigator.share;
    },

  },
  props: {
    idRange: Object,
    initialEndCredits: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    onNext() {
      this.$emit("nextPhotoEvent");
    },
    onPrevious() {
      this.$emit("previousPhotoEvent");
    },
    closeModal() {
      this.show = false;
      document.querySelector("body").classList.remove("overflow-hidden");
    },
    openModal(photo, showCredits) {
      this.photo = photo;
      if (showCredits) {
        console.log("openModal in photomodal, showCredits=true");
        this.showEndCredits = true;
      }
      console.log(this.photo);
      console.log(this.idRange);
      console.log(
        "test id<id Range.max : " +
          this.photo.id +
          " ," +
          this.idRange.max +
          " ,"
      );
      console.log(Number(this.photo.id) < Number(this.idRange.max));
      console.log(
        "with a 0 for measure:" + (this.photo.id + 0) < this.idRange.max + 0
      );
      console.log("photoId inferior to 100" + (this.photo.id < 100));
      console.log("99 inferior to idrangeMax :" + (99 < this.idRange.max));
      console.log("99 inferior to 100:" + (99 < 100));
      this.$refs.PhotoModal.openModal();

      console.log("j'ouvr photo modal");
    },
    handleShare() {
      alert("bientôt");
    },
    handleCloseModalEvent() {},
  },
  metaInfo: {
 
      title: `Lizellba `,
      meta: [
        {
          name: "description",
          content:
            "Connect and follow " +

            " on Epiloge - " 

        },
        {
          property: "og:title",
          content: "LiZellBa, "
        },
        { property: "og:site_name", content: "LiZellBa" },
        {
          property: "og:description",
          content:
            "Vue de l'eposition fictive \"" +
            "\" créée sur LiZellBa - un jeu de La Criée centre d'art contemporain",
        },
        { property: "og:type", content: "article" },
        {
          property: "og:url",
          content: "https://epiloge.com/@" 
        },
        {
          property: "og:image",
          content: 'http://lizellba.la-criee.org/img/expos/20210206201153_456.jpg'
        },
      ],

  },
  mounted() {
    console.log("photomodal mounted");
  },
};
</script>

<style lang="scss" scoped>
#exposition_curator {
  border: 1px solid black;
  padding: 5px 20px 5px 20px;
  margin-top: 20px;
}
#exposition_name {
  padding-top: 5px;
  margin-bottom: 20px;
}

.navigation_button {
  padding: 10px;
  border-radius: 2px;
  background-color: rgba(247, 247, 247, 0.3);
  stroke: black;
  &:hover {
    cursor: pointer;
    stroke: #9a9a9a;
    background-color: rgba(252, 252, 252, 0.3);
  }

  svg {
    stroke: inherit;
  }
  path {
    stroke: inherit;
  }
}
#previous_button {
  position: absolute;
  left: 0px;
}
#next_button {
  position: absolute;
  right: 0px;
}

#photo_container {
  position: relative;
}

#endCredits {
  position: absolute;
  background-color: #4f4f4f80;
  height: 100%;
  width: 100%;
  z-index: 6;
  color: white;
}
</style>