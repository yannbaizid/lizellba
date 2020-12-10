<template>
  <transition name="fade">
    <div class="modal" v-if="show">
      <div class="modal_backdrop" @click="closeModal()" />
      <div class="modal_dialog">
          <div v-if="this.correct==1">Bonne réponse!! </div>
          <div> {{question.answer}}</div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "AnswerModal",
   props: {
      question: Object
  },
  data() {
    return {
      show: false,
      correct: false
    };
  },
  methods: {
    closeModal() {
      this.show = false;
      document.querySelector("body").classList.remove("overflow-hidden");
    },
    openModal(correct) {
      this.show = true;
      document.querySelector("body").classList.add("overflow-hidden");
      console.log("j'ouvre! modal! réponse correc' ="+correct);
      console.log(this.question);
      this.correct=correct;
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
  z-index: 9;
  overflow-x: hidden;
  overflow-y: auto;

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
    //width: 600px;
    background-color: #ffffff;
    border-radius: 5px;
    //margin: 50px auto;
    display: flex;
    flex-direction: column;
    z-index: 2;
    @media screen and (max-width: 992px) {
      width: 90%;
    }
  }
}
</style>