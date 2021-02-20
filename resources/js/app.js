require('./bootstrap');

if (document.getElementById('create-apartment')) {
    require('./admin/create.js');
}


if(document.getElementById('edit-apartment')) {
    require('./admin/edit.js');
}

if(document.getElementById('show-apartment')) {
    require('./admin/show.js');
}

if(document.getElementById('payment-form')) {
    require('./admin/sponsorship.js');
}

if(document.getElementById('advanced-research-page')) {
    require('./guest/advancedResearch');
}

if(document.getElementById('map')) {
    require('./guest/map');
}

if(document.getElementById('apartment-page')) {
    require('./guest/addView')
}

if(document.getElementById('home')) {
    require('./guest/home')
}

if(document.getElementById('message-page')) {
    require('./admin/viewedMessage')
}
