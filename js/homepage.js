// --------------------------------------------Top Navigation-------------------------------------
const navigationButtons = document.querySelectorAll(".nav_buttons");
const slidingLine = document.querySelector(".nav_sliding_line");
const publicFeeds = document.querySelector(".feeds");
const privateFeeds = document.querySelector(".my_snap_container");
const followingBtn = document.querySelector(".following_btn");
const mySnapBtn = document.querySelector(".my_snap_btn");

// Function to adjust slider position and width
const updateSlidingPosition = (navButton, line) => {
    line.style.width = `${navButton.offsetWidth}px`;
    line.style.left = `${navButton.offsetLeft}px`;
};

followingBtn.addEventListener("click", () => {
    publicFeeds.classList.add("show_public_feeds");
    privateFeeds.classList.remove("show_my_snap");
    updateSlidingPosition(followingBtn, slidingLine);
});

mySnapBtn.addEventListener("click", () => {
    privateFeeds.classList.add("show_my_snap");
    publicFeeds.classList.remove("show_public_feeds");
    updateSlidingPosition(mySnapBtn, slidingLine);
});

// ---------------------------------------------Bottom Navigation------------------------------------
const bottomButtons = document.querySelectorAll('.bottom_navigation li a');
bottomButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        bottomButtons.forEach(button => button.classList.remove("active"));
        btn.classList.add('active');
    });
});

// ---------------------------------------Post Container---------------------------------------------------------
document.addEventListener("DOMContentLoaded", () => {
    const lazyLoadMedia = () => {
        const mediaElements = document.querySelectorAll('img[data-src], video[data-src]');
        mediaElements.forEach(media => {
            if (media.getBoundingClientRect().top < window.innerHeight) {
                media.src = media.getAttribute('data-src');
                media.removeAttribute('data-src');
            }
        });
    };

    const pauseAllVideosOnScroll = () => {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    entry.target.pause();
                }
            });
        }, observerOptions);

        const videos = document.querySelectorAll('video');
        videos.forEach(video => observer.observe(video));
    };

    lazyLoadMedia();
    window.addEventListener('scroll', lazyLoadMedia);
    window.addEventListener('resize', lazyLoadMedia);

    pauseAllVideosOnScroll();

    document.querySelectorAll('.play_pause_button').forEach(button => {
        button.addEventListener('click', function() {
            const video = this.previousElementSibling;
            if (video.paused) {
                video.play();
                this.innerHTML = '<i class="ri-pause-fill"></i>';
            } else {
                video.pause();
                this.innerHTML = '<i class="ri-play-fill"></i>';
            }
        });
    });

    document.querySelectorAll('video').forEach(video => {
        const progressBar = video.nextElementSibling.nextElementSibling.querySelector('.progressBar');
        video.addEventListener('timeupdate', () => {
            const value = (100 / video.duration) * video.currentTime;
            progressBar.value = value;
        });

        progressBar.addEventListener('input', () => {
            const time = video.duration * (progressBar.value / 100);
            video.currentTime = time;
        });

        video.addEventListener('play', () => {
            video.nextElementSibling.innerHTML = '<i class="ri-pause-fill"></i>';
        });

        video.addEventListener('pause', () => {
            video.nextElementSibling.innerHTML = '<i class="ri-play-fill"></i>';
        });
    });
});

// ----------------------------------------Comment------------------------------------------
const commentBtns = document.querySelectorAll('.comment_holder');
const commentSliderSection = document.querySelector('.sliding_comment_container');

commentBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        commentSliderSection.classList.add('sliding_comment_container_active');
    });
});

document.querySelector('.sliding_comment_container .comment_title button').addEventListener('click', () => {
    commentSliderSection.classList.remove('sliding_comment_container_active');
});

//----------------------------------Like/Dislike---------------------------------------------
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.like_button').forEach(button => {
        button.addEventListener('click', function() {
            const fileName = this.dataset.fileName;
            toggleLike(fileName);
        });
    });
});

function toggleLike(fileName) {
    fetch('toggle_like.php', {
        method: 'POST',
        body: JSON.stringify({ file_name: fileName }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Print success message or handle response
        // Optionally, update UI based on server response
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation:', error);
    });
}




document.addEventListener("DOMContentLoaded", () => {
    // Function to initialize video controls
    const initializeVideoControls = (video) => {
        const progressBar = video.nextElementSibling.nextElementSibling.querySelector('.progressBar');

        video.addEventListener('timeupdate', () => {
            if (video.duration) {
                const value = (video.currentTime / video.duration) * 100;
                progressBar.value = value;
            }
        });

        progressBar.addEventListener('input', () => {
            if (video.duration) {
                const time = video.duration * (progressBar.value / 100);
                video.currentTime = time;
            }
        });

        video.addEventListener('play', () => {
            const playPauseBtn = video.nextElementSibling;
            playPauseBtn.innerHTML = '<i class="ri-pause-fill"></i>';
        });

        video.addEventListener('pause', () => {
            const playPauseBtn = video.nextElementSibling;
            playPauseBtn.innerHTML = '<i class="ri-play-fill"></i>';
        });
    };

    // Initialize all video elements
    document.querySelectorAll('video').forEach(video => {
        initializeVideoControls(video);
    });

    // Play/Pause button functionality
    document.querySelectorAll('.play_pause_button').forEach(button => {
        button.addEventListener('click', function() {
            const video = this.previousElementSibling;
            if (video.paused) {
                video.play();
                this.innerHTML = '<i class="ri-pause-fill"></i>';
            } else {
                video.pause();
                this.innerHTML = '<i class="ri-play-fill"></i>';
            }
        });
    });
});
