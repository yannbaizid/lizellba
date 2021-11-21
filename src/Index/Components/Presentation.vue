<template>
  <div id="presentation" ref="Presentation">
    <img id="presentation_logo" src="../../assets/logo.png" alt="logo" />

    <h3 id="presentation_subtitle" class="font_size_big">
      Aujourd'hui vous êtes commissaire d'exposition pour La Criée centre d'art
      contemporain à Rennes !
    </h3>
    <router-link to="/game">
      <app-button message="Commencer le jeu" />
    </router-link>
    <div id="intro_arrow_container">
      <svg
        @click="handleArrowClick"
        id="intro_arrow"
        width="22"
        height="11"
        viewBox="0 0 22 11"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M21 1L11 10.1667L1 0.999999"
          stroke="black"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </div>
    <div
      id="intro_container"
      class="flexbox_row flexbox_wrap flexbox_justifycenter flexbox_alignstart"
    >
      <div ref="IntroText" class="text_column text_align_left">
        LiZellBa vous propose de créer une exposition fictive à partir de la
        découverte des œuvres du cycle artistique <i>Lili, la rozell et le marimba</i>
        (2019-2022). Résolvez les énigmes proposées et obtenez des reproductions
        d’œuvres. Composez votre exposition, prêtez attention aux formes, aux
        dimensions et aux couleurs. Chercher des correspondances entre les
        œuvres et laissez libre cours à votre imagination !
      </div>
      <!--      <div class="text_column text_align_left">
        Pour composer votre exposition, choisissez les œuvres que vous voulez
        présenter et leur disposition dans l'espace. Vous pouvez jouer sur les
        formes, les couleurs ou chercher des correspondances entre les questions
        abordées. Les œuvres racontent des histoires, jouez avec celles-ci pour
        créer votre exposition!
      </div> -->
    </div>
  </div>
</template>

<script>
import AppButton from "../../services/AppButton.vue";
export default {
  components: { AppButton },
  name: "Presentation",
  methods: {
    handleArrowClick() {
      const supportsNativeSmoothScroll =
        "scrollBehavior" in document.documentElement.style;
      if (supportsNativeSmoothScroll) {
        window.scrollTo({
          top: this.$refs.IntroText.offsetTop,
          left: 0,
          behavior: "smooth",
        });
      } else {
        window.scrollTo(0, this.$refs.IntroText.offsetTop);
      }
      console.log(this.$refs.IntroText);
    },
  },
};
</script>

<style lang="scss">
#presentation {
  //height: 90vh;
  width: 100%;
  background-image: url("../../assets/logo_bg.png");
  background-size: 100%;
  background-repeat: no-repeat;
  &_logo {
    width: 100%;
    display: inline-block;
    vertical-align: bottom;
  }
  &_subtitle {
    width: 546px;
    max-width: 60%;
    margin: auto;
    padding: 50px 0px;
  }
}

#intro_arrow_container {
  padding-top: 50px;
}

#intro_arrow {
  cursor: pointer;
}

#intro_container {
  padding: 50px 0px;
}

.text_column {
  width: 64%;
  // max-width: 600px;
  // padding: 20px;

  @media (max-width: 900px) {
    width: 64%;
  }
  @media (max-width: 700px) {
    width: 95%;
    padding: 0px 20px 20px 20px;
  }
}
</style>