
<template>
    <div>
        <div class="row justify-content-center">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">POS</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Area Chart -->
            <div class="col-xl-5 col-lg-5">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">POS Insert</h6>
                  <a href="" class="btn btn-sm btn-info">Add Customer</a>
                </div>
                

 
                
                <div class="table-responsive" style="font-size: 12px;">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                      <tr v-for="cart in carts" :key="cart.id">
                        <td>{{ cart.pro_name }}</td>
                        <td><input type="text" readonly="" style="width: 50px;" :value="cart.pro_quantity">
                          <button @click.prevent="increment(cart.id)" class="btn btn-success">+</button>
                          <button @click.prevent="decrement(cart.id)" class="btn btn-danger">-</button>
                        </td>
                        <td>{{ formatPrice(cart.product_price) }}</td>
                        <td>{{ formatPrice(cart.sub_total) }}</td>
                        <td><a @click="removeItem(cart.id)" class="btn btn-primary text-white">X</a></td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
                  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                     Total Quantity:
                      <strong>{{ qty }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                     Sub Total :
                      <strong><span>&#8369;</span> {{ formatPrice(subTotal) }}</strong>
                    </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                     Vat :
                      <strong>{{ vats.vat }} %</strong>
                    </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                     Total Amount :
                      <strong><span>&#8369;</span> {{ formatPrice(totalAmount)}}</strong>
                    </li>
                  </ul>
                  <br><br>

                  <form @submit.prevent="orderDone">
                    <label>Customer Name</label>
                    <select class="form-control" v-model="customer_id">
                      <option :value="customer.id" v-for="customer in customers">{{ customer.name }}</option>

                    </select>
                    <label>Pay</label>
                    <input type="text" class="form-control" required="" v-model="pay">
                    
                    <label>Due</label>
                    <input type="text" disabled class="form-control" v-if="this.pay != ''" required="" v-model="due">
                    <input type="text" disabled class="form-control" v-else required="">

                    <label>Pay By</label>
                    <select class="form-control" v-model="payby">
                      <option value="Cash">Cash</option>
                      <option value="Cheaque">Cheaque</option>
                      <option value="GiftCard">Gift Card</option>
                    </select>

                    <br>
                    <button type="submit" class="btn btn-success">Sumbit</button>
                  </form>
                </div>


              </div>
            </div>


            <!-- Pie Chart -->
            <div class="col-xl-7 col-lg-7">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                </div>
                <!-- Category Wise -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Product</button>
                  </li>

                  <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" @click="subProduct(category.id)">{{ category.category_name }}</button>
                  </li>
                </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card-body">
                      <input type="search" v-model="searchTerm" class="form-control" style="width: 550px;" placeholder="Search Product">
                      <br>
                        <div class="row">
                          <div class="col-lg-3 col-md-3 col-sm-6 col-" v-for="product in filterSearch" :key="product.id"> 
                          <button class="btn btn-sm" @click.prevent="AddToCart(product.id)" href="#">
                          <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                <img class="card-img-top" :src="product.image" id="em_photo">
                                <div class="card-body">
                                    <h5 class="card-title">{{ product.product_name }}</h5>
                                      <span class="badge badge-success"  v-if="product.product_quantity >= 1">Available {{ product.product_quantity }}</span>
                                    <span class="badge badge-danger" v-else=" ">Stock out</span>
                                </div>
                            </div></button>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card-body">
                          <input type="search" v-model="getSearchTerm" class="form-control" style="width: 550px;" placeholder="Search Product">
                      <br>
                    <div class="row">
                      <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="getProduct in getFilterSearch" :key="getProduct.id"> 
                     <button class="btn btn-sm" @click.prevent="AddToCart(getProduct.id)" href="#">
                      <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                            <img class="card-img-top" :src="getProduct.image" id="em_photo">
                            <div class="card-body">
                                <h5 class="card-title">{{ getProduct.product_name }}</h5>
                                  <span class="badge badge-success"  v-if="getProduct.product_quantity >= 1">Available {{ getProduct.product_quantity }}</span>
                                <span class="badge badge-danger" v-else=" ">Stock out</span>
                            </div>
                        </div></button>
                        </div>
                      </div>
                      </div>
                </div>
                </div>

                <!-- End -->

            
                </div>
              
              </div>
            </div>

          </div>
          <!--Row-->


          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <br>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="login.html" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>
    </div>
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
    this.allProduct();
    this.allCategory();
    this.allCustomer();
    this.cartProduct();
    this.vat();
    Reload.$on('afterAdd', () => {
      this.cartProduct();
    })

  },
   data() {
     return {
       customer_id:'',
       pay:'',
       payby:'',
       products:[],
       categories:'',
       getProducts:[],
       searchTerm: '',
       getSearchTerm: '',
       customers: '',
       errors: '',
       carts:[],
       vats:''     
       }
   },

   computed:{
     filterSearch(){
       return this.products.filter(product => {
         return product.product_name.toLowerCase().match(this.searchTerm.toLowerCase())
       })
     },
     getFilterSearch(){
       return this.getProducts.filter(getProduct => {
         return getProduct.product_name.toLowerCase().match(this.getSearchTerm.toLowerCase())
       })
     },
     qty() {
       let sum = 0;
       for(let i=0; i < this.carts.length; i++) {
          sum += (parseFloat(this.carts[i].pro_quantity));
       }
       return sum;
     },
     subTotal() {
       let sum = 0;
       for(let i=0; i < this.carts.length; i++) {
          sum += (parseFloat(this.carts[i].pro_quantity)) * (parseFloat(this.carts[i].product_price));
       }
       return sum;
     },
     totalAmount() {
       let total = 0;
       total = (this.subTotal * this.vats.vat/100) + this.subTotal ;

       return total;
     },
     due: function() {
       return this.pay - this.totalAmount;
     }
   },
  
  methods: {
    //Card Methods Here 
     AddToCart(id){
      axios.get('/api/addToCart/'+id)
      .then(() => {
        Reload.$emit('afterAdd');
        Notifications.cart_success()
      })
      .catch()
    },
    cartProduct(){
      axios.get('/api/cart/product/')
      .then(({data}) => (this.carts = data))
      .catch()
    },
    removeItem(id){
       axios.get('/api/remove/cart/'+id)
      .then(() => {
        Reload.$emit('afterAdd');
        Notifications.cart_delete()
      })
      .catch()
    },
    increment(id){
      axios.get('/api/cart/increment/'+id)
      .then(() => {
        Reload.$emit('afterAdd');
        Notifications.cart_success()
      })
      .catch()
    },
    decrement(id){
      axios.get('/api/cart/decrement/'+id)
      .then(() => {
        Reload.$emit('afterAdd');
        Notifications.cart_delete()
      })
      .catch()
    },
    vat() {
       axios.get('/api/vats/')
      .then(({data}) => (this.vats = data))
      .catch()
    },
    // End Cart features methods 
     allProduct(){
      axios.get('/api/product/')
      .then(({data}) => (this.products = data))
      .catch()
    },
     allCategory(){
      axios.get('/api/category/')
      .then(({data}) => (this.categories = data))
      .catch()
    },
     subProduct(id){
      axios.get('/api/getting/product/'+id)
      .then(({data}) => (this.getProducts = data))
      .catch()
    },
     formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
      allCustomer(){
      axios.get('/api/customer/')
      .then(({data}) => (this.customers = data))
      .catch(console.log('error'))
    },
    orderDone(){
      let total = this.subTotal * this.vats.vat/100 + this.subTotal;
      const data = { qty:this.qty, subTotal:this.subTotal, customer_id:this.customer_id, payby:this.payby, pay:this.pay, 
      due:this.due, vat:this.vats.vat, total:total }

      axios.post('/api/orderDone', data)
      .then(res => {
      Notifications.success()
      window.location.reload()
      this.$router.push({name: 'pos'})
      })
    }
  },

 }
</script>

<style type="text/css" scoped>
  #em_photo{
    height: 100px;
    width: 135px;
  }
</style>
