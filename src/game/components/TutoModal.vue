<template>
  <div>
    <modal ref="TutoModal" id="tuto_modal">
      <div>{{ index + 1 }}/{{ tutoSteps.length }}</div>
      <div>{{ tutoSteps[index] }}</div>
      <div v-if="index > 0" @click="index--">
        <app-icon type="<" />
      </div>
      <div v-if="index < tutoSteps.length - 1" @click="index++"  class="tuto_arrow" >
        <app-icon type=">"/>
      </div>
    </modal>
  </div>
</template>

<script>
import AppIcon from "../../services/icons/Icon.vue";

import Modal from "../../services/Modal.vue";
export default {
  components: { Modal, AppIcon },
  name: "TutoModal",
  data() {
    return {
      tutoSteps: [],
      index: 0,
    };
  },
  mounted() {
    this.tutoSteps.push(
      "Le jeu se déroule en 2 temps : un 1er temps pour collecter des œuvres et un 2e temps pour faire le montage de votre exposition. Pour cela 2 parties composent l'écran. À gauche un volet rétractable affiche des questions. Derrière se trouve votre espace d'exposition. Répondez aux questions, vous obtiendrez des œuvres pour mettre en place votre exposition. N'oubliez pas de lire les légendes, elles pourraient vous aider à répondre ! Continuez à répondre aux questions jusqu'à ce que vous soyez satisfait.e des œuvres qui composent votre exposition."
    );
    this.tutoSteps.push("informations");
    this.tutoSteps.push("informations.Encore!");
    console.log(this.tutoSteps.length);
  },
  methods: {
    closeModal() {
      console.log("close dat shit");
      this.show = false;
    },
  },
};
</script>
<style lang="scss">
#tuto_modal {
  z-index: 10;
}

.tuto_arrow {


}
</style>