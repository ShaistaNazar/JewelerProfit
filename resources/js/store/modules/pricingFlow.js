import { defaultsDeep, findKey, reject } from 'lodash';
import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
import router from '../../routes.js'

const initialState = {

  chapterFlow: [], // should be clear
  secondaryChapterFlow:[],
  jewelerId:null,// should be clear
  customer_id:null, //
  selectedFlow:0,// should be clear
  secondarySelectedFlow:0,// should be clear
  selectedChapter:null,// should be clear
  selectedDependentInProgressChapter:null,// should be clear
  selections:{},
  check_and_tighten_selections:{},
  next_options:{},
  check_and_tighten_next_options:{},
  show_modal:false,// should be clear
  picklist_exists:false,// should be clear
  show_modal_rhodium:false,// should be clear
  picklist:false,// should be clear
  rhodium_plating_status:false,// should be clear
  is_rush:false,// should be clear
  welding_technology:{},
  rhodium_plating:{},
  descriptionOfItem:// should be clear
  {
    item_description: '',
    customer_stated_value: "",
    stones_quality_description: "",
    is_guarranteed: 0,
    promise_date: new Date(Date.now() + 10 * 24 * 60 * 60 * 1000),
    is_qualiteed:0,
    photos:[],
    stones_guarrantee_description:""
  },
  estimateTheProduct:{
    id:null,
    vendor_id:'',
    date_sent:new Date(),
    date_received:new Date(),
    estimated_cost_to:'',
    estimated_cost_from:'',
    retail_price:'',
    work_to_be_performed:'',
    customer_approved_or_declined:'',
  },
  service_id:null,
  if_history_added:false,// should be clear
  items_price_detail:[],
  no_of_items_in_envelope:0,
  shall_we_duplicate_customer:false,
  requested_envelopes:1,
  selected_envelope_number:0,
  envelope_numbers:[],
  ask_furthur_modal:false,
  furthur_item:null,
  descriptions_of_envelope:[],
  current_cycle:1,
  geller_sku:null,// should be clear
  stone_work:'do_not_require_stone_work',        // should be clear
  soldering_work:'do_not_require_soldering_work',// should be clear
  finishing_work:'do_not_require_finishing_work',// should be clear
  stringing_work:'do_not_require_stringing_work',// should be clear
  gemstones_work:'do_not_require_gemstones_work',// should be clear
  price_criteria_item_name:'',
  no_of_price_criteria_item:1,

  // default stone type is not other as its appears as it is in inout field.
  
  extra_work_details:{},// should be clear
 
  stone_chapter:[700,'Stone Work'],
  soldering_chapter:[900,'Solder Work'],
  finishing_chapter:[1200,'Finishing Work'],
  stringing_chapter:[1200,'Stringing Work'],
  heads_and_bezels_chapter:[600,'Heads And Bezels'],
  gemstones_chapter:[1300,'Gem Stones'], 
  pendant_chapter:[800,'Pendants'],
  clasp_chapter:[300,'Clasp'],
  back_and_post_chapter:[400,'Back And Post'],
  extra_work_details:{},// should be clear
  enable_welding_technology:{},
  main_chapter:null,
  selectedChapterHeadings:{},
  customer_details:{},
  OKWith700:false,
  previous_page_on_customer_change:"",
  task_to_be_performed:'',
  isLoading:false,
  shop:{},
  sale_person_id:null,
  does_not_have_laser_modal:false,
  question: -1,
  set_the_quantity:{},
  quantity:{},
  chapters_not_including_welding:["500","1100","700"],
  interlink_quantity_in_chapter_flow:null,
  interlink_quantities : [],
  interlink_quantity_for_individual_items:[],
  stone_stringing_soldering_handled:false,
  interlink_quantity_values:{},
  interlinked_option:1,
  appraisal_details:{},
  complication_surcharges:[],
  two_tone_karats:[],
  vendor_id:null,
  discard_color:false,
  selectedProcedure:1,
  discarded_item_array:[],
  progress_percentage:0,
  extra_labor_chapters:[700,900,1200],
  enable_ask_stone_details_popup:false,
  enable_the_quantity:{},
  enable_require_metal_popup:false,
  enable_require_weight_popup:false,
  required_metal_along_popup:false,
  part_only:false,
  metals:{},
  repair_id:'',
  chapter_1000_metal:'',
  no_of_generated_envelopes:0,
  enable_check_and_tighten:false,
  is_estimated_set:false,
}

const state = {
  chapterFlow: [],
  secondaryChapterFlow:[],
  jewelerId:null,
  customer_id:null,
  selectedFlow:0,
  secondarySelectedFlow:0,
  selectedChapter:{},
  selectedDependentInProgressChapter:null,
  selections:{},
  check_and_tighten_selections:{},
  next_options:{},
  check_and_tighten_next_options:{},
  show_modal:false,
  show_modal_rhodium:false,
  picklist:false,
  rhodium_plating_status:false,
  is_rush:false,
  welding_technology:{},
  rhodium_plating:{},
  descriptionOfItem:// should be clear
  {
    item_description: "",
    customer_stated_value: "",
    stones_quality_description: "",
    is_guarranteed: '',
    is_qualiteed:'',
    promise_date: new Date(Date.now() + 10 * 24 * 60 * 60 * 1000),
    photos:[],
    stones_guarrantee_description:""
  },
  estimateTheProduct:{
    vendor_id:'',
    date_sent:new Date(),
    date_received:new Date(),
    estimated_cost_to:'',
    estimated_cost_from:'',
    retail_price:'',
    work_to_be_performed:'',
    customer_approved_or_declined:'',
  },
  service_id:null, 
  picklist_exists:false,
  if_history_added:false,
  items_price_detail:[],
  no_of_items_in_envelope:0,
  shall_we_duplicate_customer:false,
  requested_envelopes:1,
  selected_envelope_number:0,
  envelope_numbers:[],
  ask_furthur_modal:false,
  furthur_item:null,
  descriptions_of_envelope:[],
  current_cycle:1,
  geller_sku:null,
  stone_work:'do_not_require_stone_work',
  soldering_work:'do_not_require_soldering_work',
  finishing_work:'do_not_require_finishing_work',
  stringing_work:'do_not_require_stringing_work',
  extra_work_details:{},
  price_criteria_item_name:'',
  no_of_price_criteria_item:1,
  stone_chapter:[700,'Stone Work'],
  soldering_chapter:[900,'Solder Work'],
  finishing_chapter:[1200,'Finishing Work'],
  stringing_chapter:[1200,'Stringing Work'],
  heads_and_bezels_chapter:[600,'Heads And Bezels'],
  pendant_chapter:[800,'Pendants'],
  clasp_chapter:[300,'Clasp'],
  back_and_post_chapter:[400,'Back And Post'],
  enable_welding_technology:{},
  main_chapter:null,
  selectedChapterHeadings:{},
  customer_details:{},
  OKWith700:false,
  previous_page_on_customer_change:"",
  task_to_be_performed:'',
  isLoading:false,
  shop:{},
  sale_person_id:null,
  does_not_have_laser_modal:false,
  question: -1,
  set_the_quantity:{},
  quantity:{},
  chapters_not_including_welding:["500","1100","700"],
  interlink_quantity_in_chapter_flow:null,
  interlink_quantities : [],
  interlink_quantity_for_individual_items:[],
  stone_stringing_soldering_handled:false,
  interlink_quantity_values:{},
  interlinked_option:1,
  appraisal_details:{},
  complication_surcharges:[],
  two_tone_karats:[],
  vendor_id:null,
  discard_color:false,
  selectedProcedure:1,
  discarded_item_array:[],
  progress_percentage:0,
  extra_labor_chapters:[700,900,1200],
  enable_ask_stone_details_popup:false,
  enable_the_quantity:{},
  enable_require_metal_popup:false,
  enable_require_weight_popup:false,
  required_metal_along_popup:false,
  part_only:false,
  metals:{},
  repair_id:'',
  chapter_1000_metal:'',
  no_of_generated_envelopes:0,
  enable_check_and_tighten:false,
  is_estimated_set:false,
}

const getters = {

  getFlow: state => () => {
    return state.chapterFlow;
  },
  getSelectedFlow: state => () => {
    return state.chapterFlow[state.selectedFlow];
  },
  getJeweler: state => () => {
    return state.jewelerId;
  },
  getCustomer: state => () => {
    return state.customer_id;
  },
  getselectedChapter: state => () => {
    return state.selectedChapter;
  },
  getSelections: state => () => {
    return state.selections;
  },
  getNextOptions: state => () => {
    return Object.entries(state.next_options);
  },
  getDescriptionOfItem: state => () => {
    return state.descriptionOfItem;
  },
  getServiceId: state => () => {
    return state.service_id;
  },
  getJobConfirmationStatus: state => () => {
    return state.if_history_added;
  },
  getItemsPricingDetails: state => () => {
    return state.items_price_detail;
  },
  getIfPicklistExists: state => () => {
    return state.picklist_exists;
  },
  getEnvelopeItemNumber: state => () => {
    return state.no_of_items_in_envelope;
  },
  getDuplicateCustomerStatus: state => () => {
    return state.shallWeDuplicateTheCustomer;
  },
  getAllowedEnvelopes : state => () => {
    return state.requested_envelopes;
  },
  getNextOption:state => () => {
    return state.chapterFlow[state.selectedFlow + 1];
  },
  allReceiptsGenerated: state => {
    var numOfReceiptsGenerated = state.items_price_detail.map(obj => Object.values(obj))
    .flat()
    .reduce((acc, obj) => {
      if (obj.hasOwnProperty("receipt_generated") && obj.receipt_generated) {
        acc++;
      }
      return acc;
    }, 0); 
    console.log('final v',numOfReceiptsGenerated)
    return numOfReceiptsGenerated;
  },
  getPercentage:state => () => {
    // Track the progress
      var totalStages = 0;
      var currentIndex = 0;

      if(state.selectedChapter == state.main_chapter)
      {
        var totalStages = Object.keys(state.chapterFlow).length;
        currentIndex = state.selectedFlow
      }
      else
      {
        var totalStages = Object.keys(state.secondaryChapterFlow).length;
        currentIndex = state.secondarySelectedFlow
      }

      const progressPercentage = (currentIndex / totalStages) * 100;
      state.progress_percentage = progressPercentage;
      // Display the progress percentage
      console.log(`Progress: ${progressPercentage}%`);
  }

}

const mutations = {

  // reset default state modules by looping around the initialStoreModules
  resetState(state) {
    _.forOwn(initialState, (value, key) => {
        state[key] = _.cloneDeep(value);
    });
  },
  
  setFlow:(state, flow) => (state.chapterFlow = flow),
  setSecondaryFlow:(state, flow) => (state.secondaryChapterFlow = flow),
  setPercentage(state,percentage = null) {
    if(percentage)
    {
      state.progress_percentage = percentage;
    }
    else
    {
      // Track the progress
      var totalStages = 0;
      var currentIndex = 0;

      if(state.selectedChapter == state.main_chapter)
      {
        var totalStages = Object.keys(state.chapterFlow).length;
        currentIndex = state.selectedFlow
      }
      else
      {
        var totalStages = Object.keys(state.secondaryChapterFlow).length;
        currentIndex = state.secondarySelectedFlow
      }

      const progressPercentage = (currentIndex / totalStages) * 100;
      state.progress_percentage = Math.round(progressPercentage);
      // Display the progress percentage
      console.log(`Progress: ${progressPercentage}%`);
    }
  },
  setSelectedFlow(state,selectedFlow) 
  {
    // return new Promise((resolve, reject) => {
    // selectedFlow
    // if forwarrds  > then  increment by one 
    // if backwards  > then  should be decrement
    // will handle with route param independent
    if(!selectedFlow){
      // vuex calling with no option then auto increment its the case when previous next optons are empty
      if(state.main_chapter == state.selectedChapter)
      {
        state.selectedFlow = state.selectedFlow + 1;
      }
      else
      {
        state.secondarySelectedFlow = state.secondarySelectedFlow + 1;
      }
      // when go back karats are being overriden by empty array 
    }else{
      if(selectedFlow == 'reset')
      {
        // state.selectedFlow = selectedFlow;   
        if(state.main_chapter == state.selectedChapter)
        {
          state.selectedFlow = 1; 
        }
        else
        {
          state.secondarySelectedFlow = 1;
        }
        
        // state.selectedFlow = state.selectedFlow + 1;
      }else{

        if(state.main_chapter == state.selectedChapter)
        {
          state.selectedFlow = Number(Object.keys(state.chapterFlow).find(key => state.chapterFlow[key] === selectedFlow)) + 1 
        }
        else
        {
          console.log('new selected flow',Number(Object.keys(state.secondaryChapterFlow).find(key => state.secondaryChapterFlow[key] === selectedFlow)));
          state.secondarySelectedFlow = Number(Object.keys(state.secondaryChapterFlow).find(key => state.secondaryChapterFlow[key] === selectedFlow)) + 1 
        }
      }
    }
    // resolve(true);
  //  }).catch(error => {
  //   reject(error);
  //  });
  },

  setSelectedProcedure(state,selectedProcedure) 
  {
    // return new Promise((resolve, reject) => {
    // selectedFlow
    // if forwarrds  > then  increment by one 
    // if backwards  > then  should be decrement
    // will handle with route param independent
    if(!selectedProcedure)
    {
      // vuex calling with no option then auto increment its the case when previous next optons are empty
      state.selectedProcedure = state.selectedProcedure + 1;
      // when go back karats are being overriden by empty array 
    }
    else
    {
      if(selectedProcedure == 'reset')
      {
        // state.selectedFlow = selectedFlow;   
        state.selectedProcedure = 1; 
        // state.selectedFlow = state.selectedFlow + 1;
      }
      else
      {
        // when options were handled with routing params
        state.selectedProcedure = selectedProcedure 
      }
    }
  },
  setExtraWorkFlowBasicObjectStructure(state,specification)
  {

    /**
     * it will create a basic object for each specification
     */

    // console.log('specification in js',specification)

    // just deleting flow details because deleting whole object can cause disappearing options in stne soldering screen 
    console.log('setExtraWorkFlowBasicObjectStructure for extra_work_details');

    if(state[specification+'_chapter'][0] in state.extra_work_details && 'flow_details' in state.extra_work_details[state[specification+'_chapter'][0]])
    Vue.delete(state.extra_work_details[state[specification+'_chapter'][0]],'flow_details');

    state.extra_work_details[state[specification+'_chapter'][0]] = 
    {
    'is_captured':false,
    'is_capturable':specification == 'stone' ? false : true,
    'specification':specification,
    'enable_ask_each_flow' : false,
    'same_flow_for_each'   : true,
    'no_of_flow_procedures': 1,
    'total_no_of_items'    : 1
    };  // overriden

    var basic_procedure_detail_object = {
      ['procedure_details_1']:{}
    };
    basic_procedure_detail_object['procedure_details_1']['id'] = 1;
    basic_procedure_detail_object['procedure_details_1']['no_of_items'] = 1;
    basic_procedure_detail_object['procedure_details_1']['in_progress'] = true
    basic_procedure_detail_object['procedure_details_1']['is_captured'] = false;
    if(specification == 'stone')
    {
      basic_procedure_detail_object['procedure_details_1']['stone_type'] = 'diamond';
      basic_procedure_detail_object['procedure_details_1']['lower_value_colored_stone'] = false;
    }
    state.extra_work_details[state[specification+'_chapter'][0]] = Object.assign({},state.extra_work_details[state[specification+'_chapter'][0]],{'flow_details':basic_procedure_detail_object});
    // state.extra_work_details[state[specification+'_chapter'][0]] = Object.assign({},state.extra_work_details[[state[specification+'_chapter'][0]]],obj);
    state.extra_work_details = Object.assign({}, state.extra_work_details, {[[state[specification+'_chapter'][0]]]: state.extra_work_details[[state[specification+'_chapter'][0]]]});

  },
  resetExtraWorkDetailsStructure(state,spec)
  {
    if(spec)
    {
      if(spec == 'stone')
      {
        Vue.delete(state.extra_work_details,700);
      }
    }else{
      state.extra_work_details = {};
    }
    
  },
  setNextOption:(state) => (state.selectedFlow = state.selectedFlow + 1),
  enableWeldingTechnology (state,enable_welding_technology) 
  {
    var current_chapter = state.selectedChapter;
    if(typeof current_chapter == 'number')
    var chapter = current_chapter.toString();
    else
    var chapter = current_chapter;
    var welding_exists = false;
    // console.log("welding_technology" in state.chapterFlow,'"welding_technology" in state.chapterFlow');
    if(chapter == state.main_chapter)
    {
      var hasWeldingTechnology = Object.values(state.chapterFlow).includes('welding_technology');
    }else{
      var hasWeldingTechnology = Object.values(state.secondaryChapterFlow).includes('welding_technology');
    }
    if (hasWeldingTechnology) 
    {
      welding_exists = true;
    }
    if((!(state.chapters_not_including_welding.includes(chapter))) && welding_exists)
    {
      // if(current_chapter in state.enable_welding_technology)
      // {
        if(enable_welding_technology !== undefined)
        {
          var procedure_details = {};
          procedure_details = Object.assign({}, procedure_details,{ ["procedure_details_"+state.selectedProcedure]: enable_welding_technology});
          console.log('in welding technology',procedure_details);
          state.enable_welding_technology = Object.assign({}, state.enable_welding_technology, 
          { [chapter]: procedure_details});

          // state.enable_welding_technology[current_chapter]['procedure_details_'+state.selectedProcedure] = enable_welding_technology;  // overriden
        }
        else
        {
          var procedure_details = {};
          procedure_details = Object.assign({}, procedure_details,{ ["procedure_details_"+state.selectedProcedure]: true});
          state.enable_welding_technology = Object.assign({}, state.enable_welding_technology, 
          { [chapter]: procedure_details});
        }
      }
      else
      {
        // if(enable_welding_technology){
          state.enable_welding_technology = Object.assign({}, state.enable_welding_technology,   // created
            { [current_chapter]: false });
        // }else{
        //   state.enable_welding_technology = Object.assign({}, state.enable_welding_technology,   // created
        //     { [current_chapter]: true });
        // }
      }
    
  },
  removeExtraLabor(state,extra_labor)
  {
    if(extra_labor)
    {
      // var current_chapter  = state.selectedChapter;
      // var required_chapter = state[extra_labor + '_chapter'][0];
      // if(current_chapter in state.extra_work_details)
      // {
      //   // console.log('required chapter',required_chapter);
      //   state.extra_work_details[required_chapter] = {'is_captured':false,'specification':extra_labor,'is_required':false};  // overriden
      // }
      // else
      // {
      //   state.extra_work_details = Object.assign({}, state.extra_work_details,   // created
      //     { [required_chapter]: {'is_captured':false,'specification':extra_labor,'is_required':false} });
      // }
      
      // state.finishing_work = 'require_finishing_work';
      // state.stone_work = 'require_stone_work';
      // state.soldering_work = 'require_soldering_work';
      // state.heads_and_bezels_work = 'require_heads_and_bezels_work';
      // state.gemstones_work = 'require_gemstones_work';
      state[extra_labor + '_work'] = 'require_'+extra_labor+'_work';
      // state.extra_labor = {};
    }
  },
  addExtraLabor(state,extra_labor = null) 
  {
    console.log('addExtraLabor called');
    var current_chapter = state.selectedChapter;
    if(extra_labor)
    {
      var current_chapter = state.selectedChapter;
      var required_chapter = state[extra_labor + '_chapter'][0];
      if(current_chapter in state.extra_work_details)
      {
        // console.log('required chapter',required_chapter);
        state.extra_work_details[required_chapter] = {'is_captured':false,'specification':extra_labor,'is_required':false};  // overriden
      }
      else
      {
        state.extra_work_details = Object.assign({}, state.extra_work_details,   // created
          { [required_chapter]: {'is_captured':false,'specification':extra_labor,'is_required':false} });
      }
      // state.finishing_work = 'require_finishing_work';
      // state.stone_work = 'require_stone_work';
      // state.soldering_work = 'require_soldering_work';
      // state.heads_and_bezels_work = 'require_heads_and_bezels_work';
      // state.gemstones_work = 'require_gemstones_work';
      state[extra_labor + '_work'] = 'require_'+extra_labor+'_work';
    }
    else
    {
      // handling stone case calling from flow options in method "handleStoneAndSolderingWork"
    }
  },

  // enableWeldingTechnology:(state,enable_welding_technology) => (state.enable_welding_technology = enable_welding_technology),
  setJeweler:(state, jeweler_id) => (state.jewelerId = jeweler_id),
  setTheCustomer(state, customer_details) 
  {
    if(customer_details)
    {
      state.customer_details = Object.assign({}, state.customer_details, customer_details);
    }
  },
  removeCustomer:(state) => (state.customer_details = {}),
  setSelectedChapter(state,chapter_array)
  {
    if((!state.main_chapter && !chapter_array.length == 3) || (chapter_array.length == 3 && chapter_array[2] == 1))
    {
      state.main_chapter = chapter_array[0];
    }
    state.selectedChapter = chapter_array[0];
    state.selectedChapterHeadings[chapter_array[0]] = chapter_array[1];
  },

  addProcedureDetailsToSelections(state,chapter)
  {
    if(!chapter)
    {
      var chapter = state.selectedChapter;
    }
    if(state.extra_work_details[chapter] && 'flow_details' in state.extra_work_details[chapter])
    {
        state.selections = Object.assign({}, state.selections, 
        {[chapter]: state.selections[chapter]});

        // adding key
        // alert('before interlinking');
        state.selections[chapter] = Object.assign({},state.selections[chapter],{});
        state.selections = Object.assign({},state.selections,{[chapter]: state.selections[chapter]});
        // alert('after interlinking');
        
        // updaing some values
        // state.selections[chapter] = state.extra_work_details[chapter]['flow_details'];

        // updating key
        // no_of_flow_procedures
         
        Object.entries(state.extra_work_details[chapter].flow_details).forEach(
          ([key, procedure_detail]) => {
          // console.log(typeof procedure_detail,'typeof procedure_detail');
          if(typeof procedure_detail ==  'object')
          {
            state.selections[chapter]["procedure_details_"+procedure_detail.id] = Object.assign({}, state.selections[chapter]["procedure_details_"+procedure_detail.id], 
            { 'id': 1});
            state.selections[chapter]['procedure_details_'+procedure_detail.id] = Object.assign({}, state.selections[chapter]['procedure_details_'+procedure_detail.id],
            {'options': {}});
            state.selections[chapter] = Object.assign({},state.selections[chapter],{['procedure_details_'+procedure_detail.id]: state.selections[chapter]['procedure_details_'+procedure_detail.id]});
          }
        });
        state.selections = Object.assign({},state.selections,{[chapter]: state.selections[chapter]});
      }
      else
      {
        // now resetting 
        console.log('now resetting');
        var procedure_details = {};
        procedure_details = Object.assign({}, procedure_details,{ ["procedure_details_"+state.selectedProcedure]: {}});
        procedure_details["procedure_details_"+state.selectedProcedure] = Object.assign({}, procedure_details["procedure_details_"+state.selectedProcedure], 
        { 'id': 1});
        // procedure_details["procedure_details_"+state.selectedProcedure] = Object.assign({}, procedure_details["procedure_details_"+state.selectedProcedure], 
        // { 'no_of_items': 1});
        procedure_details["procedure_details_"+state.selectedProcedure] = Object.assign({}, procedure_details["procedure_details_"+state.selectedProcedure], 
        { 'options': {}});
        // console.log('procedure_details after one adding in selection',procedure_details);
        // state.selections[chapter] = procedure_details;
        state.selections = Object.assign({}, state.selections, 
          { [chapter]: procedure_details});
          Object.entries(state.selections).forEach(
            ([chapter_index, chapter_data]) => {
            // console.log('chapter_data',chapter_index);
            if(chapter_index !== state.selectedChapter)
            {
              Vue.delete(state.selections,chapter_index);
            }
            else
            {
              Object.entries(state.selections[chapter_index]).forEach(
                ([key, procedure_detail]) => {
                // console.log(procedure_detail,key,'key and value');
                if(!(key ==  'procedure_details_1'))
                {
                  Vue.delete(state.selections[chapter],key);
                }
              });
            }
            });
      }
  },
  addProcedureDetailsToRhodiumPlating(state,chapter)
  {
    if(!chapter)
    {
      var chapter = state.selectedChapter;
    }
    // now resetting 
    var procedure_details = {};
    procedure_details = Object.assign({}, procedure_details,{ ["procedure_details_"+state.selectedProcedure]: {}});
    state.rhodium_plating = Object.assign({}, state.rhodium_plating, 
    { [chapter]: procedure_details});

  },
  addProcedureDetailsToPickList(state,chapter)
  {

  },
  addProcedureDetailsToNextOptions(state,chapter)
  {
    if(!chapter)
    {
      var chapter = state.selectedChapter;
    }
    // console.log('extra_work_details',state.extra_work_details);
    if(state.extra_work_details[chapter] && 'flow_details' in state.extra_work_details[chapter])
      {
        state.next_options = Object.assign({}, state.next_options, 
        {[current_chapter]: state.next_options[current_chapter]});

        // adding key
        state.next_options[chapter] = Object.assign({},state.next_options[chapter],state.extra_work_details[chapter]['flow_details']);
        state.next_options = Object.assign({},state.next_options,{[chapter]: state.next_options[chapter]});

        // updaing some values
        // state.next_options[chapter] = state.extra_work_details[chapter]['flow_details'];

        // updating key
        // no_of_flow_procedures
        // 
        Object.entries(state.extra_work_details[chapter].flow_details).forEach(
          ([key, procedure_detail]) => {
          // console.log(typeof procedure_detail,'typeof procedure_detail');
          if(typeof procedure_detail ==  'object')
          {
            // state.next_options[chapter]["procedure_details_"+procedure_detail.id] = Object.assign({}, state.next_options[chapter]["procedure_details_"+procedure_detail.id], 
            // { 'id': 1});
            // state.next_options[chapter]['procedure_details_'+procedure_detail.id] = Object.assign({}, state.next_options[chapter]['procedure_details_'+procedure_detail.id],
            // {'options': {}});
            state.next_options[chapter] = Object.assign({},state.next_options[chapter],{['procedure_details_'+procedure_detail.id]: state.next_options[chapter]['procedure_details_'+procedure_detail.id]});
          }
        });
        state.next_options = Object.assign({},state.next_options,{[chapter]: state.next_options[chapter]});

      }
      else
      {
        var procedure_details = {};
        procedure_details = Object.assign({}, procedure_details, 
        { ["procedure_details_"+state.selectedProcedure]: {}});
        // procedure_details["procedure_details_"+state.selectedProcedure] = Object.assign({}, procedure_details["procedure_details_"+state.selectedProcedure], 
        // { 'id': 1});
        // procedure_details["procedure_details_"+state.selectedProcedure] = Object.assign({}, procedure_details["procedure_details_"+state.selectedProcedure], 
        // { 'no_of_items': 1});
        // procedure_details["procedure_details_"+state.selectedProcedure] = Object.assign({}, procedure_details["procedure_details_"+state.selectedProcedure], 
        // { 'options': {}});
        // console.log('procedure_details after one adding in selection',procedure_details);
        // state.selections[chapter] = procedure_details;
        state.next_options = Object.assign({}, state.next_options, 
        { [chapter]: procedure_details});
        Object.entries(state.next_options).forEach(
        ([chapter_index, chapter_data]) => {
        // console.log('chapter_data',chapter_index);
        if(chapter_index !== state.selectedChapter)
        {
          Vue.delete(state.next_options,chapter_index);
        }
        else
        {
          Object.entries(state.next_options[chapter_index]).forEach(
            ([key, procedure_detail]) => {
            if(!(key ==  'procedure_details_1'))
            {
              Vue.delete(state.next_options[chapter],key);
            }
          });
        }
        });
      }
  },

  addToSelections (state,new_selection) 
  {
    // console.log('new selection');
    // console.log(new_selection);
    var current_chapter = state.selectedChapter;
    if(new_selection)
    {
      // console.log('1');
      // if exists before then override and remove furthur.
      // new code with chapter index
        var coming_key = Object.keys(new_selection)[0];
        // console.log('coming_key',coming_key)
        // console.log('before selection options',state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']);
        _.forOwn(state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'], (value, key) => {
          // console.log('key and value');
          // console.log('key is in add to selections',key);
          // console.log('2');
          if(key == 'no_of_price_criteria_item')
          key = 'price_criteria_item';
          // console.log('value, key', key);
          let selections_key_inchapter_flow = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == key);
          // console.log('selections_key_inchapter_flow',selections_key_inchapter_flow);
          let new_selection_key_inchapter_flow = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == coming_key);
         
          if(typeof selections_key_inchapter_flow == 'string')
          selections_key_inchapter_flow = Number(selections_key_inchapter_flow)

          if(typeof selections_key_inchapter_flow == 'string')
          new_selection_key_inchapter_flow = Number(new_selection_key_inchapter_flow)
        
          if(coming_key != 'no_of_price_criteria_item') //reset the quantity
          {
            if(state.selectedChapter in state.quantity)
            {
              Vue.delete(state.quantity,state.selectedChapter);
            }
            if(state.selectedChapter in state.enable_the_quantity)
            {
              Vue.delete(state.enable_the_quantity,state.selectedChapter);
            }
          }
          
          if(state.selectedChapter == '100' && state.selections[current_chapter]['procedure_details_'+state.selectedProcedure]['options']['major_item'] &&
             state.selections[current_chapter]['procedure_details_'+state.selectedProcedure]['options']['major_item'].toLowerCase() == 'rings' && (key == 'size_now' || key == 'size_to'))
            {
              // determining size_now and size_to
              let ring_size_key_inchapter_flow = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == 'ring_size');
              // console.log('comparison in 100',Number(ring_size_key_inchapter_flow),Number(new_selection_key_inchapter_flow))
              if(Number(ring_size_key_inchapter_flow) > Number(new_selection_key_inchapter_flow)) 
              {
                delete state.selections[current_chapter]['procedure_details_'+state.selectedProcedure]['options'][key];
              }
           }
           if(state.selectedChapter ==  '1000' && key == 'popup')
           {
              console.log('should delete this key now where key is',key);                      
              state.enable_require_metal_popup = false;
           }

          // console.log('selection in keys loop and new selection and key',selections_key_inchapter_flow , new_selection_key_inchapter_flow,key);
          // console.log('3');
          if(selections_key_inchapter_flow)
          {
            if(selections_key_inchapter_flow > new_selection_key_inchapter_flow)
            {
              console.log('selection key comparison',selections_key_inchapter_flow,new_selection_key_inchapter_flow)
              if(key == 'price_criteria_item')
              {
                key = 'no_of_price_criteria_item'
                state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']['no_of_price_criteria_item'] = 1;  
              }
              // if(state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']['size_now'] && current_chapter == '100') // chapter 100 
              // {
              //   state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']['size_now'] = null;
              // }
              // if(state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']['size_to'] && current_chapter == '100') // chapter 100 
              // {
              //   state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']['size_to'] = null;
              // }
              if(key == 'question')
              {
                state.question = -1;  
              }
              delete state.selections[current_chapter]['procedure_details_'+state.selectedProcedure]['options'][key];
              // console.log('deleted and remaings are',key,'---',state.selections[current_chapter]['procedure_details_'+state.selectedProcedure]);
  
            }
          }else{ //mens chapter flow doesnot contain no_of_price_criteria_item
            // console.log('key before deletion',key);
            if(key == 'price_criteria_item')
              {
                delete state.selections[current_chapter]['procedure_details_'+state.selectedProcedure]['options']['no_of_price_criteria_item'];
                state.price_criteria_item_name = '';
              }
              // else{
              //   delete state.selections[current_chapter]['procedure_details_'+state.selectedProcedure]['options'][key];
              // }
          }
          
          let ring_sizing_key_inchapter_flow = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == 'ring_sizing')
          // console.log('ring_sizing_key_inchapter_flow',ring_sizing_key_inchapter_flow,new_selection_key_inchapter_flow)
          if(ring_sizing_key_inchapter_flow > new_selection_key_inchapter_flow) 
          //if sizing ring is greater than coimng key
          {
            commit('setSizeNow', null);
            commit('setSizeTo', null);
          }
          // picklist handling
          let picklist_key_inchapter_flow = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == 'picklist_item_if_needed')
          // console.log('ring_sizing_key_inchapter_flow',ring_sizing_key_inchapter_flow,new_selection_key_inchapter_flow)
          if(picklist_key_inchapter_flow && (picklist_key_inchapter_flow > new_selection_key_inchapter_flow))
          //if sizing ring is greater than coimng key
          {
            state.picklist_exists = false;
          }

        });
        // console.log('add to selections',coming_key,Object.values(new_selection)[0]);
        state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'] = Object.assign({}, 
        state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'], 
        {[coming_key]: Object.values(new_selection)[0]});

        state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure] = Object.assign({}, 
        state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure], 
        { 'options': state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']});

        state.selections[state.selectedChapter] = Object.assign({}, 
        state.selections[state.selectedChapter], 
        { ['procedure_details_'+state.selectedProcedure]: state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]});

        state.selections = Object.assign({}, 
        state.selections, 
        { [state.selectedChapter]: state.selections[state.selectedChapter]});
        // console.log('add to selection ended');
      }
      console.log('end of add to selections');
      console.log(state.selections);
        // else
        // {

        //   state.selections = Object.assign({}, state.selections,
        //   { [current_chapter]: {}}); 

        // }
      // else
      // {
      //   var procedure_details = {};
      //   procedure_details = Object.assign({}, procedure_details, 
      //   { ["procedure_details_"+state.selectedProcedure]: {}});
      //   procedure_details['procedure_details_'] = Object.assign({}, procedure_details["procedure_details_"+state.selectedProcedure], 
      //   { 'id': 1});
      //   procedure_details["procedure_details_"+state.selectedProcedure] = Object.assign({}, procedure_details["procedure_details_"+state.selectedProcedure], 
      //   { 'no_of_items': 1});
      //   procedure_details["procedure_details_"+state.selectedProcedure] = Object.assign({}, procedure_details["procedure_details_"+state.selectedProcedure], 
      //   { 'options': {}});
      //   console.log(state.selections);
      //   state.selections[current_chapter] = procedure_details;
      //   state.selections = Object.assign({}, state.selections, 
      //   { [current_chapter]: state.selections[current_chapter]});
      // }

     
    },                        

  deleteUnWantedOptions(state)
  {
    var current_chapter = state.selectedChapter;
    var current_flow_key = state.selectedFlow;
    if(typeof current_flow_key == 'string')
    current_flow_key = Number(current_flow_key);
    var current_next_options = state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure];
    if(current_chapter in state.next_options)
    {
    // delete furthur values if incoming has index smaller than existed
    _.forOwn(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure], (value, key) => 
    {
      let loop_key = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == key);
      if(typeof loop_key == 'string')
      loop_key = Number(loop_key);
      console.log('loop key',loop_key,current_flow_key);
      if(loop_key > current_flow_key)
      {
        let temp_key = state.chapterFlow[loop_key];
        if(temp_key == 'price_criteria_item')
        {
          state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']['no_of_price_criteria_item'] = 1;
          Vue.delete(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure],temp_key);
        }
        else
        {
          Vue.delete(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure],temp_key);
        }
        // and disable welding tech as well
      }
    });
    console.log('if false',Object.keys(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure]));
    if((Object.keys(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure]).includes(state.chapterFlow[state.selectedFlow])))
    {
      // already exist there before setting next options
      Vue.delete(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure],state.chapterFlow[state.selectedFlow]);
      console.log('now after deletion',state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure]);
    }
    // unwanted deletion of keys in case previous option changes and needs some keys and options deleted.
    var keys = [];
    _.forOwn(state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'], (value, key) => 
    {
      let selections_key_inchapter_flow = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == key);
      keys.push(selections_key_inchapter_flow);
    }
    );
    var index_to_conclude_from_next_options = Array.from({ length: (current_flow_key - Math.max(keys)) / 1 + 1}, (_, i) => Math.max(keys) + (i * 1)).slice(1, -1);

    // delete mid value between incoming options and existed selection
    for(var i = 0; i < index_to_conclude_from_next_options.length ; i++)
    {
      let loop_key = index_to_conclude_from_next_options[i];
      let temp_key = state.chapterFlow[loop_key];
      Vue.delete(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure],temp_key);
    }
    }
  },
  setNextOptions (state,next_options) 
  {
    var current_chapter = state.selectedChapter;
    var coming_key = Object.keys(next_options)[0];
    var vals = Object.values(next_options)[0];
    var new_next_options_key_inchapter_flow = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == coming_key);
    if(typeof new_next_options_key_inchapter_flow == 'string')
    new_next_options_key_inchapter_flow = Number(new_next_options_key_inchapter_flow);
    if(current_chapter in state.next_options)
    {
    // delete furthur values if incoming has index smaller than existed
    _.forOwn(state.next_options[current_chapter]['procedure_details_'+state.selectedProcedure], (value, key) => 
    {
      let next_options_loop_key_inchapter_flow = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == key);
      var welding_tech_key = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == 'welding_technology');
      // console.log(next_options_loop_key_inchapter_flow,new_next_options_key_inchapter_flow )
      if(typeof next_options_loop_key_inchapter_flow == 'string')
      next_options_loop_key_inchapter_flow = Number(next_options_loop_key_inchapter_flow);

      if(next_options_loop_key_inchapter_flow > new_next_options_key_inchapter_flow)
      {
        let temp_key = state.chapterFlow[next_options_loop_key_inchapter_flow];
        if(temp_key == 'price_criteria_item')
        {
          state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']['no_of_price_criteria_item'] = 1;
          Vue.delete(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure],temp_key);
        }
        else
        {
          Vue.delete(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure],temp_key);
        }
        // and disable welding tech as well
      }
      if(new_next_options_key_inchapter_flow < welding_tech_key && state.enable_welding_technology[current_chapter] == true)
      {
        state.enable_welding_technology[current_chapter] = false;
      }
    });
    // if((Object.keys(state.selections[current_chapter]['procedure_details_'+state.selectedProcedure]).includes(state.chapterFlow[state.selectedFlow])))
    // {
    //   // already exist there before setting next options
    //   Vue.delete(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure],state.chapterFlow[state.selectedFlow]);
    //   console.log('now after deletion',state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure]);
    // }
    // unwanted deletion of keys in case previous option changes and needs some keys and options deleted.
    var keys = [];  
    _.forOwn(state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'], (value, key) => 
    {
      let selections_key_inchapter_flow = Object.keys(state.chapterFlow).find(chapterflow_item_key => state.chapterFlow[chapterflow_item_key] == key);
      keys.push(selections_key_inchapter_flow);
    }
    );
    var index_to_conclude_from_next_options = Array.from({ length: (new_next_options_key_inchapter_flow - Math.max(keys)) / 1 + 1}, (_, i) => Math.max(keys) + (i * 1)).slice(1, -1);

    // delete mid value between incoming options and existed selection
    for(var i = 0; i < index_to_conclude_from_next_options.length ; i++)
    {
      let loop_key = index_to_conclude_from_next_options[i];
      let temp_key = state.chapterFlow[loop_key];
      Vue.delete(state.next_options[state.selectedChapter]['procedure_details_'+state.selectedProcedure],temp_key);
    }
    // if add_ons {}
    // console.log(coming_key);
    // console.log(Object.values(next_options)[0]);//charms,gold_items,photo,digital


    // override  
    // if(coming_key == 'add_ons')
    // {
    //   for (var appraisal_no = 1; appraisal_no <= state.interlinked_option; appraisal_no++){
    //     for (var loop_key = 0; loop_key<vals.length; loop_key++)
    //     {
    //       var charm_listed_separately = vals[loop_key];
    //       state.next_options[current_chapter]["appraisal_"+appraisal_no] = Object.assign({}, 
    //         {},{});//appraisal_1={}
    //       state.next_options[current_chapter]["appraisal_"+appraisal_no] = Object.assign({}, 
    //         state.next_options[current_chapter]["appraisal_"+appraisal_no],  
    //       {[charm_listed_separately]:false});
    //     }
    //     console.log('---------------------------------------------');
    //     console.log('appraisal_made',state.next_options[current_chapter]["appraisal_"+appraisal_no])
    //   }
    state.next_options[current_chapter]['procedure_details_'+state.selectedProcedure] = Object.assign({}, 
      state.next_options[current_chapter]['procedure_details_'+state.selectedProcedure],  
    {[coming_key]:vals});
    // state.next_options[current_chapter] = Object.assign({}, 
    //   state.next_options[current_chapter],state.next_options[current_chapter]);
    state.next_options = Object.assign({}, state.next_options,{[current_chapter]: state.next_options[current_chapter]});
    // }
    // console.log('after prototype, object is ', state.next_options);

    }
    else
    {
      // console.log('in else part'); 
      // state.next_options = Object.assign({}, state.next_options, 
      // { [current_chapter]: {[coming_key]:Object.values(next_options)[0]} }); 
      state.next_options = Object.assign({}, state.next_options, 
        {[current_chapter]: state.next_options[current_chapter]});

        // adding key
        state.next_options[current_chapter] = Object.assign({},state.next_options[current_chapter],{["procedure_details_"+current_chapter]:{}});
        state.next_options = Object.assign({},state.next_options,{[current_chapter]: state.next_options[current_chapter]});

      state.next_options[current_chapter]['procedure_details_'+state.selectedProcedure] = Object.assign({}, 
        state.next_options[current_chapter]['procedure_details_'+state.selectedProcedure],  
      {[coming_key]:vals})
      // state.next_options[current_chapter] = Object.assign({}, 
      //   state.next_options[current_chapter],state.next_options[current_chapter]['procedure_details_'+state.selectedProcedure]);
      state.next_options = Object.assign({}, state.next_options, 
        {[current_chapter]: state.next_options[current_chapter]});
    }
  },
  setpicklistmodal:(state,show_modal) => (state.show_modal = show_modal),
  // setRhodiumPlate:(state,rhodium_plating_status) => (state.rhodium_plating_status = rhodium_plating_status),
  setrhodiumplatingmodal:(state,show_modal_rhodium) => (state.show_modal_rhodium = show_modal_rhodium),
  setpicklistItem:(state,picklist) => (state.picklist = picklist),
  setIsRush:(state,is_rush) => (state.is_rush = is_rush),
  setDescriptionOfItem:(state,descriptionOfItem) => (state.descriptionOfItem = descriptionOfItem),
  setPhotosOfDescription(state,photos) 
  {
    state.descriptionOfItem.photos = photos
  },
  setServiceId:(state,service_id) => (state.service_id = service_id),
  confirmJob:(state,if_history_added) => (state.if_history_added = if_history_added),
  setIfPicklistExists:(state,picklist_exists) => (state.picklist_exists = picklist_exists),
  incrementEnvelopeItem:(state) => (state.no_of_items_in_envelope++),
  setSelectedEnvelopeNumber(state)
  {
    state.selected_envelope_number += 1;
  },
  resetSelectedEnvelopeNumber()
  {
    state.selected_envelope_number = 0;
  },
  generateEnvelopeNumbers:(state) => (state.no_of_items_in_envelope++),
  shallWeDuplicateTheCustomer:(state,shall_we_duplicate_customer) => (state.shall_we_duplicate_customer = shall_we_duplicate_customer),
  allowEnvelopes:(state,requested_envelopes) => (state.requested_envelopes = requested_envelopes),
  setRhodiumPlate(state,rhodium_plating_status)
  {
    console.log('setRhodiumPlate called',rhodium_plating_status);
    if(router.currentRoute.query.chapter in state.rhodium_plating)
    {
      if('procedure_details_1' in state.rhodium_plating[router.currentRoute.query.chapter])
      {
        state.rhodium_plating[router.currentRoute.query.chapter]['procedure_details_'+state.selectedProcedure] = rhodium_plating_status !== undefined ? rhodium_plating_status:true;
        state.rhodium_plating[router.currentRoute.query.chapter] = Object.assign({},state.rhodium_plating[router.currentRoute.query.chapter],{['procedure_details_'+state.selectedProcedure]: state.rhodium_plating[router.currentRoute.query.chapter]['procedure_details_'+state.selectedProcedure]});
        state.rhodium_plating = Object.assign({},state.rhodium_plating,{[router.currentRoute.query.chapter]: state.rhodium_plating[router.currentRoute.query.chapter]});
      }
      else
      {
        state.rhodium_plating[router.currentRoute.query.chapter] = Object.assign({}, 
        state.rhodium_plating[router.currentRoute.query.chapter],{['procedure_details_'+state.selectedProcedure]: (rhodium_plating_status !== undefined ? rhodium_plating_status:true)});
        state.rhodium_plating = Object.assign({},state.rhodium_plating,{[router.currentRoute.query.chapter]:state.rhodium_plating[router.currentRoute.query.chapter]});
      }
    }
    else
    {
      state.rhodium_plating = Object.assign({}, state.rhodium_plating,{[router.currentRoute.query.chapter]: {}});
      state.rhodium_plating[router.currentRoute.query.chapter] = Object.assign({},state.rhodium_plating[router.currentRoute.query.chapter],
        {['procedure_details_'+state.selectedProcedure]:rhodium_plating_status !== undefined ? rhodium_plating_status:true});
    }
  },
  setWeldingTechnology (state,welding_technology_array)
  {
    // if(state.shop.have_laser == 0 && welding_technology_array[1] == 'laser'){
    //   state.does_not_have_laser_modal = true;
    //   return;
    // }
    // traverse welding technology data that already exists
    var laser_exists = Object.values(state.welding_technology).find(welding_technology_chapter_wise => welding_technology_chapter_wise == 'laser');
    console.log('laser_exists',laser_exists);
    console.log('welding_technology_array',welding_technology_array)
    var chapter = (welding_technology_array && typeof welding_technology_array == 'array' && welding_technology_array[0]) ? welding_technology_array[0] : state.selectedChapter;
    
    if(welding_technology_array)
    {
      // state.welding_technology[chapter] = welding_technology_array[1];  // overriden
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'] = Object.assign({}, 
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'], 
      { 'welding_technology': welding_technology_array[1]});

      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure] = Object.assign({}, 
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure], 
      { 'options': state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']});

      state.selections[state.selectedChapter] = Object.assign({}, 
      state.selections[state.selectedChapter], 
      { ['procedure_details_'+state.selectedProcedure]: state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]});

      state.selections = Object.assign({}, 
      state.selections, 
      { [state.selectedChapter]: state.selections[state.selectedChapter]});
    }
    else
    {

      var basic_procedure_detail_object = 
      {
        ['procedure_details_'+state.selectedProcedure]:{}
      };

      // updating current ones
      // console.log('to resolve errors',state.selections[state.selectedChapter]);
      // state.welding_technology[chapter] = welding_technology_array[1];  // overriden
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'] = Object.assign({}, 
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'], 
      { 'welding_technology': (laser_exists ? 'laser' : 'torch')});
      // console.log('after adding welding technology options',state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']);
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure] = Object.assign({}, 
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure], 
      { 'options': state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options']});
      state.selections[state.selectedChapter] = Object.assign({}, 
      state.selections[state.selectedChapter], 
      { ['procedure_details_'+state.selectedProcedure]: state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]});
      state.selections = Object.assign({}, 
      state.selections, 
      { [state.selectedChapter]: state.selections[state.selectedChapter]});

    }
  },



  addPricingDetails (state,service) 
  {
    console.log('service',service);
    var current = state.envelope_numbers[state.selected_envelope_number];
    var added = false;
    state.items_price_detail.forEach(function (el) {
      console.log('keys in envelope',Object.keys(el))
      if(current == Object.keys(el)[0])
      {
        if(state.selectedChapter in el[current])
        {
          el[current][state.selectedChapter][service.service_id] = service;
        }
        else
        {
          el[current][state.selectedChapter] = {};
          el[current][state.selectedChapter][service.service_id] = service;
        }
        added = true;
        el[current]['receipt_generated'] = false;
      }
    });
    if(!added)
    {
      // new object creation process
      var obj = {};
      obj[current] = {};
      var service_obj = obj[current];
      service_obj[state.selectedChapter] = {};
      service_obj[state.selectedChapter][service.service_id] = service;
      service_obj['receipt_generated'] = false;
      state.items_price_detail.push(obj);
    }

  },

  setEstimatedProduct(state,estimateTheProduct)
  {
    state.estimateTheProduct = estimateTheProduct;
  },
  setIsEstimated(state,is_estimated_set)
  {
    state.is_estimated_set = is_estimated_set;
  },
  addDescriptionDetails (state) {

    // check envelope number exists
    // state.descriptions_of_envelope.push(state.descriptionOfItem);  
    
    var current = state.envelope_numbers[state.selected_envelope_number];
    var added = false;
    state.descriptions_of_envelope.forEach(function (el) {

      if(current == Object.keys(el)[0])
      {
        el[current][state.service_id] = state.descriptionOfItem;
        added = true;
      }

    });
    if(!added)
    {
      // new object creation process 
      var obj = {};
      obj[current] = {};
      var service_obj = obj[current];
      service_obj[state.service_id] = state.descriptionOfItem;
      state.descriptions_of_envelope.push(obj);
    }
  },
  getEnvelopeNumbers(state,envelope_numbers)
  {
    state.envelope_numbers = envelope_numbers
  },
  askForFurthurSKUs:(state,furthur_sku_modal) => (state.ask_furthur_modal = furthur_sku_modal),
  setFurthurItem:(state,furthur_item) => (state.furthur_item = furthur_item),
  setCycle:(state,current_cycle) => (state.current_cycle = current_cycle),
  setGellerSKU:(state,geller_sku) => (state.geller_sku = geller_sku),
  resetCycle(state,resetCycle) {
    if(resetCycle)
    {

      state.show_modal_rhodium = false;
      state.show_modal = false;
      state.selections = {};
      state.selectedFlow = 0;
      state.rhodium_plating_status = false;
      state.show_modal_rhodium = false;
      state.picklist_exists = false;
      state.picklist = false;
      state.is_rush = false;
      state.if_history_added = false;
      state.furthur_item = null;
      state.ask_furthur_modal = false;
      state.descriptionOfItem = {
        item_description: "",
        customer_stated_value: "",
        stones_quality_description: "",
        is_guarranteed: '',
        is_qualiteed:'',
        promise_date: new Date(Date.now() + 10 * 24 * 60 * 60 * 1000),
        photos:[],
        stones_guarrantee_description:""
      },
  
      state.next_options = {};
      state.no_of_price_criteria_item = '1'
      state.price_criteria_item_name = ''
      state.stone_stringing_soldering_handled  = false,
      state.enable_welding_technology = {},
      state.extra_work_details = {},
      state.enable_check_and_tighten = false,
      localStorage.setItem('review_options_enabled',false)
 state.progress_percentage = 0;
      router.push("/find-sku").catch(()=>{});
    }
  },
  resetCycleForNewEnvelope(state,resetCycle) {
    state.selected_envelope_number = 0; 
  },
  // addStoneTypeToStoneDetails(state,stone_type)
  // {
  //   state.extra_work_details[700] = Object.assign({},state.extra_work_details[700],obj);
  //   state.extra_work_details = Object.assign({}, state.extra_work_details, {700: state.extra_work_details[700]});
    
  //   state.flow_details = Object.assign({}, state.flow_details, { 'stone_type': stone_type })
  // },
  addSameFlowForEachStoneValue(state,same_flow_for_each_stone)
  {
    state.extra_work_details[700]['flow_details'] = Object.assign({},state.extra_work_details[700]['flow_details'],{'same_flow_for_each_stone':same_flow_for_each_stone});
    state.extra_work_details[700] = Object.assign({},state.extra_work_details[700],{'flow_details':state.extra_work_details[700]['flow_details']});
    state.extra_work_details = Object.assign({}, state.extra_work_details, {700: state.extra_work_details[700]});
  },
  addStringingWorkStatus(state,stringing_status)
  {
    state.stringing_work = stringing_status
  },
  addStoneWorkStatus(state,stone_work)
  {
    // console.log('stone work status',stone_work);
    state.stone_work = stone_work
    // if(stone_work.includes('do_not'))
    // {
    //   Vue.delete(state.extra_work_details,state.stone_chapter[0]);
    // }
  },
  addSolderingWorkStatus(state,soldering_work)
  {
    state.soldering_work = soldering_work
    // if(!soldering_work)
    // {
    //   Vue.delete(state.extra_work_details,state.soldering_work[0]);
    // }
  },
  addFinishingWorkStatus(state,finishing_work)
  {
    state.finishing_work = finishing_work
    // if(!finishing_work)
    // {
    //   Vue.delete(state.extra_work_details,state.finishing_work[0]);
    // }
  },
  addGemStonesWorkStatus(state,gemstones_work)
  {
    state.gemstones_work = gemstones_work
    // if(!gemstones_work)
    // {
    //   Vue.delete(state.extra_work_details,state.gemstones_work[0]);
    // }
  },
  // addLowerValueColoredStoneToStoneDetails(state,lower_value_colored_stone)
  // {
  //   state.flow_details = Object.assign({}, state.flow_details, { 'lower_value_colored_stone': lower_value_colored_stone })
  //   state.extra_work_details[700]['flow_details'] = Object.assign({},state.extra_work_details[700]['flow_details'],{'lower_value_colored_stone':same_flow_for_each_stone});
  //   state.extra_work_details[700] = Object.assign({},state.extra_work_details[700],{'flow_details':state.extra_work_details[700]['flow_details']});
  //   state.extra_work_details = Object.assign({}, state.extra_work_details, {700: state.extra_work_details[700]});
  // },
  // addNoOfStonesToStoneDetails(state,no_of_stones)
  // { 
  //   state.flow_details = Object.assign({}, state.flow_details, { 'no_of_stones': no_of_stones })
  // },
  // addTotalNoOfStonesToStoneDetails(state,total_no_of_items)
  // {
  //   state.extra_work_details[state.stone_chapter[0]]['flow_details'] = Object.assign({},state.extra_work_details[state.stone_chapter[0]]['flow_details'],{'total_no_of_items':total_no_of_items});
  //   state.extra_work_details[state.stone_chapter[0]] = Object.assign({},state.extra_work_details[state.stone_chapter[0]],{'flow_details':state.extra_work_details[state.stone_chapter[0]]['flow_details']});
  //   state.extra_work_details = Object.assign({}, state.extra_work_details, {[state.stone_chapter[0]]: state.extra_work_details[state.stone_chapter[0]]});
  // },  
  // enableAskEachStoneFlow(state,enable_ask_each_stone_flow)
  // {
  //   state.extra_work_details[state.stone_chapter[0]]['flow_details'] = Object.assign({},state.extra_work_details[state.stone_chapter[0]]['flow_details'],{'enable_ask_each_stone_flow':enable_ask_each_stone_flow});
  //   state.extra_work_details[state.stone_chapter[0]] = Object.assign({},state.extra_work_details[state.stone_chapter[0]],{'flow_details':state.extra_work_details[state.stone_chapter[0]]['flow_details']});
  //   state.extra_work_details = Object.assign({}, state.extra_work_details, {[state.stone_chapter[0]]: state.extra_work_details[state.stone_chapter[0]]});
  // },
  setNoOfStoneFlows(state,no_of_flow_details = null)
  {
    if(no_of_flow_details)
    {
      state.extra_work_details[state.stone_chapter[0]]['flow_details'] = Object.assign({},state.extra_work_details[state.stone_chapter[0]]['flow_details'],{'no_of_flow_details':no_of_flow_details});
      state.extra_work_details[state.stone_chapter[0]] = Object.assign({},state.extra_work_details[state.stone_chapter[0]],{'flow_details':state.extra_work_details[state.stone_chapter[0]]['flow_details']});
      state.extra_work_details = Object.assign({}, state.extra_work_details, {[state.stone_chapter[0]]: state.extra_work_details[state.stone_chapter[0]]});
      state.flow_details = Object.assign({}, state.flow_details, { 'no_of_flow_details': no_of_flow_details });
      // Vue.delete(state.flow_details,'stone_details_1')
      // Vue.delete(state.flow_details,'stone_details_2')
      // Vue.delete(state.flow_details,'stone_details_3')
      // Vue.delete(state.flow_details,'stone_details_')
      Object.values(state.flow_details).forEach((stone_flow) => {
        // console.log(typeof stone_flow,'typeof stone_flow');
        if(typeof stone_flow ==  'object')
        {
          // console.log('stone_flow',stone_flow)
          if(stone_flow['id'] > no_of_flow_details)
          {
            // console.log('property to be deleted','stone_details_'.concat(stone_flow['id']));
            Vue.delete(state.flow_details,'stone_details_'.concat(stone_flow['id'])); 
          }
        }
      });
    } 
    else
    {
      // console.log('in else part setNoOfStoneFlows');
      for(let i = 1; i <= state.extra_work_details[state.stone_chapter[0]].flow_details['no_of_flow_details']; i++)
      {
        // console.log('setNo.OfFlows called');

        // creating multiple stone details per multiple flow procedures
        state.flow_details = Object.assign({}, state.flow_details, 
          {'stone_details_': 
          {
            id:[i],
            stone_type: '',
            no_of_stones:1,
            lower_value_colored_stone:false,
          } 
        });

        state.extra_work_details[state.stone_chapter[0]].flow_details['stone_details_'.concat(i)] = Object.assign({}, 
        state.extra_work_details[state.stone_chapter[0]].flow_details['stone_details_'.concat(i)],
        {

          'id':i,
          'stone_type': 'diamond',
          'no_of_stones':1,
          'lower_value_colored_stone':false,

        });

        state.extra_work_details[state.stone_chapter[0]].flow_details = Object.assign({}, 
        state.extra_work_details[state.stone_chapter[0]].flow_details,
        {['stone_details_'.concat(i)]:state.extra_work_details[state.stone_chapter[0]].flow_details['stone_details_'.concat(i)]});

        state.extra_work_details[state.stone_chapter[0]] = Object.assign({}, 
        state.extra_work_details[state.stone_chapter[0]],
        {'flow_details':state.extra_work_details[state.stone_chapter[0]]['flow_details']});
        
        state.extra_work_details = Object.assign({}, 
        state.extra_work_details,
        {[state.stone_chapter[0]]:state.extra_work_details[state.stone_chapter[0]]});

        // console.log('state.flow_details',state.flow_details)  
      }

    }
    Object.entries(state.extra_work_details[state.stone_chapter[0]].flow_details).forEach(
      ([key, stone_flow]) => {
      // console.log(typeof stone_flow,'typeof stone_flow');
      if(typeof stone_flow ==  'object')
      { 
        // if stone detail fo id 5 exits but total no. of flows are 4 then delete extras
        if(stone_flow.id > state.extra_work_details[state.stone_chapter[0]].flow_details.no_of_flow_details)
        {
          Vue.delete(state.extra_work_details[state.stone_chapter[0]].flow_details,key);
        }
      }
    });
  },
  updateStoneDetailsPerIndex(state,event_array)
  {
    console.log('event array',event_array)
    var event_value = event_array[0];
    var specification_value;
    var specification;
    var required_chapter;

    if(event_value instanceof Event)
    {

      specification_value = event_value.target.name;
      event_value         = event_value.target.value;
      specification       = specification_value.split('_');
      specification       = specification[specification.length - 1];
      required_chapter    = state[specification+'_chapter'][0];
      // console.log('required',required_chapter);

    }
    // console.log('event_value',event_value);
    if(!specification)
    {
      required_chapter = router.currentRoute.query.chapter
    }
    
    let index = event_array[1];   // stone type etc
    let id = event_array[2];  
    // console.log('event_array',event_value,specification,required_chapter);
    if(!id)
    {
      // console.log('required chapter',required_chapter,state.extra_work_details['700'],state.extra_work_details[700],data);    
      var data = event_value   // id
  
      Object.entries(state.extra_work_details[required_chapter]).forEach(
        ([key, flow_detail]) => {
            console.log('key',key,'INDEX',index);
            // console.log('index and key and event value',index, key, event_array[0].target.value);
            if(index == key)
            {
              console.log('index and key are same in if', index,key);
            // state.extra_work_details[state[specification+'_chapter'][0]] = Object.assign({}, 
            // state.extra_work_details[state[specification+'_chapter'][0]],
            // {[key]:data});
            // state.extra_work_details = Object.assign({},state.extra_work_details,
            // {[state[specification+'_chapter'][0]]:state.extra_work_details[state[specification+'_chapter'][0]]});
            if(index === 'total_no_of_items')
            {
                // console.log('enable_ask_if_asked is true',event_array[0].target.value);
                // enable ask if same or different
                state.extra_work_details[required_chapter] = Object.assign({}, 
                state.extra_work_details[required_chapter],
                {[index]:event_array[0].target.value});
  
                if(Number(event_array[0].target.value) > 1)
                {
                  // console.log('enable_ask_if_asked is greater than 1');
                  // enable ask if same or different
                  state.extra_work_details[required_chapter] = Object.assign({}, 
                  state.extra_work_details[required_chapter],
                  {'enable_ask_each_flow':true});
                }
                state.extra_work_details = Object.assign({}, 
                state.extra_work_details,
                {[required_chapter]:state.extra_work_details[required_chapter]});
                return;
            }
            else if(index === 'same_flow_for_each')
            {
                // console.log('same flow for each');
                // if(data)
                // {
                // var data = event_array[0].target.value.toLowerCase() === 'true' || event_array[0].target.value === true; // its not true value but casting boolean string to actual boolean
                // enable ask if same or different
                state.extra_work_details[required_chapter] = 
                Object.assign({}, 
                state.extra_work_details[required_chapter],
                {
                  'same_flow_for_each':(typeof event_array[0].target.value == string) ? event_array[0].target.value.toLowerCase() === 'true' : event_array[0].target.value === true
                });
                state.extra_work_details = Object.assign({}, state.extra_work_details, 
                  {[required_chapter]:state.extra_work_details[required_chapter]});
              // }else{
              //   //  create separate procedure flow
              // }
              return;
            }
            else if(index === 'no_of_flow_procedures')
            {

              state.extra_work_details[required_chapter] = Object.assign({}, 
              state.extra_work_details[required_chapter],
              {'no_of_flow_procedures':event_array[0].target.value});
              
              // state.extra_work_details = Object.assign({}, 
              // state.extra_work_details,
              // {[required_chapter]:state.extra_work_details[required_chapter]});
              for(var i = 1; i <= Number(event_array[0].target.value); i++)
              {
                // console.log('loop running');
                // updating flow_details
                if('flow_details' in state.extra_work_details[required_chapter])
                {
                  var basic_procedure_detail_object = {};
                  // basic_object['procedure_details_'.concat(i)] = {};
                  basic_procedure_detail_object['id'] = i;
                  basic_procedure_detail_object['no_of_items'] = 1;
                  basic_procedure_detail_object['in_progress'] = (i == 1 ? true : false);
                  basic_procedure_detail_object['is_captured'] = false;

                  if(specification == 'stone')
                  {
                    basic_procedure_detail_object['stone_type'] = 'diamond';
                    basic_procedure_detail_object['lower_value_colored_stone'] = false;
                  }                                    
                  state.extra_work_details[required_chapter].flow_details['procedure_details_'.concat(i)] = Object.assign({}, 
                  state.extra_work_details[required_chapter].flow_details['procedure_details_'.concat(i)],basic_procedure_detail_object);
                
                  state.extra_work_details[required_chapter].flow_details = Object.assign({}, 
                  state.extra_work_details[required_chapter].flow_details,
                  {['procedure_details_'.concat(i)]:state.extra_work_details[required_chapter].flow_details['procedure_details_'.concat(i)]});

                  state.extra_work_details[required_chapter] = Object.assign({}, 
                  state.extra_work_details[required_chapter],
                  {'flow_details':state.extra_work_details[required_chapter]['flow_details']});

                }else{
                  var basic_procedure_detail_object = {
                    ['procedure_details_'.concat(i)]:{}
                  };
                  // basic_object['procedure_details_'.concat(i)] = {};
                  basic_procedure_detail_object['procedure_details_'.concat(i)]['id'] = i;
                  basic_procedure_detail_object['procedure_details_'.concat(i)]['no_of_items'] = 1;
                  basic_procedure_detail_object['procedure_details_'.concat(i)]['in_progress'] = (i == 1 ? true : false)
                  basic_procedure_detail_object['procedure_details_'.concat(i)]['is_captured'] = false;
                  if(specification == 'stone')
                  {
                    basic_procedure_detail_object['procedure_details_'.concat(i)]['stone_type'] = 'diamond';
                    basic_procedure_detail_object['procedure_details_'.concat(i)]['lower_value_colored_stone'] = false;
                  }
                  state.extra_work_details[required_chapter] = Object.assign({}, 
                    state.extra_work_details[required_chapter],{'flow_details':basic_procedure_detail_object});
                }


                // state.extra_work_details[required_chapter].flow_details['procedure_details_'.concat(i)] = Object.assign({}, 
                // state.extra_work_details[required_chapter].flow_details['procedure_details_'.concat(i)],basic_object);

                // state.extra_work_details[required_chapter].flow_details = Object.assign({}, 
                // state.extra_work_details[required_chapter].flow_details,
                // {['procedure_details_'.concat(i)]:state.extra_work_details[required_chapter].flow_details['procedure_details_'.concat(i)]});

                // state.extra_work_details[required_chapter] = Object.assign({}, 
                // state.extra_work_details[required_chapter],
                // {'flow_details':state.extra_work_details[required_chapter]['flow_details']});

                state.extra_work_details = Object.assign({}, 
                state.extra_work_details,
                {[required_chapter]:state.extra_work_details[required_chapter]});
                // console.log('work details now',state.extra_work_details);
              }

              Object.entries(state.extra_work_details[state.stone_chapter[0]].flow_details).forEach(
                ([key, stone_flow]) => {
                // console.log(typeof stone_flow,'typeof stone_flow');
                if(typeof stone_flow ==  'object')
                {
                  // if stone detail fo id 5 exits but total no. of flows are 4 then delete extras
                  if(stone_flow.id > state.extra_work_details[required_chapter].no_of_flow_procedures)
                  {
                    Vue.delete(state.extra_work_details[required_chapter].flow_details,key);
                  }
                }
              });
            return;
            }
            else if(index === 'is_captured')
            {

              console.log('is captured value',event_array[0]);
              state.extra_work_details[required_chapter]['is_captured'] = event_array[0] instanceof Event ? (event_array[0].target.value == 'string' ? event_array[0].target.value.toLowerCase() === 'true' : event_array[0].target.value === true) : event_array[0] ;

              // state.extra_work_details['is_captured'] = Object.assign({}, 
              // state.extra_work_details['is_captured'],state.extra_work_details['is_captured']);

              state.extra_work_details = Object.assign({}, 
              state.extra_work_details,
              {[required_chapter]:state.extra_work_details[required_chapter]});
              console.log('is captured now',state.extra_work_details[required_chapter]['is_captured']);

              return;

            }
          }
      });
      // console.log("scope",event_array[0].target.value)
      // resolve(true);
      // return;
    }else{
      console.log('in else part')
      if(state.extra_work_details[state.stone_chapter[0]].flow_details)
      {
        Object.entries(state.extra_work_details[state.stone_chapter[0]].flow_details).forEach(
          ([key, stone_flow]) => {
            console.log(stone_flow,'stone_flow execution');
          // console.log(typeof stone_flow,'typeof stone_flow');
          if(typeof stone_flow ==  'object')
           {
            console.log('stone_flow is object');
            if(stone_flow.id == id)
            {
              console.log('id is matched',index,event_value,state.stone_chapter[0]);
              state.extra_work_details[state.stone_chapter[0]].flow_details['procedure_details_'.concat(id)] = 
              Object.assign({}, 
              state.extra_work_details[state.stone_chapter[0]].flow_details['procedure_details_'.concat(id)],{
                [index]:event_value
              });

              // state.extra_work_details[state.stone_chapter[0]].flow_details['procedure_details_'.concat(id)] = Object.assign({}, 
              // state.extra_work_details[state.stone_chapter[0]].flow_details['procedure_details_'.concat(id)],{[index]:
              // state.extra_work_details[state.stone_chapter[0]].flow_details['procedure_details_'.concat(id)[index]]});
              // console.log('step 2',state.extra_work_details)
              state.extra_work_details[state.stone_chapter[0]].flow_details = Object.assign({}, 
              state.extra_work_details[state.stone_chapter[0]].flow_details,
              {['procedure_details_'.concat(id)]:state.extra_work_details[state.stone_chapter[0]].flow_details['procedure_details_'.concat(id)]});

              state.extra_work_details[state.stone_chapter[0]] = Object.assign({}, 
              state.extra_work_details[state.stone_chapter[0]],
              {'flow_details':state.extra_work_details[state.stone_chapter[0]]['flow_details']});

              // state.extra_work_details = Object.assign({}, 
              // state.extra_work_details,
              // {[state.stone_chapter[0]]:state.extra_work_details[state.stone_chapter[0]]});

            }
          }
        });
        return;
      }
      else
      {
        return;
      }
    }
    
    // specification *
    // index exists *
  },
  setNoOfItems(state,no_of_price_criteria_item)
  { 
    state.no_of_price_criteria_item = no_of_price_criteria_item;
  },
  
  setInterlinkedOption(state,interlinked_option)
  {
    state.interlinked_option = interlinked_option;
  },
  setInterlinkOption(state,interlinked_option)
  {
    state.interlinked_option = interlinked_option;
  },
  setQuestion(state,question)
  {
    state.question = question;
  },
  setSizeTo(state,size_to)
  {
    if(size_to != undefined)
    {
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'] = 
      Object.assign({}, state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'], { 'size_to': size_to } );
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure] = 
      Object.assign({}, state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure], { 'options': state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'] } );
      state.selections[state.selectedChapter] = 
      Object.assign({}, state.selections[state.selectedChapter], { ['procedure_details_'+state.selectedProcedure]: state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure] } );
      state.selections = Object.assign({}, state.selections, { [state.selectedChapter]: state.selections[state.selectedChapter] } );
    }
  },
  setSizeNow(state,size_now)
  {
    if(size_now != undefined)
    {
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'] = 
      Object.assign({}, state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'], { 'size_now': size_now } );
      state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure] = 
      Object.assign({}, state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure], { 'options': state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'] } );
      state.selections[state.selectedChapter] = 
      Object.assign({}, state.selections[state.selectedChapter], { ['procedure_details_'+state.selectedProcedure]: state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure] } );
      state.selections = Object.assign({}, state.selections, { [state.selectedChapter]: state.selections[state.selectedChapter] } );
    }
  },
  setQuantity(state,quantity)
  {
    console.log('setQuantity called')
    var chapter = state.selectedChapter;
    if(chapter in state.quantity)
    {
      state.quantity[chapter] = quantity; // overriden
    }
    else
    {
      console.log('in-else-setQuantity');
      state.quantity = Object.assign({}, state.quantity, // created
      { [chapter]: quantity });
      console.log(state.quantity);
    }
  },
  enableQuantity(state,enable_the_quantity)
  {
    console.log('enable_the_quantity',enable_the_quantity);
    var chapter = state.selectedChapter;
    if(enable_the_quantity !== undefined)
    {
      if(chapter in state.enable_the_quantity)
      {
        state.enable_the_quantity[chapter] = enable_the_quantity; // overriden
      }
      else
      {
        state.enable_the_quantity = Object.assign({}, state.enable_the_quantity, // created
        { [chapter]: enable_the_quantity } );
      }
    }
  },
  OKWith700(state,OKWith700)
  {
    state.OKWith700 = OKWith700
  },
  setPreviousPageOnCustomerChange(state,previous_page_on_customer_change)
  {
    state.previous_page_on_customer_change = previous_page_on_customer_change;
  },
  setLoader(state,isLoading)
  {
    state.isLoading = isLoading;
  },
  setShop(state,shop)
  {
    state.shop = shop
  },
  bindSalePerson(state,sale_person_id)
  {
    state.sale_person_id = sale_person_id
  },
  
  ChangeWeldingToLaser(state,change_to_or_not)
  {
    if(change_to_or_not)
    {
      _.forOwn(state.welding_technology, (value, key) => 
      {
        if(value == 'torch')
        {
          state.welding_technology[key] = 'laser';
        }
      });
    }
  },
  setStaffGivenDescriptionOfItem(state,task_to_be_performed)
  {
    state.task_to_be_performed = Object.assign({}, state.task_to_be_performed, {[state.main_chapter]:task_to_be_performed});
  },
  setPriceCriteriaItem(state,price_criterian_item)
  {
    state.price_criteria_item_name = price_criterian_item['price_criteria_item_name']
  },
  setInterlinkedQuantityInChapterFlow(state,interlink_quantity_in_chapter_flow)
  {
    state.interlink_quantity_in_chapter_flow = interlink_quantity_in_chapter_flow
  },
  setInterlinkedQuantities(state,interlink_checkbox_value)
  {
    if(interlink_checkbox_value)
    {
      // var appraisal_no  =  interlink_checkbox_value[0];
      // var single_add_on =  interlink_checkbox_value[1];
      // var event_value   =  interlink_checkbox_value[2];
      // if (appraisal_no && single_add_on){
      state.interlink_quantities = Object.assign({}, state.interlink_quantities,interlink_checkbox_value);
      // state.interlink_quantities[appraisal_no][single_add_on] = event_value;
      // }
    }
  },
  setComplicationSurcharge(state,complication_checkbox_arr)
  {
    // console.log(complication_checkbox_arr);
    var complication_checkbox_value = complication_checkbox_arr[0];
    if(complication_checkbox_value)
    {
      var event_value = complication_checkbox_value[0];
      var surcharge_value = complication_checkbox_value[1];
      state.complication_surcharges = Object.assign({}, 
      state.complication_surcharges, 
      {[surcharge_value]: event_value});
    }
  },
  setTwoToneKarats(state,two_tone_karats_arr)
  {
    // console.log('two_tone_karats_arr',two_tone_karats_arr);
    var two_tone_karats_arr_value = two_tone_karats_arr[0];
    if(two_tone_karats_arr_value)
    {
      var event_value = two_tone_karats_arr_value[0]; // true/false
      var value = two_tone_karats_arr_value[1];//18kt white
      if(!event_value)
      {
        this.commit('removeTwoToneKarats',value);
      }
      else
      {
        state.two_tone_karats = Object.assign({}, 
        state.two_tone_karats, 
        {[value]: event_value});
      }
    }
    // Object.keys(newValue).forEach((key)=>{
    //   if(newValue[key] == false)
    //   {
    //     this['dataStore/removeTwoToneKarats'](key);
    //   }
    //   });
  },
  putQuantityAgainstInterlinkItems(state,interlink_quantities_arr)
  {
    // array is of form [single_add_on,Number(event_value.target.value),appraisal_no]
    // console.log('putQuantityAgainstInterlinkItems',interlink_quantities_arr);
    var interlink_quantities = interlink_quantities_arr[0];
    if(interlink_quantities)
    {
      var event_value   = interlink_quantities[0];
      var appraisal_no  = interlink_quantities[1];
      var single_add_on = interlink_quantities[2];
      // console.log('after getting 0 index',event_value,appraisal_no);
      if (appraisal_no && single_add_on)
      {
        // state.interlink_quantities[appraisal_no] = Object.assign({},
        // {},{[single_add_on]:event_value});
        // console.log('getting b appraisal no.');
        // console.log(state.interlink_quantities[appraisal_no]);

          state.interlink_quantities[appraisal_no] = Object.assign({}, 
          state.interlink_quantities[appraisal_no],
          {[single_add_on]:event_value});
          state.interlink_quantities = Object.assign({}, state.interlink_quantities, 
          {[appraisal_no]: state.interlink_quantities[appraisal_no]});

        // state.interlink_quantities = Object.assign({}, state.interlink_quantities, 
        // {[appraisal_no]: state.interlink_quantities[appraisal_no]}); 
        // state.interlink_quantities[appraisal_no][single_add_on] = event_value
      }
    }
  },

  setInterlinkedQuantityForIndividualItems(state,interlink_quantity_for_individual_items)
  {
    state.interlink_quantity_for_individual_items = interlink_quantity_for_individual_items
  },
  setInterlinkedQuantityValues(state,interlink_quantity_values)
  {
    state.interlink_quantity_values = interlink_quantity_values
  },
  stoneStringingSolderingHandled(state,stone_stringing_soldering_handled)
  {
    state.stone_stringing_soldering_handled = stone_stringing_soldering_handled
  },
  discardColor(state,discard_color)
  {
    state.discard_color = discard_color;
  },
  removeTwoToneKarats(state,index)
  {
    Vue.delete(state.two_tone_karats,index); 
  },
  setDiscardedCategory(state,discarded_item_array)
  {
   state.discarded_item_array = discarded_item_array;
  },
  enableAskStoneDetailsPopup(state,value)
  {
    state.enable_ask_stone_details_popup = value
  },
  removeWeldingTechnologyFromSelections(state)
  { 
    Vue.delete(state.selections[state.selectedChapter]['procedure_details_1']['options'],'welding_technology');
  },
  enableRequireMetalPopup(state,value)
  {
    state.enable_require_metal_popup = value;
  },
  enableRequireWeightPopup(state,value)
  {
    state.enable_require_weight_popup = value;
  },
  // requireMetalAlongWithLabor(state,value)
  // {
  //   state.required_metal_along_popup = value;
  // }
  setPartOnly(state,value)
  {
    state.part_only = value;
  },
  setMetals(state,metals)
  {
    state.metals = metals;
  },
  setRepairID(state,value)
  {
    state.repair_id = value;
  },
  chooseMetal(state,value)
  {
    state.chapter_1000_metal = value;
  },
  setReceiptGeneratedToEnvelope(state,value)
  {
    // setTimeout(() => {
      console.log('no of generated ones',state.no_of_generated_envelopes);
      state.items_price_detail[state.no_of_generated_envelopes][state.envelope_numbers[state.selected_envelope_number]]['receipt_generated'] = true;
      // resolve1();
    // }, 0);
    // state.selected_envelope_number += 1;
  },
  setNoOfRequestedEnvelopes(state,value)
  {
    state.requested_envelopes = value;
  },
  setNoOfGeneratedEnvelopes(state,value)
  {
    state.no_of_generated_envelopes = state.no_of_generated_envelopes + 1;
  },
  resetStoneNumber(state,value)
  {
    state.extra_work_details[700]['flow_details']['procedure_details_1']['no_of_items'] = 1;
  },
  enableCheckAndTighten(state,value)
  {
    state.enable_check_and_tighten = value;
  }
}

const actions = {
  chooseMetal({commit},value)
  {
    commit('chooseMetal',value);
  },
  setRepairID({commit},value)
  {
    commit('setRepairID',value);
  },

  enableAskStoneDetailsPopup({commit},value)
  {
    commit('enableAskStoneDetailsPopup',value);
  },

  setMetals({commit},value)
  {
    commit('setMetals',value);
  },

   /**
   *
    @param {} param0
    */
  enableRequireWeightPopup({commit},value)
  {
    commit('enableRequireWeightPopup',value);
  },
  /**
   *
    @param {} param0
    */
    enableRequireMetalPopup({commit},value)
    {
      commit('enableRequireMetalPopup',value);
    },

    /**
   *
    @param {} param0
    */
    // requireMetalAlongWithLabor({commit},value)
    // {
    //   commit('requireMetalAlongWithLabor',value);
    // },
  
  /**
   *
    @param {} param0
    */
  enableQuantity({commit},value)
  {
    commit('enableQuantity',value);
  },
  /**
   *
    @param {} param0
    */
  enableAskStoneDetailsPopup({commit},value)
  {
    commit('enableAskStoneDetailsPopup',value);
  },

  /**
   *
    @param {} param0
    */
  setDiscardedCategory({commit},discarded_item_detail)
  {
    commit('setDiscardedCategory',discarded_item_detail);
  },

  removeTwoToneKarats({commit},index)
  {
    commit('removeTwoToneKarats',index);
  },
  /**
   *
    @param {} param0
    @param {} details 
  */
  addProcedureDetailsToRhodiumPlating({commit},details)
  {
    commit('addProcedureDetailsToRhodiumPlating',details);
  },

   /**
   *
    @param {} param0
    @param {} details 
  */
    addProcedureDetailsToNextOptions({commit},details)
    {
      commit('addProcedureDetailsToNextOptions',details);
    },
  
  setSizeTo({commit},size_to)
  { 
    commit('setSizeTo',size_to);
  },

  setSizeNow({commit},size_now)
  {
    commit('setSizeNow',size_now);
  },

  /**
   *
    @param {} param0
    @param {} details 
  */
  addProcedureDetailsToSelections({commit},details)
  {
    commit('addProcedureDetailsToSelections',details);
  },
  /**
   *
    @param {} param0
    @param {} event_array 
  */
  addStringingWorkStatus({commit},stringing_status)
  {
    commit('addStringingWorkStatus',stringing_status);
  },
    /**
 *
  @param {} param0
  @param {} event_array 
*/
  addStoneWorkStatus({commit},stone_status)
  {
    commit('addStoneWorkStatus',stone_status);
  },  /**
  *
   @param {} param0
   @param {} event_array 
 */
 addSolderingWorkStatus({commit},soldering_status)
 {
   commit('addSolderingWorkStatus',soldering_status);
 },  /**
 *
  @param {} param0
  @param {} event_array 
*/
addFinishingWorkStatus({commit},finishing_status)
{
  commit('addFinishingWorkStatus',finishing_status);
},  
/**
*
 @param {} param0
 @param {} event_array 
*/
addGemStonesWorkStatus({commit},gemstone_status)
{
 commit('addGemStonesWorkStatus',gemstone_status);
},  
  /**
   *
    @param {} param0
    @param {} event_array 
  */
  setSelectedProcedure({commit},selectedProcedure)
  {
    commit('setSelectedProcedure',selectedProcedure);
  },

  /**
   *
    @param {} param0
    @param {} event_array 
  */
  resetExtraWorkDetailsStructure({commit})
  {
    commit('resetExtraWorkDetailsStructure');
  },
  /**
   *
    @param {} param0
    @param {} event_array 
  */
  setExtraWorkFlowBasicObjectStructure({commit},specification)
  {
    commit('setExtraWorkFlowBasicObjectStructure',specification);
  },

  /**
   *
    @param {} param0 
    @param {} event_array 
  */
  addSameFlowForEachStoneValue({commit},no_of_flow_details)
  {
    commit('addSameFlowForEachStoneValue',no_of_flow_details);
  },

  /**
   *
    @param {} param0 
    @param {} event_array 
  */  
  addTotalNoOfStonesToStoneDetails({commit},total_no_of_items)
  {
    commit('addTotalNoOfStonesToStoneDetails',total_no_of_items);
  },

  /**
   *
    @param {} param0 
    @param {} event_array 
  */
  setNoOfStoneFlows({commit},no_of_flow_details)
  {
    commit('setNoOfStoneFlows',no_of_flow_details);
  },

  /**
   *
    @param {} param0 
    @param {} event_array 
  */
  updateStoneDetailsPerIndex({commit},event_array)
  {
    return new Promise((resolve, reject) => {
    commit('updateStoneDetailsPerIndex',event_array);
      resolve(true);
    }).catch(error => {
      reject(error);
    });
  },

  /**
   *
    @param {} param0 
    @param {} size_to 
  */
  setSizeTo({commit},size_to)
  { 
    commit('setSizeTo',size_to);
  },

  /**
   *
    @param {} param0 
    @param {} size_to 
  */
  setSizeNow({commit},size_now)
  {
    commit('setSizeNow',size_now);
  },

  /**
   *
    @param {} param0 
    @param {} stone_stringing_soldering_handled 
  */
  stoneStringingSolderingHandled({commit},stone_stringing_soldering_handled)
  {
    commit('stoneStringingSolderingHandled',stone_stringing_soldering_handled);
  },

  /**
   *
    @param {} param0 
    @param {} task_to_be_performed
  */
  setQuantity({commit},set_the_quantity)
  {
    commit('setQuantity',set_the_quantity);
  },

    /**
     *
      @param {} param0 
      @param {} task_to_be_performed 
    */
     setStaffGivenDescriptionOfItem({commit},task_to_be_performed)
     {
      commit('setStaffGivenDescriptionOfItem',task_to_be_performed);
    },

  /**
   *
    @param {} param0 
    @param {} shop 
  */
   ChangeWeldingToLaser({commit},change_to_or_not)
  {
    commit('ChangeWeldingToLaser',change_to_or_not);
  },
  
   /**
   *
    @param {} param0 
    @param {} sale_person_id 
  */
    bindSalePerson({commit},sale_person_id){
      commit('bindSalePerson',sale_person_id);
    },

    
  
   /**
   *
    @param {} param0 
    @param {} shop 
  */
  setShop({commit},shop){
    commit('setShop',shop);
  },
  /**
   *
    @param {} param0 
    @param {} previous_page_on_customer_change 
  */
   setLoader({commit},isLoading){
    commit('setLoader',isLoading);
  },

  /**
   *
    @param {} param0 
    @param {} previous_page_on_customer_change 
  */
  setPreviousPageOnCustomerChange({commit},previous_page_on_customer_change){
    commit('setPreviousPageOnCustomerChange',previous_page_on_customer_change);
  },
  /**
   *
    @param {} param0 
    @param {} OKWith700 
  */
   async OKWith700({commit},OKWith700){
    commit('OKWith700',OKWith700);
  },
  /**
   *
    @param {} param0 
    @param {} enable_welding_technology 
  */
   async enableWeldingTechnology({commit},enable_welding_technology){
    commit('enableWeldingTechnology',enable_welding_technology);
  },

  /**
   *
    @param {} param0 
    @param {} extra_labor 
  */
  async addExtraLabor({commit},extra_labor){
    commit('addExtraLabor',extra_labor);
  },
 
  /**
   *
    @param {} param0 
    @param {} stone_details 
  */
  async addStoneDetails({commit},stone_details){
    commit('addStoneDetails',stone_details);
  },

  /**
   *
    @param {} param0 
    @param {} resetCycle 
  */
  async resetCycle({commit},resetCycle){
    commit('resetCycle',resetCycle);
  },

  /**
   *
    @param {} param0 
    @param {} geller_sku 
  */
  async setGellerSKU({commit},geller_sku)
  {
    commit('setGellerSKU',geller_sku);
  },

  /**
   *
    @param {} param0
    @param {} current_cycle  
  */
  async setCycle({commit},current_cycle){
    commit('setCycle',current_cycle);
  },

  /**
   *
   * @param {*} param0 
  */
  async addDescriptionDetails({commit}){
    commit('addDescriptionDetails');
  },

  /**
   *
   * @param {*} param0 
   * @param {*} furthur_item 
  */
  async setFurthurItem({commit},furthur_item){
    commit('setFurthurItem',furthur_item)
  },

  /**
   *
   * @param {*} param0 
   * @param {*} furthur_sku_modal 
  */
  async askForFurthurSKUs({commit},furthur_sku_modal){
    commit('askForFurthurSKUs',furthur_sku_modal)
  },

 /**
   *
   * @param {*} param0 
   * @param {*} requested_envelopes 
  */
  async allowEnvelopes({commit},requested_envelopes){
     commit('allowEnvelopes',requested_envelopes)
  },

  /**
   *
   * @param {*} param0 
   * @param {*} shall_we_duplicate 
  */
  async shallWeDuplicateTheCustomer({state,commit},shall_we_duplicate){
      commit('shallWeDuplicateTheCustomer',shall_we_duplicate);
  },

  /**
   *
   * @param {*} param0 
   * @param {*} chapter 
  */
  async getEnvelopeNumbers({state,commit},chapter){
    await axios.get("/api/get-envelope-numbers?chapter="+chapter+"&no_of_envelopes="+state.requested_envelopes).then(response=>{
      var envelope_numbers = response.data.data;
      commit('getEnvelopeNumbers',envelope_numbers)
    });
  },
  
   /**
   *
   * @param {*} param0 
   * @param {*} chapter 
  */
  async generateEnvelopeNumbers({commit}){
    commit('generateEnvelopeNumbers');
  },
  
  /**
   * 
   * @param {commit object} param0 
   * @param {chapter} chapter 
   */

  fetchFlow({state,commit},chapter)
  {  
    // commit('setFlow');
    // console.log('state.main_chapter',state.main_chapter,typeof chapter,typeof state.main_chapter);
    return new Promise((resolve, reject) => {
      axios.get("/api/get-chapter-flow?chapter=" + chapter.chapter).then(response=>{
        var flow = response.data.data;
        if(chapter.chapter == state.main_chapter)
        {
          commit('setFlow',flow);
        }
        else
        {
          commit('setSecondaryFlow',flow);
        }
        resolve(flow);
        return flow;
      }).catch(error => {
        reject(error);
      });      
    }).catch(error=>{
    });
  },

  /**
   *
   * @param {*} param0
  */
  async incrementEnvelopeItem({commit}){
    commit('incrementEnvelopeItem');
  },
  /**
   *
   * @param {*} param0 
  */
   async incrementEnvelopeNumber({commit}){
    commit('incrementEnvelopeNumber');
  },
  /**
   *
   * @param {*} param0 
  */
  async resetState({commit}){
    commit('resetState');
  },

  /**
   *
   * @param {*} param0 
   * @param {*} description_of_item 
  */

  async addPricingDetails({commit},service)
  {
    commit('addPricingDetails',service);
  }, 

  /**
   * 
   * @param {*} param0 
   * @param {*} description_of_item 
  */

  async confirmJob({commit},if_history_added){
    commit('confirmJob',if_history_added);
  },
  /**
   * 
   * @param {*} param0 
   * @param {*} service_id 
  */

 async setServiceId({commit},service_id){
  commit('setServiceId',service_id);
},
  /**
   * 
   * @param {*} param0 
   * @param {*} description_of_item 
*/

 async setDescriptionOfItem({commit},descriptionOfItem){
  commit('setDescriptionOfItem',descriptionOfItem);
},

/**
   * 
   * @param {*} param0 
   * @param {*} photos 
*/

async setPhotosOfDescription({commit},photos){
  commit('setPhotosOfDescription',photos);
},
/**
   * 
   * @param {*} param0 
   * @param {*} is_rush 
*/
 async setWeldingTechnology({commit},technology){
  commit('setWeldingTechnology',technology);
},

 /**
   * 
   * @param {*} param0 
   * @param {*} show_modal_rhodium 
   */

  async setrhodiumplatingmodal({commit},show_modal_rhodium){
    // if('karats' in state.selections[state.selectedChapter] && state.selections[state.selectedChapter]['karats'].includes('wg')){
      // console.log('setrhodiumplatingmodal',show_modal_rhodium);
      commit('setrhodiumplatingmodal',show_modal_rhodium);
    // }
  },

  /**
   * 
   * @param {*} param0 
   * @param {*} show_modal 
   */

   async setpicklistmodal({commit},show_modal){
    commit('setpicklistmodal',show_modal);
  },
  /**
   * 
   * @param {*} param0 
   * @param {*} setIsRush 
   */

   async setIsRush({commit},is_rush){
    // console.log('set is rush called');
    commit('setIsRush',is_rush);
  },
   /**
   * 
   * @param {*} param0 
   * @param {*} rhodium_plating_status 
   */
  async setRhodiumPlate({commit},rhodium_plating_status){
    commit('setRhodiumPlate',rhodium_plating_status);
      // router.push("/description-of-item").catch(()=>{});
  },

  /**
   * 
   * @param {*} param0 
   * @param {*} picklist_statue 
   */

  async setpicklistItem({commit,state},picklist_status){

    commit('setpicklistItem',picklist_status);
    // if('karats' in state.selections[state.selectedChapter] && state.selections[state.selectedChapter]['karats'].includes('wg')){
    //   commit('setrhodiumplatingmodal',true);
    // }else{
    //   router.push("/description-of-item").catch(()=>{});
    // }

  },
  
  /**
   * 
   * @param {*} param0 
   */
   async addToSelections({commit},new_selection_to_be_added = null)
   {
    return new Promise((resolve, reject) => {
      commit('addToSelections',new_selection_to_be_added);
      resolve(flow);
      return flow;
    }).catch(error=>{
      reject(error);
    });
  },

  /**
   * 
   * @param {*} param0 
   */
    async getFlowOptions({commit,state,dispatch},option = null)
    {
      // console.log('------------1------------');
      return new Promise((resolve, reject) => 
      {
      // console.log('discarded array',state.discarded_item_array,state.discarded_item_array[0] == router.currentRoute.query.chapter
      // ,state.discarded_item_array[1] == router.currentRoute.query.procedure,);
    

      dispatch('setLoader',true);
      dispatch('setSelectedFlow',option == null ? 'reset' : option).then(async response1 => {
        if(state.main_chapter == state.selectedChapter)
        {
          var selecetedChapterFlow = state.chapterFlow[state.selectedFlow];
        }
        else
        {
          var selecetedChapterFlow = state.secondaryChapterFlow[state.secondarySelectedFlow];
        }
        const response = await axios.post("/api/get-next-options",{
        chapter: state.selectedChapter,
        previous_selections: state.selections[state.selectedChapter]['procedure_details_'+state.selectedProcedure]['options'],
        next_selection: selecetedChapterFlow,
        geller_sku:this.geller_sku,
        discarded_item:state.discarded_item_array[0] == state.selectedChapter && 
        state.discarded_item_array[1] == state.selectedProcedure && state.discarded_item_array[2] ? state.discarded_item_array[2]:null,
        no_of_appraisals:state.selectedChapter == "1200" &&
        state.selections[state.selectedChapter] && 'major_item' in state.selections[state.selectedChapter]['procedure_details_1']['options'] && state.selections[state.selectedChapter]['procedure_details_1']['options']['major_item'].toLowerCase() === 'appraisals'
        ? state.interlinked_option : null
      },{
        headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}
      });
      //  console.log('response');
      //  console.log(response.data);
      if(response.data.response_header.response_code == 200)
      {
        commit('setPercentage');
        
        var next_options = response.data.data;
        var next_option_array = Object.values(next_options);
        console.log('next options from backend');
        // console.log(next_options['interlink_quantity']);
        // console.log(next_options,typeof next_options);
        var unique = [...new Set(next_option_array)];
        // console.log(typeof next_options);

        // console.log(unique[0]);
        if((unique[0] && 0 in unique[0] && selecetedChapterFlow == 'color') && (unique[0][0] == 'both' || (unique[0][0].toLowerCase().includes('yg') && unique[0][0].toLowerCase().includes('wg'))))
        {
          next_options = {'color':['White','Yellow']};
          next_option_array = ['White','Yellow'];
          commit('discardColor',true);
        }
        // console.log('------------3------------');
        
          console.log('next_options',unique[0]);
          if(next_options != '-1')
          {
          if(state.selectedChapter ==  '1100' && 'complication_surcharge' in next_options)
          {
            commit('setComplicationSurcharge',next_options['complication_surcharge']);
          }
          if(state.selectedChapter ==  '1200' && 'extra_work_per_appraisal' in next_options)
          {
            commit('setInterlinkedQuantities',next_options['extra_work_per_appraisal']);
          }
          // if(state.selectedChapter ==  '1200' && 'interlinked_option' in next_options)
          // {
          //   commit('setInterlinkedQuantities',next_options['extra_work_per_appraisal']);
          // }
          if(state.selectedChapter ==  '1200' && 'interlink_quantity_for_individual_items' in next_options)
          {
            commit('setInterlinkedQuantityForIndividualItems',next_options['interlink_quantity_for_individual_items']);
          }
          if(state.selectedChapter ==  '1000')
          {
            if('popup' in next_options)
            {
              if(0 in unique && unique[0] !== '' && unique[0].length !== 0)
              {
                commit('enableRequireMetalPopup',true);
                dispatch('setLoader',false);
                return;
              }
            }
            else if('dependent_chapter' in next_options)
            {
              if(0 in unique && unique[0] !== '')
              {
                new Promise(function(resolve, reject) {
                  if(unique[0] == '800')
                  {
                    dispatch('addExtraLabor', 'pendant');
                    commit('setPartOnly',true)
                  }
                  if(unique[0] == '300')
                  {
                    console.log('clasp is extra');
                    dispatch('addExtraLabor', 'clasp');
                    commit('setPartOnly',true)
                  }
                  if(unique[0] == '400')
                  {
                    dispatch('addExtraLabor', 'post_and_back');
                    commit('setPartOnly',true)
                  }
                  resolve(true);
                  return true;
                }).then(function(result) { // (**)
                  if(unique[0] == '800')
                  {
                    dispatch('setExtraWorkFlowBasicObjectStructure','pendant');
                    commit('setPartOnly',true)
                  }
                  if(unique[0] == '300')
                  {
                    dispatch('setExtraWorkFlowBasicObjectStructure','clasp');
                    commit('setPartOnly',true)
                  }
                  if(unique[0] == '400')
                  {
                    dispatch('setExtraWorkFlowBasicObjectStructure','post_and_back');
                    commit('setPartOnly',true)
                  }
                  return true;
                }).then(function(result) { // (**)
                  console.log('flow options after dependent chapter',selecetedChapterFlow);
                  dispatch('getFlowOptions', selecetedChapterFlow); 
                  // Its being minus because when 
                  // Getflowoptions is being called and incremented 
                  return true;
                });
              }
              else
              {
                dispatch('getFlowOptions', state.chapterFlow[state.selectedFlow - 1]); 
              }
            }else if('require_weight_popup' in next_options){
              if(0 in unique && unique[0] == '1')
              {
                commit('enableRequireWeightPopup',true);
                axios.get("/api/get-chap1000metals",{},{headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}})
                  .then(metal_response=>{
                  var metals = metal_response.data.data
                  console.log('metal_response and data',metal_response,metals)
                  dispatch('setMetals',metals);
                  }).catch(error=>{
                  console.log(error)
                  });
                dispatch('setLoader',false);
                return;
              }
            }
          }
          
          // means its welding technology, no need to to set as next options
          if(((unique.length == 1 && (unique[0] == null || unique[0] == '' || unique[0] == undefined)) || unique.length == 0) && !('quantity' in next_options) )
          {
            // this check is implemented so that price_criteria_item should not be incremented
            // to another chapter flow and ca be used below
            if(selecetedChapterFlow !== 'price_criteria_item')
            {
              // call next options again if previous are empty
              // its incrementing selectd flow except when next is price criterian item  
              // (async () => console.log(await dispatch('getFlowOptions', selecetedChapterFlow)))();
              commit('deleteUnWantedOptions');
              dispatch('getFlowOptions', selecetedChapterFlow);
              return;
            }
            // console.log('------------4------------');
          }
          else
          {
            // console.log('------------5------------');
            if(selecetedChapterFlow == 'price_criteria_item')
            {
              console.log('hi',unique[0]);
              // if current is price criteria item and chapter doesnot have price criterain item then handle manually by inserting in next_options
              // if(unique[0] && unique[0].length !== 0 && unique[0] !== ''){
              if((unique[0] !== 'N/A' && (typeof unique[0] == 'object' && 0 in unique[0] && unique[0][0] !== 'N/A')) && !(state.selectedChapter == '1200' && state.selections[state.selectedChapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('appraisals')))
              commit('setPriceCriteriaItem', {'price_criteria_item_name':unique[0]}); 
              if((unique[0] !== 'N/A' && (typeof unique[0] == 'object' && 0 in unique[0] && unique[0][0] !== 'N/A')) && state.selectedChapter == '700') // as in 700 price criteria item is last
              {
                console.log('should enableask stone details');
                commit('enableAskStoneDetailsPopup',true); 
                commit('stoneStringingSolderingHandled',false);
              }
              else if((unique[0] !== 'N/A' && 
              (typeof unique[0] == 'object' && 0 in unique[0] && unique[0][0] == 'N/A')) && state.selectedChapter == '700')
              {
                commit('resetStoneNumber');
                commit('setPriceCriteriaItem','')
              }
              // }
              // from backend quantity is being set when price critaerian item request is sent 
              if("quantity" in next_options && next_options['quantity'] == true)
              {
                // console.log('------------6------------');

                dispatch('setSelectedFlow').then(flow_response => { // incrementing and next is welding technology
                  commit('enableQuantity',true);
                  commit('setQuantity',1);
                });
              }
              else
              {
                // console.log('------------7------------');

                // as 1200 flow contians quantity in between price criteria item and welding technology.
                if(state.chapterFlow[state.selectedFlow + 1] == 'quantity')
                {
                  dispatch('setSelectedFlow');
                }
              }
            }
            // set price criterian item only if we get from backend
            // console.log('price_criteria_item in nextoptions');
            // console.log(next_options['price_criteria_item']);
            // console.log('price_criteria_item' in next_options);
            if(!('price_criteria_item' in next_options && (next_options['price_criteria_item'].length === 0 || next_options['price_criteria_item'][0] == ''))){
            // console.log('------------8------------');
              
              commit('setNextOptions', next_options);
            }
          }
        }
        else if(next_options == '-1' && state.selectedChapter == '900')
        {
          dispatch('enableWeldingTechnology',true);
          next_options = {'welding_technology':['Torch','Laser']}
          commit('setNextOptions', next_options);
        }
        // console.log('before');
        // console.log(selecetedChapterFlow);
        // console.log(state.chapterFlow[state.selectedFlow + 1]);
        // sirf 1200 k case men nhi dikhana unless k backend sy receive na huye hon.
        console.log('selected chapter flow');
        console.log(selecetedChapterFlow);

        if((selecetedChapterFlow  === 'price_criteria_item' && 
        state.chapterFlow[state.selectedFlow + 1] === 'welding_technology') ||
        (state.chapterFlow[state.selectedFlow + 1] === 'welding_technology' && 
        (state.selectedChapter !== '100' && selecetedChapterFlow !== 'ring_size'))  ||
        (selecetedChapterFlow === 'welding_technology' && state.selectedChapter !== '900'))
        {
          // console.log(state.selectedChapter == "1200",state.selections[state.selectedChapter]['procedure_details_1']['options']['major_item'].toLowerCase() === 'broken peg in a pearl ring');
          if((
          state.selectedChapter == "1200" && 'major_item' in state.selections[state.selectedChapter]['procedure_details_1']['options']
          && state.selections[state.selectedChapter]['procedure_details_1']['options']['major_item'].toLowerCase() === 'broken peg in a pearl ring') ||
          state.selectedChapter != 1200 && state.selectedChapter != "1200")
          {
            console.log('if case executed');
            dispatch('setSelectedFlow').then(flow_response => {
              dispatch('enableWeldingTechnology',true);
            //   if(selecetedChapterFlow == 'welding_technology' && state.chapterFlow[state.selectedFlow + 1] == undefined)
            // { // this if check was to make sure that welding tech is last but can activated again as per changing requirements
              console.log('setWeldingTechnology would be called');
              dispatch('setWeldingTechnology');
            // }
            });
          } 
          else
          {
            console.log('if case dont');

            console.log('after code after setWeldingTechnology');
            // its called in every case to reach maximim chapter flow so that we can submit the flow.
            
            dispatch('setSelectedFlow').then(flow_response => {
              dispatch('enableWeldingTechnology',false);
            //   if(selecetedChapterFlow == 'welding_technology' && state.chapterFlow[state.selectedFlow + 1] == undefined)
            // { // this if check was to make sure that welding tech is last but can activated again as per changing requirements
              // console.log('setWeldingTechnology would be called');
              // dispatch('setWeldingTechnology');
            // }
            }); 
          }
        }
        else if(state.selectedChapter == '900' && 
                state.chapterFlow[state.selectedFlow + 1] === 'welding_technology')
        {
            console.log('else if 900 case');
          // dispatch('setSelectedFlow').then(flow_response => {
            dispatch('enableWeldingTechnology',true);
            dispatch('setWeldingTechnology');
          // });
        }
        
        
        // next to call 
        // next to call that already set by us
        router.push({name:"flow-option",query: { chapter: state.selectedChapter,procedure:state.selectedProcedure }}).catch(()=>{});
      }
      else 
      {
        // dispatch('setLoader',false);
        if(response.data.response_header.response_code == 202){
          // show popup
          // following commit is being handled in laser and torch screen
          if(state.selectedChapter == state.main_chapter)
          {
            dispatch('setIfPicklistExists',true);
          }
          else
          {
            dispatch('setIfPicklistExists',false);
          }
        }else if(response.data.response_header.response_code == 203){
          // show popup
          // following commit is being handled in laser and torch screen
          dispatch('setIfPicklistExists',false);
        }
        // if next exists
        if(state.chapterFlow[state.selectedFlow + 1])
        {
          dispatch('getFlowOptions', state.chapterFlow[state.selectedFlow]);
          return;
        }
      }
      dispatch('setLoader',false);
        resolve(true);      
    });
    },error =>{
      reject(error);
    });            
  },

  /**
   * 
   * @param {*} param0 
   * @param {*} seleted_flow_index 
   */
   async setIfPicklistExists({commit},to_set){  
    commit('setIfPicklistExists',to_set);
  },
  /**
   * 
   * @param {*} param0 
   * @param {*} seleted_flow_index 
   */
  async setSelectedFlow({commit},selectedFlow){  
    return new Promise((resolve, reject) => {
    commit('setSelectedFlow',selectedFlow);
      resolve(true);      
    }).catch(error=>{
      reject(false);
    });
  },

  /**
   * 
   * @param {*} param0 
   * @param {*} chapter 
   */
  async setSelectedChapter({commit},chapter_array){ 
    commit('setSelectedChapter',chapter_array)
  },

/**
 * 
 * @param {*} param0 
 * @param {*} jeweler_id 
 */
  async selectTheJeweler({commit},jeweler_id){ 
    commit('setJeweler',jeweler_id)
  },

  /**
   * 
   * @param {*} param0 
   * @param {*} customer_id 
   */
   async setTheCustomer({commit},customer){ 
    commit('setTheCustomer',customer)
  },
   async setNextOption({commit}){
    commit('setNextOption')
  },

}

export const dataStore  = {
  namespaced:true,
  state,
  getters,
  mutations,
  actions,
};

