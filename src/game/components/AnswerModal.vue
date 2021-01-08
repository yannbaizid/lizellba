<template>
  <transition name="fade">
    <modal
      ref="AnswerModal"
      id="answer_modal"
      @closeModalEvent="handleCloseModalEvent"
    >
      <div class="flexbox flexbox_row">
        <div class="answer_panel_left">
          <img
            id="answer_image"
            class="answer_image"
            :src="question.imglink"
            alt="image loading"
          />
          <div class="caption">
            {{ question.caption }}
          </div>
        </div>
        <div class="answer_panel_right text_align_left ">
          <div id="reponse ">
            <div class="bold" v-if="this.correct == 1">
              Bonne réponse!<br />Tu as gagné une oeuvre à placer dans ton
              espace d'exposition!
            </div>
            <div class="bold" v-if="this.correct == 0">
              Mauvaise réponse!<br />Ne te décourage pas, essaye encore!
            </div>
          </div>
          <!--         <div v-for="answer in question.answers" :key="answer.id">
              <div v-if="answer.correct==1">{{answer.text}}</div>
            </div>
 -->
          <div>{{ question.answer }}</div>
          <div id="info_link">
            <a id="answer_link" :href="question.info_link" target="_blank">
              lien vers le site de La Criée</a
            >
          </div>
          <div @click="$refs.AnswerModal.closeModal()">
            <app-button message="Placer l'oeuvre" />
          </div>
        </div>
      </div>
    </modal>
  </transition>
</template>

<script>
import AppButton from '../../services/AppButton.vue';
import Modal from "../../services/Modal.vue";
export default {
  components: { Modal, AppButton },
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
      this.$refs.AnswerModal.openModal();

      console.log("j'ouvre! modal! réponse correc' =" + correct);
      console.log(this.question);
      this.correct = correct;
    },
    handleCloseModalEvent() {
      this.closeModal();
    }
  },
};
</script>

<style lang="scss" scoped>
#info_link {
  padding: 0px;
}

#reponse {
  padding:  0px;
}

.answer_panel_right {
  width: 50%;
  padding: 20px;
}
.answer_panel_left {
  width: 40%;
  padding: 20px;
}

#answer_link {
  text-decoration: underline;
}
.answer_image {
  width: 100%;
  height: 400px;
  background-color: #f4f4f4;
  object-fit: contain;
}
</style>