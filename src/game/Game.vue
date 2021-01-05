<template>
  <div id="app">
    <tuto-modal id="tuto" ref="TutoModal" />
    <answer-modal
      ref="AnswerModal"
      v-bind:question="question"
      @newQuestionEvent="chargeQuestion()"
    />
    <validate-modal id="validateModal" ref="ValidateModal" />
    <div id="question">
      <Question
        v-bind:question="question"
        @showAnswerEvent="handleShowAnswerEvent"
        ref="questionComponent"
      />
    </div>

    <Exposition ref="expositionComponent" id="exposition" />
   <!-- <div id="btn_close" @click="closeGame">
      <app-icon type="x" />
    </div>-->
   <router-link to="/" id="btn_close">
      <app-icon type="x" />
    </router-link>
    <div id="btn_tuto" @click="openTutoModal()">
      <app-icon type="?" />
    </div>
    <div id="btn_validate" @click="openValidateModal()">
      <app-button message="valider votre exposition" />
    </div>
  </div>
</template>

<script>
import Exposition from "./components/Expostion";
import Question from "./components/Question";
import axios from "axios";
import AnswerModal from "./components/AnswerModal.vue";
import AppIcon from "../services/icons/Icon.vue";
import TutoModal from "./components/TutoModal.vue";
import AppButton from "../services/AppButton.vue";
import ValidateModal from "./components/ValidateModal.vue";

export default {
  name: "Game",
  components: {
    Exposition,
    Question,
    AnswerModal,
    AppIcon,
    TutoModal,
    AppButton,
    ValidateModal,
  },
  data() {
    return {
      showQuestion: false,
      question: {},
      //RndmQuestionurl: "http://localhost/testphp/getquestion.php",
      RndmQuestionurl: "http://yannbaizid.fr/yann/lizellba/getquestion.php",
    };
  },
  methods: {
    chargeQuestion() {
      console.log("change question");
      axios.get(this.RndmQuestionurl).then((response) => {
        this.question = response.data;
        console.log(this.question);
        this.showQuestion = false;
      });
    },

    handleShowAnswerEvent(payload) {
      console.log(
        "handleShowAnswerEvent in app.vue, correct=" + payload.correct
      );
      if (payload.correct == 1) {
        this.$refs.expositionComponent.addArtwork(
          "salut je suis app.vue et je demande à exposion.vue d'ajouter une oeuvre"
        );
      }
      this.$refs.questionComponent.closeQuestion(
        "salut je suis app.vue et je demande la fermeture de la question"
      );
      this.showQuestion = false;
      this.$refs.AnswerModal.openModal(payload.correct);
    },
    openTutoModal() {
      console.log("Lâche ce point d'interrogation!!");
      this.$refs.TutoModal.openModal();
    },
    openValidateModal() {
      console.log("on valide toussa!");
      this.$refs.ValidateModal.openModal();
    },
  },

  mounted() {
    this.chargeQuestion();
  },
};
</script>

<style lang="scss">
#question {
  float: left;
  position: fixed;
  top: 0px;
  left: 0px;
  height: 100%;

  z-index: 9;
}
.slide-enter-active,
.slide-leave-active {
  transition: all 0.5s;
}
.slide-enter, .slide-leave-to /* .fade-leave-active below version 2.1.8 */ {
  left: -1000px;
}
.slide-enter-to,
.slide-leave {
  left: 8px;
}
.overflow-hidden {
  overflow: hidden;
}

#btn_close {
  position: fixed;
  right: 20px;
  top: 20px;
  z-index: 7;
}

#btn_tuto {
  position: fixed;
  right: 80px;
  top: 20px;
  z-index: 7;
}

#btn_validate {
  position: fixed;
  right: 20px;
  bottom: 20px;
  z-index: 7;
}

#exposition {
  background-color: #e5e5e5;
  display: flex;
  height: 100%;
  justify-content: center;
  align-items: center;
}
</style>
