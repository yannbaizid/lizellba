import axios from 'axios'


export default {
   async  getArtworks() {
        return axios
            .get("getartwork.php")
            .then((response) => {
                console.log('api.js');
                console.log(response);
                return response.data;
            });
    },

    async getRandomQuestion() {
      console.log('getrandomquestion');
        return axios.get("getquestion.php").then((response) => {
            return response.data;
          });
    },

    async saveExpoImage(imgURL, curatorName,expoName) {
        return axios.post("saveExpoImage.php", {
          image: imgURL,
          curatorName: curatorName,
          expoName: expoName,
        })
    
    },

    async getGalleryPhotos () {
        return axios.get("getgalleryphotos.php").then((response) => {
               console.log('api getgalleryphotos ok' );
               console.log(response.data);
               return response.data;
          });
    },

    async getGalleryPhoto (id) {
        return axios.get("getgalleryphotos.php?id="+id).then((response) => {
            return response.data;
       });
 },

}