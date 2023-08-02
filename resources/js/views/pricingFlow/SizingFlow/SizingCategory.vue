<template>
    <div class="container pb-5">

    <div class="envelop_container text-center pt-5 mt-5"> 

        <h3 class="pb-5 text-uppercase">{{subHeading}}</h3>

        
        <div class="container"> 
            <div class="row mb-5">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'choose-colors'}" >Regular Ring</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'choose-classified-karat'}" >10kt or 14kt Gold Class Ring</router-link></li> 
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'choose-size'}" >Stretch Gold Plain Band</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'choose-size'}" >Two Tune Wedding Band</router-link></li>  
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
        subHeading:"14kt / 18kt" ,
        infoNote:"We are unable to size ANY faux metal rings. ie, Silidium"
      }
    }
  }
</script>    