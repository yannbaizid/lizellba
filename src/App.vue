<template>
  <div id="app">
    <router-view />
  </div>
</template>

<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Livvic");

#app {
  font-family: Livvic;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #000000;
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
}

</style>
