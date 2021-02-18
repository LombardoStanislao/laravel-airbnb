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

if(document.getElementById('advanced-research-page')) {
    require('./guest/advancedResearch');
}

if(document.getElementById('map')) {
    require('./guest/map');
}

if(document.getElementById('apartment-page')) {
    require('./guest/addView')
}

// Guest's Homepage

document.getElementById('user-icon').addEventListener("click", openMenu);


function openMenu() {
    document.getElementById('user-dropdown-menu').classList.toggle("open");
}
