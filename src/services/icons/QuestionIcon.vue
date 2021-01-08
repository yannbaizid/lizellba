!<template>
  <div>
    <svg  v-if="type == 'question'"
      id="icon"
      width="25"
      height="25"
      viewBox="0 0 25 25"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <g clip-path="url(#clip0)">
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
 <svg v-if="type == 'icône'"
      id="icon"
      width="25"
      height="25"
      viewBox="0 0 18 18"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <g>
        <path
          d="M10.7236 0.621643L0.621658 10.7236C0.812938 11.3931 1.0879 12.0387 1.4346 12.6245L12.6364 1.42263C12.0387 1.08789 11.4051 0.812923 10.7236 0.621643Z"
          stroke="#004F91"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M0.311523 8.32067L8.32137 0.310822C3.94584 0.406461 0.407163 3.93318 0.311523 8.32067Z"
          stroke="#004F91"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M12.6245 1.43459L1.4346 12.6245C1.75739 13.1863 2.1519 13.7004 2.60619 14.1667L14.1786 2.59422C13.7124 2.15189 13.1864 1.75737 12.6245 1.43459Z"
          stroke="#004F91"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M8.5 0.310822C8.44022 0.310822 8.38045 0.322777 8.32067 0.322777L0.310829 8.33262C0.310829 8.3924 0.298874 8.45217 0.298874 8.51195C0.298874 9.28902 0.418424 10.0302 0.609704 10.7356L10.7117 0.633606C10.0183 0.418416 9.27707 0.310822 8.5 0.310822Z"
          stroke="#004F91"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M8.22504 16.6772C8.32068 16.6772 8.41632 16.6892 8.5 16.6892C13.0309 16.6892 16.6892 13.019 16.6892 8.49999C16.6892 8.40435 16.6772 8.30871 16.6772 8.22502L8.22504 16.6772Z"
          stroke="#004F91"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M14.1786 2.59422L2.60619 14.1667C3.04852 14.6329 3.55063 15.0394 4.08861 15.3861L15.398 4.07664C15.0513 3.53867 14.6329 3.03656 14.1786 2.59422Z"
          stroke="#004F91"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M16.2707 5.91771L5.91772 16.2707C6.64698 16.5098 7.42405 16.6533 8.22504 16.6772L16.6892 8.21307C16.6533 7.41208 16.5098 6.64696 16.2707 5.91771Z"
          stroke="#004F91"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M15.398 4.08859L4.08861 15.398C4.65049 15.7567 5.27215 16.0555 5.91772 16.2707L16.2707 5.91771C16.0556 5.26018 15.7567 4.65048 15.398 4.08859Z"
          stroke="#004F91"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
      </g>
 </svg>
  <svg v-if="type == 'texte'"
      id="icon"
      width="25"
      height="25"
      viewBox="0 0 13 18"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <g v-if="type == 'texte'">
        <path
          d="M12.4872 0.517613V17.4824H0.51282V0.517613H12.4872ZM13 0H0V18H13V0Z"
          fill="#692F88"
        />
        <path
          d="M1.82051 0V18"
          stroke="#692F88"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M3.4359 0V18"
          stroke="#692F88"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M5.01282 0V18"
          stroke="#692F88"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M6.6282 0V18"
          stroke="#692F88"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M8.23077 0V18"
          stroke="#692F88"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M9.80769 0V18"
          stroke="#692F88"
          stroke-width="0.5"
          stroke-miterlimit="10"
        />
        <path
          d="M11.4231 0V18"
          stroke="#692F88"
          stroke-width="0.5"
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