<template>
  <modal
    ref="InfoArtworkModal"
    id="answer_modal"
    type="answer"
    @closeModalEvent="handleCloseModalEvent"
  >
    <div v-if="artworkLoaded" class="flexbox flexbox_row h_100">
      <div class="info_panel_left flexbox_col h_100">
        <img
          id="info_image"
          class="info_image h_100 "
          :src="'/img/artwork/' + artwork.src"
          alt="image loading"
        />
       
      </div>
      <div class="info_panel_right text_align_left flexbox_col h_100">
        <div class="info_width flexbox_col flexbox_spacearound flex_grow">
          <div class="flex_grow flexbox_col flexbox_justifycenter flexbox_alignstart">
            <div>{{artwork.artist.name}} {{artwork.artist.surname}}, <span class="italic">{{artwork.name}}</span>, {{artwork.year}}</div>
            <div>{{artwork.caption}}</div>
               <div id="info_link" class="p_t_20">
              <a id="answer_link" :href="'/img/artwork'+artwork.src" target="_blank">
                lien vers le site de La Criée</a
              >
            </div>
         
          </div>
          <!--         <div v-for="answer in question.answers" :key="answer.id">
              <div v-if="answer.correct==1">{{answer.text}}</div>
            </div>
 -->   
          <div @click="$refs.InfoArtworkModal.closeModal()">
          
            <app-button  message="Retour au jeu" />
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import AppButton from "../../services/AppButton.vue";
import Modal from "../../services/Modal.vue";
export default {
  components: { Modal, AppButton },
  name: "InfoArtworkModalComponent",
 
  data() {
    return {
      artwork: Object,
      artworkLoaded: false,
    };
  },
  methods: {
    closeModal() {
      this.show = false;
      document.querySelector("body").classList.remove("overflow-hidden");
    },
    openModal(artwork) {
        console.log(artwork);
        
      this.$refs.InfoArtworkModal.openModal();
        this.artwork=artwork;
        this.artworkLoaded=true;
    },
    handleCloseModalEvent() {
      this.closeModal();
    },
  },
};
</script>

<style lang="scss" scoped>
.info_panel_right {
  width: 60%;
}
.info_panel_left {
  max-width: 40%;
  width: 424px;
}

#info_link {
  text-decoration: underline;
}
.info_image {
  width: 100%;

  background-color: #f4f4f4;
  object-fit: contain;
}

.info_width {
  max-width: 300px;
}
</style>