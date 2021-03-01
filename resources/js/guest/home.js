import Vue from 'vue';

var home = new Vue({
    el: '#home',
    data: {
        showMore: false,
        noSponsoredApartments
    }
});

window.addEventListener("scroll",function(){
    var navbarTop = document.querySelector(".navbar-top");
    var navbarSearch = document.querySelector(".navbar-search");
    navbarTop.classList.toggle("sticky", window.scrollY > 0);
    navbarSearch.classList.toggle("sticky", window.scrollY > 0);
});

document.getElementById('user-icon').addEventListener("click", openMenu);

function openMenu() {
    document.getElementById('user-dropdown-menu').classList.toggle("open");
}
