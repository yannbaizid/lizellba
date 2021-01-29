<template>
  <div>
    <modal
      ref="ValidateModal"
      id="validate_modal"
      @closeModalEvent="handleCloseModalEvent"
    >
      <div
        v-if="artworksUnlocked < 1"
        class="modal_container h_100 w_100 flexbox_col flexbox_justifycenter modal_container_text"
      >
        <div class="bold font_size_big">
          Vous devez disposer d'au moins une oeuvre avant de pouvoir valider
          votre exposition.
        </div>
      </div>
      <!--ASK FOR NAME -->
      <div
        v-if="currentStep == 1 && artworksUnlocked > 0"
        class="modal_container h_100 w_100 flexbox_col flexbox_spacebetween modal_container_text"
      >
        <div class="bold font_size_big">
          Complétez les informations suivantes<br />
        </div>
        <div class="input_long">
          Votre nom de commissaire :
          <span v-show="curatorNameTooLong">(40 caractères maximum)</span><br />
          <input
            class="validate_input"
            v-model="curatorName"
            type="text"
            name="curatorName"
          />
          <br />
          Nom de votre exposition :
          <span v-show="expoNameTooLong">(50 caractères maximum)</span>
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
      <div
        v-if="currentStep == 2 && artworksUnlocked > 0"
        class="modal_container h_100 w_100 flexbox_col flexbox_spacebetween modal_container_text"
      >
        <div class="bold font_size_big">
          êtes vous sûr?<br />Vous ne pourrez plus modifier votre exposition.
        </div>
        <div
          class="flex_grow flexbox_col flexbox_justifycenter flexbox_alignstart name_container"
        >
          <div>Nom de commissaire: {{ curatorName }}</div>
          <div class="p_t_20">Nom de l'expo: {{ expoName }}</div>
        </div>
        <div class="flexbox flexbox_spacearound w_100">
          <div @click="cancel()">
            <app-button message="Retour" />
          </div>

          <div @click="closeModal()">
            <app-button message="Annuler" />
          </div>
          <div @click="validate()">
            <app-button message="Valider" />
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
  computed: {
    curatorNameTooLong() {
      return this.curatorName.length > 40;
    },
    expoNameTooLong() {
      return this.expoName.length > 50;
    },
  },
  props: {
    artworksUnlocked: Number,
  },
  mounted() {},
  methods: {
    openModal() {
      console.log(
        "Open da shit. Current artwork count:" + this.artworksUnlocked
      );
      this.$refs.ValidateModal.openModal();
    },
    handleCloseModalEvent() {
      this.currentStep = 1;
      console.log("handleclosemodalevent");
    },
    validate() {
      if (!this.curatorNameTooLong && !this.expoNameTooLong) {
        if (!(this.curatorName && this.expoName)) {
          alert(
            "Vous devez rentrer un nom d'exposition et un nom de commissaire"
          );
        } else {
          if (this.currentStep == 1) {
            this.currentStep++;
          } else if (this.currentStep == 2) {
            this.$emit("validateExpoEvent", {
              curatorName: this.curatorName,
              expoName: this.expoName,
            });
            this.$refs.ValidateModal.closeModal();
          }
        }
      }
    },
    cancel() {
      if (this.currentStep == 2) {
        this.currentStep--;
      }
    },
    closeModal() {
      console.log("validate modal. Close modal");
      this.$refs.ValidateModal.closeModal();
    },
  },
};
</script>
<style lang="scss" scoped>
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
  width: 60%;
  text-align: start;

  @media screen and (max-width: 900px) {
    width: 80%;
  }
  @media screen and (max-width: 600px) {
    width: 95%;
  }
}
.name_container {
  width: 410px;
}
</style>