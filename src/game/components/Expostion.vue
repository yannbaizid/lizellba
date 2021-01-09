<template>
  <div>
    <v-stage :config="configKonva" ref="stage">
      <v-layer id="background" @click="hideToolsFrame">
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
          :ref="image.id"
          @dragmove="dragMoveWall(image, index, $event)"
          @click="displayToolsFrame(image.id, $event)"
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
          @dragend="setZindex()"
          @click="displayToolsFrame(image.id, $event)"
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
          <v-image ref="ReduceIcon" :config="reduceIcon"
           @click="reduceArtwork()" />
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
import axios from "axios";
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
      //TODO
      console.log(poly);
    },

    //drag bound function for wall artworks
    dragMoveWall(image, index, event) {
      console.log("draging " + image.src);

      // image.config.skewY = 0.25;
      const y = event.target.y();
      var x = event.target.x();

      //TRANSITION ZONE FROM LEFT TO RIGHT
      if (x > cornerWidth - event.target.width && x < cornerWidth) {
        if (y < 0) {
          event.target.y(0);
        }
        if (y > cornerHeight - image.config.height) {
          event.target.y(cornerHeight - image.config.height);
        }
        if (image.config.skewY == 0) {
          event.target.x(cornerWidth - event.target.width);
        } else {
          event.target.x(cornerWidth);
        }
      }

      //ARTWORK ON LEFT WALL
      if (x < cornerWidth - event.target.width) {
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
        if (x +event.target.width > width) {
          event.target.x(width - event.target.width);
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
      if (this.toolsFrameConfig.visible) {
        this.setToolsFrame(event);
      }
    },

    //drag bound function for floor artworks
    dragMoveFloor(image, index, event) {
      const margin = 50;
      const artworkHeight = event.target.height;
      const artworkWidth = event.target.width;

      //TOP LIMIT
      if (event.target.y() + artworkHeight < cornerHeight + margin) {
        event.target.y(cornerHeight + margin - artworkHeight);
      }

      //BOTTOM LIMIT
      if (event.target.y() + artworkHeight > height) {
        event.target.y(height - artworkHeight);
      }
      //LEFT LIMIT
      if (event.target.x() < 0) {
        event.target.x(0);
      }

      if (event.target.x() + artworkWidth > width) {
        event.target.x(width - artworkWidth);
      }
      //RIGHT BORDER LIMIT

      if (event.target.x() + artworkWidth > cornerWidth) {
        const floorHeight =
          cornerHeight +
          ((event.target.x() + artworkWidth - cornerWidth) /
            (width - cornerWidth)) *
            (height - cornerHeight);
        if (event.target.y() + artworkHeight - margin < floorHeight) {
          console.log("je tape la limite droite!");
          event.target.y(floorHeight + margin - artworkHeight);
        }
      }

      //LEFT BORDER LIMIT
      const floorWidth =
        ((event.target.y() + artworkHeight - cornerHeight) /
          (height - cornerHeight)) *
        (width - cornerWidth);
      if (event.target.x() < floorWidth) {
        event.target.x(floorWidth);
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
      if (event.target.y() + artworkHeight > height) {
        console.log("je tape la limite basse!");
        event.target.y(height - artworkHeight);
      }
      this.floorArtworks.push(this.floorArtworks.splice(index, 1)[0]);
      if (this.toolsFrameConfig.visible) {
        this.setToolsFrame(event);
      }
    },

    //Put artwork in front. NOT WORKING, TEST METHOD
    setZindex() {
      this.floorArtworks.forEach((artwork) => {
        console.log("artwork " + artwork.config.y);
      });
      console.log("dragend");
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
    displayToolsFrame(imageId, event) {
      console.log("displaytoolsframe");
      console.log(event.target);
      if (this.toolsFrameConfig.visible) {
        this.hideToolsFrame();
      } else {
        this.iconsConfig.target = imageId;
        this.showToolsFrame(event);
      }
    },
    showToolsFrame(event) {
      console.log("showtoolsframe");
      this.toolsFrameConfig.visible = true;
      this.iconsConfig.visible = true;
      this.setToolsFrame(event);
    },
    hideToolsFrame() {
      console.log("displaytoolsframe");
      this.toolsFrameConfig.visible = false;
      this.iconsConfig.visible = false;
    },

    //set tools frame position
    setToolsFrame(event) {
      this.toolsFrameConfig.y = event.target.y() - this.toolsFrameConfig.margin;
      this.toolsFrameConfig.x = event.target.x() - this.toolsFrameConfig.margin;

      this.toolsFrameConfig.height =
        event.target.height() *
          (1 + (event.target.skewY() * event.target.width()) / 180) +
        2 * this.toolsFrameConfig.margin;
      this.toolsFrameConfig.width =
        event.target.width() + 2 * this.toolsFrameConfig.margin;

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
      console.log(this.$refs);
      var baseWidth=this.$refs[targetRef][0].config.width;
      var baseHeight=this.$refs[targetRef][0].config.height;
      var targetScale = this.$refs[targetRef][0].config.scale;
      var scaleIndex = this.possibleScale.lastIndexOf(targetScale);
      if (scaleIndex != -1 && scaleIndex < this.possibleScale.length - 1) {
        targetScale = this.possibleScale[scaleIndex + 1];
      this.$refs[targetRef][0].getNode().width(  baseWidth* targetScale );
      this.$refs[targetRef][0].getNode().height(baseHeight* targetScale );
       this.$refs[targetRef][0].config.scale=targetScale;
      this.$refs.stage.getNode().draw();
      }
    },
    //reduce artwork
    reduceArtwork() {
      var targetRef = this.iconsConfig.target;
      console.log("enlarge yur pinis " + targetRef);
      console.log("enlarge yur pinis " + this.$refs[targetRef][0].config.width);
      console.log(this.$refs);
      var baseWidth=this.$refs[targetRef][0].config.width;
      var baseHeight=this.$refs[targetRef][0].config.height;
      var targetScale = this.$refs[targetRef][0].config.scale;
      var scaleIndex = this.possibleScale.lastIndexOf(targetScale);
      if (scaleIndex != -1 && scaleIndex > 0) {
        targetScale = this.possibleScale[scaleIndex - 1];
      this.$refs[targetRef][0].getNode().width(  baseWidth* targetScale );
      this.$refs[targetRef][0].getNode().height(baseHeight* targetScale );
          this.$refs[targetRef][0].config.scale=targetScale;
      this.$refs.stage.getNode().draw();
      }
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
