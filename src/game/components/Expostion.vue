<template>
  <div>
    <div @click="hideToolsFrame" @tap="hideToolsFrame"></div>

    <v-stage
      :config="configKonva"
      ref="stage"
      @touchmove="handleStagePinch"
      @touchend="handleTouchEnd"
    >
      <v-layer id="background" @click="hideToolsFrame" @tap="hideToolsFrame">
        <v-line ref="backgroundPoly" :config="backgroundPoly" />
        <v-line
          v-for="(poly, index) in backgroundPolys"
          v-bind:key="index"
          @dblclick="
            poly.name == 'leftWall' || poly.name == 'rightWall'
              ? changePolyColor(poly)
              : null
          "
          :config="poly"
          @mouseover="
            poly.name == 'leftWall' || poly.name == 'rightWall'
              ? handleMouseOver()
              : null
          "
          @mouseout="handleMouseOut"
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
          @tap="displayToolsFrame(image.id, 'wall', index, $event)"
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
          @tap="displayToolsFrame(image.id, 'floor', index, $event)"
        ></v-image>
      </v-layer>
      <v-layer id="tools">
        <v-image ref="watermark" :config="watermark"> </v-image>
        <v-rect ref="toolsFrame" :config="toolsFrameConfig" />
        <v-group ref="icons" :config="iconsConfig">
          <v-image
            ref="InfoIcon"
            :config="infoIcon"
            @click="openArtworkModal"
            @tap="openArtworkModal"
          />
          <v-image
            ref="DeleteIcon"
            :config="deleteIcon"
            @click="askDeleteConfirmation"
            @tap="askDeleteConfirmation"
          />
          <v-image
            ref="EnlargeIcon"
            :config="enlargeIcon"
            @click="enlargeArtwork()"
            @tap="enlargeArtwork()"
          />
          <v-image
            ref="ReduceIcon"
            :config="reduceIcon"
            @click="reduceArtwork()"
            @tap="reduceArtwork()"
          />
        </v-group>
      </v-layer>
    </v-stage>
  </div>
</template>

<script>
//import axios from "axios";
//import api from "@/services/api/api";

const totalWidth = 1920;
const totalHeight = 1080;
const relativeSizeOfContent = 0.87;
const height = totalHeight * relativeSizeOfContent;
let width = totalWidth * relativeSizeOfContent;
let heightRatio = window.innerHeight / height;
let widthRatio = window.innerWidth / width;
let ratio = Math.min(heightRatio, widthRatio);
const cornerHeight = (2 * height) / 3;
const cornerWidth = (2 * width) / 3;
const thickness = 20;
const iconMargin = 10;
const iconSize = 40;
const wallHeight = 400;
var lastDist = 0;
var lastCenter = 0;
const angle = Math.atan((height - cornerHeight) / (width - cornerWidth));

export default {
  name: "Exposition",
  props: {},
  data() {
    return {
      paintCursor:
        "url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/9632/happy.png');",
      configKonva: {
        width: totalWidth,
        height: totalHeight,
        scaleX: ratio,
        scaleY: ratio,
        draggable: true,
        dragBoundFunc: (pos) => {
          var newX = this.configKonva.x;
          var newY = this.configKonva.y;

          if (totalWidth * this.configKonva.scaleX <= this.screenWidth) {
            console.log("y a tout qui rent en X");
            //width of scaled exposition is shorter than screen width  => no dragging on X axis
            newX = (this.screenWidth - width * this.configKonva.scaleX) / 2;
          } else {
            console.log("ca depasse en X");
            newX =
              pos.x + totalWidth * this.configKonva.scaleX < this.screenWidth
                ? this.screenWidth - totalWidth * this.configKonva.scaleX
                : pos.x;
            if (newX > ((totalWidth - width) * this.configKonva.scaleX) / 2) {
              newX = ((totalWidth - width) * this.configKonva.scaleX) / 2;
            }
          }

          if (totalHeight * this.configKonva.scaleY <= this.screenHeight) {
            //height of scaled exposition is shorter than screen height  => no dragging on Y axis
            console.log("y a tout qui rent en Y");
            newY = (this.screenHeight - height * this.configKonva.scaleY) / 2;
          } else {
            console.log("ca depasse en Y");
            newY =
              pos.y + totalHeight * this.configKonva.scaleY < this.screenHeight
                ? this.screenHeight - totalHeight * this.configKonva.scaleY
                : pos.y;

            if (newY > ((totalHeight - height) * this.configKonva.scaleY) / 2) {
              newY = ((totalHeight - height) * this.configKonva.scaleY) / 2;
            }
          }

          return {
            x: newX,
            y: newY,
          };
        },
      },

      artworks: [],
      backgroundPolys: [],
      width: width,
      height: height,
      watermark: {},
      showWaterMark: false,
      toolsFrameOn: false,
      screenHeight: 1080,
      screenWidth: 1920,
      savedImage: null,
      imageSaved: false,
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
      wallColors: ["#FFFFFF", "#9d87c8", "#b0ffb0", "#ffa0a0", "#ffffa0"],
      rightwallColors: ["#F2F2F2", "#907ABB", "#93f293", "#f29393", "#f2f293"],
    };
  },
  computed: {
    backgroundPoly() {
      console.log(
        "hey jsuile. screenwi" +
          this.screenWidth +
          ",heigh:" +
          this.screenHeight +
          " x:" +
          -(this.screenHeight - width * this.configKonva.scaleX) / 2
      );
      return {
        points: [
          0,
          0,
          this.configKonva.width / this.configKonva.scaleX,
          0,
          this.configKonva.width / this.configKonva.scaleX,
          this.configKonva.height / this.configKonva.scaleX,
          0,
          this.configKonva.height / this.configKonva.scaleX,
        ],
        x:
          -(this.configKonva.width - width * this.configKonva.scaleX) /
          (2 * this.configKonva.scaleX),
        y:
          -(this.configKonva.height - height * this.configKonva.scaleY) /
          (2 * this.configKonva.scaleY),
        fill: "#E5E5E5",
        closed: true,
      };
    },
    topHeight() {
      return (totalHeight * (1 - relativeSizeOfContent)) / 2;
    },
    leftWidth() {
      return totalWidth * (1 - relativeSizeOfContent);
    },
    wallArtworks() {
      return this.artworks.filter((artwork) => artwork.type == "wall");
    },
    floorArtworks() {
      return this.artworks.filter((artwork) => artwork.type == "floor");
    },
  },

  methods: {
    handleMouseOver() {
      document.body.style.cursor =
        'url("http://lizellba.la-criee.org/img/icons/paintCursor.svg"),pointer';
      console.log(document.body.style.cursor);
      console.log("mouseover");
    },
    handleMouseOut() {
      document.body.style.cursor = "default";
    },
    getDistance(p1, p2) {
      return Math.sqrt(Math.pow(p2.x - p1.x, 2) + Math.pow(p2.y - p1.y, 2));
    },

    getCenter(p1, p2) {
      return {
        x: (p1.x + p2.x) / 2,
        y: (p1.y + p2.y) / 2,
      };
    },
    handleStagePinch(e) {
      console.log(e);
      var touch1 = e.evt.touches[0];
      var touch2 = e.evt.touches[1];
      if (touch1 && touch2) {
        this.configKonva.draggable = false;
        console.log(this.$refs.stage.getNode());

        console.log("touch 1 et 2!!!");
        var p1 = { x: touch1.clientX, y: touch1.clientY };
        var p2 = { x: touch2.clientX, y: touch2.clientY };
        console.log("p1:" + p1.x + ",p2:" + p2.x);
        var dist = this.getDistance(p1, p2);
        var newCenter = this.getCenter(p1, p2);
        if (!lastDist) {
          lastDist = this.getDistance(p1, p2);
        }

        if (!lastCenter) {
          lastCenter = newCenter;
          return;
        }
        var scale = this.configKonva.scaleX * (dist / lastDist);
        if (
          scale >= 1 &&
          totalWidth * scale > this.screenWidth &&
          totalHeight * scale > this.screenHeight
        ) {
          console.log("dont scale up too much!");
        } else if (
          totalHeight * scale < this.screenHeight &&
          totalWidth * scale < this.screenWidth
        ) {
          console.log("don't reduce it too much");
        } else {
          this.configKonva.scaleX = scale;
          this.configKonva.scaleY = scale;

          // local coordinates of center point
          var pointTo = {
            x: (newCenter.x - this.configKonva.x) / this.configKonva.scaleX,
            y: (newCenter.y - this.configKonva.y) / this.configKonva.scaleX,
          };

          // calculate new position of the stage
          var dx = newCenter.x - lastCenter.x;
          var dy = newCenter.y - lastCenter.y;

          var newPos = {
            x: newCenter.x - pointTo.x * scale + dx,
            y: newCenter.y - pointTo.y * scale + dy,
          };

          this.configKonva.x = newPos.x;
          this.configKonva.y = newPos.y;
          this.$refs.stage.getNode().batchDraw();
        }

        lastDist = dist;
        lastCenter = newCenter;
      }
    },
    handleTouchEnd() {
      if (
        totalHeight * this.configKonva.scaleY < this.screenHeight &&
        totalWidth * this.configKonva.scaleX < this.screenWidth
      ) {
        this.fitStageIntoParentContainer();
      }
      console.log("evenement touchend");
      lastDist = 0;
      lastCenter = null;
      this.configKonva.draggable = true;
    },
    sayHello() {
      console.log("hello");
    },
    addArtwork(artwork) {
      console.log(
        artwork.name +
          " , method addartwork in exposition component fired from app.vue"
      );

      var image = new Image();

      //image.src = require("@/assets/img/artworks/" + artwork.src);

      // image.src = "/img/artwork/" + artwork.src;

      console.log(image.src);
      const randomX = Math.floor(Math.random() * width);
      const randomY = Math.floor(Math.random() * width);
      artwork.config = {
        x: randomX,
        y: randomY,
        image: image,
        width: 100,
        height: 100,
        draggable: true,
        skewY: 0,
        scale: 1,
        opacity: 1,
        name: artwork.id,
      };
      if (artwork.optional_info == "movie") {
        artwork.config.opacity = 0.8;
      }
      image.src = process.env.VUE_APP_IMGLINK + "artwork/" + artwork.src;
      image.onload = () => {
        // set DImension proportional to wall height
        artwork.config.height = (artwork.height / wallHeight) * cornerHeight;
        artwork.config.width =
          (image.width / image.height) * artwork.config.height;

        console.log("image:" + image.src + " loaded");
        /*    if (image.height < image.width) {
          artwork.config.height = 175;
          artwork.config.width = (image.width / image.height) * artwork.config.height;
        } else {
          artwork.config.width = 175;
          artwork.config.height = (image.height / image.width) * 175;
        } */

        this.artworks.push(artwork);

        console.log(this.$refs);
        var targetId = artwork.id.toString();
        console.log("targetId:" + targetId);
        this.$nextTick(() => {
          console.log(this.$refs[targetId][0]);

          this.showToolsFrame();
          this.iconsConfig.target = artwork.id;
          this.placeArtwork(this.$refs[targetId][0].getNode());
        });
      };
    },

    //change the color of a wall
    changePolyColor(poly) {
      if (poly.name == "leftWall") {
        var index = this.wallColors.findIndex((x) => x == poly.fill);
        console.log(
          "index begore:" +
            index +
            " index 0:" +
            this.wallColors[0] +
            " polyfill:" +
            poly.fill
        );
        index++;
        if (index == this.wallColors.length) {
          index = 0;
        }
        poly.fill = this.wallColors[index];
      }
      if (poly.name == "rightWall") {
        index = this.rightwallColors.findIndex((x) => x == poly.fill);
        index++;
        if (index == this.rightwallColors.length) {
          index = 0;
        }
        poly.fill = this.rightwallColors[index];
      }
      console.log(poly);
    },

    //drag bound function for wall artworks
    dragMoveWall(image, index, event) {
      this.iconsConfig.target = image.id;
      this.placeWallArtwork(event.target);
    },

    placeWallArtwork(target) {
      console.log("place wall artwork");

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
      const index = this.artworks.findIndex(
        (x) => x.config.name === artworkName
      );
      target.getParent().draw();
      this.placeOnTop("wall", index);
    },

    //drag bound function for floor artworks
    dragMoveFloor(image, index, event) {
      this.iconsConfig.target = image.id;
      this.placeFloorArtwork(event.target);
    },
    placeFloorArtwork(target) {
      var artwork = this.artworks.find(
        (x) => x.config.name === target.VueComponent.config.name
      );

      // deprecated
      // const margin = 50;
      const artworkHeight = target.height();
      const artworkWidth = target.width();
      const verticalMargin = (artwork.margin_vertical * artworkHeight) / 100;
      const leftMargin = (artwork.margin_left * artworkWidth) / 100;
      const rightMargin = (artwork.margin_right * artworkWidth) / 100;
      console.log(
        "margin v:" +
          verticalMargin +
          "margin l: " +
          leftMargin +
          " ,margin r: " +
          rightMargin
      );

      //TOP LIMIT
      if (target.y() + artworkHeight - verticalMargin < cornerHeight) {
        target.y(cornerHeight - artworkHeight + verticalMargin);
      }

      //BOTTOM LIMIT
      if (target.y() + artworkHeight > height) {
        target.y(height - artworkHeight);
      }

      
      //BOTTOM LIMIT
      if (target.y() + artworkHeight > height) {
        console.log("je tape la limite basse!");
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
      const rightFloorWidth = Math.min(
        ((target.y() + artworkHeight - cornerHeight) /
          (height - cornerHeight)) *
          (width - cornerWidth) +
        cornerWidth, width);
    
      if (target.x() + rightMargin + artworkWidth > rightFloorWidth) {
    console.log('ca tape à droite');
    target.x(rightFloorWidth- rightMargin- artworkWidth);
      }

      /*     if (target.x() + artworkWidth > cornerWidth) {
        const floorHeight =
          cornerHeight +
          ((target.x() + artworkWidth - cornerWidth) / (width - cornerWidth)) *
            (height - cornerHeight);
        if (target.y() + artworkHeight - margin < floorHeight) {
          console.log("je tape la limite droite!");
          target.y(floorHeight + margin - artworkHeight);
        }
      }
 */
      //LEFT BORDER LIMIT
      const floorWidth =
        ((target.y() + artworkHeight - cornerHeight) /
          (height - cornerHeight)) *
        (width - cornerWidth);
      if (target.x() + leftMargin < floorWidth) {
        target.x(floorWidth - leftMargin);
      }

      if (this.toolsFrameConfig.visible) {
        this.setToolsFrame(target);
      }

      var artworkName = target.VueComponent.config.name;
      const index = this.artworks.findIndex(
        (x) => x.config.name === artworkName
      );
      target.getParent().draw();
      this.placeOnTop("floor", index);
    },
    placeArtwork(target) {
      console.log("placeArtwork");
      if (target.getParent().attrs.id == "wall") {
        this.placeWallArtwork(target);
      }
      if (target.getParent().attrs.id == "floor") {
        this.placeFloorArtwork(target);
      }
    },

    //Put artwork in front. NOT WORKING, TEST METHOD
    placeOnTop(type, index) {
      this.artworks.push(this.artworks.splice(index, 1)[0]);
    },

    //Scale the stage to fit windows size
    fitStageIntoParentContainer() {
      this.screenHeight = Math.min(screen.height, window.innerHeight);
      this.screenWidth = Math.min(screen.width, window.innerWidth);
      /*  console.log(
        "resizing. thisscrren height" +
          this.screenHeight +
          ",thisscreenwidth" +
          this.screenWidth +
          ",windowheight" +
          window.innerHeight +
          ",window width" +
          window.innerWidth
      );
      console.log(
        "screenwidth" + screen.width + ", screenheigh" + screen.height
      ); */
      heightRatio = this.screenHeight / totalHeight;
      widthRatio = this.screenWidth / totalWidth;
      ratio = Math.min(heightRatio, widthRatio);
      this.configKonva.scaleX = ratio;
      this.configKonva.scaleY = ratio;

      this.configKonva.width = this.screenWidth;
      this.configKonva.height = this.screenHeight;
      // this.configKonva.width = totalWidth * ratio;
      //this.configKonva.height = totalHeight * ratio;
      this.configKonva.x = (this.screenWidth - width * ratio) / 2;
      this.configKonva.y = (this.screenHeight - height * ratio) / 2;
    },

    setExpoToInitialSize() {
      this.configKonva.height = totalHeight;
      this.configKonva.width = totalWidth;
      this.configKonva.scaleX = 1;
      this.configKonva.scaleY = 1;
      this.configKonva.x = (totalWidth - width) / 2;
      this.configKonva.y = (totalHeight - height) / 2;
    },

    //return the expo snapshot as base 64
    async returnExpoImage() {
      window.removeEventListener("resize", this.fitStageIntoParentContainer);

      this.showWaterMark = true;
      this.hideToolsFrame();
      this.$refs.watermark.getNode().opacity(1);
      this.$refs.icons.getNode().opacity(0);
      this.$refs.toolsFrame.getNode().opacity(0);
      this.$refs.watermark.getNode().draw();
      this.setExpoToInitialSize();
      this.$refs.stage.getNode().draw();
      console.log(this.configKonva);
      //const pixelRatio = totalWidth / this.$refs.stage.getNode().width();
      console.log(
        "returnexpoimage" +
          this.configKonva.width +
          " height:" +
          this.configKonva.height
      );
      console.log(this.$refs.stage.getNode());
      await this.$nextTick();

      var imgURL = this.$refs.stage.getNode().toDataURL({
        mimeType: "image/jpeg",
        width: 1920,
        height: 1080,
        pixelRatio: 1,
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
      if (event) {
        this.setToolsFrame(event.target);
      }
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
        const targetType = this.artworks.find(
          (artwork) => artwork.id == targetRef
        ).type;
        console.log("target type:" + targetType);
        if (targetType == "wall") {
          console.log(
            "width of artwrok:" + this.$refs[targetRef][0].getNode().width()
          );
          console.log("wall width" + (width - cornerWidth));
          if (
            this.$refs[targetRef][0].getNode().width() >=
            width - cornerWidth
          ) {
            this.$refs[targetRef][0].getNode().width(width - cornerWidth);
            this.$refs[targetRef][0]
              .getNode()
              .height(((width - cornerWidth) / baseWidth) * baseHeight);
          }
          if (this.$refs[targetRef][0].getNode().height() >= cornerHeight) {
            this.$refs[targetRef][0].getNode().height(cornerHeight);
            this.$refs[targetRef][0]
              .getNode()
              .width((cornerHeight / baseHeight) * baseWidth);
          }
        }
        if (targetType == "floor") {
          if (this.$refs[targetRef][0].getNode().width() >= width) {
            this.$refs[targetRef][0].getNode().width(width);
            this.$refs[targetRef][0]
              .getNode()
              .height((width / baseWidth) * baseHeight);
          }
          if (this.$refs[targetRef][0].getNode().height() >= height) {
            this.$refs[targetRef][0].getNode().height(height);
            this.$refs[targetRef][0]
              .getNode()
              .width((height / baseHeight) * baseWidth);
          }
        }
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

    //DELETE artwork

    askDeleteConfirmation() {
      this.$emit("askDeleteConfirmationEvent");
    },
    deleteArtwork() {
      this.hideToolsFrame();
      console.log("deletartwork method in exposition.vue");
      var deletedArtwork = this.findArtworkById(this.iconsConfig.target);
      console.log(deletedArtwork.name);

      //whithout type info in artwork
      const id = this.iconsConfig.target;
      var index = this.artworks.findIndex((x) => x.id == id);
      if (index != -1) {
        deletedArtwork = this.artworks.splice(index, 1)[0];
      } else {
        deletedArtwork = undefined;
      }

      this.$emit("deleteArtworkEvent", { deletedArtwork: deletedArtwork });
    },
    openArtworkModal() {
      console.log("exposition.vue open artwork modal");
      var artwork = this.artworks.find((x) => x.id == this.iconsConfig.target);

      console.log(artwork);
      this.$emit("openArtworkModalEvent", { artwork: artwork });
    },
    findArtworkById(id) {
      var index = this.artworks.findIndex((x) => x.id == id);
      return this.artworks[index];
    },
  },
  created() {},
  mounted() {
    console.log("window and document.document element");
    console.log(screen.height);
    window.addEventListener("resize", this.fitStageIntoParentContainer);

    this.fitStageIntoParentContainer();

    //initialize background
    //add backgound:

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
      name: "rightWall",
      color: "white",
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
      name: "leftWall",
      color: "white",
      closed: true,
    });

    //INIT WATERMARK

    var image = new Image();
    image.src = require("@/assets/watermark.png");

    this.watermark = {
      x: 0,
      y: 0,
      image: image,
      width: totalWidth,
      height: totalHeight,
      opacity: 1,
      scaleX: relativeSizeOfContent,
      scaleY: relativeSizeOfContent,

      listening: false,
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

    // DEPRECATED CALL TO API. Now in game.vue
    /*   console.log("exposition.vue api call");
    api.getArtworks().then((artworks) => {
      this.disponibleImages = artworks;
      console.log(this.disponibleImages);
    }); */
    /*     axios
      .get("http://yannbaizid.fr/yann/lizellba/getartwork.php")
      .then((response) => {
        this.disponibleImages = response.data;
        console.log(this.disponibleImages);
      }); */
    this.fitStageIntoParentContainer();
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
#background {
  position: fixed;
  top: 0px;
  left: 0px;
  width: 100%;
  height: 100%;
}

#testbutton {
  position: fixed;
  bottom: 20px;
  right: 200px;
  z-index: 8;
}
</style>
