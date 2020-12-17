<template>
  <tuto-modal />
</template>

<script>
import TutoModal from '../game/components/TutoModal.vue';

export default {
  name: "testmodal",
  data() {
    return {
      select: 1,
      show: false
    };
  },
  methods: {
    showModal() {
      this.$refs.testmodal.openModal();
    },
    toggle() {
        this.select++;
        if (this.select==4) {
            this.select=1;
        }
        console.log(this.select+" toggle");
        this.show=!this.show;
    }
  },
  components: {
    TutoModal
  }
};
</script>

<style>
</style>