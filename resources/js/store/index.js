import Vue from 'vue'
import Vuex from 'vuex'
import { dataStore  } from'./modules/pricingFlow';
import createPersistedState from "vuex-persistedstate";
Vue.use(Vuex);

const dataState  = createPersistedState({
    storage: sessionStorage
  });

export default new Vuex.Store({
    modules: {
        dataStore,
    },
    plugins: [dataState],
    strict:true
});
// import Vue from 'vue';
// import Vuex from 'vuex';

// Vue.use(Vuex);

// const moduleA = {
//     state: { 
//         count: 3
//     },
//     mutations: {
        
//     },
//     getters: {
        
//     },
//     actions: {
        
//     }
// }

// const moduleB = {
//     state: {
//         count: 8
//     },
//     mutations: {
        
//     },
//     getters: {
        
//     },
//     actions: {
        
//     }
// }

// const store = new Vuex.Store({
//     modules: {
//         a: moduleA,
//         b: moduleB
//     },
// })
