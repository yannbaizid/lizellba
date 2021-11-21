<template>
  <div
    class="btn"
    :class="['btn_background_' + background, active && !selector ? 'btn_active' : '', active && selector ? 'btn_active_dark' : '',selector? 'btn_selector' : '']" >
    <div class="btn_text" >
      {{ message }}
    </div>
  </div>
</template>

<script>
export default {
  name: "AppButton",
  props: {
    message: String,
    link: String,
    background: {
      type: String,
      default: "none",
    },
    active: {
      type: Boolean,
      default: false,
    },
    selector: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss">
.btn {
  border: 1px solid #000000;
  box-sizing: border-box;
  border-radius: 50px;
  padding: 10px 25px;
  //background-color: white;
  display: inline-block;
  &_selector {
    padding: 5px 20px;
  }

  &_active_dark {
    border: 1px solid #4f4f4f;
    background-color: #4f4f4f;
    color: white;
    &:hover {
      cursor: pointer;
      background-color: 1px solid #9a9a9a;
    }
  }
  &_active {
    border: 1px solid #9a9a9a;
    color: #9a9a9a;
  }
  &:hover {
    cursor: pointer;
    border: 1px solid #9a9a9a;
    color: #9a9a9a;
  }
  &_background_white {
    background-color: white;
  }
  &_text {
    border: 25px 10px;
    text-decoration: none;
  }
}
</style>