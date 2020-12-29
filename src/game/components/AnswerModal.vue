<template>
  <transition name="fade">
    <div class="modal" v-if="show">
      <div class="modal_backdrop" @click="closeModal()" />
      <div class="modal_dialog">
        <div id="reponse">
          <div>{{ question.answer }}</div>
          <div v-if="this.correct == 1">
            Bonne réponse!! Vous gagnez une oeuvre à placer dans l'espace
            d'exposition
          </div>
          <div v-if="this.correct == 0">Mauvaise réponse!!</div>
        </div>
        <div id="info_link">
          plus d'informations:
          <a :href="question.info_link" target="_blank">{{
            question.info_link
          }}</a>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "AnswerModal",
  props: {
    question: Object,
  },
  data() {
    return {
      show: false,
      correct: false,
    };
  },
  methods: {
    closeModal() {
      this.show = false;
      this.$emit("newQuestionEvent");
      document.querySelector("body").classList.remove("overflow-hidden");
    },
    openModal(correct) {
      this.show = true;
      document.querySelector("body").classList.add("overflow-hidden");
      console.log("j'ouvre! modal! réponse correc' =" + correct);
      console.log(this.question);
      this.correct = correct;
    },
  },
};
</script>

<style lang="scss" scoped>
.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 10;
  overflow-x: hidden;
  overflow-y: auto;
  display: flex;
  align-items: center;

  &_backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.3);
    z-index: 1;
  }
  &_dialog {
    position: relative;
    width: 800px;
    height: 600px;
    background-color: #ffffff;
    border-radius: 5px;
    margin: auto;
    display: flex;
    flex-direction: column;
    z-index: 2;
    @media screen and (max-width: 992px) {
      width: 90%;
    }
  }
}
#info_link {
  padding: 50px 0px;
}

#reponse {
  padding: 50px 0px;
}
</style>