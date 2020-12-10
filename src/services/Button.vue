<template>
  <div class="btn">
    <div class="btn_text">
      {{ message }}
    </div>
  </div>
</template>

<script>
export default {
  name: "button",
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
  display: inline-block;
  &_text {
      border:10px;
      text-decoration: none;
  }
}
</style>