 

<template>
  
  <div>

  <div class="row">
    <div class="col-sm-12">
  <router-link to="/stock" class="btn btn-primary float-right">Back </router-link>
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
                    <h1 class="h4 text-gray-900 mb-4"> Stock Update</h1>
                  </div>

      <form class="user" @submit.prevent="stockUpdate">                  
            
                        <div class="form-group">

                            <div class="form-row">
            
                                <div class="col-md-12">
                                <label for="exampleFormControlSelect1">Product Stock</label>
                                <input type="number" class="form-control" id="exampleInputFirstName"  v-model="form.product_quantity">
                                <small class="text-danger" v-if="errors.product_quantity"> {{ errors.product_quantity[0] }} </small>
                                    </div>     
                            
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                        
                    </form><hr>
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



<script  lang="ts">
  
  export default {
    created(){
      if (!User.loggedIn()) {
        this.$router.push({name: '/'})
      }
    },
    data(){
    return {
      form:{
        product_quantity: ''
      },
      errors:{},
    }
  },
  created(){
  	let id = this.$route.params.id
  	axios.get('/api/product/'+id)
  	.then(({data}) => (this.form = data))
  	.catch(console.log('error'))
  },
  methods:{
  
  stockUpdate(){
  	  let id = this.$route.params.id
       axios.post('/api/stock/update/'+id,this.form)
       .then(() => {
        this.$router.push({ name: 'stock'})
        Notifications.success()
       })
       .catch(error =>this.errors = error.response.data.errors)
     },
  } 
  }
   
</script>


<style type="text/css">
  
</style>