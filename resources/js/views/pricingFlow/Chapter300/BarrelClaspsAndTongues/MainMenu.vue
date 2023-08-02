<template>
    <div class="container pb-5"> 

    <div class="envelop_container text-center "> 

        <div class="row">
            <div class="col-lg-3 text-left">
                <b-button              
                class="round-border backBtn" @click="$router.go(-1)"> 
                    <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                </b-button>
            </div>
        </div> 

        <h3 class="pb-5 pt-3 mt-5 text-uppercase">{{subHeading}}</h3>

        <div class="container">  
          <div class="row cardSetting mb-5">
            <div v-for="item in menu" :key="item.id" class="col-md-3">
              <div class="card">
                <button class="card-img-top" @click="chooseClasp(item.major_item)" ><img :src="item.Images.FullUrl" class="" alt="..." /></button>
                <div class="card-body">
                  <p class="card-text">{{item.major_item}}</p>
                </div>
              </div>
            </div> 
          </div> 
        </div>        
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'; 
  export default {
    data() {
      return {
        selected: [], // Must be an array reference!  
        subHeading:"Clasps List",
        menu:[]
      }
    },
    mounted(){
      this.getMenu();
    },
    methods:{

      ...mapActions('dataStore', [ 'getFlowOptions','addToSelections','setSelectedFlow']), 

      /**
      * Fetch 300 menu clasps
      */
      getMenu(value) {
          axios.get("/api/get-all-clasps").then(({
              data
          }) => this.menu = data);
      },

      // addToSelections

      chooseClasp(major_item) {

        this.setSelectedFlow();
        var obj = {};
        var current = "major_item";
        obj[current] = major_item;
        this.addToSelections(obj);
        this.getFlowOptions(current);

      },
    },
  }
</script>    
<style scoped>

.cardSetting .card {border: 0px; background-color: #333c73; cursor: pointer; margin-bottom: 20px;}
.cardSetting .card button { display: block; width: 100%; overflow: hidden; transition: all 0.3s ease; position: relative; border: 0px; }
.cardSetting .card button:after {   content: ''; position: absolute; left: 0; top: 0px; width: 100%; height: 100%;background-color: #fff; opacity: 0;  
-ms-transition: all 0.3s ease; 
-o-transition: all 0.3s ease;
-webkit-transition: all 0.3s ease;}

.cardSetting .card button img{ display: block; width: 100%;  -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease; 
    -o-transition: all 0.3s ease;
    -webkit-transition: all 0.3s ease;}

.cardSetting .card:hover button img{ transform: scale(1.1);}

.cardSetting .card:hover button:after { opacity: .3;  }

.cardSetting .card-body { padding: 15px 10px;}
.cardSetting .card-text { font-size: 15px;}

</style>