<template>
  <pagination
    :currentPage="currentPage"
    :pageCount="3"
    @pageSelectionEvent="handlePageSelection"
  />
</template>

<script>
import Pagination from "../Index/Components/Pagination.vue";

export default {
  name: "testmodal",
  data() {
    return {
      select: 1,
      show: false,
      currentPage: 4,
    };
  },
  methods: {
    handlePageSelection(page) {
      console.log("lol");
      console.log("page");
      this.currentPage = page;
    },
    showModal() {
      this.$refs.testmodal.openModal();
    },
    toggle() {
      this.select++;
      if (this.select == 4) {
        this.select = 1;
      }
      console.log(this.select + " toggle");
      this.show = !this.show;
    },
  },
  components: {
    Pagination,
  },
};
</script>

<style>
</style>