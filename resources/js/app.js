require('./bootstrap');

if (document.getElementById('create-apartment')) {
    require('./admin/create.js');
}

if (document.getElementById('header-form')) {
    require('./guest/autocomplete');
}

if(document.getElementById('edit-apartment')) {
    require('./admin/edit.js');
}

if(document.getElementById('payment-form')) {
    require('./admin/sponsorship.js');
}

if(document.getElementById('advanced-research-page')) {
    require('./guest/advancedResearch');
}

if(document.getElementById('apartment-page')) {
    require('./guest/apartmentDetails');
}

if(document.getElementById('home')) {
    require('./guest/home')
}

if(document.getElementById('message-page')) {
    require('./admin/viewedMessage')
}

if(document.getElementById('statistics')) {
    require('./admin/statistics')
}

if (document.getElementById('container-register-signin')) {
    require('./auth/loginPage')
}
