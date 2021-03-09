<template>
  <div id="index_container">
    <div id="index_presentation">
      <presentation />
    </div>
    <div id="gallery">
      <gallery />
    </div>
    <footer id="index_footer" class="align_left flexbox_row w_100 flexbox_spacebetween">
      <div id="typo_credits" class="font_size_small text_align_left flexbox_row flexbox_wrap">
        <div class="mr_02">Graphisme: Fanny Martel.</div><div  class="mr_02">Développement: Yann Baïzid. </div><div  class="mr_02">Conception additionnelle: Léa Bénétou. </div><div>Crédit typographique pour le logo Lizellba : Jocelyn Cottencin.</div>
      </div>
    <div class="mx_20" @click="handleScrollTopClick">
    <app-icon type="up" :circle="false"></app-icon>
    </div>
    </footer>
  </div>
</template>

<script>
import AppIcon from '../services/icons/Icon.vue';
import Gallery from "./Components/Gallery.vue";
import Presentation from "./Components/Presentation.vue";
export default {
  components: { Gallery, Presentation, AppIcon },
 
  mounted() {
    console.log('salut'+this.$route.params.photoId);
    console.log(this.$route.params);

  },
  methods: {
      handleScrollTopClick() {
      const supportsNativeSmoothScroll =
        "scrollBehavior" in document.documentElement.style;
      if (supportsNativeSmoothScroll) {
        window.scrollTo({
          top: 0,
          left: 0,
          behavior: "smooth",
        });
      } else {
        window.scrollTo(0, 0);
      }

    },
  }
};
</script>

<style>
#typo_credits {
  padding: 10px;
}
</style>