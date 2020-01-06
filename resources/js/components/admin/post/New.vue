<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Post</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Add New Post</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <!-- left column -->
                    <div class="col-md-8">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add New Post</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" enctype="multipart/form-data" @submit.prevent="addnewPost()">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="addNewPostTitle">Title</label>
                                        <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('title') }" id="addNewPostTitle" placeholder="Title" v-model="form.title" name="title">
                                        <has-error :form="form" field="title"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="addNewPostDescription">Description</label>
                                        <markdown-editor v-model="form.description"  id="addNewPostDescription"></markdown-editor>
                                        <has-error :form="form" field="description"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="addNewPostCategory">Category</label>
                                        <select name="cat_id" id="addNewPostCategory" class="form-control" :class="{ 'is-invalid': form.errors.has('cat_id') }" v-model="form.cat_id">
                                            <option value="" disabled>Select category</option>
                                            <option :value="category.id" v-for="category in getAllCategory">{{category.cat_name}}</option>
                                        </select>
                                        <has-error :form="form" field="cat_id"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="addNewPostPhoto">Photo</label>
                                        <input type="file" id="addNewPostPhoto" @change="changePhoto($event)" :class="{ 'is-invalid': form.errors.has('photo') }">
                                        <img v-if="form.photo != ''" :src="form.photo" alt="" width="80" height="80">
                                        <has-error :form="form" field="photo"></has-error>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
            </div>
        </section>

    </div>
</template>

<script>
    export default {
        name: "New",
        data(){
            return{
                form: new Form({
                    title:'',
                    description:'',
                    cat_id:'',
                    photo:''
                })
            }
        },
        mounted(){
            this.$store.dispatch('allCategory')
        },
        computed:{
            getAllCategory(){
                return this.$store.getters.getCategory
            }
        },
        methods:{
            changePhoto(event){
                let file = event.target.files[0];
                if(file.size > 1024678){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        footer: '<a href>Why do I have this issue?</a>'
                    })
                }else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.photo = event.target.result
                };
                reader.readAsDataURL(file);
                }
            },
            addnewPost(){
                this.form.post('/savepost')
                    .then((response)=>{
                        this.$router.push('/post-list')
                        Toast.fire({
                            icon: 'success',
                            title: 'Post Added successfully'
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
