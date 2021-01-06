<template>
  <v-stage :config="configKonva" ref="stage">
    <v-layer id="background">
      <v-line
        v-for="(poly, index) in backgroundPolys"
        v-bind:key="index"
        @click="changePolyColor(poly)"
        :config="poly"
      ></v-line>
    </v-layer>
    <v-layer id="wall">
      <v-image
        v-for="(image, index) in wallArtworks"
        v-bind:key="image.id"
        :config="image.config"
        @dragmove="dragMoveWall(image, index, $event)"
      >
      </v-image>
    </v-layer>

    <v-layer id="floor">
      <v-image
        v-for="(image, index) in floorArtworks"
        v-bind:key="image.id"
        :config="image.config"
        @dragmove="dragMoveFloor(image, index, $event)"
        @dragend="setZindex()"
      ></v-image>
    </v-layer>
    <v-layer id="watermark">
      <v-image ref="watermark" :config="watermark"> </v-image>
    </v-layer>
  </v-stage>
</template>

<script>
import axios from "axios";
const totalWidth = 1920;
const totalHeight = 1080;
const relativeSizeOfContent = 0.95;
let height = totalHeight * relativeSizeOfContent;
let width = totalWidth * relativeSizeOfContent;
let heightRatio = window.innerHeight / height;
let widthRatio = window.innerWidth / width;
let ratio = Math.min(heightRatio, widthRatio);
const cornerHeight = (2 * height) / 3;
const cornerWidth = (2 * width) / 3;

export default {
  name: "Exposition",
  props: {},
  data() {
    return {
      configKonva: {
        width: totalWidth,
        height: totalHeight,
        scaleX: ratio,
        scaleY: ratio,
      },
      wallArtworks: [],
      floorArtworks: [],
      disponibleImages: [],
      backgroundPolys: [],
      width: width,
      height: height,
      watermark: {},
    };
  },
  computed: {
    topHeight() {
      return (totalHeight * (1 - relativeSizeOfContent)) / 2;
    },
    leftWidth() {
      return totalWidth * (1 - relativeSizeOfContent);
    },
  },

  methods: {
    testEvent: function (text) {
      console.log(text);
    },
    addArtwork(text) {
      console.log(
        text + " , method addartwork in exposition component fired from app.vue"
      );

      if (this.disponibleImages.length > 0) {
        let index = Math.floor(Math.random() * this.disponibleImages.length);
        var artwork = this.disponibleImages.splice(index, 1)[0];

        var image = new Image();
        //image.src = "http://localhost/testphp/img/" + artwork.src;
        image.src = require("@/assets/img/artworks/" + artwork.src);

        artwork.config = {
          x: width / 5,
          y: height / 5,
          image: image,
          width: 100,
          height: 100,
          draggable: true,
          skewY: 0,
          /* dragBoundFunc: function (pos) {
            var newY = (pos.y) < (totalHeight*(1-relativeSizeOfContent)/2)*ratio ?(totalHeight*(1-relativeSizeOfContent)/2)*ratio : pos.y;
            console.log(pos.y + " et " + cornerHeight+ "position ");
            return {
              x: pos.x,
              y: newY,
            };
          },*/

          name: "konva" + artwork.id,
        };
        image.onload = () => {
          console.log("image:" + image.src + " loaded");
          if (image.height < image.width) {
            artwork.config.height = 175;
            artwork.config.width = (image.width / image.height) * 175;
          } else {
            artwork.config.width = 175;
            artwork.config.height = (image.height / image.width) * 175;
          }
          if (artwork.type == "peinture") {
            // set image only when it is loaded
            this.wallArtworks.push(artwork);
          } else {
            artwork.config.y = height / 2;
            artwork.config.x = width / 2;
            this.floorArtworks.push(artwork);
          }
        };
      } else {
        alert("y a plus rien");
      }
    },
    changePolyColor(poly) {
      //TODO
      console.log(poly);
    },
    dragMoveWall(image, index, event) {
      console.log("draging " + image.src);
      console.log(image);
      // image.config.skewY = 0.25;
      const y = event.target.y();
      var x = event.target.x();

      //TRANSITION ZONE FROM LEFT TO RIGHT
      if (x > cornerWidth - image.config.width && x < cornerWidth) {
        if (y < 0) {
          event.target.y(0);
        }
        if (y > cornerHeight - image.config.height) {
          event.target.y(cornerHeight - image.config.height);
        }
        if (image.config.skewY == 0) {
          event.target.x(cornerWidth - image.config.width);
        } else {
          event.target.x(cornerWidth);
        }
      }

      //ARTWORK ON LEFT WALL
      if (x < cornerWidth - image.config.width) {
        image.config.skewY = 0;
        event.target.skewY(0);
        if (y > cornerHeight - image.config.height) {
          event.target.y(cornerHeight - image.config.height);
        }
        if (y < 0) {
          event.target.y(0);
        }

        if (x < 0) {
          event.target.x(0);
        }
      }

      //ARTWORK  ON RIGHT WALL
      if (x > cornerWidth) {
        image.config.skewY = 0.56;
        event.target.skewY(0.56);
        console.log("partie droite" + height + "skew =" + image.config.skewY);
        if (x + image.config.width > width) {
          event.target.x(width - image.config.width);
          x = event.target.x();
        }

        const ceilingHeight =
          ((x - cornerWidth) / (width - cornerWidth)) * (height - cornerHeight);

        const floorHeigth = ceilingHeight + cornerHeight;

        if (y > floorHeigth - image.config.height) {
          event.target.y(floorHeigth - image.config.height);
        }
        if (y < ceilingHeight) {
          event.target.y(ceilingHeight);
        }
      }
      this.wallArtworks.push(this.wallArtworks.splice(index, 1)[0]);
    },
    dragMoveFloor(image, index, event) {
      const margin = 50;
      const artworkHeight = image.config.height;
      const artworkWidth = image.config.width;
      const y = event.target.y();
      var x = event.target.x();
      let rightX = x + artworkWidth;
      const bottomY = y + artworkHeight;
      console.log(
        "x=" +
          x +
          ",target x=" +
          event.target.x() +
          ",target y=" +
          event.target.y() +
          ", bottomy=" +
          bottomY
      );
      //TOP LIMIT
      if (bottomY < cornerHeight + margin) {
        console.log("je tape le mur du haut!");
        event.target.y(cornerHeight + margin - artworkHeight);
      }

      //BOTTOM LIMIT
      if (bottomY > height) {
        console.log("je tape la limite basse!");
        event.target.y(height - artworkHeight);
      }
      //LEFT LIMIT
      if (x < 0) {
        event.target.x(0);
        x = 0;
        rightX = artworkWidth;
      }

      if (rightX > width) {
        event.target.x(width - artworkWidth);
        x = width - artworkWidth;
        rightX = width;
      }
      //RIGHT BORDER LIMIT

      if (rightX > cornerWidth) {
        const floorHeight =
          cornerHeight +
          ((rightX - cornerWidth) / (width - cornerWidth)) *
            (height - cornerHeight);
        if (bottomY - margin < floorHeight) {
          console.log("je tape la limite droite!");
          event.target.y(floorHeight + margin - artworkHeight);
        }
      }

      //LEFT BORDER LIMIT
      if (x < width - cornerWidth) {
        const floorHeight =
          cornerHeight + (x / (width - cornerWidth)) * (height - cornerHeight);
        if (bottomY > floorHeight) {
          console.log("je tape la limite gôche!  x=");
          event.target.y(floorHeight - artworkHeight);
        }
      }
      //TOP LIMIT
      if (event.target.y() + artworkHeight < cornerHeight + margin) {
        console.log("je tape le mur du haut!");
        event.target.y(cornerHeight + margin - artworkHeight);
      }

      //BOTTOM LIMIT
      if (event.target.y() + artworkHeight > height) {
        console.log("je tape la limite basse!");
        event.target.y(height - artworkHeight);
      }
      this.floorArtworks.push(this.floorArtworks.splice(index, 1)[0]);
    },
    setZindex() {
      this.floorArtworks.forEach((artwork) => {
        console.log("artwork " + artwork.config.y);
      });
      console.log("dragend");
    },

    fitStageIntoParentContainer() {
      heightRatio = window.innerHeight / totalHeight;
      widthRatio = window.innerWidth / totalWidth;
      ratio = Math.min(heightRatio, widthRatio);
      this.configKonva.scaleX = ratio;
      this.configKonva.scaleY = ratio;
      this.configKonva.width = totalWidth * ratio;
      this.configKonva.height = totalHeight * ratio;
      this.configKonva.x = ((totalWidth - width) / 2) * ratio;
      this.configKonva.y = ((totalHeight - height) / 2) * ratio;
    },
    returnExpoImage() {
      this.$refs.watermark.getNode().opacity(1);
      this.$refs.watermark.getNode().draw();
      const pixelRatio = totalWidth / this.$refs.stage.getNode().width();

      var imgURL = this.$refs.stage.getNode().toDataURL({
        mimeType: "image/jpeg",
        pixelRatio: pixelRatio,
        quality: 1,
      });
      return imgURL;
    },
  },
  created() {},
  mounted() {
    window.addEventListener("resize", this.fitStageIntoParentContainer);

    this.fitStageIntoParentContainer();

    //initialize background
    //add backgound:
    this.backgroundPolys.push({
      points: [
        -100,
        -100,
        width + 100,
        -500,
        width + 100,
        height + 100,
        -100,
        height + 100,
      ],
      fill: "#E5E5E5",
      closed: true,
    });

    //add floor
    this.backgroundPolys.push({
      points: [
        cornerWidth,
        cornerHeight,
        width,
        height,
        width - cornerWidth,
        height,
        0,
        cornerHeight,
      ],
      fill: "#949494",
      closed: true,
    });
    //add wall:

    //RIGHT WALL
    this.backgroundPolys.push({
      points: [
        cornerWidth,
        cornerHeight,
        width,
        height,
        width,
        height - cornerHeight,
        cornerWidth,
        0,
      ],
      fill: "#F2F2F2",
      closed: true,
    });

    //WRONG WALL.... NO LEFT WALL
    this.backgroundPolys.push({
      points: [
        cornerWidth,
        cornerHeight,
        cornerWidth,
        0,
        0,
        0,
        0,
        cornerHeight,
      ],
      fill: "#FFFFFF",
      closed: true,
    });

    //INIT WATERMARK

    var image = new Image();
    image.src = require("@/assets/watermark.png");

    this.watermark = {
      x: 50,
      y: height - 270,
      image: image,
      width: 300,
      height: 300,
      opacity: 1,
    };

    image.onload = () => {
      console.log("watermark loeaded");
      this.watermark.opacity = 0;
      this.showWaterMark = false;

      this.$refs.stage.getNode().draw();
    };

    //LOAD images from DB
    //axios.get("http://localhost/testphp/getartwork.php").then((response) => {
    axios
      .get("http://yannbaizid.fr/yann/lizellba/getartwork.php")
      .then((response) => {
        this.disponibleImages = response.data;
        console.log(this.disponibleImages);
      });
  },
};
</script>


<style lang="scss">
</style>
