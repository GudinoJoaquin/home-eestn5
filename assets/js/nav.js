document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('navbar');
    const logo = document.getElementById('logo');
    const leftOptions = document.getElementById('left-options');
    const rightOptions = document.getElementById('right-options');

    logo.addEventListener('click', function () {
        navbar.classList.toggle('clicked');
        leftOptions.classList.toggle('show');
        rightOptions.classList.toggle('show');
    });
});
