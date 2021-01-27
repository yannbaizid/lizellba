<template>
  <div id="presentation">
    <img id="presentation_logo" src="../../assets/logo.png" alt="logo" />

    <h3 id="presentation_subtitle" class="font_size_big">
      Aujourd'hui vous êtes commissaire d'exposition pour La Criée centre d'art
      contemporain à Rennes !
    </h3>
    <router-link to="/game">
      <app-button message="Commencer le jeu" />
    </router-link>

    <div
      id="intro_container"
      class="flexbox_row  flexbox_wrap flexbox_justifycenter flexbox_alignstart"
    >
      <div class="text_column text_align_left">
        Aujourd'hui vous êtes commissaire d'exposition pour La Criée centre
        d'art contemporain à Rennes ! Le jeu LiZellBa vous propose de créer une
        exposition fictive à partir de la découverte des œuvres du cycle
        artistique Lili, la rozell et le marimba (2019-2022) Pour cela, résolvez
        les énigmes proposées et obtenez des reproductions d’oeuvres
      </div>
      <div class="text_column text_align_left">
        Pour composer votre exposition, choisissez les œuvres que vous voulez
        présenter et leur disposition dans l'espace. Vous pouvez jouer sur les
        formes, les couleurs ou chercher des correspondances entre les questions
        abordées. Les œuvres racontent des histoires, jouez avec celles-ci pour
        créer votre exposition!
      </div>
    </div>
  </div>
</template>

<script>
import AppButton from "../../services/AppButton.vue";
export default {
  components: { AppButton },
  name: "Presentation",
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

#intro_container {
  padding: 50px 0px;
}

.text_column {
  width: 40%;
  max-width: 600px;
  padding: 20px;

  @media (max-width: 500px) {
    width: 95%;
padding: 0px 20px 20px 20px;
  }
}
</style>