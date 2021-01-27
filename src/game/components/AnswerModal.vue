<template>
  <transition name="fade">
    <modal
      ref="AnswerModal"
      id="answer_modal"
      type="answer"
      @closeModalEvent="handleCloseModalEvent"
    >
      <div class="flexbox flexbox_row h_100">
        <div class="answer_panel_left flexbox_col h_100">
          <img
            id="answer_image"
            class="answer_image flex_grow flex_shrink"
            :src="imgLink + 'question/' + question.img_link"
            alt="image loading"
          />
          <div class="caption text_align_left">
            {{
              question.caption_details
                ? question.caption_details
                : question.caption
            }}
          </div>
        </div>
        <div class="answer_panel_right text_align_left flexbox_col h_100">
          <div class="answer_width flexbox_col flexbox_spacearound flex_grow">
            <div>
              <div class="bold font_size_big" v-if="this.correct == 1">
                Bonne réponse!<br />
                <span v-if="artwork.id >= 0"
                  >Vous avez gagné une oeuvre à placer dans votre espace
                  d'exposition!</span
                >
                <span v-else
                  >Malheureusement, il ne reste plus d'oeuvre a débloquer.
                </span>
              </div>
              <div class="bold font_size_big" v-if="this.correct == 0">
                Mauvaise réponse!<br />Ne vous découragez pas, essayez encore!
              </div>
            </div>
            <!--         <div v-for="answer in question.answers" :key="answer.id">
              <div v-if="answer.correct==1">{{answer.text}}</div>
            </div>
 -->
            <div>
              <div>{{ question.answer }}</div>
              <div id="info_link" class="p_t_20">
                <a id="answer_link" :href="question.info_link" target="_blank">
                  lien vers le site de La Criée</a
                >
              </div>
            </div>
            <div @click="$refs.AnswerModal.closeModal()">
              <app-button v-if="this.correct == 1" message="Placer l'oeuvre" />
              <app-button
                v-if="this.correct == 0"
                message="Continuer à jouer"
              />
            </div>
          </div>
        </div>
      </div>
    </modal>
  </transition>
</template>

<script>
import AppButton from "../../services/AppButton.vue";
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
      artwork: {},
      imgLink: process.env.VUE_APP_IMGLINK,
    };
  },
  methods: {
    closeModal() {
      this.show = false;
      this.$emit("newQuestionEvent");
      document.querySelector("body").classList.remove("overflow-hidden");
    },
    openModal(correct, artwork) {
      this.correct = correct;
      console.log(artwork.id);
      this.artwork = artwork;
      if (artwork !== undefined) {
        if (this.question.expo_id == artwork.expo_id) {
          console.log("right expo fetched!!");
        }
      }
      console.log("j'ouvre! modal! réponse correc' =" + this.correct);
      this.$refs.AnswerModal.openModal();
      console.log(this.question);
    },
    handleCloseModalEvent() {
      this.closeModal();
    },
  },
};
</script>

<style lang="scss" scoped>
.answer_panel_right {
  width: 60%;
}
.answer_panel_left {
  max-width: 40%;
  width: 424px;
}

#answer_link {
  text-decoration: underline;
}
.answer_image {
  width: 100%;
  display: block;
  background-color: #f4f4f4;
  object-fit: contain;
}

.answer_width {
  max-width: 300px;
}
</style>