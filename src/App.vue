<template>
  <div>
    <div id="app">
      <transition name="fade">
        <div v-if="showQuestion" id="question">
          <keep-alive>
            <Question
              v-bind:question="question"
              @newQuestionEvent="chargeQuestion()"
              @addArtworkEvent="addArtwork()"
            />
          </keep-alive>
        </div>
      </transition>

      <Exposition ref="expositionComponent" />
      <button @click="showQuestion = !showQuestion">show Question</button>
      <button @click="click">Click</button>
    </div>
  </div>
</template>

<script>
import Exposition from "./components/Expostion";
import Question from "./components/Question";
import axios from "axios";

export default {
  name: "App",
  components: {
    Exposition,
    Question,
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
    addArtwork: function() {
       this.$refs.expositionComponent.addArtwork("salut je passe par là");
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
.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  left: -1000px;
}
.fade-enter-to,
.fade-leave {
  left: 8px;
}
</style>
