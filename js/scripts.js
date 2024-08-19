/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

// SCRIPTS DE HOME
const navbarToggle = document.getElementById('navbar-toggle');
const navbarClose = document.getElementById('navbar-close');
const navbarMenu = document.getElementById('navbar-menu');

function toggleMenu() {
    navbarMenu.classList.toggle('active');
}

navbarToggle.addEventListener('click', toggleMenu);
navbarClose.addEventListener('click', toggleMenu);

function handleLogout() {
    window.location.href = 'logout.php';
}

// Ajustar el menú en cambios de tamaño de pantalla
window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        navbarMenu.classList.remove('active');
    }
});

// Cambiar el icono de menu al icono de cerrar cuando se de un click
navbarToggle.addEventListener('click', () => {
    navbarToggle.innerHTML = navbarToggle.innerHTML === '<span class="jam jam-menu"></span>' ? '<span class="jam jam-close"></span>' : '<span class="jam jam-menu"></span>';
});