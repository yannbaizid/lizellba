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

  async getGalleryPhotos(photoType,currentPage,limit) {
    return axios.get("getgalleryphotos.php", { params: {typeId : photoType,page: currentPage,limit: limit} }).then((response) => {
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

  async getGalleryPhotoIdRange(photoType) {
    if (photoType==0) {
      return axios.get("getgalleryphotos.php", { params: { function: 'idrange' } }).then((response) => {
        return response.data;
      });

    }
    else {
      return axios.get("getgalleryphotos.php", { params: { function: 'idrange',typeId : photoType } }).then((response) => {
        return response.data;
      });
    }
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