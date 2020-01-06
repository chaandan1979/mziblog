<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Post List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Post</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools float-right align-right"><button class="btn btn-primary"><router-link to="/add-post" style="color: #fff">Add New Post</router-link></button></div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc">Sl No.</th>
                                                <th class="sorting">Photo</th>
                                                <th class="sorting">Name</th>
                                                <th class="sorting">Description</th>
                                                <th class="sorting">Posted By</th>
                                                <th class="sorting">Category</th>
                                                <th class="sorting">Created Date</th>
                                                <th class="sorting">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd" v-for="(post,index) in getAllPost" :key="post.id">
                                                <td class="sorting_1">{{index+1}}</td>
                                                <td><img :src="postImage(post.photo)" width="100" height="110" alt=""></td>
                                                <td>{{post.title|textshorten(20,'---')}}</td>
                                                <td>{{post.description|textshorten(40,'...')}}</td>
                                                <td v-if="post.user">{{post.user.name}}</td>
                                                <td v-if="post.category">{{post.category.cat_name}}</td>
                                                <td>{{post.created_at|dateformat}}</td>
                                                <td><router-link :to="`edit-post/${post.id}`">Edit</router-link> | <a href="" @click.prevent="deletePost(post.id)">Delete</a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    export default {
        name: "List",
        mounted(){
            this.$store.dispatch('allPost')
        },
        computed:{
            getAllPost(){
              return this.$store.getters.getAllPost
            }
        },
        methods:{
            postImage(img){
                var pattern = /^((http|https|ftp):\/\/)/;

                if(!pattern.test(img)) {
                    return "uploadPostImages/" + img;
                }else{
                    return img;
                }
            },
            deletePost(id){
                axios.get("/deletepost/"+id)
                    .then(()=>{
                        this.$store.dispatch('allPost')
                        Toast.fire({
                            icon: 'success',
                            title: 'Post Deleted successfully'
                        })
                    })
                    .catch(()=>{

                    })
            }
        }
    }
</script>

<style scoped>

</style>
