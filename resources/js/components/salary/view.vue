
<template>
<div>
    <div class="row">
      <div class="col-sm-12">
        <router-link to="/salary" class="btn btn-primary float-right">Back</router-link>
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
                  <h6 class="m-0 font-weight-bold text-primary">Employee Salary Details</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="employee in filterSearch" :key="employee.id">
                        <td>{{ employee.name }}</td>
                        <td><img :src="employee.photo" id="em_photo"></td>
                        <td>{{ employee.phone }}</td>
                        <td>{{ formatPrice(employee.salary) }}</td>
                        <td>{{ employee.joining_date }}</td>
                        <td>
                          <router-link :to="{name: 'pay-salary', params: {id: employee.id}}" class="btn btn-sm btn-primary">Pay Salary</router-link>
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
    this.viewSalary();
  },
   data() {
     return {
       salaries:[],
       searchTerm: ''
     }
   },

   computed:{
     filterSearch(){
       return this.salaries.filter(salary => {
         return salary.name.toLowerCase().match(this.searchTerm.toLowerCase())
       })
     }
   },
  
  methods: {
     viewSalary(){
      	  let id = this.$route.params.id
       axios.get('/api/salary/view/'+id)
       .then(({data}) => (this.salaries = data))
       .catch(error =>this.errors = error.response.data.errors)
    },
    formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },

  },

 }
</script>

<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>
