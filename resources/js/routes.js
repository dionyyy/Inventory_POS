let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forgot = require('./components/auth/forgot.vue').default;
let logout = require('./components/auth/logout.vue').default;

// End Authentication
let home = require('./components/home.vue').default;

//POS components
let pos = require('./components/pos/pointofsale.vue').default;

// Employee Compponents
let create = require('./components/employee/create.vue').default;
let employee = require('./components/employee/index.vue').default;
let edit = require('./components/employee/edit.vue').default;

//Supplier Components
let createSupplier = require('./components/supplier/create.vue').default;
let supplier = require('./components/supplier/index.vue').default;
let editSupplier = require('./components/supplier/edit.vue').default;

//Category Components
let createCategory = require('./components/category/create.vue').default;
let category = require('./components/category/index.vue').default;
let editCategory = require('./components/category/edit.vue').default;

//Product Components
let createProduct = require('./components/product/create.vue').default;
let product = require('./components/product/index.vue').default;
let editProduct = require('./components/product/edit.vue').default;

//Expense Components
let createExpense = require('./components/expense/create.vue').default;
let expense = require('./components/expense/expense.vue').default;
let editExpense = require('./components/expense/edit.vue').default;

//Salary Components
let salary = require('./components/salary/all_employee.vue').default;
let paySalary = require('./components/salary/create.vue').default;

let allSalary = require('./components/salary/index.vue').default;
let viewSalary= require('./components/salary/view.vue').default;
let editSalary= require('./components/salary/edit.vue').default;

//Stock Components
let stock = require('./components/product/stock.vue').default;
let editStock = require('./components/product/edit_stock.vue').default;

// Customer Compponents
let createCustomer = require('./components/customer/create.vue').default;
let customer = require('./components/customer/index.vue').default;
let editCustomer = require('./components/customer/edit.vue').default;

// Order Components
let order = require('./components/order/order.vue').default;

export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forgot', component: forgot, name: 'forgot' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/home', component: home, name: 'home' },

    //Employee Routes
    { path: '/store-employee', component: create, name: 'store-employee' },
    { path: '/employee', component: employee, name: 'employee' },
    { path: '/edit-employee/:id', component: edit, name: 'edit-employee' },

    //Suppliier Routes
    { path: '/store-supplier', component: createSupplier, name: 'store-supplier' },
    { path: '/supplier', component: supplier, name: 'supplier' },
    { path: '/edit-supplier/:id', component: editSupplier, name: 'edit-supplier' },

    //Category Routes
    { path: '/store-category', component: createCategory, name: 'store-category' },
    { path: '/category', component: category, name: 'category' },
    { path: '/edit-category/:id', component: editCategory, name: 'edit-category' },

     //Product Routes
    { path: '/store-product', component: createProduct, name: 'store-product' },
    { path: '/product', component: product, name: 'product' },
    { path: '/edit-product/:id', component: editProduct, name: 'edit-product' },

    //Expense Routes
    { path: '/store-expense', component: createExpense, name: 'store-expense' },
    { path: '/expense', component: expense, name: 'expense' },
    { path: '/edit-expense/:id', component: editExpense, name: 'edit-expense' },

    //Salary Routes
    { path: '/given-salary', component: salary, name: 'given-salary' },
    { path: '/pay-salary/:id', component: paySalary, name: 'pay-salary' },

    { path: '/salary', component: allSalary, name: 'salary' },
    { path: '/view-salary/:id', component: viewSalary, name: 'view-salary' },
    { path: '/edit-salary/:id', component: editSalary, name: 'edit-salary' },

    //Stock Routes
    { path: '/stock', component: stock, name: 'stock' },
    { path: '/edit-stock/:id', component: editStock, name: 'edit-stock' },

      //Customer Routes
    { path: '/store-customer', component: createCustomer, name: 'store-customer' },
    { path: '/customer', component: customer, name: 'customer' },
    { path: '/edit-customer/:id', component: editCustomer, name: 'edit-customer' },

    //POS Routes
    { path: '/pos', component: pos, name: 'pos' },

    //Order Routes
    { path: '/order', component: order, name: 'order' },
  ]