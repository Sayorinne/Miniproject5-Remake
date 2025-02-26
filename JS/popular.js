// Define dummy data for popular posts
const popularPostsData = [
    { title: "Post 1", content: "Content of post 1" },
    { title: "Post 2", content: "Content of post 2" },
    { title: "Post 3", content: "Content of post 3" }
];

// Function to display popular posts
function displayPopularPosts() {
    const popularPostsContainer = document.getElementById('popular-posts');

    // Clear previous content
    popularPostsContainer.innerHTML = '';

    // Iterate through each post and create HTML elements to display them
    popularPostsData.forEach(post => {
        const postElement = document.createElement('div');
        postElement.classList.add('post');

        // Create an anchor tag and set its href attribute to link to the "Inside Post" page
        const postTitleLink = document.createElement('a');
        postTitleLink.href = 'Post.php'; // Link to the "Inside Post" page
        postTitleLink.innerHTML = `<h3>${post.title}</h3>`; // Set the inner HTML to the post title

        // Append the anchor tag to the post element
        postElement.appendChild(postTitleLink);

        const contentElement = document.createElement('p');
        contentElement.textContent = post.content;

        postElement.appendChild(contentElement);

        popularPostsContainer.appendChild(postElement);
    });
}

// Call the displayPopularPosts function to display popular posts when the page loads
window.addEventListener('load', displayPopularPosts);