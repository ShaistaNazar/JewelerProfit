<template>


<div class="container pb-5">
        


        <div class="row">
          <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <div class="web-camera-container pictureForm p-4">
              <div class="camera-button d-flex align-items-center">
                  <button type="button" class="btn round-border shadow-lg btn-success ml-2 mr-2" :class="{ 'is-primary' : !isCameraOpen, 'is-danger' : isCameraOpen}" @click="toggleCamera">
                    <span v-if="!isCameraOpen">Open Camera</span>
                    <span v-else>Close Camera</span>
                  </button>
                  <strong class="import_btn btn round-border shadow-lg btn-success ml-2 mr-2 pl-3 pr-3">
                    <input type="file" accept="image/*" @change="previewImage" class="form-control-file" id="my-file">
                    Import from Computer
                  </strong>
              </div>
              
              <div v-show="isCameraOpen && isLoading" class="camera-loading">
                <ul class="loader-circle">
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </div>
              
              <div v-if="isCameraOpen" v-show="!isLoading" class="camera-box" :class="{ 'flash' : isShotPhoto }">
                
                <div class="camera-shutter" :class="{'flash' : isShotPhoto}"></div>
                  
                <video v-show="!isPhotoTaken" ref="camera" :width="450" :height="337.5" autoplay></video>
                
                <canvas v-show="isPhotoTaken" id="photoTaken" ref="canvas" :width="450" :height="337.5"></canvas>
                
              </div>
              
              <div class="d-flex align-items-center">
                <div v-if="isCameraOpen && !isLoading" class="camera-shoot ml-2 mr-2">
                <button type="button" class="button" @click="takePhoto">
                  <img src="https://img.icons8.com/material-outlined/50/000000/camera--v2.png">
                </button>
              </div> 
              </div>
              
              
              <div v-if="isPhotoTaken && isCameraOpen" class="camera-download">
                <a id="downloadPhoto" download="my-photo.jpg" class="btn round-border shadow-lg btn-success" role="button" @click="downloadImage">
                  Download
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-3"></div>
        </div>

    </div>

</template>

<style lang="scss" scoped>

.pictureForm   { background-color: #333c73; min-height: 200px;}

.web-camera-container {
  margin-top: 2rem;
  margin-bottom: 2rem;
  padding: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center; 
  border-radius: 4px;
  width: 100%;

  
  .camera-button {
    margin-bottom: 2rem;
  }

  .import_btn {position: relative; cursor: pointer;}
  .import_btn input {position: absolute; left: 0px; top: 0px; z-index: 0; width: 100%; height: 100%; opacity: 0;cursor: pointer;}
  
  .camera-box {    
    .camera-shutter {
      opacity: 0;
      width: 450px;
      height: 337.5px;
      background-color: #fff;
      position: absolute;
      
      &.flash {
        opacity: 1;
      }
    }
  }
  
  .camera-shoot {
    margin: 1rem 0;
    
    button {
      height: 60px;
      width: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 100%;
      
      img {
        height: 35px;
        object-fit: cover;
      }
    }
  }
  
  .camera-loading {
    overflow: hidden;
    height: 100%;
    position: absolute;
    width: 100%;
    min-height: 150px;
    margin: 3rem 0 0 -1.2rem;
    
    ul {
      height: 100%;
      position: absolute;
      width: 100%;
      z-index: 999999;
      margin: 0;
    }
    
    .loader-circle {
      display: block;
      height: 14px;
      margin: 0 auto;
      top: 50%;
      left: 100%;
      transform: translateY(-50%);
      transform: translateX(-50%);
      position: absolute;
      width: 100%;
      padding: 0;
      
      li {
        display: block;
        float: left;
        width: 10px;
        height: 10px;
        line-height: 10px;
        padding: 0;
        position: relative;
        margin: 0 0 0 4px;
        background: #999;
        animation: preload 1s infinite;
        top: -50%;
        border-radius: 100%;
        
        &:nth-child(2) {
          animation-delay: .2s;
        }
        
        &:nth-child(3) {
          animation-delay: .4s;
        }
      }
    }
  }

  @keyframes preload {
    0% {
      opacity: 1
    }
    50% {
      opacity: .4
    }
    100% {
      opacity: 1
    }
  }
}

</style>


<script>
export default {
    data() {
        return  {
        }
    },
    methods: {

 previewImage(event) { 

      var input = event.target;
      if (input.files) { 
        this.image=input.files[0];
        alert(this.image);
        reader.readAsDataURL(input.files[0]);
      }

    },


    toggleCamera() {
      if(this.isCameraOpen) {
        this.isCameraOpen = false;
        this.isPhotoTaken = false;
        this.isShotPhoto = false;
        this.stopCameraStream();
      } else {
        this.isCameraOpen = true;
        this.createCameraElement();
      }
    },
    
    createCameraElement() {
      this.isLoading = true;
      
      const constraints = (window.constraints = {
				audio: false,
				video: true
			});


			navigator.mediaDevices
				.getUserMedia(constraints)
				.then(stream => {
          this.isLoading = false;
					this.$refs.camera.srcObject = stream;
				})
				.catch(error => {
          this.isLoading = false;
					alert("May the browser didn't support or there is some errors.");
				});
    },
    
    stopCameraStream() {
      let tracks = this.$refs.camera.srcObject.getTracks();

			tracks.forEach(track => {
				track.stop();
			});
    },
    
    takePhoto() {
      if(!this.isPhotoTaken) {
        this.isShotPhoto = true;

        const FLASH_TIMEOUT = 50;

        setTimeout(() => {
          this.isShotPhoto = false;
        }, FLASH_TIMEOUT);
      }
      
      this.isPhotoTaken = !this.isPhotoTaken;
      
      const context = this.$refs.canvas.getContext('2d');
      context.drawImage(this.$refs.camera, 0, 0, 450, 337.5);
    },
    
    downloadImage() {
      const download = document.getElementById("downloadPhoto");
      const canvas = document.getElementById("photoTaken").toDataURL("image/jpeg")
    .replace("image/jpeg", "image/octet-stream");
      download.setAttribute("href", canvas);
    }
  }
}
</script>
