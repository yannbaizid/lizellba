<template>
  <transition name="fade">
    <div class="modal" v-if="show">
      <div class="modal_backdrop" @click="closeModal()" />
      <div class="modal_dialog">
        <app-icon
          id="close_icon"
          v-bind:type="'x'"
          :circle="false"
          class="align_right"
          @click.native="closeModal()"
        />
        <div class="flexbox_col flexbox_spacebetween flexbox_alignstart h_100">
          <div class="flexbox_row flexbox_spacebetween w_100">
            <div class="float_left" v-if="photo.id<idRange.max" >&#12296;</div>
            <img
              class="img_rnd photo_modal_img w_100 flex_shrink"
              :src="imgLink + '/expos/' + photo.file_name"
              :alt="photo.img_name"
            />
            <div v-if="photo.id>idRange.min">></div>
          </div>
          <div class="flexbox_row flexbox_spacebetween w_100">
            <div
              id="exposition_description"
              class="flexbox_col flexbox_spacebetween flexbox_alignstart m_20"
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
              ></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    :src=
  </transition>
</template>

<script>
import AppIcon from "../../services/icons/Icon.vue";
export default {
  components: { AppIcon },
  name: "PhotoModal",

  data() {
    return {
      show: false,
      photo: {},
      imgLink: process.env.VUE_APP_IMGLINK,
    };
  },
  props: {
    idRange: Object
  },
  methods: {
    closeModal() {
      this.show = false;
      document.querySelector("body").classList.remove("overflow-hidden");
    },
    openModal(photo) {
      this.show = true;
      document.querySelector("body").classList.add("overflow-hidden");
      console.log("j'ouvr photo modal");
      this.photo = photo;
      console.log(this.photo);
      console.log(this.idRange);
    },
  },
  mounted() {
    console.log("photomodal mounted");
    
  },
};
</script>

<style lang="scss" scoped>
.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 9;
  overflow-x: hidden;
  overflow-y: auto;

  &_backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.3);
    z-index: 1;
  }
  &_dialog {
    position: relative;
    width: 774px;
    background-color: #ffffff;
    margin: 50px auto;
    display: flex;
    flex-direction: column;
    z-index: 2;
    // height: 645px;
    padding: 0px;
    @media screen and (max-width: 992px) {
      width: 90%;
    }
  }
}

#exposition_curator {
  border: 1px solid black;
  padding: 5px 20px 5px 20px;
}
#exposition_name {
  padding: 5px 0px;
}
.photo_modal_img {
  padding: 0px 20px;
}
</style>