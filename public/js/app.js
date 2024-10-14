
// function darkMode() {
//     var body = document.getElementById('body');
//     var icon = document.getElementById('icon');
//     var table = document.getElementById('table');
//     var table2 = document.getElementById('table2');
//     var display_Dark = localStorage.getItem('darkMode');

//     if (display_Dark === '1') {
//         // Switch to light mode
//         localStorage.setItem('darkMode', '0');
//         body.classList.remove('dark');
//         icon.classList.remove('bi-sun');
//         icon.classList.add('bi-moon');
//         if (table) table.classList.remove("table-dark");
//         if (table2) table2.classList.remove("table-dark");

//         // Toastr notification
//         toastr.success('Light mode activated!');
//     } else {
//         // Switch to dark mode
//         localStorage.setItem('darkMode', '1');
//         body.classList.add('dark');
//         icon.classList.remove('bi-moon');
//         icon.classList.add('bi-sun');
//         if (table) table.classList.add("table-dark");
//         if (table2) table2.classList.add("table-dark");

//         // Toastr notification
//         toastr.success('Dark mode activated!');
//     }
// }


document.addEventListener("DOMContentLoaded", function() {
    var body = document.getElementById('body');
    var icon = document.getElementById('icon');
    var table = document.getElementById('table');
    var table2 = document.getElementById('table2');
    var display_Dark = localStorage.getItem('darkMode');

    if (display_Dark === '1') {
        // Apply dark mode settings
        body.classList.add('dark');
        icon.classList.remove('bi-moon');
        icon.classList.add('bi-sun');
        table.classList.add("table-dark");
        table2.classList.add("table-dark");
    } else {
        // Apply light mode settings
        body.classList.remove('dark');
        icon.classList.remove('bi-sun');
        icon.classList.add('bi-moon');
        table.classList.remove("table-dark");
        table2.classList.remove("table-dark");
    }
});

function darkMode() {
    var body = document.getElementById('body');
    var icon = document.getElementById('icon');
    var table = document.getElementById('table');
    var table2 = document.getElementById('table2');
    var display_Dark = localStorage.getItem('darkMode');

    if (display_Dark === '1') {
        // Switch to light mode
        localStorage.setItem('darkMode', '0'); // Update localStorage to light mode
        body.classList.remove('dark');
        icon.classList.remove('bi-sun');
        icon.classList.add('bi-moon');
        table.classList.remove("table-dark");
        table2.classList.remove("table-dark");

    } else {
        // Switch to dark mode
        localStorage.setItem('darkMode', '1'); // Update localStorage to dark mode
        body.classList.add('dark');
        icon.classList.remove('bi-moon');
        icon.classList.add('bi-sun');
        table.classList.add("table-dark");
        table2.classList.add("table-dark");

    }
}


// Check localStorage on page load and apply the appropriate theme
window.onload = function() {
    var display_Dark = localStorage.getItem('darkMode');
    var body = document.getElementById('body');
    var icon = document.getElementById('icon');

    if (display_Dark === '1') {
        body.classList.add('dark');
        icon.classList.remove('bi-moon');
        icon.classList.add('bi-sun');
    } else {
        body.classList.remove('dark');
        icon.classList.remove('bi-sun');
        icon.classList.add('bi-moon');
    }
};


