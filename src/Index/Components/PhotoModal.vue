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
        <div >
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
          <div v-if="shareApi" @click="handleShare" class="p_l_1">
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
        <ShareNetwork class="p_l_1"
    network="twitter"
    :url="photo.id? 'http://lizellba.la-criee.org/sharephoto.php?photo='+photo.id : 'https://lizellba.la-criee.org/'"
    :title="'Venez visitez \''+photo.expo_name+'\' , une exposition réalisée par '+photo.curator_name+' sur LiZellBa, un jeu de La Criée centre d\'art contemporain'"
  twitter-user="la_criee"
    hashtags="lacrieecentredart,LiZellBa"
  >
   
<svg version="1.1" stroke-width="10" id="White" fill="none" height="39" width="39" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-5 -5 410 410" style="enable-background:new 0 0 400 400;" xml:space="preserve">

<path stroke="black"  class="st0" d="M400,200c0,110.5-89.5,200-200,200S0,310.5,0,200S89.5,0,200,0S400,89.5,400,200z M163.4,305.5
	c88.7,0,137.2-73.5,137.2-137.2c0-2.1,0-4.2-0.1-6.2c9.4-6.8,17.6-15.3,24.1-25c-8.6,3.8-17.9,6.4-27.7,7.6
	c10-6,17.6-15.4,21.2-26.7c-9.3,5.5-19.6,9.5-30.6,11.7c-8.8-9.4-21.3-15.2-35.2-15.2c-26.6,0-48.2,21.6-48.2,48.2
	c0,3.8,0.4,7.5,1.3,11c-40.1-2-75.6-21.2-99.4-50.4c-4.1,7.1-6.5,15.4-6.5,24.2c0,16.7,8.5,31.5,21.5,40.1c-7.9-0.2-15.3-2.4-21.8-6
	c0,0.2,0,0.4,0,0.6c0,23.4,16.6,42.8,38.7,47.3c-4,1.1-8.3,1.7-12.7,1.7c-3.1,0-6.1-0.3-9.1-0.9c6.1,19.2,23.9,33.1,45,33.5
	c-16.5,12.9-37.3,20.6-59.9,20.6c-3.9,0-7.7-0.2-11.5-0.7C110.8,297.5,136.2,305.5,163.4,305.5"/>
</svg>


</ShareNetwork> 
        <ShareNetwork class="p_l_1"
    network="facebook"
    :url="photo.id? 'http://lizellba.la-criee.org/sharephoto.php?photo='+photo.id : 'https://lizellba.la-criee.org/'"
    title="Lizellba"
    description="Lizellba, un jeu de La Criée."
    :quote="'Venez visitez \''+photo.expo_name+'\' , une exposition réalisée par '+photo.curator_name+' sur LiZellBa, un jeu de La Criée centre d\'art contemporain'"

    hashtags="lacrieecentredart,LiZellBa"
  >
    <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="19.5" cy="19.5" r="19" stroke="black"/>
<path d="M22.9782 11.6671H24.9786V8.17625C24.6336 8.12865 23.4464 8.02144 22.064 8.02144C19.1799 8.02144 17.2039 9.83933 17.2039 13.1805V16.2554H14.0214V20.1583H17.2043V29.9786H21.1066V20.1592H24.1607L24.6456 16.2562H21.1058V13.5673C21.1066 12.4395 21.4097 11.6671 22.9782 11.6671Z" stroke="black" stroke-miterlimit="10"/>
</svg>

</ShareNetwork> 
       <!--  <ShareNetwork class="p_l_1"
    network="twitter"
    :url="photo.id? 'http://lizellba.la-criee.org/sharephoto.php?photo='+photo.id : 'https://lizellba.la-criee.org/'"
    :title="'Venez visitez \''+photo.expo_name+'\' , une exposition réalisée par '+photo.curator_name+' sur LiZellBa, un jeu de La Criée centre d\'art contemporain'"
    description="Lizellba, un jeu de La Criée."
    :quote="'Venez visitez \''+photo.expo_name+'\' , une exposition réalisée par '+photo.curator_name+' sur LiZellBa, un jeu de La Criée centre d\'art contemporain'"

    hashtags="lacrieecentredart,LiZellBa"
  >
    <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="19.5" cy="19.5" r="19" stroke="black"/>
<path d="M22.9782 11.6671H24.9786V8.17625C24.6336 8.12865 23.4464 8.02144 22.064 8.02144C19.1799 8.02144 17.2039 9.83933 17.2039 13.1805V16.2554H14.0214V20.1583H17.2043V29.9786H21.1066V20.1592H24.1607L24.6456 16.2562H21.1058V13.5673C21.1066 12.4395 21.4097 11.6671 22.9782 11.6671Z" stroke="black" stroke-miterlimit="10"/>
</svg>

</ShareNetwork>  -->
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
      navigator.share({
        title: "Vernissage de l'exposition "+this.photo.expo_name,
        text: 'Venez visitez \''+this.photo.expo_name+'\' , une exposition réalisée par '+this.photo.curator_name+' sur LiZellBa, un jeu de La Criée',
        url: this.photo.id? 'http://lizellba.la-criee.org/sharephoto.php?photo='+this.photo.id : 'https://lizellba.la-criee.org/',
      });
    },
    handleCloseModalEvent() {},
  },
  metaInfo: {
    title: `Lizellba `,
    meta: [
      {
        name: "description",
        content: "Visitez les expositions virtuelles montées sur le jeu Lizellba",
      },
      {
        property: "og:title",
        content: "LiZellBa, ",
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
        content: "http://lizellba.la-criee.org/",
      },
      {
        property: "og:image",
        content:
          "http://lizellba.la-criee.org/img/expos/20210206201153_456.jpg",
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