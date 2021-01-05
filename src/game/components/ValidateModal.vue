<template>
  <div>
    <modal
      ref="ValidateModal"
      id="validate_modal"
      @closeModalEvent="handleCloseModalEvent"
    >
      <!--ASK FOR NAME -->
      <div v-if="currentStep == 1" class="modal_container modal_container_text">
        <div class="bold">Complète les informations suivantes<br /></div>
        <div class="input_long">
          Votre nom de commissaire :<br />
          <input
            class="validate_input"
            v-model="curatorName"
            type="text"
            name="curatorName"
          />
          <br />
          Nom de votre exposition :
          <br />
          <input
            class="validate_input"
            v-model="expoName"
            type="text"
            name="expoName"
          />
        </div>
        <div @click="validate()">
          <app-button message="Valider" />
        </div>
      </div>

      <!--ASK FOR CONFIRMATION -->
      <div v-if="currentStep == 2" class="modal_container modal_container_text">
        <div class="bold">êtes vous sûr?<br /></div>
        <div>
          Vous ne pourrez plus modifier votre exposition.<br />
          Nom de commissaire: {{ curatorName }},<br />
          Nom de l'expo: {{ expoName }}
        </div>
        <div class="flexbox flexbox_spacearound">
          <div @click="validate()">
            <app-button message="Valider" />
          </div>

          <div @click="closeModal()">
            <app-button message="Annuler" />
          </div>
          <div @click="cancel()">
            <app-button message="Retour" />
          </div>
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
    return {
      curatorName: "",
      expoName: "",
      currentStep: 1,
    };
  },
  mounted() {},
  methods: {
    openModal() {
      console.log("Open da shit");
      this.$refs.ValidateModal.openModal();
    },
    handleCloseModalEvent() {
      this.currentStep = 1;
      console.log("handleclosemodalevent");
    },
    validate() {
      if (!(this.curatorName && this.expoName)) {
        alert(
          "Vous devez rentrer un nom d'exposition et un nom de commissaire"
        );
      } else {
        if (this.currentStep == 1) {
          this.currentStep++;
        } else if (this.currentStep == 2) {
          alert("et hop, cest validé");
        }
      }
    },
    cancel() {
      if (this.currentStep == 2) {
        this.currentStep--;
      }
    },
  },
};
</script>
<style lang="scss">
#validate_modal {
  z-index: 10;
}

.validate_input {
  margin: 0px 0px 2em 0px;
  width: 100%;
  border-radius: 5px;
  height: 2em;
  border: 1px solid;
}

.input_long {
  width: 100%;
  text-align: start;
}
</style>