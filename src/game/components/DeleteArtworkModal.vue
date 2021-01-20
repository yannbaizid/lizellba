<template>
  
    <modal
      ref="DeleteArtworkModal"
      id="DeleteArtwork_modal"
      class="w_100"
      @closeModalEvent="handleCloseModalEvent"
    >
      <!--ASK FOR CONFIRMATION -->
     
      <div class="DeleteArtwork_modal h_100 align_center flexbox_col" >
        <div class="bold font_size_big">
          Êtes-vous sûr de vouloir retirer cette oeuvre de votre exposition?
        </div>

        <div class="flexbox flexbox_col flexbox_justifyend flex_grow ">
          <div @click="onConfirmDelete()"  class="w_100 p_t_20">
            <app-button message="oui" class="w_100" />
          </div>
      
          <div @click="closeModal()" class="p_t_20 w_100">
            <app-button message="Retour au jeu" class="w_100" />
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
  name: "DeleteArtworkModal",
  data() {
    return {};
  },
  mounted() {},
  methods: {
    openModal() {
      console.log("Open da shit");
      this.$refs.DeleteArtworkModal.openModal();
    },
    handleCloseModalEvent() {
      console.log("handleclosemodalevent");
    },
    closeModal() {
      this.$refs.DeleteArtworkModal.closeModal();
    },
    onConfirmDelete() {
      this.$emit("confirmDeleteArtworkEvent");
      this.closeModal();
    },

  },
};
</script>
<style lang="scss">
.DeleteArtwork_modal {
  max-width: 410px;
  margin: 30px 0px 75px 0px;
}
</style>