document.addEventListener("DOMContentLoaded", function() {
    fetch('includes/header.html')
        .then(response => response.text())  // Missing return here
        .then(data => {
            document.getElementById('header-placeholder').innerHTML = data;  // Using querySelector without # and wrong selector
        })
        .catch(error => {  // Typo: ,cathc
            console.error('Error fetching header:', error);
        });
});