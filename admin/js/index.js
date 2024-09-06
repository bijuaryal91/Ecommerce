const menuBar = document.querySelector('.content nav .bx.bx-menu');
const sideBar = document.querySelector('.sidebar');

handleResize();

menuBar.addEventListener('click', () => {
    sideBar.classList.toggle('close');
});


function handleResize() {
    if (window.innerWidth < 768) {
        sideBar.classList.add('close');
    } else {
        sideBar.classList.remove('close');
    }
}


// Add the event listener for window resize
window.addEventListener('resize', handleResize);
