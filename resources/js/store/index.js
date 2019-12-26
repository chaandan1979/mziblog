export default {
    state:{
        category:[],
        posts:[]
    },
    getters:{
        getCategory(state){
            return state.category
        },
        getAllPost(state){
            return state.posts
        }
    },
    actions:{
        allCategory(context){
            axios.get('/category')
                .then((response)=>{
                    context.commit('mcategories',response.data.categories)
                })
        },
        allPost(context){
            axios.get('/post')
                .then((response)=>{
                    console.log(response.data.posts)
                    context.commit('allpostsdata',response.data.posts)
                })
        }
    },
    mutations:{
        mcategories(state,data){
            return state.category = data
        },
        allpostsdata(state,payload){
            return state.posts = payload
        }
    }
}
