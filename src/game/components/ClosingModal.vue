<template>
  <div>
    <modal
      ref="ClosingModal"
      id="closing_modal"
      @closeModalEvent="handleCloseModalEvent"
    >
      <!--ASK FOR CONFIRMATION -->

      <div class="bold">
        Es-tu sûr de vouloir quitter le montage sans valider l'exposition?
      </div>

      <div class="flexbox flexbox_col flexbox_spacearound">
        <div @click="validateExpo()">
          <app-button message="Valider votre exposition" />
        </div>
        <div @click="closeModal()">
          <app-button message="Retourner sur le montage" />
        </div>
        <div @click="exit()">
          <app-button message="oui" />
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import AppButton from "../../services/AppButton.vue";

import Modal from "../../services/Modal.vue";
export default {
  components: { Modal, AppButton },
  name: "ClosingModal",
  data() {
    return {};
  },
  mounted() {},
  methods: {
    openModal() {
      console.log("Open da shit");
      this.$refs.ClosingModal.openModal();
    },
    handleCloseModalEvent() {
      console.log("handleclosemodalevent");
    },
    closeModal() {
      this.$refs.ClosingModal.closeModal();
    },
    exit() {
      this.$emit("closeExpoEvent");
      this.closeModal();
    },
    validateExpo() {
      this.$emit("askExpoValidationEvent");
      this.closeModal();
    },
  },
};
</script>
<style lang="scss">
</style>