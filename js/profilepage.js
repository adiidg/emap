const bottom_navigation_buttons = document.querySelectorAll(".botton_nav_button")
const bottom_sliding_line = document.querySelector(".bottom_sliding_line")

// function to adjust slider position and width
const updateSlidingPosition = (nav_button, line) => {
    line.style.width = nav_button.offsetWidth + "px";
    line.style.left = nav_button.offsetLeft  + "px";
}


// event listner for bottom navigation buttons
bottom_navigation_buttons.forEach(nav_button => {
    nav_button.addEventListener("click", (e)=>{
        e.preventDefault()
        
        bottom_navigation_buttons.forEach(nav_button =>{
            nav_button.classList.remove("bottom_nav_active")});
        nav_button.classList.add("bottom_nav_active");
        updateSlidingPosition(nav_button, bottom_sliding_line)
    })
})


// open sidebar
const open_sidebar_button = document.querySelector(".open_sidebar")
const sidebar_container = document.querySelector(".sidebar_container")

open_sidebar_button.addEventListener("click", ()=>{
    sidebar_container.classList.add("open_sidebar_button_active")
    sidebar_container.classList.remove("close_sidebar_button_active")

})

// close SideBar
const close_sidebar_button = document.querySelector(".close_sidebar")
close_sidebar_button.addEventListener("click", ()=>{
    sidebar_container.classList.add("close_sidebar_button_active")
    sidebar_container.classList.remove("open_sidebar_button_active")
})

//made by adii
const followingsButton = document.getElementById('followingsButton');
const username = followingsButton.dataset.username; // Get username from data attribute
const modal = document.getElementById('followingsModal');
const followingsList = document.getElementById('followingsList');
const closeSpan = document.querySelector('.close');

document.getElementById('followingsButton').onclick = function() {
    // Clear previous list items
    followingsList.innerHTML = '';

    // Fetch followings list
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'followings_list.php', true);
    xhr.onload = function() {
        if (this.status == 200) {
            var response = JSON.parse(this.responseText);
            if (response.error) {
                alert(response.error);
            } else {
                var followings = response.followings;
                followings.forEach(function(following) {
                    var li = document.createElement('li');
                    const profilePicSrc = following.profile_pic || 'placeholder.jpg'; // Set default profile picture if not provided

                    li.innerHTML = `
                        <style>
                        .profile-link {
                            display: inline-flex; /* Make it behave like an inline element but allow flexbox properties */
                            align-items: center; /* Align content vertically within the element */
                            padding: 5px 10px; /* Add some padding for spacing */
                            border: 1px solid #ccc; /* Add a thin border */
                            border-radius: 5px; /* Add rounded corners for a button-like feel */
                            background-color: #000000; /* Set background color to white (adjust as needed) */
                            text-decoration: none; /* Remove underline from the anchor tag */
                            color: #333; /* Set text color (adjust as needed) */
                            font-size: 0.9rem; /* Adjust font size if needed */
                            cursor: pointer; /* Set cursor to pointer on hover */
                            transition: all 0.2s ease-in-out; /* Add a smooth transition for hover effects */
                        }
                          
                        .profile-link:hover {
                            background-color: #f5f5f5; /* Change background color on hover (adjust as needed) */
                        }
                          
                        .auto-height-div {
                            display: flex; /* Allow image and suggestionBio to sit side-by-side */
                            flex-grow: 1; /* Make the div expand to fill remaining space */
                        }
                          
                        .suggestionBio {
                            margin-left: 5px; /* Add some margin between image and bio */
                        }
                          
                        .suggestionName,
                        .suggestionUsername {
                            margin-bottom: 2px; /* Add some space between name and username */
                        }
                          
                        .suggestionUsername {
                            font-weight: lighter; /* Make username text lighter */
                        }
                          
                        .profile-link img {
                            width: 30px; /* Set image width */
                            height: 30px; /* Set image height */
                            border-radius: 50%; /* Make image circular */
                            margin-right: 5px; /* Add some margin between image and name */
                        }
                        </style>
                        <a href="others_profilepage.php?username=${following.username}" class="profile-link">
                            <div class="auto-height-div">
                                <img src="${profilePicSrc}" alt="${following.username}'s profile picture">
                                <div class="suggestionBio">
                                    <div class="suggestionName">${following.name}</div>
                                    <div class="suggestionUsername">@${following.username}</div>
                                </div>
                            </div>
                        </a>
                    `;
                    followingsList.appendChild(li);
                });
            }
        }
    };
    xhr.send();

    modal.style.display = 'block';
};

closeSpan.addEventListener("click", function() {
    modal.style.display = 'none';
});

window.addEventListener("click", function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
});
