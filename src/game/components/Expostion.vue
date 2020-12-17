<template>
  <v-stage :config="configKonva">
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
        ></v-image
      >
    </v-layer>
    <v-layer id="floor">
      <v-image
        v-for="(image, index) in floorArtworks"
        v-bind:key="index"
        :config="image.config"
        @dragmove="dragMoveFloor(image, index, $event)"
      ></v-image>
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
        image.src = "http://localhost/testphp/img/" + artwork.src;

        console.log(artwork);

        artwork.config = {
          x: (3 * width) / 5,
          y: height / 4,
          image: image,
          width: 300,
          height: 300,
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
          artwork.config.height = (image.height / image.width) * 300;
          if (artwork.type == "peinture") {
            // set image only when it is loaded
            this.wallArtworks.push(artwork);
          } else {
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
console.log('x='+x+",target x="+event.target.x()+",target y="+event.target.y()+', bottomy='+bottomY)
      //TOP LIMIT
      if (bottomY < cornerHeight + margin) {
        console.log('je tape le mur du haut!');
        event.target.y(cornerHeight + margin - artworkHeight);
      }

      //BOTTOM LIMIT
      if (bottomY > height) {
        console.log('je tape la limite basse!');
        event.target.y(height - artworkHeight);
      }
        //LEFT LIMIT
        if (x<0) {
          event.target.x(0);
          x=0;
          rightX=artworkWidth;
        }
  
        if (rightX>width) {
          event.target.x(width-artworkWidth);
          x=width-artworkWidth;
          rightX=width;
        }
      //RIGHT BORDER LIMIT

      if (rightX > cornerWidth) {
        
        const floorHeight =
          cornerHeight +
          ((rightX - cornerWidth) / (width - cornerWidth)) *
            (height - cornerHeight);
        if (bottomY - margin < floorHeight) {
           console.log('je tape la limite droite!');
          event.target.y(floorHeight + margin - artworkHeight);
        }
      }

      //LEFT BORDER LIMIT
      if (x < width - cornerWidth) {
        const floorHeight =
          cornerHeight + (x / (width - cornerWidth)) * (height - cornerHeight);
        if (bottomY  > floorHeight) {
           console.log('je tape la limite gôche!  x=');
          event.target.y(floorHeight  - artworkHeight);
        }
      }
        //TOP LIMIT
      if (event.target.y()+artworkHeight < cornerHeight + margin) {
        console.log('je tape le mur du haut!');
        event.target.y(cornerHeight + margin - artworkHeight);
      }

      //BOTTOM LIMIT
      if (event.target.y()+artworkHeight > height) {
        console.log('je tape la limite basse!');
        event.target.y(height - artworkHeight);
      }

    },

    fitStageIntoParentContainer() {
      heightRatio = window.innerHeight / totalHeight;
      widthRatio = window.innerWidth / totalWidth;
      ratio = Math.min(heightRatio, widthRatio);
      this.configKonva.scaleX = ratio;
      this.configKonva.scaleY = ratio;
      this.configKonva.width = totalWidth * ratio;
      this.configKonva.height = totalHeight * ratio;
      this.configKonva.x = (totalWidth - width) / 2;
      this.configKonva.y = (totalHeight - height) / 2;
    },
  },
  created() {},
  mounted() {
    window.addEventListener("resize", this.fitStageIntoParentContainer);

    this.fitStageIntoParentContainer();

    //initialize background
    //add backgound:
    this.backgroundPolys.push({
      points: [-5, -5, width + 5, -5, width + 5, height + 5, -5, height + 5],
      fill: "#E5E5E5",
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
    console.log("background plys" + this.backgroundPolys);

    axios.get("http://localhost/testphp/getartwork.php").then((response) => {
      this.disponibleImages = response.data;
      console.log(this.disponibleImages);
    });
  },
};
</script>


<style lang="scss">
</style>
