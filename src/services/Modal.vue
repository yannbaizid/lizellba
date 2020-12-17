<template>
  <div class="modal" v-if="show">
    <div class="modal_backdrop" />
    <div class="modal_dialog">
      <div @click="show = false" class="modal_close align_right"><app-icon type="x"  /></div>
      <slot></slot>
    </div>
  </div>
</template>

<script>
import AppIcon from "./icons/Icon.vue";
export default {
  components: { AppIcon },
  name: "Modal",
  props: {},
  data() {
    return {
      show: true,
    };
  },
  mounted() {
    this.show = true;
  },
  methods: {
    closeModal() {
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
    min-width: 800px;
    height: 60%;
    min-height: 390px;
    background-color: #ffffff;
    border-radius: 10px;
    padding: 10px;
    display: flex;
    flex-direction: column;
    z-index: 2;
    justify-content: space-between;
    @media screen and (max-width: 992px) {
      width: 90%;
    }
  }
}
</style>