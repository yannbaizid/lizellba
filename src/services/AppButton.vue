<template>
  <div class="btn">
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
  },
};
</script>

<style lang="scss">
.btn {
  border: 1px solid #000000;
  box-sizing: border-box;
  border-radius: 50px;
  padding: 10px 25px;
  background-color: white;
  display: inline-block;
  &:hover {
    cursor: pointer;
    border: 1px solid #9A9A9A;
    color:  #9A9A9A;
  }
  &_text {
      border:10px;
      text-decoration: none;
  }
}
</style>