<template>
  <transition name="fade">
    <div class="modal" v-if="show">
      <div class="modal_backdrop" @click="closeModal()" />
      <div class="modal_dialog">
          Ze suis un modal et ze cache le reste du site,
          <br>RIen à battre!!!
          {{photo.image}}, {{photo.description}}
      </div>
    </div>
  </transition>
</template>

<script>
export default {
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

<style lang="scss">
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
    width: 600px;
    background-color: #ffffff;
    border-radius: 5px;
    margin: 50px auto;
    display: flex;
    flex-direction: column;
    z-index: 2;
    @media screen and (max-width: 992px) {
      width: 90%;
    }
  }
}
</style>