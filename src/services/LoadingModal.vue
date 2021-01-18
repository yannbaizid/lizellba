<template>
  <modal   ref="LoadingModal"
      id="loading_modal"
 :closable="false"
      @closeModalEvent="handleCloseModalEvent"
    ><div class="h_100 flexbox_col flexbox_justifycenter">
        <div class="font_size_big bolder">LOADING</div>
        </div>
    </modal>
</template>

<script>
import Modal from "./Modal.vue";
export default {
  components: { Modal },
  mounted() {
      console.log('opening modal loading');
      this.$refs.LoadingModal.openModal();
  }
};
</script>

<style>
</style>