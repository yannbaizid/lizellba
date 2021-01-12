<template>
  <div>
    <v-stage :config="configKonva" ref="stage">
      <v-layer id="background" @click="hideToolsFrame">
        <v-line
          v-for="(poly, index) in backgroundPolys"
          v-bind:key="index"
          
          @dblclick="poly.name=='leftWall' || poly.name=='rightwall'? changePolyColor(poly): null"
          :config="poly"
        ></v-line>
      </v-layer>
      <v-layer id="wall">
        <v-image
          v-for="(image, index) in wallArtworks"
          v-bind:key="image.id"
          :config="image.config"
          :ref="image.id"
          @dragmove="dragMoveWall(image, index, $event)"
          @click="displayToolsFrame(image.id, 'wall', index, $event)"
        >
        </v-image>
      </v-layer>

      <v-layer id="floor">
        <v-image
          class="selected"
          v-for="(image, index) in floorArtworks"
          v-bind:key="image.id"
          :config="image.config"
          :ref="image.id"
          @dragmove="dragMoveFloor(image, index, $event)"
          @click="displayToolsFrame(image.id, 'floor', index, $event)"
        ></v-image>
      </v-layer>
      <v-layer id="tools">
        <v-image ref="watermark" :config="watermark"> </v-image>
        <v-rect ref="toolsFrame" :config="toolsFrameConfig" />
        <v-group :config="iconsConfig">
          <v-image ref="InfoIcon" :config="infoIcon" />
          <v-image ref="DeleteIcon" :config="deleteIcon" />
          <v-image
            ref="EnlargeIcon"
            :config="enlargeIcon"
            @click="enlargeArtwork()"
          />
          <v-image
            ref="ReduceIcon"
            :config="reduceIcon"
            @click="reduceArtwork()"
          />
        </v-group>
      </v-layer>
    </v-stage>
    <!--  <div
      id="tools_frame"
      :class="toolsFrameOn ? '' : 'hidden'"
      ref="ToolsFrame"
      v-bind:style="{
        top: toolsFrame.top + 'px',
        left: toolsFrame.left + 'px',
        width: toolsFrame.width + 'px',
        height: toolsFrame.height + 'px',
      }"
    ></div> -->
  </div>
</template>

<script>
//import axios from "axios";
import api from "@/services/api/api";

const totalWidth = 1920;
const totalHeight = 1080;
const relativeSizeOfContent = 0.9;
let height = totalHeight * relativeSizeOfContent;
let width = totalWidth * relativeSizeOfContent;
let heightRatio = window.innerHeight / height;
let widthRatio = window.innerWidth / width;
let ratio = Math.min(heightRatio, widthRatio);
const cornerHeight = (2 * height) / 3;
const cornerWidth = (2 * width) / 3;
const thickness = 20;
const iconMargin = 10;
const iconSize = 40;

const angle = Math.atan((height - cornerHeight) / (width - cornerWidth));

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
      toolsFrameOn: false,
      toolsFrameConfig: {
        x: 0,
        y: 0,
        width: 0,
        height: 0,
        stroke: "#32D8FD",
        strokeWidth: 3,
        cornerRadius: 10,
        fillEnabled: false,
        margin: 20,
        skewY: 0,
        visible: false,
      },
      iconsConfig: {
        target: null,
        visible: false,
      },
      possibleScale: [0.6, 1, 1.5],
      wallColors: ['#ffffff','#a0ffa0','#ffa0a0','#a0a0ff'],
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
          scale: 1,

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

    //change the color of a wall
    changePolyColor(poly) {
      if (poly.name=='leftWall') {

        var index=this.wallColors.findIndex((x) => x == poly.fill);
     index++;
     if(index==this.wallColors.length) {
       index=0;
     }
     poly.fill=this.wallColors[index];
      }
      console.log(poly);
    },

    //drag bound function for wall artworks
    dragMoveWall(image, index, event) {
      this.placeWallArtwork(event.target);
    },

    placeWallArtwork(target) {
      console.log('place wall artwork');
      var y = target.y();
      var x = target.x();
      var targetWidth = target.width();
      var targetHeight = target.height();

      //TRANSITION ZONE FROM LEFT TO RIGHT
      if (x > cornerWidth - targetWidth && x < cornerWidth) {
        if (y < 0) {
          target.y(0);
        }
        if (y > cornerHeight - targetHeight) {
          target.y(cornerHeight - targetHeight);
        }
        if (target.skewY() == 0) {
          target.x(cornerWidth - targetWidth);
        } else {
          target.x(cornerWidth);
        }
      }

      //ARTWORK ON LEFT WALL
      if (x < cornerWidth - targetWidth) {
        target.skewY(0);
        if (y > cornerHeight - targetHeight) {
          target.y(cornerHeight - targetHeight);
        }
        if (y < 0) {
          target.y(0);
        }

        if (x < 0) {
          target.x(0);
        }
      }

      //ARTWORK  ON RIGHT WALL
      if (x > cornerWidth) {
        target.skewY(0.56);

        if (x + targetWidth > width) {
          target.x(width - targetWidth);
        }

        const ceilingHeight =
          ((target.x() - cornerWidth) / (width - cornerWidth)) *
          (height - cornerHeight);

        const floorHeigth = ceilingHeight + cornerHeight;

        if (y > floorHeigth - targetHeight) {
          target.y(floorHeigth - targetHeight);
        }
        if (y < ceilingHeight) {
          target.y(ceilingHeight);
        }
      }

        if (this.toolsFrameConfig.visible) {
          this.setToolsFrame(target);
        }
      var artworkName = target.VueComponent.config.name;
      const index = this.wallArtworks.findIndex(
        (x) => x.config.name === artworkName
      );
      target.getParent().draw();
      this.placeOnTop("wall", index);
    },

    //drag bound function for floor artworks
    dragMoveFloor(image, index, event) {
      this.placeFloorArtwork(event.target);
    },
    placeFloorArtwork(target) {
      const margin = 50;
      const artworkHeight = target.height();
      const artworkWidth = target.width();

      //TOP LIMIT
      if (target.y() + artworkHeight < cornerHeight + margin) {
        target.y(cornerHeight + margin - artworkHeight);
      }

      //BOTTOM LIMIT
      if (target.y() + artworkHeight > height) {
        target.y(height - artworkHeight);
      }
      //LEFT LIMIT
      if (target.x() < 0) {
        target.x(0);
      }

      if (target.x() + artworkWidth > width) {
        target.x(width - artworkWidth);
      }
      //RIGHT BORDER LIMIT

      if (target.x() + artworkWidth > cornerWidth) {
        const floorHeight =
          cornerHeight +
          ((target.x() + artworkWidth - cornerWidth) / (width - cornerWidth)) *
            (height - cornerHeight);
        if (target.y() + artworkHeight - margin < floorHeight) {
          console.log("je tape la limite droite!");
          target.y(floorHeight + margin - artworkHeight);
        }
      }

      //LEFT BORDER LIMIT
      const floorWidth =
        ((target.y() + artworkHeight - cornerHeight) /
          (height - cornerHeight)) *
        (width - cornerWidth);
      if (target.x() < floorWidth) {
        target.x(floorWidth);
      }
      /*
      if (event.target.x()< width - cornerWidth) {




        const floorHeight =
          cornerHeight + (event.target.x() / (width - cornerWidth)) * (height - cornerHeight);
        if (event.target.y()+artworkHeight  > floorHeight) {
          console.log("je tape la limite gôche!  x=");
          event.target.y(floorHeight - artworkHeight);
        }
      }
      //TOP LIMIT
      if (event.target.y() + artworkHeight < cornerHeight + margin) {
        console.log("je tape le mur du haut!");
        event.target.y(cornerHeight + margin - artworkHeight);
      }*/

      //BOTTOM LIMIT
      if (target.y() + artworkHeight > height) {
        console.log("je tape la limite basse!");
        target.y(height - artworkHeight);
      }
      if (this.toolsFrameConfig.visible) {
        this.setToolsFrame(target);
      }

      var artworkName = target.VueComponent.config.name;
      const index = this.floorArtworks.findIndex(
        (x) => x.config.name === artworkName
      );
       target.getParent().draw();
      this.placeOnTop("floor", index);
    },
    placeArtwork(target) {
      console.log('placeArtwork');
      if (target.getParent().attrs.id == "wall") {
        this.placeWallArtwork(target);
      }
      if (target.getParent().attrs.id == "floor") {
        this.placeFloorArtwork(target);
      }
    },

    //Put artwork in front. NOT WORKING, TEST METHOD
    placeOnTop(type, index) {
      if (type == "wall") {
        this.wallArtworks.push(this.wallArtworks.splice(index, 1)[0]);
      } else {
        this.floorArtworks.push(this.floorArtworks.splice(index, 1)[0]);
      }
    },

    //Scale the stage to fit windows size
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

    //return the expo snapshot as base 64
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
    displayToolsFrame(imageId, imageType, index, event) {
      console.log("displaytoolsframe");
      console.log(event.target);
      this.iconsConfig.target = imageId;
      this.showToolsFrame(event);

      //  this.placeOnTop(imageType,index);
    },
    showToolsFrame(event) {
      console.log("showtoolsframe");
      this.toolsFrameConfig.visible = true;
      this.iconsConfig.visible = true;
      this.setToolsFrame(event.target);
    },
    hideToolsFrame() {
      console.log("displaytoolsframe");
      this.toolsFrameConfig.visible = false;
      this.iconsConfig.visible = false;
    },

    //set tools frame position
    setToolsFrame(target) {
      this.toolsFrameConfig.y = target.y() - this.toolsFrameConfig.margin;
      this.toolsFrameConfig.x = target.x() - this.toolsFrameConfig.margin;

      this.toolsFrameConfig.height =
        target.height() * (1 + (target.skewY() * target.width()) / 180) +
        2 * this.toolsFrameConfig.margin;
      this.toolsFrameConfig.width =
        target.width() + 2 * this.toolsFrameConfig.margin;

      this.infoIcon.x = this.toolsFrameConfig.x - this.infoIcon.width / 2;
      this.infoIcon.y = this.toolsFrameConfig.y + 20;
      this.deleteIcon.x = this.toolsFrameConfig.x - this.infoIcon.width / 2;
      this.deleteIcon.y = this.toolsFrameConfig.y + 70;
      this.$refs.InfoIcon.getNode().x(
        this.toolsFrameConfig.x - this.infoIcon.width / 2
      );
      this.$refs.InfoIcon.getNode().y(this.toolsFrameConfig.y + iconMargin);
      this.$refs.EnlargeIcon.getNode().x(
        this.toolsFrameConfig.x - this.enlargeIcon.width / 2
      );
      this.$refs.EnlargeIcon.getNode().y(
        this.toolsFrameConfig.y + iconSize + 2 * iconMargin
      );
      this.$refs.ReduceIcon.getNode().x(
        this.toolsFrameConfig.x - this.reduceIcon.width / 2
      );
      this.$refs.ReduceIcon.getNode().y(
        this.toolsFrameConfig.y + 2 * iconSize + 3 * iconMargin
      );
      this.$refs.DeleteIcon.getNode().x(
        this.toolsFrameConfig.x +
          this.toolsFrameConfig.width -
          this.reduceIcon.width / 2
      );
      this.$refs.DeleteIcon.getNode().y(
        this.toolsFrameConfig.y +
          this.toolsFrameConfig.height -
          iconMargin -
          iconSize
      );

      console.log("set tools frame");
    },

    //enlarge artwork
    enlargeArtwork() {
      var targetRef = this.iconsConfig.target;
      console.log("enlarge yur pinis " + targetRef);
      console.log(this.$refs[targetRef][0]);
      console.log(this.$refs[targetRef][0].getNode().getParent().attrs.id);
      var baseWidth = this.$refs[targetRef][0].config.width;
      var baseHeight = this.$refs[targetRef][0].config.height;
      var targetScale = this.$refs[targetRef][0].config.scale;
      var scaleIndex = this.possibleScale.lastIndexOf(targetScale);
      if (scaleIndex != -1 && scaleIndex < this.possibleScale.length - 1) {
        targetScale = this.possibleScale[scaleIndex + 1];
        this.$refs[targetRef][0].getNode().width(baseWidth * targetScale);
        this.$refs[targetRef][0].getNode().height(baseHeight * targetScale);
        this.$refs[targetRef][0].config.scale = targetScale;
        this.$refs.stage.getNode().draw();
      }

      this.placeArtwork(this.$refs[targetRef][0].getNode());
    },
    //reduce artwork
    reduceArtwork() {
      var targetRef = this.iconsConfig.target;
      console.log("enlarge yur pinis " + targetRef);
      console.log("enlarge yur pinis " + this.$refs[targetRef][0].config.width);
      console.log(this.$refs);
      var baseWidth = this.$refs[targetRef][0].config.width;
      var baseHeight = this.$refs[targetRef][0].config.height;
      var targetScale = this.$refs[targetRef][0].config.scale;
      var scaleIndex = this.possibleScale.lastIndexOf(targetScale);
      if (scaleIndex != -1 && scaleIndex > 0) {
        targetScale = this.possibleScale[scaleIndex - 1];
        this.$refs[targetRef][0].getNode().width(baseWidth * targetScale);
        this.$refs[targetRef][0].getNode().height(baseHeight * targetScale);
        this.$refs[targetRef][0].config.scale = targetScale;
        this.$refs.stage.getNode().draw();
      }
      this.placeArtwork(this.$refs[targetRef][0].getNode());
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

    const smallWidth = thickness * Math.cos(angle);
    const smallHeight = thickness * Math.sin(angle);
    //greyer thickness:
    this.backgroundPolys.push({
      points: [
        width,
        height,
        width + thickness,
        height,
        width + thickness,
        height + thickness,
        width - cornerWidth,
        height + thickness,
        -smallWidth,
        cornerHeight - smallHeight + thickness,
        -smallWidth,
        cornerHeight - smallHeight,
        0,
        cornerHeight,
      ],
      fill: "#8d8d8d",
      closed: true,
    });
    //white ackgound:
    this.backgroundPolys.push({
      points: [
        width,
        height,
        width + thickness,
        height,
        width + thickness,
        height - cornerHeight,
        cornerWidth - smallWidth + thickness,
        -smallHeight,
        -smallWidth,
        -smallHeight,
        0,
        0,
      ],
      fill: "#ffffff",
      closed: true,
    });
    //grey thickness:
    this.backgroundPolys.push({
      points: [
        -smallWidth,
        -smallHeight,
        0,
        0,
        0,
        cornerHeight,
        -smallWidth,
        cornerHeight - smallHeight,
      ],
      fill: "#f2f2f2",
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
      name: 'rightWall',
      color: 'white'
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
       name: 'leftWall',
      color: 'white',
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

    //init Icons
    image = new Image();
    image.src = require("@/assets/expo_icons/info.svg");

    this.infoIcon = {
      x: 300,
      y: 300,
      image: image,
      width: iconSize,
      height: iconSize,
      visibile: true,
    };

    image.onload = () => {
      console.log("icon loeaded");

      this.$refs.stage.getNode().draw();
    };

    //delete icon
    var deleteImage = new Image();
    deleteImage.src = require("@/assets/expo_icons/delete.svg");

    this.deleteIcon = {
      x: 350,
      y: 300,
      image: deleteImage,
      width: iconSize,
      height: iconSize,
      visibile: true,
    };

    deleteImage.onload = () => {
      console.log("icon loeaded");

      this.$refs.stage.getNode().draw();
    };

    //Enlarge icon
    image = new Image();
    image.src = require("@/assets/expo_icons/enlarge.svg");

    this.enlargeIcon = {
      x: 400,
      y: 300,
      image: image,
      width: iconSize,
      height: iconSize,
      visibile: true,
    };

    image.onload = () => {
      console.log("icon loeaded");

      this.$refs.stage.getNode().draw();
    };

    //reduce icon
    image = new Image();
    image.src = require("@/assets/expo_icons/reduce.svg");

    this.reduceIcon = {
      x: 450,
      y: 300,
      image: image,
      width: iconSize,
      height: iconSize,
      visibile: true,
    };

    image.onload = () => {
      console.log("icon loeaded");

      this.$refs.stage.getNode().draw();
    };

    //LOAD images from DB
    //axios.get("http://localhost/testphp/getartwork.php").then((response) => {
      
      console.log('exposition.vue api call');
  api.getArtworks().then(artworks=> {
    this.disponibleImages=artworks;
    console.log(this.disponibleImages);

  });
/*     axios
      .get("http://yannbaizid.fr/yann/lizellba/getartwork.php")
      .then((response) => {
        this.disponibleImages = response.data;
        console.log(this.disponibleImages);
      }); */
  },
};
</script>


<style lang="scss">
#tools_frame {
  border: 2px solid #32d8fd;
  padding: 10px;
  border-radius: 15px;
  position: fixed;
}

.hidden {
  display: none;
}

.selected {
  border: 2px solid #32d8fd;
  padding: 10px;
  border-radius: 15px;
}
</style>
