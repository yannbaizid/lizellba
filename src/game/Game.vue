<template>
  <div>
    <div id="app">
      <tuto-modal id="tuto" ref="TutoModal" />
      <answer-modal ref="AnswerModal" v-bind:question="question" />

      <div id="question">
        <Question
          v-bind:question="question"
          @newQuestionEvent="chargeQuestion()"
          @showAnswerEvent="handleShowAnswerEvent"
          ref="questionComponent"
        />
      </div>

      <Exposition ref="expositionComponent" id="exposition" />

      <router-link to="/" id="btn_close">
        <app-icon type="x" />
      </router-link>
      <div id="btn_tuto"  @click="openTutoModal()">
      <app-icon type="?" />
      </div>
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

export default {
  name: "Game",
  components: {
    Exposition,
    Question,
    AnswerModal,

    AppIcon,
    TutoModal,
  },
  data() {
    return {
      showQuestion: false,
      question: {},
      RndmQuestionurl: "http://localhost/testphp/getquestion.php",
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
    click: function () {
      this.$refs.expositionComponent.testEvent("salut je test");
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
      
    }
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
</style>
