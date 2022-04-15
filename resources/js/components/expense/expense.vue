
<template>
<div>
    <div class="row">
      <div class="col-sm-12">
        <router-link to="/store-expense" class="btn btn-primary float-right">Add Expense</router-link>
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
                  <h6 class="m-0 font-weight-bold text-primary">Expense List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Details</th>
                        <th>Amount</th>
                        <th>Expense Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="expense in filterSearch" :key="expense.id">
                        <td>{{ expense.details }}</td>
                        <td>{{ expense.amount }}</td>
                        <td>{{ expense.expenses_date }}</td>
                        <td>
                          <router-link :to="{name: 'edit-expense', params: {id: expense.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                          <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger"><font color="white">Delete</font></a>
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
    this.allExpense();
  },
   data() {
     return {
       expenses:[],
       searchTerm: ''
     }
   },

   computed:{
     filterSearch(){
       return this.expenses.filter(expense => {
         return expense.details.toLowerCase().match(this.searchTerm.toLowerCase())
       })
     }
   },
  
  methods: {
     allExpense(){
      axios.get('/api/expense/')
      .then(({data}) => (this.expenses = data))
      .catch(console.log('error'))
    },
    deleteExpense(id){
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
            axios.delete('/api/expense/'+id)
            .then(() => {
              this.expenses = this.expenses.filter(expense => {
                return expense.id != id
              })
            })
            .catch(() => {
              this.$router.push({name: 'expense' })
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
 
</style>
