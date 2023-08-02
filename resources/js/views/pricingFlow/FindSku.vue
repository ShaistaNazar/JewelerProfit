<template>
  <div class="">
    <div class="envelop_container text-center">
        <div class="container"> 
          <h4 class="mb-0 text-uppercase tittle_highlight">{{subHeading}}</h4>
            <div class="row"> 
              <div class="col-lg-12">
                <div class="sett_stone_detail text-left">
                    <div class="p-0 mt-4 mt-lg-0 pt-4 ">
                      <div class=""  v-if="isHidden">
                        <div class="alert alert-danger" role="alert">
                          Under Construction!
                          <b class="alertClose"   v-on:click="isHidden = false"><b-icon icon="x-square-fill" aria-hidden="true"></b-icon></b>
                        </div>
                      </div>
                    <!-- <div class="d-block text-right pb-3">
                      <button data-v-5f61a64d="" type="button" class="btn round-border shadow-lg btn-success"  v-on:click="isHidden = true">
                          Import from Favorites
                      </button>
                    </div> -->
                    <div class="row pb-3">
                        <div class="col-lg-3 text-left">
                            <b-button class="round-border backBtn" @click="$router.go(-1)"> 
                                <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                            </b-button>
                        </div>
                    </div>
                      <div class="my_collapse_bg round-border  mb-3">
                        <label class="round-border pointer my_collapse" @click="visible_find_sku = !visible_find_sku;"> 
                          <small>
                          Find SKU
                          </small> 
                          <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                        </label> 
                        <b-collapse id ='collapse-find-sku' class="" v-model="visible_find_sku">
                        <div class="collaps_setting"> 
                            <div class="">
                               <div class="my_collapse_bg round-border  mb-3" v-for="(chapter_category,category_index) in chapters" :key="category_index">
                                  <label class="round-border pointer my_collapse" v-b-toggle="'collapse-'+category_index"> 
                                    <small>
                                        {{
                                          category_index.split('_')
                                          .map((word) => word[0].toUpperCase()
                                          + word.slice(1).toLowerCase())
                                          .join(' ')
                                        }}
                                    </small><b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                                  </label> 

                                  <b-collapse :id="'collapse-'+category_index" class="">
                                  <div class="collaps_setting"> 
                                      <div class="list_setting addHover"> 
                                         <ul>
                                           <li v-for="(chapter,chapter_index) in chapter_category" :key="chapter_index">
                                              <button class="btn round-border btn-light my_collapse_bg  mb-4 btn-lg btn-block pointer" 
                                              :disabled="!(chapter_index == '100' || chapter_index == '200' || chapter_index == '300' ||
                                              chapter_index == '200' || chapter_index == '800' || chapter_index == '1300' || chapter_index == '1200' ||
                                              chapter_index == '700'|| chapter_index == '900' || chapter_index == '500' || chapter_index == '1000' ||
                                              chapter_index == '400' || chapter_index == '600' || chapter_index == '1100')" 
                                              @click="getChapterFlow(chapter_index,chapter)">{{chapter_index}} - <small> {{chapter}} </small></button>
                                           </li>
                                          </ul>
                                      </div>
                                  </div>
                                  </b-collapse>
                                </div> 
                            </div>
                        </div>
                      </b-collapse> 
                      </div>
                      <!-- <div class="my_collapse_bg round-border mb-3">
                          <label class="round-border pointer my_collapse" v-on:click="isShow = !isShow;"> 
                            <small>Search Sku
                             </small>  
                            <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                          </label>
                          <div class="myForn"  v-if="!visible_find_sku && isShow"> 
                            <form class="d-flex collaps_setting">
                              <div class="form-group"> 
                                  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Search" v-model="sku"> 
                              </div>  
                              <button type="submit" class="btn round-border shadow-lg btn-success ml-3" @click="searchSKU()">Search</button>
                            </form>
                          </div>
                      </div> -->
                      </div> 
                      <!-- <div class="text-center">
                        <button type="submit" class="btn round-border shadow-lg btn-success "  @click="findSKu()">Find Sku</button>
                      </div> -->
                  </div>
                  <!-- <ul class="list-unstyled">
                    <li>
                      <button v-on:click="isShow = !isShow" class="btn btn-light round-border  mb-4 btn-lg btn-block pointer">Search Sku</button></li>                      
                    <li><button class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" @click="findSKu()">Find Sku</button></li> 
                  </ul> -->
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
        radio_options: [], 
        disabledLink:true,
        subHeading:"FIND SKU" ,
        isShow: true, 
        showCollapse:true, 
        visible: false,
        sku:null,
        chapters:{},
        image_menu_chapters:[],
        visible_find_sku:true,
        visible_search_sku:false,
        isHidden: false,
        
      }
    },
    mounted(){

    this.getChapters();

    },
    methods:{
      ...mapActions('dataStore', ['fetchFlow','setSelectedChapter','addExtraLabor','setSelectedProcedure','resetExtraWorkDetailsStructure','addStoneWorkStatus',
                                  'getEnvelopeNumbers','getFlowOptions','addProcedureDetailsToSelections','setExtraWorkFlowBasicObjectStructure','setPriceCriteriaItem',
                                  'addProcedureDetailsToNextOptions','setWeldingTechnology','setSelectedChapterHeading','setRepairID','setSelectedFlow']), 

      // findSKu(){
      //   this.$router.push({
      //     name: 'list-of-job'
      //   });

      searchSKU()
      {

        if(this.sku){
        
          this.setGellerSKU(this.sku);
          this.$router.push({name:'description-of-item'}).catch(()=>{});
        
        }

      },
      getChapterFlow(chapter_index,chapter) 
      {
        // 
        var state = this.$store.state.dataStore;
        this.setSelectedChapter([chapter_index,chapter,1]);
        
        this.setRepairID(`${Math.floor(Math.random() * 900) + 100}-${Math.floor(Math.random() * 900) + 100}-${Math.floor(Math.random() * 900) + 100}`);
        
        this.resetExtraWorkDetailsStructure();
        if(Object.keys(state.extra_work_details).length === 0)
        {
          console.log('set selected should be called');
          this.setSelectedProcedure(1);
          this.addProcedureDetailsToSelections();  // delete previous selectioin and starting from very start
          this.addProcedureDetailsToNextOptions(); // delete previous next options and starting from very start
        }

        // check if chapter is dependency itself
        var stone_dependency_exists = (chapter_index == state.stone_chapter[0] );
        var soldering_dependency_exists = (chapter_index == state.soldering_chapter[0] );
        var finishing_stringing_dependency_exists = (chapter_index == state.stringing_chapter[0] );
        if(stone_dependency_exists)
        {
          this.addStoneWorkStatus('require_stone_work');
          this.setExtraWorkFlowBasicObjectStructure('stone');
        }
        // if(!(stone_dependency_exists))
        // {
          // it should only call if cycle is not been reset.
          // if(chapter_index !== '1300')
          // {
            
        //     if( this.customer_email){
        //     if(this.selected_rush)
        //     this.setIsRush(this.selected_rush);
        //     if(!this.is_selected_envelope_one)
        //     {
        //       this.shallWeDuplicateTheCustomer(this.$store.state.dataStore.shall_we_duplicate_customer);
        //       this.allowEnvelopes(this.$store.state.dataStore.requested_envelopes);
        //     }
        //     this.fetchFlow({chapter:this.$store.state.dataStore.selectedChapter}).then(response => {
        //     this.getFlowOptions();
        //   },error =>{
        //   });
        // }else{
        //     this.showAlert(['Please select the customer first.', "danger"]);
        //     this.$emit('showAlert',['Please select the customer first.','danger']);
        // }
        //   }
        //   else
        //   {
            this.fetchFlow({chapter:this.$store.state.dataStore.selectedChapter}).then(response => {
            this.setSelectedFlow('reset');
            this.$store.commit('dataStore/setPriceCriteriaItem','');
            this.getFlowOptions();
          },error =>{
          });
          // }
          

          // // clearing selections and starting from the very start 
          // if(state.selectedChapter in state.selections && 
          // "procedure_details_"+state.selectedProcedure in state.selections[state.selectedChapter])
          // {
          //   for (const prop of Object.getOwnPropertyNames(state.selections[state.selectedChapter])) 
          //   {
          //     delete state.selections[state.selectedChapter][prop];
          //   }
          // }          

          // below code is useless as getFlowOptions will call flow-option sccreen and control will not return here afterwards
          // // if not main menu with images
          // if(this.image_menu_chapters.indexOf(chapter_index) !== -1)
          // {
          //   this.$router.push({name:'main-menu'});
          // }
          // else
          // {
          //   // this.$router.push({ path: `/signup` }).catch(()=>{});
          //   this.$router.push({name:"flow-option",query: { chapter: state.selectedChapter }}).catch(()=>{});
          //   // this.$router.push({name:"flow-option",params: { chapter: state.selectedChapter }}).catch(()=>{});
          // }
        // }
        // else
        // {
          // first 700 is choosen as selected chapter and then stone work is enabled 
          // so that stone and soldering details screen is worked as expected on conditinos 
          // this.addExtraLabor('stone');
          // if(stone_dependency_exists)
          // {
          //   this.addStoneWorkStatus('require_stone_work');
          //   this.setExtraWorkFlowBasicObjectStructure('stone');
          // }
          // if(soldering_dependency_exists)
          // {
          // this.setExtraWorkFlowBasicObjectStructure('soldering');
          // }
          // if(finishing_stringing_dependency_exists)
          // {
          // this.setExtraWorkFlowBasicObjectStructure('finishing');
          // }
          // this.$router.push("/stone-soldering-details").catch(()=>{});  
        
      },
      getChapters(){

            // this.setLoader(true);
            var token = localStorage.getItem("token");
            axios
            .get(`/api/get-chapters`, {
            headers: {
                Authorization: "Bearer " + token,
            },
            })
        .then(response=>{
          var chapters = response.data.data.chapters; 
          if(Object.values(chapters).length == 0)  
          {
            this.getChapters();
          }
          var image_menu_chapters = response.data.data.image_menu_chapters;   
          this.chapters = chapters; 
          this.image_menu_chapters = image_menu_chapters;
        }).catch((error) => {
            this.getChapters();
        });
      }
    }
  }
</script>  
<style scoped> 
.btnDisable {
    pointer-events: none;
    background: #f8f8f8a8 !important;
    color: #000 !important;
}


</style>