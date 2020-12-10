<template>
  <transition name="fade">
    <div class="modal" v-if="show">
      <div class="modal_backdrop" @click="closeModal()" />
      <div class="modal_dialog">
<app-icon class="align_right"/>
          <img class="modal_img" :src="require('@/assets/img/photo/'+photo.img_name)" :alt="photo.img_name">
          {{photo.image}}, {{photo.description}}
      </div>
    </div> :src=
  </transition>
</template>

<script>
import AppIcon from '../../services/icons/Icon.vue';
export default {
  components: { AppIcon },
 name: "PhotoModal",
   props: {
  },
  data() {
    return {
      show: false,
      photo: {}
    };
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
      console.log(this.photo);
      this.photo=photo;

    },
  },
}
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
&_img {
  padding: 0px 20px;
}

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
      height: 645px;
      padding: 10px;
    @media screen and (max-width: 992px) {
      width: 90%;
    }
  }
}
</style>