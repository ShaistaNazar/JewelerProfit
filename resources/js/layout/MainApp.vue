<template>
    <div>
        <div class="main_view" >
            <!-- Page Loader -->
            <div class="vld-parent">
                <loading :active.sync="isLoading" :is-full-page="true" ></loading>
            </div>
            <div v-if="$route.meta.guest || $route.path.includes('personal-information')">
                <div>
                    <router-view></router-view>
                </div>
            </div>
            <!-- dashboard -->
            <div v-else-if="$route.meta.guest !== false && $route.path.includes('dashboard')">
                <div class="">
                    <basic-header/>
                </div>
                <dashboard-side-bar></dashboard-side-bar>
                <div class="main_view_inner" v-bind:class="{'isSetting': $route.path === '/'}">
                    <router-view></router-view>
                </div>
            </div>
            <div v-else>
                <div class=""  v-if="$route.path !== '/personal-information'">
                    <basic-header/> 
                </div>
                <side-bar v-if="$route.path !== '/' && $route.path !== '/personal-information'"></side-bar>
                <div class="main_view_inner" v-bind:class="{'isSetting': $route.path === '/'}">
                    <router-view></router-view>
                </div>
            </div>

        </div>
        <div>
            <custom-footer/>
        </div>
    </div> 
</template>

<script>
// Import component
import SideBar from './SideBar.vue';
import Loading from 'vue-loading-overlay';
export default {
  name:'app',
  components: {

    'loading':Loading,
    'side-bar': SideBar

   },
   computed: {
        
    },
    mounted(){
        console.log(this.$route)
    },
    watch: {
        "$route"(val) 
        {
        },
    },
     data(){

       return {

        isLoading: false,
        fullPage: true,
        isSetting: true,

       }

     },

    created() {
        
        this.init();
        
    }, 

    methods: {

        /**
         * Initialize app
         */
        
        init() {
            this.setHeaders();   
        },

        /**
         * Set general headers for each axios request
         */

        setHeaders() {
            let token = localStorage.getItem('token');
            axios.defaults.headers.common['Content-Type'] = 'application/json';
            if(token)
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        },

        /**
          * Fetch Permissions
         */

        fetchPermission(value) {
            axios.get("/api/permissions").then(({
                data
            }) => this.permissions = data);
        },

        /**
         * Get configuration for app
         */

        getConfig() {
            let response = axios.get('/api/config');

            if (response.data) {
                let config = response.data;
            }
        },
    },
}
</script>
<style scoped>

</style>