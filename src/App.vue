<template>
  <div id="app">
  
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
#app {
  font-family: Livvic;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #000000;
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
  display: inline-block;
  &_right {
    margin-left: auto;
    margin-right: 0px;
  }
  &_left {
    float: left;
  }

}
.flexbox {
  display: flex;
  &_row {
      display: flex;
    flex-direction: row;
     align-items: center;
  }
  &_justifycenter {
    justify-content: center;
  }
}
.container {
  width: 90%;
  display: inline-block;
  margin: auto;
}

.modal_container {
  width: 80%;
  height: 100%;
  margin: 0px auto 40px auto;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

&_text {
  margin: auto;
}
}

.bold {
 font-weight: bold;
}

input {
  margin: 0px 0px 2em 0px;
  width: 100%;
  border-radius: 5px;
  height: 2em;
  border: 1px solid;
}


.input_long {
  width: 100%;
  text-align: start;
}
</style>
