function showComments(clickedPost) {
  var allPosts = document
                    .getElementById("main-feed")
                    .getElementsByClassName("feed-item");
  for (var i = 0 ; i < allPosts.length ; i++) {
    if (allPosts[i] === clickedPost) {
      allPosts[i].style.background = "linear-gradient(to right, white, #f0f0f0)";
      allPosts[i].style.marginRight = "-3px";
      // show the comments
      $.ajax({
        url: "../process/showComments.php",
        type: "POST",
        data: {postID: clickedPost.id},
        dataType: "text",
        success: function(data) {
          document.getElementById("comments").innerHTML = data;
        }
      });

    } else {
      allPosts[i].style = null;
    }
  }
}

var feed = document.getElementById("main-feed");
var posts = feed.getElementsByClassName("feed-item");
for (var i = 0 ; i < posts.length ; i++) {
  posts[i].onclick = function() {
    document.getElementById("comments").hidden = "";
    showComments(this);
    return false;
  }
  posts[i].onfocus = function() {
    showComments(this);
    return false;
  }
}