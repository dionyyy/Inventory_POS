

<template>
  
  <div>

 <div class="row">
    <div class="col-sm-12">
  <router-link to="/customer" class="btn btn-primary float-right">All Customer </router-link>
    </div>
 </div>



    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Update Customer</h1>
                  </div>

                    <form class="user" @submit.prevent="customerUpdate" enctype="multipart/form-data">

                        <div class="form-group">

                        <div class="form-row">
                            <div class="col-md-6">
                            <label for="exampleFormControlTextarea1"><b>Name</b></label>
                        <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name" v-model="form.name">
                        <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
                            </div>


                        <div class="col-md-6">
                        <label for="exampleFormControlTextarea1"><b>Email</b></label>
                            <input type="email" class="form-control" id="exampleInputFirstName" placeholder="Enter Email" v-model="form.email">
                            <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </small>
                        </div>     
                            
                        </div>
                        </div>
                    
                        
                        <div class="form-group">

                        <div class="form-row">
                            <div class="col-md-6">
                            <label for="exampleFormControlTextarea1"><b>Address</b></label>
                        <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Address" v-model="form.address">
                        <small class="text-danger" v-if="errors.address"> {{ errors.address[0] }} </small>
                            </div>


                    <div class="col-md-6">
                    <label for="exampleFormControlTextarea1"><b>Phone</b></label>
                        <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Phone Number" v-model="form.phone">
                        <small class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </small>
                            </div>     
                            
                        </div>
                        </div>

                    


                        <div class="form-group">

                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">

                                <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small>
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>


                             <div class="col-md-6">
                                <img :src="form.photo" style="height: 40px; width: 40px;">
                             </div>     
                                
                        </div>
                        </div>

                


                        <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                        
                    </form>
                  <hr>
                  <div class="text-center">
  
  
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</template>



<script lang="ts">
  
  export default {
    created(){
      if (!User.loggedIn()) {
        this.$router.push({name: '/'})
      }
    },

    data(){
    return {
      form:{
        name: '',
        email: '',
        phone: '',
        address: '',
        photo: '',
        newphoto: '',
      },
      errors:{}
    }
  },

  created(){
  	let id = this.$route.params.id
  	axios.get('/api/customer/'+id)
  	.then(({data}) => (this.form = data))
  	.catch(console.log('error'))
  },
  methods:{
    onFileSelected(event){
     let file = event.target.files[0];
     if (file.size > 1048770) {
      Notifications.image_validation()
     }else{
      let reader = new FileReader();
      reader.onload = event =>{
        this.form.newphoto = event.target.result
        console.log(event.target.result);
      };
      reader.readAsDataURL(file);
     }
    },
    customerUpdate(){
  	  let id = this.$route.params.id
       axios.patch('/api/customer/'+id,this.form)
       .then(() => {
        this.$router.push({ name: 'customer'})
        Notifications.success()
       })
       .catch(error =>this.errors = error.response.data.errors)
     },
  } 


  }
   
</script>


<style type="text/css">
  
</style>