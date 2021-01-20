<template>
 <div id="loadingModal" class="modal">
   <div class="modal_backdrop" >
   </div>
       <div class="modal_dialog">
       <img src="..\\assets\loading.gif" alt="logo">
       </div>
 </div>
</template>

<script>

export default {
 
  mounted() {
      console.log('opening modal loading');
     
  }
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


    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    z-index: 2;
 
  }
}
</style>