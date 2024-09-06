const container = document.querySelector(".container");
const slider = document.querySelector(".slider");
const firstSlideWidth = slider.querySelector(".slide").offsetWidth;
const arrowButtons = document.querySelectorAll(".container i");
const sliderChildren = [...slider.children];

let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;

// Get the number of slides that can fit in the slider at once
let slidesPerView = Math.round(slider.offsetWidth / firstSlideWidth);

// Insert copies of the last few slides to beginning of slider for infinite scrolling
sliderChildren.slice(-slidesPerView).reverse().forEach(slide => {
    slider.insertAdjacentHTML("afterbegin", slide.outerHTML);
});

// Insert copies of the first few slides to end of slider for infinite scrolling
sliderChildren.slice(0, slidesPerView).forEach(slide => {
    slider.insertAdjacentHTML("beforeend", slide.outerHTML);
});

// Scroll the slider at appropriate position to hide first few duplicate slides on Firefox
slider.classList.add("no-transition");
slider.scrollLeft = slider.offsetWidth;
slider.classList.remove("no-transition");

// Add event listeners for the arrow buttons to scroll the slider left and right
arrowButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        slider.scrollLeft += btn.id == "prev" ? -firstSlideWidth : firstSlideWidth;
    });
});

const dragStart = (e) => {
    isDragging = true;
    slider.classList.add("dragging");
    // Records the initial cursor and scroll position of the slider
    startX = e.pageX;
    startScrollLeft = slider.scrollLeft;
}

const dragging = (e) => {
    if (!isDragging) return; // if isDragging is false return from here
    // Updates the scroll position of the slider based on the cursor movement
    slider.scrollLeft = startScrollLeft - (e.pageX - startX);
}

const dragStop = () => {
    isDragging = false;
    slider.classList.remove("dragging");
}

const infiniteScroll = () => {
    // If the slider is at the beginning, scroll to the end
    if (slider.scrollLeft === 0) {
        slider.classList.add("no-transition");
        slider.scrollLeft = slider.scrollWidth - (2 * slider.offsetWidth);
        slider.classList.remove("no-transition");
    }
    // If the slider is at the end, scroll to the beginning
    else if (Math.ceil(slider.scrollLeft) === slider.scrollWidth - slider.offsetWidth) {
        slider.classList.add("no-transition");
        slider.scrollLeft = slider.offsetWidth;
        slider.classList.remove("no-transition");
    }

    // Clear existing timeout & start autoplay if mouse is not hovering over slider
    clearTimeout(timeoutId);
    if (!container.matches(":hover")) autoPlay();
}

const autoPlay = () => {
    if (window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
    // Autoplay the slider after every 2500 ms
    timeoutId = setTimeout(() => slider.scrollLeft += firstSlideWidth, 2500);
}
autoPlay();

slider.addEventListener("mousedown", dragStart);
slider.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);
slider.addEventListener("scroll", infiniteScroll);
container.addEventListener("mouseenter", () => clearTimeout(timeoutId));
container.addEventListener("mouseleave", autoPlay);
