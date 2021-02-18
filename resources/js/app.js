require('./bootstrap');

require('./admin/create.js');

if(document.getElementById('advanced-research-page')) {
    require('./guest/advancedResearch');
}

if(document.getElementById('map')) {
    require('./guest/map');
}

// Guest's Homepage

document.getElementById('user-icon').addEventListener("click", openMenu);


function openMenu() {
    document.getElementById('user-dropdown-menu').classList.toggle("open");
}
