import moment from 'moment';
import Vue from 'vue'
Vue.filter('dateformat',(arg)=>{
    return moment(arg).format("MMM Do YYYY");
})
Vue.filter('textshorten',(text,length,prefix)=>{
    return text.substring(0,length)+prefix;
})
