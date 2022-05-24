
<template>
<div>
  
    <br>
    
      <input type="search" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search Here">
    <br>

     <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Today Order</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Total Amount</th>
                        <th>Pay</th>
                        <th>Due</th>
                        <th>Payby</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in filterSearch" :key="order.id">
                        <td>{{ order.name }}</td>
                        <td>{{ formatPrice(order.total) }}</td>
                        <td>{{ formatPrice(order.pay) }}</td>
                        <td>{{ formatPrice(order.due) }}</td>
                        <td>{{ order.payby }}</td>
                        <td>
                          <router-link :to="{name: 'view-order', params: {id: order.id}}" class="btn btn-sm btn-primary">View</router-link>
                         
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
    this.allOrder();
  },
   data() {
     return {
       orders:[],
       searchTerm: ''
     }
   },

   computed:{
     filterSearch(){
       return this.orders.filter(order => {
         return order.name.toLowerCase().match(this.searchTerm.toLowerCase())
       })
     }
   },
  
  methods: {
     allOrder(){
      axios.get('/api/orders/')
      .then(({data}) => (this.orders = data))
      .catch(console.log('error'))
    },
    formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },

  },

 }
</script>

<style type="text/css">
 
</style>
