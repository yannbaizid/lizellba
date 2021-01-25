<template>
  <div class="modal" v-if="show">
    <div class="modal_backdrop" @click="closable? closeModal(): ''" />
    <article class="modal_dialog" :class="type">
      <div v-if="closable" @click="closeModal()">
        <app-icon type="x" :circle="false" class="float_right" id="close_icon"/>
      </div>
      <slot></slot>
    </article>
  </div>
</template>

<script>
import AppIcon from "./icons/Icon.vue";
export default {
  components: { AppIcon },
  name: "Modal",
  props: {
    initialState: {
      type: Boolean,
      default: false,
    },
    type: {
      type: String,
      default: 'default'
    },
    closable: {
      type: Boolean,
      default: true
    },
  },
  data() {
    return {
      show: false,
    };
  },
  mounted() {
    this.show = this.initialState;
  },
  methods: {
    closeModal() {
      this.$emit("closeModalEvent");
      console.log("je suis method closeModal de Modal.vue");
      this.show = false;
      document.querySelector("body").classList.remove("overflow-hidden");
    },
    openModal() {
      this.show = true;
      document.querySelector("body").classList.add("overflow-hidden");
    },
  },
};
</script>

<style lang="scss" scoped>
.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 10;
  overflow-x: hidden;
  overflow-y: auto;
  display: flex;
  align-items: center;
  justify-content: center;

  &_backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
  }
  &_dialog {
    width: 774px;
    border: 1px solid #000000;
   
    min-height: 390px;
    max-height: 95%;
    background-color: #ffffff;
    border-radius: 2px;
    padding: 0px 20px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    z-index: 2;
    max-width: 98%;
    overflow: auto;
      @media (max-width: 500px) {
    width: 95%;
    height: 95%;  }
  }
}

.default {
       @media (min-width: 500px) {
   height: 393px;
       }
}

.content_size {
   @media (min-width: 500px) {
height: auto;
   }
     

}

.answer {
     @media (min-width: 500px) {
  height: 522px;
  padding-bottom: 20px;}
}

.gallery {
     @media (min-width: 500px) {
  height: 600px;
  padding-bottom: 20px;}
}

#close_icon {
  margin-right: -20px;
}

</style>