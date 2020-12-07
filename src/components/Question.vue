<template>
  <div id="question_stage">
    SALUT LES BRANGOLOS
    <div>a tout de suite pour dé question</div>
     <div class="container" id="app">
      <div class="row">
        <div class="columns small-6">

          <div class="card">
            <div class="card-divider">
              {{question.question}}
            </div>

            <div class="card-section">
              <ul>


                <li v-for="(answer) in question.answers"  :key="answer.id">
                  <div class="hollow  button" @click="verifyAnswer(answer.correct)"> {{answer.text}} {{answer.correct}} </div>
                </li>
              </ul>
            </div>
            <img class="app_question_image" :src="question.imglink" alt="lol">
          </div>
         

        </div>
        <div class="columns small-6 ">
          <div v-if="showAnswer">
            <div class="row">
              <div class="columns small-10">
                <div v-if="correct==1">BONNE REPONSE! </div>
                <div v-else>MAUVAISE RAIPONCE Té NUL!!! </div>
                 {{question.answer}}
              </div>
              <div class="columns small-2">
                <button class="button" @click="emitNewQuestionEvent();showAnswer=false"> X</button>
              </div>
            </div>
          </div>
        </div>
      </div>





      <div></div>

    </div>
  </div>
</template>

<script>


export default {
  name: "Question",
  props: {
      question: Object
  },
  data() {
    return {
      showAnswer: false
    };
  },
  methods: {
      verifyAnswer(correct) {
            if (correct==1 ) {
                console.log('cest gagné');
                this.correct=1;
                this.$emit('addArtworkEvent');
            }
            else { 
                console.log('cestperdu');
                this.correct=0;
            }
            this.showAnswer=true;
      },
      emitNewQuestionEvent() {
           this.$emit('newQuestionEvent');
      }

  },
};
</script>

<style>
#question_stage {
    background-color: rgb(213, 213, 255);
}

.app_question_image {
    max-width: 150px;
}
</style>