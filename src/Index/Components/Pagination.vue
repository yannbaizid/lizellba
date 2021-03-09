<template>
  <div>
    <div class="flexbox_row flexbox_justifycenter">
      <div class="flexbox_row flexbox_justifycenter h_100 app_navarrow">
        <div
          @click=" handlePageSelection(currentPage-1)"
          v-if="currentPage > 1"
          class="flexbox_row clickable"
        >
          <svg
            width="8"
            height="14"
            viewBox="0 0 8 14"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              transform="rotate(180,4, 7)"
              d="M1 1L6.71429 7L1 13"
              stroke="black"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </div>
      </div>
    <!--   <div v-if="currentPage > 3" class="app_pagination_item">1</div>
      <div v-if="currentPage > 4" class="app_pagination_item">
        {{ pageRange[0] == 3 ? "2" : "..." }}
      </div> -->

      <div
        v-for="page in pageRange"
        :key="page"
        class="app_pagination_item"
        :class="page == currentPage ? 'bolder' : '' +  page!='...'? 'clickable': ''"

        @click="page!='...'? handlePageSelection(page) : null"
      >
        {{ page }}
      </div>
  <!--     <div v-if="pageCount - currentPage > 3" class="app_pagination_item">
        {{
          pageRange[pageRange.length - 1] == pageCount - 2
            ? pageCount - 1
            : "..."
        }}
      </div>
      <div v-if="pageCount - currentPage > 2" class="app_pagination_item">
        {{ pageCount }}
      </div>
 -->
      <div class="flexbox_row flexbox_justifycenter h_100 app_navarrow">
        <div
          @click=" handlePageSelection(currentPage+1)"
          v-if="currentPage < pageCount"
          class="flexbox_row clickable"
        >
          <svg
            width="8"
            height="14"
            viewBox="0 0 8 14"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M1 1L6.71429 7L1 13"
              stroke="black"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    pageRange: function () {
   
      let pageRangeLengthMax = 7;
      let pageRangeLength= Math.min(pageRangeLengthMax,this.pageCount);
      console.log('pagelength'+pageRangeLength);
      let pageRangeMiddle = Math.floor(pageRangeLength / 2);
      let pageRange = new Array(pageRangeLength);
      pageRange[0] = 1;
      pageRange[pageRangeLength - 1] = this.pageCount;
      if (this.currentPage<=pageRangeMiddle) {
        console.log("<pageMiddle");
        for (let i=0;i<pageRangeLength-1;i++) {
          pageRange[i]=i+1;
        }
      }
     else  if (this.currentPage>=this.pageCount-pageRangeMiddle) {
        console.log(">pageMiddle");
       for (let i=0;i<pageRangeLength-1;i++) {
          pageRange[pageRangeLength-i-1]=this.pageCount-i;
        }
      }
      else {
         console.log("=pageMiddle");
        pageRange[pageRangeMiddle]=this.currentPage;
        for (let i=1;i<pageRangeMiddle;i++) {
          pageRange[pageRangeMiddle-i]=this.currentPage-i;
          pageRange[pageRangeMiddle+i]=this.currentPage+i;
        }
      }
      if (this.pageCount-pageRange[pageRangeLength-2]>1) {

        pageRange[pageRangeLength-2]='...';
      }
      if (pageRange[1]-pageRange[0]>1) {

        pageRange[1]='...';
      }

      return pageRange;
    },
  },
  data() {
    return {
      pageRangeSize: 2,
    };
  },
  props: {
    pageCount: Number,
    currentPage: Number,
  },
  methods: {
    handlePageSelection(page) {
      this.$emit("pageSelectionEvent",page);
    },
  },
};
</script>

<style lang="scss" scoped>
.active {
  color: red;
}

.app_pagination_item {
  width: 1.5rem;
}

.app_navarrow {
  width: calc(1rem + 8px);
}
</style>