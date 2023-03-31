/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to the navbar
    It defines a method that show/hide menu based on screen size
 */
window.onload = () => {
    var tglbtn = document.getElementById("nav-toggle");
    var navlst = document.getElementById("nav-list")

    tglbtn.addEventListener('click', () => {navlst.classList.toggle("active");});
};