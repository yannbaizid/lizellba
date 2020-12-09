<template>
  <v-stage :config="configKonva">
    <v-layer id="background">
      <v-line
        v-for="(poly, index) in backgroundPolys"
        v-bind:key="index"
        :config="poly"
      ></v-line>
    </v-layer>
    <v-layer id="wall">
      <v-image
        v-for="(image, index) in wallArtworks"
        v-bind:key="index"
        :config="image.config"
      ></v-image>
    </v-layer>
    <v-layer id="floor">
      <v-image
        v-for="(image, index) in floorArtworks"
        v-bind:key="index"
        :config="image.config"
      ></v-image>
    </v-layer>
  </v-stage>
</template>

<script>
import axios from "axios";
const width = 900;
const height = 700;

export default {
  name: "Exposition",
  props: {},
  data() {
    return {
      configKonva: {
        width: width,
        height: height,
      },
      wallArtworks: [],
      floorArtworks: [],
      disponibleImages: [],
      backgroundPolys: [],
      width: width,
      height: height
    };
  },

  methods: {
    testEvent: function (text) {
      console.log(text);
    },
    addArtwork(text) {
      console.log(text+" , method addartwork in exposition component fired from app.vue");

      //DEBUT DE ADD ARTWORK WORK IN PROGRESS

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
          width: 100,
          height: 100,
          draggable: true,
          skewY: 0,

          name: "konva" + artwork.id,
        };
        image.onload = () => {
          console.log("image:"+image.src+" loaded");
          artwork.config.height=image.height/image.width*100;
          if (artwork.type == "peinture") {
            // set image only when it is loaded
            this.wallArtworks.push(artwork);
          } else {
            this.floorArtworks.push(artwork);
          }
        };
        /*
        console.log(this.imgLink + artwork.src);

        var image = new Image();
        image.src = this.imgLink + artwork.src;
        this.images.push(image);

        if (image.width < image.height) {
          imagewidth = 200;
          imageHeight = image.height / image.width * 200;
        }
        else {
          imageHeight = 200;
          imagewidth = (image.width / image.height) * 200;
        }



        var konvaImage = new Konva.Image({
          x: 3 * this.width / 5,
          y: this.height / 4,
          image: this.images[this.images.length - 1],
          width: imagewidth,
          height: imageHeight,
          draggable: true,
          skewY: 0,
  
          name: 'konva' + artwork.id
        });

        this.konvaImages.push(konvaImage);

        var lastindex = this.konvaImages.length - 1;
        console.log('last index of' + this.konvaImages + ' =' + lastindex + ' test dacces a propriete image.src' + this.konvaImages[lastindex].image().src + ' name' + konvaImage.name());
        if (artwork.type == 'sculpture') {

          konvaImage.getTransform().rotate(40);
          konvaImage.y(this.height / 2);
          konvaImage.on('dragmove', () => {
            console.log('testscale' + konvaImage.y() / (this.height / 2));

            this.layer.draw();

            if (konvaImage.y() + konvaImage.height() - 15 < (this.height / 2)) {
              console.log('lOl');

              konvaImage.y(this.height / 2 - this.konvaImages[lastindex].height() + 15);
            }
          });
          this.floorLayer.add(this.konvaImages[this.konvaImages.length - 1]);
          this.floorLayer.batchDraw();
        }
        this.konvaImages[lastindex].on('dragstart', function () { 
          this.moveToTop();
        } );
        this.konvaImages[lastindex].on('click', function () { 
          this.moveToTop();
        } );
        if (artwork.type == 'peinture') {
          this.konvaImages[lastindex].on('dragmove', () => {

            var x = this.konvaImages[lastindex].x();
            var y = this.konvaImages[lastindex].y();

            var diffX = event.clientX - x;
            var diffY = event.clientY - y
            console.log('skew' + this.konvaImages[lastindex].skewY());
            if (this.konvaImages[lastindex].skewY() != -0.5 && x <= this.width / 3) {
              this.konvaImages[lastindex].x(this.width / 3);
              console.log('no biais' + this.konvaImages[lastindex].image().src);

            }
            if (this.konvaImages[lastindex].skewY() == -0.5 && x + this.konvaImages[lastindex].width() >= (this.width / 3)) {
              this.konvaImages[lastindex].x((this.width / 3) - this.konvaImages[lastindex].width());
              console.log('biais' + this.konvaImages[lastindex].image().src);

            }


            if ((x + this.konvaImages[lastindex].width()) < (this.width / 3)) {
              this.konvaImages[lastindex].skewY(-0.5);
              console.log('essaie rajout biais : ' + this.konvaImages[lastindex].image().src);

            }
            else if (x > this.width / 3) {
              this.konvaImages[lastindex].skewY(0);

              console.log('trankeuls' + this.konvaImages[lastindex].image().src);
            }


          });
          this.layer.add(this.konvaImages[this.konvaImages.length - 1]);
          this.layer.batchDraw();
  
        }


 

        image.onload = () => {
          this.stage.draw();
        };
        image.src = this.imgLink + artwork.src;
*/
      } else {
        alert("y a plus rien");
      }

      //END OF ADD ARTWORK WORK IN PROGRESS
    },
  },
  created() {},
  mounted() {
    //initialize background

    //add wall:
    this.backgroundPolys.push({
      points: [
        -5,
        (9 * height) / 11,
        width / 3,
       2*height / 3,
       width+5,
       2*height / 3,
        width +5,
        height+5,
        -5,
        height+5,
      ],
      fill: '#E0E0E0',
      stroke: 'black',
      strokeWidth: 2,
      closed: true,
    });
    this.backgroundPolys.push({
        points: [
        width / 3,
       2*height / 3,
        width/3,
       -5
      ],
      stroke: 'black',
      strokeWidth: 2,
      closed: false,
    })
    console.log("background plys"+this.backgroundPolys);

    axios.get("http://localhost/testphp/getartwork.php").then((response) => {
      this.disponibleImages = response.data;
      console.log(this.disponibleImages);
    });
  },
};
</script>


<style scoped lang="scss">
#stage {
  background-color: grey;
}
</style>
