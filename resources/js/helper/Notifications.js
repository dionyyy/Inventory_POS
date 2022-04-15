class Notifications{

   success(){
    new Noty({
        type: 'success',
        text: 'Successfully Done',
        layout: 'topRight',
        timeout: 1000,
    }).show();
   }

   alert(){
    new Noty({
        type: 'alert',
        text: 'Are you sure?',
        layout: 'topRight',
        timeout: 1000,
    }).show();
   }

   error(){
    new Noty({
        type: 'alert',
        text: 'Something went wrong',
        layout: 'topRight',
        timeout: 1000,
    }).show();
   }

   warning(){
    new Noty({
        type: 'warning',
        text: 'Opps wrong',
        layout: 'topRight',
        timeout: 1000,
    }).show();
   }

   salary(){
    new Noty({
        type: 'alert',
        text: 'Salary already Paid',
        layout: 'topRight',
        timeout: 1000,
    }).show();
   }

   image_validation(){
    new Noty({
        type: 'error',
        text: 'Upload Image less than 1MB',
        layout: 'topRight',
        timeout: 1000,
    }).show();
   }
   
   }
   
   export default Notifications = new Notifications()