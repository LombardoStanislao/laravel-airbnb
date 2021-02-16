require('./bootstrap');

require('./admin/create.js');

if(document.getElementById('advanced-research-page')) {
    require('./guest/advancedResearch');
}
