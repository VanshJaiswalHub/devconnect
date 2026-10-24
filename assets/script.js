const followButtons = document.querySelectorAll(".follow-btn");

followButtons.forEach(button => {

    button.addEventListener("click", async () => {

        const followingId = button.dataset.userId;
        const csrfToken = button.dataset.csrfToken;

        const formData = new FormData();

        formData.append("following_id", followingId);
        formData.append("csrf_token", csrfToken);

        try {

            const response = await fetch("follow.php", {
                method: "POST",
                body: formData
            });

            const data = await response.json();

            if (data.success) {

                if (data.following) {
                    button.textContent = "Following";
                    button.classList.remove("btn-outline-success");
                    button.classList.add("btn-success");
                } else {
                    button.textContent = "Follow";
                    button.classList.remove("btn-success");
                    button.classList.add("btn-outline-success");
                }

            } else {
                alert(data.message);
            }

        } catch (error) {

            console.error("Follow request failed:", error);
            alert("Something went wrong. Please try again.");

        }
    });

});

    /*====================================================
    2. CONNECTIONS PAGE SCRIPTS
    ====================================================*/

    // Script for handling the following/followers tabs

    const connectionTabs =
        document.querySelectorAll(".connection-tab");

    const followingList =
        document.getElementById("following-list");

    const followersList =
        document.getElementById("followers-list");


    connectionTabs.forEach(function(tab) {

        tab.addEventListener("click", function() {

            connectionTabs.forEach(function(item) {
                item.classList.remove("active");
            });

            this.classList.add("active");


            if (this.dataset.tab === "following") {

                followingList.style.display = "block";
                followersList.style.display = "none";

            } else {

                followingList.style.display = "none";
                followersList.style.display = "block";

            }

        });

    });

    //Script for handling the unfollow modal


    const unfollowModalElement =
        document.getElementById("unfollowModal");

    if (unfollowModalElement) {

        const unfollowModal =
            new bootstrap.Modal(unfollowModalElement);

        const unfollowUsername =
            document.getElementById("unfollowUsername");

        const unfollowUserId =
            document.getElementById("unfollowUserId");

        const unfollowButtons =
            document.querySelectorAll(".unfollow-btn");

        unfollowButtons.forEach(function(button) {

            button.addEventListener("click", function() {

                const userId = this.getAttribute("data-user-id");
                const username = this.getAttribute("data-username");

                unfollowUserId.value = userId;
                unfollowUsername.textContent = username;

                unfollowModal.show();

            });

        });

    }

    /*=====================================================
    3. MY POSTS PAGE SCRIPTS
    =====================================================*/

    // Script for handling the delete post modal

    const deletePostModal =
        document.getElementById("deletePostModal");

    if (deletePostModal) {

        deletePostModal.addEventListener("show.bs.modal", function(event) {

            const deleteButton = event.relatedTarget;

            if (!deleteButton) {
                return;
            }

            const postId = deleteButton.getAttribute("data-post-id");

            console.log("Clicked button:", deleteButton);
            console.log("Post ID:", postId);

            document.getElementById("deletePostId").value = postId;

        });

    }

    /*=====================================================
    4. Topbar Drawer
    =====================================================*/

    const sidebar = document.getElementById('appSidebar');
    const menuButton = document.getElementById('sidebarToggle');

    if (sidebar && menuButton) {

        // Start closed on mobile; open on desktop
        if (window.innerWidth <= 758) {
            sidebar.classList.add('sidebar-hidden');
            document.body.classList.add('sidebar-is-hidden');
            menuButton.setAttribute('aria-expanded', 'false');
        }

        menuButton.addEventListener('click', function () {
            const isHidden = sidebar.classList.toggle('sidebar-hidden');

            document.body.classList.toggle(
                'sidebar-is-hidden',
                isHidden
            );

            menuButton.setAttribute(
                'aria-expanded',
                String(!isHidden)
            );
        });

    }
    /*=====================================================
    5. Index page hamburger
    =====================================================*/

   document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.getElementById('landingMenuToggle');
    const navLinks = document.getElementById('landingNavLinks');

    if (!menuButton || !navLinks) {
        return;
    }

    menuButton.addEventListener('click', function () {
        const isOpen = navLinks.classList.toggle('is-open');
        menuButton.setAttribute('aria-expanded', String(isOpen));
    });
});

/*=====================================================
5.Hamburger autofold
=====================================================*/


document.addEventListener("click", function(event) {
    const link = event.target.closest("#appSidebar a");

    if (!link || window.innerWidth > 758) {
        return;
    }

    const sidebar = document.getElementById("appSidebar");
    const menuButton = document.getElementById("sidebarToggle");

    if (sidebar && menuButton) {
        sidebar.classList.add("sidebar-hidden");
        document.body.classList.add("sidebar-is-hidden");
        menuButton.setAttribute("aria-expanded", "false");
    }
});
