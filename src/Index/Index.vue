<template>
  <div id="index_container">
    <div id="index_presentation">
      <presentation />
    </div>
    <div id="gallery">
      <gallery />
    </div>
    <div id="index_footer" class="align_left">
      <div id="typo_credits" class="font_size_small text_align_left">
        Crédit typographique pour le logo Lizellba : Jocelyn Cottencin.<br>
        Graphisme: Fanny Martel. Développement: Yann Baïzid. Conception additionnelle: Léa Bénétou.
      </div>
    </div>
  </div>
</template>

<script>
import Gallery from "./Components/Gallery.vue";
import Presentation from "./Components/Presentation.vue";
export default {
  components: { Gallery, Presentation },
 
  mounted() {
    console.log('salut'+this.$route.params.photoId);
    console.log(this.$route.params);

  },
};
</script>

<style>
#typo_credits {
  padding: 10px;
}
</style>