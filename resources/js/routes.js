// Authentication
const login = () => import('./components/auth/login.vue');
const register = () => import('./components/auth/register.vue');
const forgot = () => import('./components/auth/forgot.vue');
const logout = () => import('./components/auth/logout.vue');

// Dashboard
const home = () => import('./components/home.vue');

// POS
const pos = () => import('./components/pos/pointofsale.vue');

// Employee
const create = () => import('./components/employee/create.vue');
const employee = () => import('./components/employee/index.vue');
const edit = () => import('./components/employee/edit.vue');

// Supplier
const createSupplier = () => import('./components/supplier/create.vue');
const supplier = () => import('./components/supplier/index.vue');
const editSupplier = () => import('./components/supplier/edit.vue');

// Category
const createCategory = () => import('./components/category/create.vue');
const category = () => import('./components/category/index.vue');
const editCategory = () => import('./components/category/edit.vue');

// Product
const createProduct = () => import('./components/product/create.vue');
const product = () => import('./components/product/index.vue');
const editProduct = () => import('./components/product/edit.vue');

// Expense
const createExpense = () => import('./components/expense/create.vue');
const expense = () => import('./components/expense/expense.vue');
const editExpense = () => import('./components/expense/edit.vue');

// Salary
const salary = () => import('./components/salary/all_employee.vue');
const paySalary = () => import('./components/salary/create.vue');
const allSalary = () => import('./components/salary/index.vue');
const viewSalary = () => import('./components/salary/view.vue');
const editSalary = () => import('./components/salary/edit.vue');

// Stock
const stock = () => import('./components/product/stock.vue');
const editStock = () => import('./components/product/edit_stock.vue');

// Customer
const createCustomer = () => import('./components/customer/create.vue');
const customer = () => import('./components/customer/index.vue');
const editCustomer = () => import('./components/customer/edit.vue');

// Order
const order = () => import('./components/order/order.vue');
const viewOrder = () => import('./components/order/vieworder.vue');
const searchOrder = () => import('./components/order/searchorder.vue');

export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forgot', component: forgot, name: 'forgot' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/home', component: home, name: 'home' },

    // Employee Routes
    { path: '/store-employee', component: create, name: 'store-employee' },
    { path: '/employee', component: employee, name: 'employee' },
    { path: '/edit-employee/:id', component: edit, name: 'edit-employee' },

    // Supplier Routes
    { path: '/store-supplier', component: createSupplier, name: 'store-supplier' },
    { path: '/supplier', component: supplier, name: 'supplier' },
    { path: '/edit-supplier/:id', component: editSupplier, name: 'edit-supplier' },

    // Category Routes
    { path: '/store-category', component: createCategory, name: 'store-category' },
    { path: '/category', component: category, name: 'category' },
    { path: '/edit-category/:id', component: editCategory, name: 'edit-category' },

    // Product Routes
    { path: '/store-product', component: createProduct, name: 'store-product' },
    { path: '/product', component: product, name: 'product' },
    { path: '/edit-product/:id', component: editProduct, name: 'edit-product' },

    // Expense Routes
    { path: '/store-expense', component: createExpense, name: 'store-expense' },
    { path: '/expense', component: expense, name: 'expense' },
    { path: '/edit-expense/:id', component: editExpense, name: 'edit-expense' },

    // Salary Routes
    { path: '/given-salary', component: salary, name: 'given-salary' },
    { path: '/pay-salary/:id', component: paySalary, name: 'pay-salary' },
    { path: '/salary', component: allSalary, name: 'salary' },
    { path: '/view-salary/:id', component: viewSalary, name: 'view-salary' },
    { path: '/edit-salary/:id', component: editSalary, name: 'edit-salary' },

    // Stock Routes
    { path: '/stock', component: stock, name: 'stock' },
    { path: '/edit-stock/:id', component: editStock, name: 'edit-stock' },

    // Customer Routes
    { path: '/store-customer', component: createCustomer, name: 'store-customer' },
    { path: '/customer', component: customer, name: 'customer' },
    { path: '/edit-customer/:id', component: editCustomer, name: 'edit-customer' },

    // POS Routes
    { path: '/pos', component: pos, name: 'pos' },

    // Order Routes
    { path: '/order', component: order, name: 'order' },
    { path: '/view-order/:id', component: viewOrder, name: 'view-order' },
    { path: '/search-order', component: searchOrder, name: 'search-order' },
];
