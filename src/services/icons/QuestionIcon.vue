!<template>
  <div>
    <svg id="icon"
      width="25"
      height="25"
      viewBox="0 0 25 25"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <g v-if="type=='question'" clip-path="url(#clip0)">
        <path
          d="M12.5029 24.5547L24.5605 12.4971L12.5029 0.439434L0.445273 12.4971L12.5029 24.5547Z"
          stroke="#50BCBD"
          stroke-miterlimit="10"
        />
        <path
          d="M0.435547 12.5002L12.5002 0.435547"
          stroke="#50BCBD"
          stroke-miterlimit="10"
        />
        <path
          d="M1.74219 14.0178L13.8069 1.95312"
          stroke="#50BCBD"
          stroke-miterlimit="10"
        />
        <path
          d="M3.29688 15.5354L15.3491 3.4707"
          stroke="#50BCBD"
          stroke-miterlimit="10"
        />
        <path
          d="M4.85156 17.0395L16.9038 4.9873"
          stroke="#50BCBD"
          stroke-miterlimit="10"
        />
        <path
          d="M6.39258 18.5571L18.4573 6.50488"
          stroke="#50BCBD"
          stroke-miterlimit="10"
        />
        <path
          d="M7.94727 20.0747L20.0119 8.02246"
          stroke="#50BCBD"
          stroke-miterlimit="10"
        />
        <path
          d="M9.50195 21.5923L21.5542 9.54004"
          stroke="#50BCBD"
          stroke-miterlimit="10"
        />
        <path
          d="M11.0566 23.1096L23.1089 11.0449"
          stroke="#50BCBD"
          stroke-miterlimit="10"
        />
      </g>
 
    </svg>
  </div>
</template>


<script>
export default {
  name: "questionIcon",
  mounted() {},
  props: {
    type: String,
    size: {
      type: Number,
      default: 39,
    },
  },
  data() {
    return {};
  },
};
</script>


<style lang="scss" scoped>
#icon {
  display: inline-block;
  text-align: center;

}
</style>