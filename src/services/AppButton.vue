<template>
  <div class="btn" :class="'btn_background_'+background">
    <div class="btn_text">
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
      default: 'none'
    }
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
  &:hover {
    cursor: pointer;
    border: 1px solid #9A9A9A;
    color:  #9A9A9A;
  }
  &_background_white {
    background-color: white;
  }
  &_text {
      border:25px 10px;
      text-decoration: none;
  }
}
</style>