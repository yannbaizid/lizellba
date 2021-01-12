<template>
  
    <modal
      ref="ClosingModal"
      id="closing_modal"
      class="w_100"
      @closeModalEvent="handleCloseModalEvent"
    >
      <!--ASK FOR CONFIRMATION -->
     
      <div class="closing_modal h_100 align_center flexbox_col" >
        <div class="bold font_size_big">
          Êtes-vous sûr de vouloir quitter le montage sans valider l'exposition?
        </div>

        <div class="flexbox flexbox_col flexbox_justifyend flex_grow ">
          <div @click="validateExpo()"  class="w_100">
            <app-button message="Valider votre exposition" class="w_100" />
          </div>
          <div @click="closeModal()" class="p_t_20 w_100">
            <app-button message="Retour au jeu" class="w_100" />
          </div>
          <div @click="exit()"  class="w_100 p_t_20">
            <app-button message="Quitter" class="w_100" />
          </div>
        </div>
      </div>
    </modal>
  
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
.closing_modal {
  max-width: 410px;
  margin: 30px 0px 75px 0px;
}
</style>