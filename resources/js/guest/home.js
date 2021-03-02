import Vue from 'vue';

var home = new Vue({
    el: '#home',
    data: {
        showMore: false,
        noSponsoredApartments
    }
});

const headerGuest = document.querySelector("#header-guest");
const navbarTop = document.querySelector(".navbar-top");
const jumbotron = document.querySelector("#jumbotron-homepage");

const tl = new TimelineMax();

tl.fromTo(headerGuest, 2, {opacity: "0"}, {opacity: "1"})
.fromTo(navbarTop, 0.9, {x: "-100%"}, {x: "0%", ease: Power0.easeInOut}, "-=2")
.fromTo(jumbotron, 1.8, {x: "+100%"}, {x: "0%", ease: Power2.easeOut}, "-=2");

window.addEventListener("scroll",function(){
    var navbarSearch = document.querySelector(".navbar-search");
    navbarTop.classList.toggle("sticky", window.scrollY > 0);
    navbarSearch.classList.toggle("sticky", window.scrollY > 0);
});

document.getElementById('user-icon').addEventListener("click", openMenu);

function openMenu() {
    document.getElementById('user-dropdown-menu').classList.toggle("open");
}
