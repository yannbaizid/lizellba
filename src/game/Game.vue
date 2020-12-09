<template>
  <div>
    <div id="app">
      
      <answer-modal ref="AnswerModal" v-bind:question="question"> </answer-modal>

      <transition name="slide">
        <div v-if="showQuestion" id="question">
          <keep-alive>
            <Question
              v-bind:question="question"
              @newQuestionEvent="chargeQuestion()"
              @showAnswerEvent="handleShowAnswerEvent"
              ref="questionComponent"
            />
          </keep-alive>
        </div>
      </transition>

      <Exposition ref="expositionComponent" />
      <button @click="showQuestion = !showQuestion">show Question</button>
      <button @click="click">Click</button>
        <button   @click="$refs.AnswerModal.openModal('from button')">Open modal</button>
    </div>
  </div>
</template>

<script>
import Exposition from "./components/Expostion";
import Question from "./components/Question";
import axios from "axios";
import AnswerModal from './components/AnswerModal.vue';

export default {
  name: "Game",
  components: {
    Exposition,
    Question,
    AnswerModal
   
  },
  data() {
    return {
      showQuestion: false,
      question: [],
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
      console.log('handleShowAnswerEvent in app.vue, correct='+payload.correct);
      if (payload.correct==1) {
         this.$refs.expositionComponent.addArtwork("salut je suis app.vue et je demande à exposion.vue d'ajouter une oeuvre");
      }
      this.$refs.questionComponent.closeQuestion("salut je suis app.vue et je demande la fermeture de la question");
      this.showQuestion=false;
      this.$refs.AnswerModal.openModal(payload.correct);
    }
  },

  mounted() {
    this.chargeQuestion();
  },
};
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

#question {
  float: left;
  position: absolute;
  background-color: white;

  z-index: 100;
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
</style>
