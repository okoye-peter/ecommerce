var slideIndex = 0;

let images = document.querySelectorAll('.img-thumbnail');
let displayed_img = document.querySelector('.img_displayed');

// show the first image
showSlides(slideIndex);

// show next slide
function nextSlide(n) {
    showSlides(slideIndex += n);
}

// get current slide
function currentSlide(params) {
    showSlides(slideIndex = params);
}

function showSlides(n) {
    if (slideIndex >= images.length)
        slideIndex = 0;
    if (slideIndex < 0)
        slideIndex = images.length - 1;

    images.forEach((img, index) => {
        if (slideIndex == index) {
            displayed_img.src = img.getAttribute('src');
            displayed_img.parentElement.setAttribute('href', img.getAttribute('src'))
            if (!img.classList.contains('active'))
                img.classList.toggle('active')
                // console.log(index, img.classList);
        } else {
            if (img.classList.contains('active'))
                img.classList.toggle('active');
            // console.log(index, img.classList);
        }
    });
}


// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var modalImg = document.getElementById("img01");
displayed_img.onclick = function() {
    modal.classList.add('active');
    modalImg.src = this.src;
}

// Get the <span> element that closes the modal
var span = document.querySelector(".dismiss-modal");

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.classList.add('animation');
    setTimeout(() => {
        modal.classList.toggle('active');
        modal.classList.remove('animation');
    }, 500)
}