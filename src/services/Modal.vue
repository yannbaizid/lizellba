<template>
  <div class="modal" v-if="show">
    <div class="modal_backdrop" />
    <div class="modal_dialog">
      <div @click="closeModal()" class="modal_close">
        <app-icon type="x" :circle="false" class="modal_close_icon" />
      </div>
      <slot></slot>
    </div>
  </div>
</template>

<script>
import AppIcon from "./icons/Icon.vue";
export default {
  components: { AppIcon },
  name: "Modal",
  props: {
    initialState: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      show: false,
    };
  },
  mounted() {
    this.show = this.initialState;
  },
  methods: {
    closeModal() {
      this.$emit("closeModalEvent");
      console.log("je suis method closeModal de Modal.vue");
      this.show = false;
      document.querySelector("body").classList.remove("overflow-hidden");
    },
    openModal() {
      this.show = true;
      document.querySelector("body").classList.add("overflow-hidden");
    },
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
  z-index: 10;
  overflow-x: hidden;
  overflow-y: auto;
  display: flex;
  align-items: center;
  justify-content: center;

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
    width: 60%;

    height: 60%;
    min-height: 390px;
    background-color: #ffffff;
    border-radius: 2px;
    padding: 0px;
    display: flex;
    flex-direction: column;
    z-index: 2;

    @media screen and (max-width: 900px) {
      width: 80%;
    }
    @media screen and (max-width: 600px) {
      width: 95%;
    }
  }
  &_close {

    &_icon {
     float:right;
    }
  }
}
</style>