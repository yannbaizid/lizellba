<template>
  <div id="question_container">
    <div id="question_content_container" v-if="showQuestion">
      <div id="question_content_header" class="container">
        <div>Icone ici</div>
        <div>carte {{ question.type ? question.type : "*type unknow*" }}</div>
      </div>
      <div id="question_content_image" class="container">
        <img class="app_question_image" :src="question.imglink" alt="lol" />
      </div>
      <div id="question_content_question" class="container">
        {{ question.question }}
      </div>

      <div id="question_content_answerlist" class="container">
        <div
          @click="selectedAnswer = answer"
          v-for="(answer, index) in question.answers"
          :key="index"
          class="question_content_answer flexbox_row"
        >
          <input
            type="radio"
            :id="answer.id"
            name="drone"
            :value="answer.correct"
            :checked="selectedAnswer.id == answer.id"
          />
          <div>{{ answer.text }} {{ answer.correct }}</div>
        </div>
      </div>

      <div
        id="question_content_validate"
        @click="verifyAnswer(selectedAnswer.correct)"
        class="container"
      >
        <app-button
          :class="{ disabled: !selectedAnswer.correct }"
          message="valider"
        />
      </div>
    </div>

    <!--
    <div id="question_content_container" v-if="showQuestion">
      <div id="question_emptyset" v-if="!question">
        SALUT LES BRANGOLOS
        <div>a tout de suite pour dé question</div>
      </div>
      <div class="row">
        <div class="columns small-6">
          <div class="card">
            <div class="card-divider">
              {{ question.question }}
            </div>

            <div class="card-section">
              <ul>
                <li v-for="answer in question.answers" :key="answer.id">
                  <div
                    class="hollow button"
                    @click="verifyAnswer(answer.correct)"
                  >
                    {{ answer.text }} {{ answer.correct }}
                  </div>
                </li>
              </ul>
            </div>
            <img class="app_question_image" :src="question.imglink" alt="lol" />
          </div>
        </div>

      </div>

    </div> 
    -->
    <div id="question_toggler" @click="toggleQuestion()" class="flexbox_row">
      <app-icon :size="20" v-bind:type="showQuestion ? '>' : '<'" />
      QUIZZ
    </div>
  </div>
</template>

<script>
import AppButton from "../../services/AppButton.vue";
import AppIcon from "../../services/icons/Icon.vue";
export default {
  components: { AppIcon, AppButton },
  name: "Question",
  props: {
    question: Object,
  },
  data() {
    return {
      showAnswer: false,
      showQuestion: true,
      selectedAnswer: {},
    };
  },
  methods: {
    toggleQuestion() {
      this.showQuestion = !this.showQuestion;
    },
    verifyAnswer(correct) {
      if (correct) {
        this.$emit("showAnswerEvent", { correct: correct });
        if (correct == 1) {
          this.$emit("addArtworkEvent");
        } else {
          console.log("cestperdu");
          this.correct = 0;
        }
        this.selectedAnswer = {};
        this.showQuestion = false;
        this.showAnswer = true;
        
      }
    },
    emitNewQuestionEvent() {
      this.$emit("newQuestionEvent");
    },

    closeQuestion(text) {
      console.log(text + ".right now i'm in question.vue");
    },
  },
};
</script>

<style lang="scss" scoped>
#question {
  &_content_question {
    font-weight: bold;
  }
  &_content_header {
    text-transform: uppercase;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }
  &_content_container {
    height: 100vh;
    width: 25%;
    min-width: 400px;
    border-right: 1px solid black;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background-color: white;
    text-align: left;
  }
  &_container {
    display: flex;
    justify-content: flex-start;
  }
  &_toggler {
    writing-mode: tb-rl;
    transform: rotate(-180deg);
    display: flex;
    align-items: center;
    border-bottom: 1px solid black;
    border: 1px solid black;
    border-right: 1px solid white;
    border-radius: 5px 0px 0px 5px;
    height: 100px;
    background-color: white;
    position: relative;
    top: 300px;
    margin-left: -1px;

    padding: 10px;
    &:hover {
      cursor: pointer;
    }
  }
}
.question_content_answer {
  padding: 10px 0px;
}
.app_question_image {
  max-width: 150px;
}
.disabled {
  background-color: lightgray;
  cursor: default;
}
</style>