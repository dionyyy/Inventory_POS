
<template>
<div>
    <div class="row">
      <div class="col-sm-12">
        <router-link to="/store-customer" class="btn btn-primary float-right">Add Customer</router-link>
        </div>
    </div>
    <br>
    
      <input type="search" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search Here">
    <br>

     <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="customer in filterSearch" :key="customer.id">
                        <td>{{ customer.name }}</td>
                        <td><img :src="customer.photo" id="em_photo"></td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ customer.email }}</td>
                        <td>{{ customer.address }}</td>
                        <td>
                          <router-link :to="{name: 'edit-customer', params: {id: customer.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                          <a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger"><font color="white">Delete</font></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
          <!--Row-->
</div>
</template>

<script lang="ts">
 export default {
   created() {
     if (!User.loggedIn()) {
       this.$router.push({ name: '/' })
     }
   },

    created() {
    this.allCustomer();
  },
   data() {
     return {
       customers:[],
       searchTerm: ''
     }
   },

   computed:{
     filterSearch(){
       return this.customers.filter(customer => {
         return customer.name.toLowerCase().match(this.searchTerm.toLowerCase())
       })
     }
   },
  
  methods: {
     allCustomer(){
      axios.get('/api/customer/')
      .then(({data}) => (this.customers = data))
      .catch(console.log('error'))
    },
    formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
    deleteCustomer(id){
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete('/api/customer/'+id)
            .then(() => {
              this.customers = this.customers.filter(customer => {
                return customer.id != id
              })
            })
            .catch(() => {
              this.$router.push({name: 'customer' })
            })
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
          }
        })
    }
  },

 }
</script>

<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>
