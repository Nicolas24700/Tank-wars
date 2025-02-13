function updateImageAndStats(selectId, imgId, statsId, atkId, pvId) {
    const select = document.getElementById(selectId);
    const img = document.getElementById(imgId);
    const stats = document.getElementById(statsId);
    const atk = document.getElementById(atkId);
    const pv = document.getElementById(pvId);
    const selectedOption = select.options[select.selectedIndex];
    const imageUrl = selectedOption.getAttribute('data-image');
    const attack = selectedOption.getAttribute('data-atk');
    const health = selectedOption.getAttribute('data-pv');
    
    if (imageUrl) {
        img.src = imageUrl;
        img.style.visibility = 'visible';
        img.classList.remove('animate', 'animate-right');
        //permet de forcer la réinitialisation de l'animation
        void img.offsetWidth;
        if (imgId === 'tankbot-img') {
            img.classList.add('animate');
        } else if (imgId === 'tankjoueur-img') {
            img.classList.add('ennemi');
            img.classList.add('animate-right');
        }
    } else {
        img.style.visibility = 'hidden';
        img.classList.remove('animate', 'animate-right');
    }

    if (attack && health) {
        atk.textContent = attack;
        pv.textContent = health;
        stats.style.visibility = 'visible';
    } else {
        stats.style.visibility = 'hidden';
    }
}
function togglePopup() {
    const popup = document.getElementById("myForm");
    const overlay = document.getElementById("popupOverlay");

    if (popup.style.display === "block") {
        popup.style.display = "none";
        overlay.style.display = "none";
    } else {
        popup.style.display = "block";
        overlay.style.display = "block";
    }
}