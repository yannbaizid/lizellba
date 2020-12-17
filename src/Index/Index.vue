<template>
  <div id="index_container">
    <div id="index_presentation">
      <presentation />
      Gallerie
    </div>
    <div id="gallery">
      <gallery />
    </div>
    <div id="index_footer" class="align_left"> 
      <div id="typo_credits">
      Crédit typographique pour le logo Lizellba : Jocelyn Cottencin
      </div>
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
#typo_credits {
  padding: 20px;
}

</style>