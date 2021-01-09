<template>
  <div id="app" class="font_size_normal">
    <router-view />
  </div>
</template>

<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Livvic");
html {
  height: 100%;
}
body {
  margin: 0px;
  padding: none;
  width: 100%;
  height: 100%;

  #nav {
    padding: 30px;

    a {
      font-weight: bold;
      color: #2c3e50;

      &.router-link-exact-active {
        color: #42b983;
      }
    }
  }

  a {
    text-decoration: none;
    color: inherit;
  }

  .align {
    &_right {
      display: inline-block;
      margin-left: auto;
      margin-right: 0px;
    }
    &_left {
      float: left;
    }
    &_center {
      margin-left:auto;
      margin-right:auto;
    }
  }

  .float {
    &_right {
      float: right;
    }
  }

  //flexbox logic
  .flexbox {
    display: flex;
    &_row {
      display: flex;
      flex-direction: row;
      align-items: center;
    }
    &_col {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    &_justifycenter {
      justify-content: center;
    }
    &_justifystart {
      justify-content: flex-start;
    }
    &_justifyend {
      justify-content: flex-end;
    }

    &_spacearound {
      justify-content: space-around;
    }
    &_spacebetween {
      justify-content: space-between;
    }
    &_alignstart {
      align-items: flex-start;
    }
  }

  .flex_grow {
    flex-grow: 1;
  }

  .flex_shrink {
    flex-shrink: 1;
  }


  .modal_container {

    margin: 0px auto 40px auto;
 

  }

  .h_100 {
    height: 100%;
  }
  .w_100 {
    width: 100%;
  }

  .valign_middle {
    vertical-align: middle;
  }

  .valign_top {
    vertical-align: top;
  }

  .inlineblock {
    display: inline-block;
  }

  //FONT STYLES
  .bold {
    font-weight: 600;
  }

  .bolder {
    font-weight: bold;
  }
  .caption {
    font-weight: 300;
    font-size: 12px;
    line-height: 15px;
  }
  #app {
    font-family: Livvic;
    font-weight: normal;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #000000;
    height: 100%;
  }

  //font size
  .font_size_normal {
    font-size: 15px;
  }

  .font_size_big {
    font-size: 20px;
  }
  .font_size_small {
    font-size: 12px;
  }
  //font style
  .font_style_italic {
    font-style: italic;
  }

  .text_align_left {
    text-align: left;
  }


  //image styling

  .img_rnd {
    border-radius: 5px;
    box-sizing: border-box;
  }

  .p {
    &_t_20 {
      padding-top: 20px;
    }
    &_b_20 {
      padding-bottom: 20px;
    }
  }
.box_20 {
  margin: 20px;
  box-sizing: border-box;
}
 
}
</style>
