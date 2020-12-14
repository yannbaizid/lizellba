<template>
  <div id="index_container">
    <div id="index_presentation">
      <presentation />
    </div>
    <div id="gallery">
      <gallery />
    </div>
    <div id="index_footer" class="align_left"> 
      Crédits typographiques: JOJO TINTIN
    </div>
  </div>
</template>

<script>
import Gallery from "./Components/Gallery.vue";
import Presentation from "./Components/Presentation.vue";
export default {
  components: { Gallery, Presentation },
};
</script>

<style>
</style>