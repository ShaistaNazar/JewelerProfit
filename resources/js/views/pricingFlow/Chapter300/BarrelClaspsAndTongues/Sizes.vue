<template>
    <div class="container pb-5">
        

    <div class="envelop_container text-center"> 


      <div class="row">
            <div class="col-lg-3 text-left">
                <b-button :variant="variant" class="round-border backBtn" @click="$router.go(-1)"> 
                    <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                </b-button>
            </div>
        </div> 

        <h3 class="pb-5 text-uppercase  pt-3 mt-5">{{subHeading}}</h3>

        
        <div class="container"> 
            <div class="row mb-5">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'stones_quaintity'}" >{{sizes[0]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'stones_quaintity'}" >{{sizes[1]}}</router-link></li>
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'stones_quaintity'}" >{{sizes[2]}}</router-link></li> 
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'stones_quaintity'}" >{{sizes[3]}}</router-link></li> 
                    <li><router-link class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" :to="{name:'stones_quaintity'}" >{{sizes[4]}}</router-link></li>  
                  </ul>
                </div>
              </div>
              <div class="col-lg-3">
                 
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
        sizes:[
          "7.5 x 2.5mm ",
          "8.0 x 2.0mm",
          "8.5 x 2.0mm", 
          "8.5 x 3.0mm", 
          "8.5 x 4.0mm", 
        ],
        subHeading:"Choose Width" 
      }
    }
  }
</script>    