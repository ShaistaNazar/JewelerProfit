<template>
    <div class="container pb-5"> 

    <div class="envelop_container text-center pt-5 mt-5"> 

        <!-- <h3 class="pb-5 text-uppercase">{{subHeading}}</h3> -->

        
        <div class="container"> 
            <div class="row mb-5">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:''}" >{{stones[0]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:''}" >{{stones[1]}}</router-link></li> 
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:''}" >{{stones[2]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:''}" >{{stones[3]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:''}" >{{stones[4]}}</router-link></li>    

                  </ul>
                </div>
              </div>
              <div class="col-lg-3">
                 
              </div>
            </div>


            <div class=" mt-5 mb-5" :class="$mq">
                <div class="bg-lightblue no-border text-small text-left d-inline-flex align-items-center justify-content-center flex-nowrap">
                <div  class="my-auto mr-3">
                    <b-icon icon="info-circle-fill" variant="light"></b-icon>
                </div>
                <small>
                    {{infoNote}}
                </small>
                </div>
            </div>
 
        </div>





    </div>

    </div>
</template>
<script>
  export default {
    data() {
      return {
        selected: [], // Must be an array reference!   
        stones:[
          "14kt Yellow",
          "14kt Rose", 
          "14kt White",
          "18kt Yelow",
          "18kt White"
        ],
        subHeading:"Choose Size",
        infoNote:"Platinum available, call vendor"

      }
    }
  }
</script>    