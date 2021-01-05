<template>
  <div>
    <modal
      ref="ValidateModal"
      id="validate_modal"
      @closeModalEvent="handleCloseModalEvent"
    >
      <div class="modal_container modal_container_text">
        <div class="bold">
          Complète les informations suivantes<br />
        </div>
        <div class= "input_long">
          Votre nom de commissaire :<br />
          <input type="text" name="curatorName" />
          <br />
          Nom de votre exposition :
          <br />
          <input type="text" name="expoName" />
        </div>
        <div @click="validate()">
          <app-button message="Valider" />
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
  name: "ValidateModal",
  data() {
    return {};
  },
  mounted() {},
  methods: {
    openModal() {
      console.log("Open da shit");
      this.$refs.ValidateModal.openModal();
    },
    handleCloseModalEvent() {
      console.log("handleclosemodalevent");
    },
    validate() {
      alert('êtes vous sûr de vouloir valider votre exposition?\nVous ne pourrez plus la modifier.');
      console.log("salut");
    }
  },
};
</script>
<style lang="scss">
#validate_modal {
  z-index: 10;
}
</style>