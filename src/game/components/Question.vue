<template>
  <div id="question_container">
    <div id="question_content_container" v-if="showQuestion">
      <div id="question_content_header" class="container" :class="question.type.name">
        <div><question-icon :type="question.type.name"/></div>
        <div >
          carte {{ question.type ? question.type.name : "*type unknow*" }}
        </div>
      </div>
      <div class="container">
      
          <img  id="question_content_image"
            class="app_question_image"
            :src="question.imglink"
            alt="image loading"
          />

        <div class="caption">{{ question.caption }}</div>
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
          <div class="flexbox_col flexbox_spacearound">
            <input
              class="align_left"
              type="radio"
              :id="answer.id"
              name="drone"
              :value="answer.correct"
              :checked="selectedAnswer.id == answer.id"
            />
          </div>
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
    <div
      id="question_toggler"
      @click="toggleQuestion()"
      class="flexbox_row flexbox_spacearound"
    >
      <app-icon :size="20" v-bind:type="showQuestion ? '>' : '<'" />
      QUIZZ
    </div>
  </div>
</template>

<script>
import AppButton from "../../services/AppButton.vue";
import AppIcon from "../../services/icons/Icon.vue";
import QuestionIcon from '../../services/icons/QuestionIcon.vue';
export default {
  components: { AppIcon, AppButton, QuestionIcon },
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
  &_content_image {
    width: 100%;
    height: 200px;
    background-color: #F4F4F4;
    object-fit: contain;
  }
  &_content_container {
    height: 100%;
    width: 25%;
    min-width: 400px;
    max-width: 100%;
    border-right: 1px solid black;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background-color: white;
    text-align: left;
overflow: auto;
  }
  &_container {
    display: flex;
    justify-content: flex-start;
    height: 100%;
 
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
    top: 200px;
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

.disabled {
  background-color: lightgray;
  cursor: default;
}

.caption {
  font-size: smaller;
}

.question {
color: #50BCBD;
}

.texte {
color:  #692F88;
}

.icone {
color: #004F91;
}
</style>