<template>
  <div>
    <svg
      id="icon"
      :height="size"
      :width="size"
      viewBox="0 0 40 40"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <circle cx="19.5" cy="19.5" r="19" fill="white" stroke="black" />

      <!-- ICON "X" -->
      <g v-if="type == 'x'">
        <line
          x1="25.5"
          y1="13.5"
          x2="13.5"
          y2="25.5"
          stroke="black"
          stroke-linecap="round"
          stroke-linejoin="round"
        />

        <line
          x1="13.7071"
          y1="13"
          x2="25.7279"
          y2="25.0208"
          stroke="black"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </g>
      <!-- ICON ">" -->
      <path
        v-if="type == '>'"
        d="M17 13L22.7143 19L17 25"
        stroke="black"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <!-- ICON "<" -->
      <path
        v-if="type == '<'"
        transform="rotate(180, 19.5, 19.5)"
        d="M17 13L22.7143 19L17 25"
        stroke="black"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <!-- ICON "+" and "-" -->
      <line
        v-if="type == '+' || type == '-'"
        x1="25.7279"
        y1="13.7071"
        x2="13.7071"
        y2="25.7279"
        stroke="black"
        transform="rotate(45, 19.5, 19.5)"
        stroke-linecap="round"
        stroke-linejoin="round"
      />

      <line
        v-if="type == '+'"
        x1="13.7071"
        y1="13"
        x2="25.7279"
        y2="25.0208"
        stroke="black"
        transform="rotate(45, 19.5, 19.5)"
        stroke-linecap="round"
        stroke-linejoin="round"
      />

      <g v-if="type == 'photo'" transform="translate(6.5,7.5)">
        <path
          d="M24.7396 20.2262H2.41465C1.83556 20.2262 1.3657 19.7586 1.3657 19.1811V5.11195C1.3657 4.53498 1.83508 4.06685 2.41465 4.06685H24.7401C25.3192 4.06685 25.7891 4.53451 25.7891 5.11195V19.1811C25.7886 19.7581 25.3192 20.2262 24.7396 20.2262Z"
          stroke="black"
          stroke-miterlimit="10"
        />
        <path
          d="M13.5771 18.214C16.9403 18.214 19.6666 15.4976 19.6666 12.1468C19.6666 8.79597 16.9403 6.07959 13.5771 6.07959C10.214 6.07959 7.48764 8.79597 7.48764 12.1468C7.48764 15.4976 10.214 18.214 13.5771 18.214Z"
          stroke="black"
          stroke-miterlimit="10"
        />
        <path
          d="M18.0558 4.06733H9.0985L9.85743 1.45529C9.97286 1.05797 10.3383 0.784698 10.7532 0.784698H16.4001C16.8151 0.784698 17.1805 1.05797 17.2959 1.45529L18.0558 4.06733Z"
          stroke="black"
          stroke-miterlimit="10"
        />
        <path
          d="M5.98793 3.98518H2.65936V3.01802C2.65936 2.59409 3.00423 2.25 3.4302 2.25H5.21756C5.64305 2.25 5.9884 2.59361 5.9884 3.01802V3.98518H5.98793Z"
          stroke="black"
          stroke-miterlimit="10"
        />
      </g>
      <!-- ICON "DELETE" -->
      <g v-if="type == 'delete'" transform="translate(11,10)">
        <path
          d="M12.9366 15.9243H3.90907L2.43399 2.16864H14.4117L12.9366 15.9243Z"
          stroke="black"
          stroke-miterlimit="10"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
        <path
          d="M1.49658 2.16864H15.3491"
          stroke="black"
          stroke-miterlimit="10"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
        <path
          d="M7.05468 2.16257V1.85074C7.05468 1.4231 7.39248 1.07568 7.80993 1.07568H9.03572C9.45317 1.07568 9.79096 1.4231 9.79096 1.85074V2.16257"
          stroke="black"
          stroke-miterlimit="10"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </g>

      <path v-if="type=='?'"
        d="M18.873 24.309L17.739 24.255C17.739 23.031 17.946 21.969 18.36 21.069C18.774 20.151 19.521 19.242 20.601 18.342C21.375 17.676 21.96 17.1 22.356 16.614C22.77 16.128 23.049 15.669 23.193 15.237C23.337 14.787 23.409 14.283 23.409 13.725C23.409 12.645 23.049 11.817 22.329 11.241C21.627 10.665 20.718 10.377 19.602 10.377C17.172 10.377 15.543 11.7 14.715 14.346L13.5 13.806C13.932 12.312 14.688 11.142 15.768 10.296C16.848 9.432 18.144 9 19.656 9C20.682 9 21.591 9.189 22.383 9.567C23.175 9.945 23.796 10.485 24.246 11.187C24.696 11.889 24.921 12.717 24.921 13.671C24.921 14.391 24.813 15.048 24.597 15.642C24.381 16.236 24.012 16.839 23.49 17.451C22.986 18.045 22.302 18.702 21.438 19.422C20.574 20.16 19.935 20.907 19.521 21.663C19.125 22.419 18.909 23.301 18.873 24.309ZM18.225 28.656C17.901 28.656 17.631 28.548 17.415 28.332C17.217 28.116 17.118 27.855 17.118 27.549C17.118 27.225 17.217 26.964 17.415 26.766C17.631 26.55 17.901 26.442 18.225 26.442C18.549 26.442 18.81 26.55 19.008 26.766C19.224 26.964 19.332 27.225 19.332 27.549C19.332 27.855 19.224 28.116 19.008 28.332C18.81 28.548 18.549 28.656 18.225 28.656Z"
        fill="black"
      />
    </svg>
  </div>
</template>

<script>
export default {
  name: "appIcon",
  mounted() {
    console.log(this.type);
  },
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


<style lang="scss" >
#icon {
  display: inline-block;
  text-align: center;
  &:hover {
    cursor: pointer;
  }
}
</style>