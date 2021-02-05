import axios from 'axios'


export default {
  async getArtworks() {
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
  async getQuestions() {
    console.log('getAllQuestions');
    return axios.get("questionmanager.php").then((response) => {
      return response.data;
    });
  },

  async saveExpoImage(imgURL, curatorName, expoName) {
    return axios.post("saveExpoImage.php", {
      image: imgURL,
      curatorName: curatorName,
      expoName: expoName,
      typeId: 1,
      pwd: 'Twin!Peaks!S3'
    })

  },

  async getGalleryPhotos() {
    return axios.get("getgalleryphotos.php").then((response) => {
      console.log('api getgalleryphotos ok');
      console.log(response.data);
      return response.data;
    });
  },

  async getGalleryPhoto(id) {
    return axios.get("getgalleryphotos.php?id=" + id).then((response) => {
      return response.data;
    });
  },

  async getGalleryPhotoIdRange() {
    return axios.get("getgalleryphotos.php", { params: { function: 'idrange' } }).then((response) => {
      return response.data;
    });
  },


  async getNextGalleryPhotos(limit, page) {
    return axios.get("getgalleryphotos.php", { params: { limit: limit, page: page } }).then((response) => {
      return response.data;
    });
  },
  async getPreviousGalleryPhoto(id) {
    return axios.get("getgalleryphotos.php", { params: { function: 'prev', id: id } }).then((response) => {
      return response.data;
    });
  },
  async getNexGalleryPhoto(id) {
    return axios.get("getgalleryphotos.php", { params: { function: 'next', id: id } }).then((response) => {
      return response.data;
    });
  },

}