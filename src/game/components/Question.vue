<template>
  <div id="question_container">
    <div
      id="question_content_container"
      class="flexbox_col"
      v-if="showQuestion"
    >
      <div class="h_800 box_20 flexbox_col flexbox_spacebetween flex_grow">
        <div
          id="question_content_header"
          class="container w_100 bold"
          :class="question.type.name"
        >
          <div class="flexbox_row flex_grow flexbox_spacebetween">
            <div><question-icon :type="question.type.name" /></div>
            <div class="flexbox_row h_100">
              carte {{ question.type ? question.type.name : "*type unknow*" }}
            </div>
            <div class="appear_small" @click="toggleQuestion()">
              <app-icon type="x" :circle="false" />
            </div>
          </div>
        </div>
        <div class="container">
          <img
            id="question_content_image"
            class="app_question_image"
            :src="imgLink+'question/'+question.img_link"
            alt="image loading"
          />

          <div class="caption" v-html="question.caption">
        
          </div>
        </div>
        <div id="question_content_question" class="container bolder">
          {{ question.question ? question.question : "*question loading*" }}
        </div>

        <div id="question_content_answerlist" class="container w_100">
          <div
            @click="selectedAnswer = answer"
            v-for="(answer, index) in question.answers"
            :key="index"
            class="question_content_answer flexbox_row flexbox_alignstart"
          >
            <div id="radio_button" class="flexbox_row flexbox_justifystart">
              <input
                type="radio"
                :id="answer.id"
                name="drone"
                :value="answer.correct"
                :checked="selectedAnswer.id == answer.id"
              />
            </div>
            <div>{{ answer.text }}</div>
          </div>
        </div>

        <div
          id="question_content_validate"
          @click="verifyAnswer(selectedAnswer.correct)"
          class="container w-100 flexbox_row flexbox_justifycenter"
        >
          <app-button message="Valider" />
        </div>
      </div>
    </div>
    <div
      id="question_toggler"
      @click="toggleQuestion()"
      class="flexbox_row flexbox_spacearound font_size_small"
      :class="showQuestion ? 'hide_small' : ''"
    >
      <app-icon :size="20" v-bind:type="showQuestion ? '>' : '<'" />
      <div class="valign_top">QUIZZ</div>
    </div>
  </div>
</template>

<script>
import AppButton from "../../services/AppButton.vue";
import AppIcon from "../../services/icons/Icon.vue";
import QuestionIcon from "../../services/icons/QuestionIcon.vue";
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
      imgLink: process.env.VUE_APP_IMGLINK,
    };
  },
  methods: {
    toggleQuestion() {
      this.showQuestion = !this.showQuestion;
    },
    verifyAnswer(correct) {
      if (correct) {
        this.$emit("validateQuestionEvent", {
          correct: correct,
          expoId: this.question.expo_id,
        });
      }
      this.selectedAnswer = {};
      this.showQuestion = false;
      this.showAnswer = true;
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
  &_content_header {
    text-transform: uppercase;
  }
  &_content_image {
    width: 100%;
    height: 356px;
    background-color: #f4f4f4;
    object-fit: contain;
  }
  &_content_container {
    height: 100%;
    width: 408px;

    @media (max-width: 500px) {
      width: 98%;
      height: 98%;
    }
    max-width: 100%;

    border: 1px solid black;

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

    border-bottom: 1px solid black;
    border: 1px solid black;
    border-right: 1px solid white;
    border-radius: 5px 0px 0px 5px;
    height: 118px;
    background-color: white;
    position: relative;
    top: 45%;
    margin-left: -1px;
    @media (max-width: 500px) {
      margin-left: -4px;
    }

    padding: 23px 10px;
    box-sizing: border-box;
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

.question {
  color: #50bcbd;
}

.texte {
  color: #692f88;
}

.icône {
  color: #004f91;
}

#radio_button {
  padding: 0px 5px 0px 0px;
}

.h_800 {
  max-height: 800px;
}

.appear_small {
  display: none;
  @media (max-width: 500px) {
    display: initial;
  }
}
.hide_small {
  @media (max-width: 500px) {
    display: none;
  }
}
</style>