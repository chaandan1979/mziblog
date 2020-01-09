export default {
    state:{
        category:[],
        posts:[],
        blogpost:[]
    },
    getters:{
        getCategory(state){
            return state.category
        },
        getAllPost(state){
            return state.posts
        },
        getAllBlogPost(state){
            return state.blogpost
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
        },
        getAllBlogPost(context){
            axios.get('/blogposts')
                .then((response)=>{
                    console.log(response.data.posts)
                    context.commit('allblogpostsdata',response.data.posts)
                })
        }
    },
    mutations:{
        mcategories(state,data){
            return state.category = data
        },
        allpostsdata(state,payload){
            return state.posts = payload
        },
        allblogpostsdata(state,payload){
            return state.blogpost = payload
        }
    }
}
