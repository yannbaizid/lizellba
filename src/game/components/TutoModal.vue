<template>
  <div>
    <modal
      ref="TutoModal"
      id="tuto_modal"
      :initialState="true"
      @closeModalEvent="handleCloseModalEvent"
      type="gallery"
    >
      <div class="h_100 flexbox_col w_100 flexbox_spacebetween">
        <div
          class="tuto_style align_center flex_grow flex_shrink flexbox_col w_100 flexbox_spacebetween"
        >
          <div class="font_size_big">Étape {{ index + 1 }}/{{ tutoSteps.length }}</div>
          <div class="bold font_size_big">{{ tutoSteps[index][0] }}</div>
          <div class="">{{ tutoSteps[index][1] }}</div>
          <img id="tuto_img" :src="require('../../assets/tuto/'+(index+1)+'.jpg')"/>
          
        </div>
        <div class="w_100">
          <div class="flexbox_row flexbox_justifycenter w_100 flexbox_alignend">
            <div v-if="index == tutoSteps.length - 1" @click="closeModal()">
              <app-button
                :message="!visited ? 'Commencer le jeu' : 'Retour au jeu'"
                 background="white"
              />
            </div>
            <div
              v-if="index > 0 && index < tutoSteps.length - 1"
              @click="index--"
              class="align_left flexbox_col flexbox_shrink flexbox_alignend"
            >
              <app-icon type="<" />
            </div>
            <div
              v-if="index < tutoSteps.length - 1"
              @click="index++"
              class="tuto_arrow align_right"
            >
              <app-icon type=">" />
            </div>
          </div>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import AppIcon from "../../services/icons/Icon.vue";
import AppButton from "../../services/AppButton";
import Modal from "../../services/Modal.vue";
export default {
  components: { Modal, AppIcon, AppButton },
  name: "TutoModal",
  data() {
    return {
      tutoSteps: [],
      index: 0,
      visited: false,
    };
  },
  mounted() {
    this.tutoSteps.push([
      "1. La collecte des œuvres –miniatures",
      "Deux parties composent l'écran. À gauche un volet rétractable affiche des questions. Derrière se trouve votre espace d'exposition. Répondez aux questions, vous obtiendrez des œuvres pour créer votre exposition. N'oubliez pas de lire les légendes, elles pourraient vous aider à répondre ! Continuez à répondre aux questions jusqu'à ce que votre exposition vous plaise.",
    ]);
    this.tutoSteps.push([
      "2. Le montage de votre exposition",
      "Sélectionnez et placez les œuvres où vous voulez dans l'espace. Vous pouvez aussi les redimensionner grâce au cadre de sélection qui apparaît en cliquant sur chacune d’entre elles.",
    ]);
    this.tutoSteps.push([
      "3. La prise de vue",
      "L'accrochage est terminé ? Vous pouvez prendre en photo votre exposition grâce au bouton “Valider votre exposition” en bas à droite de l’écran. En tant que commissaire d'exposition, donnez-lui un titre et notez votre nom en remplissant les champs proposés dans la page suivante. Félicitations, votre exposition est désormais accessible depuis la page d’accueil !",
    ]);
  },
  methods: {
    openModal() {
      console.log("Open da shit " + this.visited);
      this.$refs.TutoModal.openModal();
    },
    handleCloseModalEvent() {
      console.log("handleclosemodalevent, " + this.visited);
      this.index = 0;
      this.visited = true;
    },
    closeModal() {
      this.$refs.TutoModal.closeModal();
    },
  },
};
</script>
<style lang="scss" scoped>
#tuto_modal {
  z-index: 10;
}

.tuto_style {
  max-width: 580px;
  // line-height: 18px;
}

#tuto_img {
  
  height: 200px;
  max-width: 100%;
}
</style>