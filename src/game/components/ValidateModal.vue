<template>
  <div>
    <modal ref="ValidateModal" id="validate_modal"
    @closeModalEvent="handleCloseModalEvent" >
   <div>
     Fonctionnalité activée lorsque l'application sera installée sur un véritable serveur avec un script pour enregistrer des images.<br>
     à bientôt!<br>
     Joyeux Noël, stay classy San Diego.

   </div>
    </modal>
  </div>
</template>

<script>

import Modal from "../../services/Modal.vue";
export default {
  components: { Modal },
  name: "ValidateModal",
  data() {
    return {
    };
  },
  mounted() {

  },
  methods: {

    openModal() {
      console.log("Open da shit");
      this.$refs.ValidateModal.openModal();
    },
    handleCloseModalEvent() {
        console.log('handleclosemodalevent');
    }
  },
};
</script>
<style lang="scss">
#validate_modal {
  z-index: 10;
}

</style>