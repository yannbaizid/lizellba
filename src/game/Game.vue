<template>
  <div id="app">
    <tuto-modal id="tuto" ref="TutoModal" />
    <answer-modal
      ref="AnswerModal"
      v-bind:question="question"
      @newQuestionEvent="getRandomQuestion()"
    />
    <closing-modal
      ref="ClosingModal"
      @askExpoValidationEvent="openValidateModal"
      @closeExpoEvent="exitToHome()"
    />
    <validate-modal
      id="validateModal"
      ref="ValidateModal"
      @validateExpoEvent="handleValidateExpoEvent"
      :artworksUnlocked="artworksUnlocked"
    />
    <div id="question">
      <Question
        v-bind:question="question"
        @validateQuestionEvent="handleValidateAnswerEvent"
        ref="questionComponent"
      />
    </div>

    <Exposition
      ref="expositionComponent"
      id="exposition"
      class="flexbox_row flexbox_justifycenter h_100"
      @openArtworkModalEvent="openArtworkModal"
      @deleteArtworkEvent="deleteArtwork"
      @askDeleteConfirmationEvent="askDeleteConfirmation"
    />

    <div id="btn_close" @click="openClosingModal()">
      <app-icon type="x" :fill="false" />
    </div>
    <div id="btn_tuto" @click="openTutoModal()">
      <app-icon type="?" :fill="false" />
    </div>
    <div id="btn_validate" @click="openValidateModal()">
      <app-button :fill="false" message="Valider votre exposition" />
    </div>
    <info-artwork-modal ref="InfoArtworkModal" />
    <delete-artwork-modal
      ref="DeleteArtworkModal"
      @confirmDeleteArtworkEvent="handleConfirmDeleteArtwork"
    />
    <loading-modal v-show="loading" ref="LoadingModal" />
  </div>
</template>

<script>
import Exposition from "./components/Expostion";
import Question from "./components/Question";
import api from "@/services/api/api";
import AnswerModal from "./components/AnswerModal.vue";
import AppIcon from "../services/icons/Icon.vue";
import TutoModal from "./components/TutoModal.vue";
import AppButton from "../services/AppButton.vue";
import ValidateModal from "./components/ValidateModal.vue";
import ClosingModal from "./components/ClosingModal.vue";

import InfoArtworkModal from "./components/InfoArtworkModal.vue";
import LoadingModal from "../services/LoadingModal.vue";
import DeleteArtworkModal from "./components/DeleteArtworkModal.vue";

export default {
  name: "Game",
  components: {
    Exposition,
    Question,
    AnswerModal,
    AppIcon,
    TutoModal,
    AppButton,
    ValidateModal,
    ClosingModal,
    InfoArtworkModal,
    LoadingModal,
    DeleteArtworkModal,
  },
  data() {
    return {
      showQuestion: false,
      questions: [],
      question: {},
      artwork: {},
      disponibleArtworks: [],
      loadingArtwork: false,
      loadingQuestion: false,
      loadingGeneral: false,
      artworksUnlocked: 0,
    };
  },
  computed: {
    loading() {
      return this.loadingArtwork || this.loadingQuestion || this.loadingGeneral;
    },
  },
  methods: {
    chargeQuestions() {
      console.log("change question");
      /*  axios.get(this.RndmQuestionurl).then((response) => {
        this.question = response.data;
        console.log(this.question);
        this.showQuestion = false;
      }); */
      this.loadingQuestion = true;
      api
        .getQuestions()
        .then((questions) => {
          this.questions = questions;
          console.log("hola les questions");
          console.log(this.questions);
          this.getRandomQuestion();
        })
        .catch((error) => {
          alert("erreur lors du chargement de question" + error.message);
          this.loadingQuestion = false;
        })
        .finally(() => {
          this.loadingQuestion = false;
        });
    },
    /*     chargeRandomQuestion() {
      console.log("change question");
      /*  axios.get(this.RndmQuestionurl).then((response) => {
        this.question = response.data;
        console.log(this.question);
        this.showQuestion = false;
      }); 
      this.loadingArtwork = true;
      api
        .getRandomQuestion()
        .then((question) => {
          this.question = question;
          console.log(this.question);
        })
        .catch((error) => {
          alert("erreur lors du chargement de question" + error.message);
        })
        .finally(() => {
          this.loadingArtwork = false;
        });
    }, */
    getRandomQuestion() {
      this.loadingQuestion = true;
      console.log("getrandomquestion");
      if (this.questions.length > 0) {
        var index = Math.floor(Math.random() * this.questions.length);
        console.log("index" + index);
        console.log(this.questions[index]);
        this.question = this.questions.splice(index, 1)[0];
        console.log(this.question);
      } else {
        this.chargeQuestions();
      }
      this.loadingQuestion = false;
    },

    handleValidateExpoEvent(data) {
      this.loadingGeneral = true;
      console.log("game.vue, handleValidateExpo");
      const curatorName = data.curatorName;
      const expoName = data.expoName;
      var imgURL = "";
      this.$refs.expositionComponent.returnExpoImage().then((response) => {
        console.log(response);
        imgURL = response;
        this.sendImageToServer(imgURL, curatorName, expoName);
      });
    },
    sendImageToServer(imgURL, curatorName, expoName) {
      console.error("game.vue, return of returnExpoImage : " + imgURL);

      console.log("curator name:" + curatorName + " exponame:" + expoName);
      console.log("imagURL:" + imgURL);
      console.error("Game.vue, handleValidate :" + imgURL);
      //Send data to php
      api
        .saveExpoImage(imgURL, curatorName, expoName)
        .then((response) => {
          console.log(response.data);
          var photoId = response.data;

          this.$router.push({
            name: "Home",
            params: { photoId: photoId },
            query: { credits: true },
          });
          this.loadingGeneral = false;
          //this.exitToHome();
        })
        .catch((error) => {
          alert("erreur de sauvegarde\n" + error.message);
          console.log(error);
          this.loadingGeneral = false;
        })
        .finally(() => {
          this.loadingGeneral = false;
        });
    },

    handleValidateAnswerEvent(payload) {
      console.log(
        "handleShowAnswerEvent in app.vue, correct=" +
          payload.correct +
          " expoid:" +
          payload.expoId
      );

      this.$refs.questionComponent.closeQuestion(
        "salut je suis app.vue et je demande la fermeture de la question"
      );
      var artwork = {};
      if (payload.correct == 1) {
        artwork = this.addArtwork(payload.expoId);
      }
      this.showQuestion = false;

      this.$refs.AnswerModal.openModal(payload.correct, artwork);
    },
    openArtworkModal(payload) {
      this.artwork = payload.artwork;
      console.log("game.vue, openArtwork modal" + this.artwork.name);
      this.$refs.InfoArtworkModal.openModal(payload.artwork);
    },

    openClosingModal() {
      this.$refs.ClosingModal.openModal();
    },
    openTutoModal() {
      console.log("Lâche ce point d'interrogation!!");
      this.$refs.TutoModal.openModal();
    },
    openValidateModal() {
      console.log("on valide toussa!");
      this.$refs.ValidateModal.openModal();
    },
    exitToHome() {
      this.$router.push({ name: "Home" });
    },
    addArtwork(expoId) {
      console.log("handleAddArtworkevent");

      var artwork = {};
      //only if artwork still left
      if (this.disponibleArtworks.length > 0) {
        //first try to fetch artwork of the right expo.
        const expoArtworks = this.disponibleArtworks.filter(
          (artwork) => artwork.expo_id == expoId
        );
        console.log("addartwork method");
        console.log(expoArtworks);
        console.log(this.disponibleArtworks);
        if (expoArtworks.length > 0) {
          let index = Math.floor(Math.random() * expoArtworks.length);
          artwork = expoArtworks[index];

          const generalIndex = this.disponibleArtworks.findIndex(
            (x) => x.id == artwork.id
          );
          artwork = this.disponibleArtworks.splice(generalIndex, 1)[0];
        }
        //else, fetch any remaining artwork.
        else {
          let index = Math.floor(
            Math.random() * this.disponibleArtworks.length
          );
          artwork = this.disponibleArtworks.splice(index, 1)[0];
        }
        console.log("after splice");
        console.log(this.disponibleArtworks);
        console.log(artwork);
        this.$refs.expositionComponent.addArtwork(artwork);
        this.artworksUnlocked++;
        console.log("current artwork count:" + this.artworksUnlocked);
      }

      return artwork;
    },
    askDeleteConfirmation() {
      this.$refs.DeleteArtworkModal.openModal();
    },
    handleConfirmDeleteArtwork() {
      this.$refs.expositionComponent.deleteArtwork();
    },
    deleteArtwork(payload) {
      const deletedArtwork = payload.deletedArtwork;
      this.disponibleArtworks.push(deletedArtwork);
      this.artworksUnlocked--;
      console.log(
        "deleteArtwork method, game.vue. current artworks count:" +
          this.artworksUnlocked
      );
    },
    chargeArtworks() {
      this.loadingQuestion = true;
      api
        .getArtworks()
        .then((artworks) => {
          this.disponibleArtworks = artworks;
          console.log(this.disponibleArtworks);
        })
        .catch((error) => {
          alert("erreur lors du chargement des oeuvres" + error.message);
        })
        .finally(() => {
          this.loadingQuestion = false;
        });
    },
  },
  mounted() {
    console.log("phplink:" + this.phpLink);
    this.chargeQuestions();
    this.chargeArtworks();
  },
};
</script>

<style lang="scss">
#question {
  position: fixed;
  top: -1px;
  left: 0px;
  height: 100%;

  z-index: 6;
  @media (max-width: 500px) {
    top: 1%;
    left: 1%;
  }
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

#btn_close {
  position: fixed;
  right: 20px;
  top: 20px;
  z-index: 5;
}

#btn_tuto {
  position: fixed;
  right: 80px;
  top: 20px;
  z-index: 5;
}

#btn_validate {
  position: fixed;
  right: 40px;
  bottom: 40px;
  z-index: 5;
}

#exposition {
  background-color: #e5e5e5;
}
</style>
