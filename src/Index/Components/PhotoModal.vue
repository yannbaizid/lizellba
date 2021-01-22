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
          <div class="flexbox_row flexbox_spacebetween w_100 flex_grow">
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
                class="navigation_svg"  transform="rotate(180,9,17)"
                  d="M1 1L15.6667 17L1 33"
                  stroke="black"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
            <img
              class="img_rnd photo_modal_img w_100 flex_shrink"
              :src="imgLink + '/expos/' + photo.file_name"
              :alt="photo.img_name"
            />
            <div
              v-if="photo.id > idRange.min"
              id="next_button"
              class="navigation_button"
              @click="onNext()"
            >
              <svg
                width="17"
                height="34"
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
    idRange: Object,
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
  margin: 0px 20px;
  background-color: pink;
}

.navigation_button {
  margin: 20px;
  padding: 10px;
  border-radius: 2px;
  background-color: rgba(247, 247, 247, 0.1);
  stroke: black;
  &:hover {
    cursor: pointer;
    stroke:#9A9A9A;
     background-color: rgba(252, 252, 252, 0.1);
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
</style>