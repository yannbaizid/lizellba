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
}
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
    margin-left: auto;
    margin-right: auto;
  }
}

.float {
  &_right {
    float: right;
  }
  &_left {
    float: left;
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
  &_alignend {
    align-items: flex-end;
  }
  &_wrap {
    flex-wrap: wrap;
  }
  &_wrapreverse {
    flex-wrap: wrap-reverse;
  }
}

.flex_grow {
  flex-grow: 1;
}

.flex_shrink {
  flex-shrink: 1;
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
.italic {
  font-style: italic;
}
.caption {
  font-weight: 300;
  font-size: 12px;
  line-height: 15px;
  @media (max-width: 500px) {
    font-size: 10px;
  }
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
  font-size: 17px;
  @media (max-width: 1500px) {
    font-size: 15px;
  }
  @media (max-width: 500px) {
    font-size: 0.8em;
  }
}

.font_size_big {
  font-size: 23px;
  @media (max-width: 1500px) {
    font-size: 20px;
  }
  @media (max-width: 500px) {
    font-size: 18px;
  }
}
.font_size_small {
  font-size: 15px;
  @media (max-width: 1500px) {
    font-size: 12px;
  }
  @media (max-width: 500px) {
    font-size: 10px;
  }
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
  &_l_1 {
    padding-left: 1em;
  }
  &x_20 {
    padding: 0px 20px;
  }
}
.m {
  &_20 {
    margin: 20px;
  }
  &_wide_20 {
    margin: 20px;
    @media (max-width: 500px) {
      margin: 0px;
    }
  }
  &x_20 {
    margin: 0px 20px;
  }
  &y_20 {
    margin-top: 20px;
    margin-bottom: 20px;
  }
  &x_05 {
    margin-left: 0.5rem;
    margin-right: 0.5rem;
  }
  &r_02 {
    margin-right: 0.25rem;

  }
  &x_02 {
    margin: 0px 0.25rem;
  }
}
.border_box {
  box-sizing: border-box;
}
.box_20 {
  margin: 20px;
  box-sizing: border-box;
}

.clickable:hover {
  cursor: pointer;
}
</style>
