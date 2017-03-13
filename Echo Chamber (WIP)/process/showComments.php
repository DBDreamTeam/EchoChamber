

<form method="post">
  <label id="comment-box">
    <textarea placeholder="New Comment..."></textarea>
  </label>
  <label>
    <button type="submit" class="btn btn-default pull-right">Post</button>
  </label>
</form>

<h5>Comments</h5>

<?php
require_once("../includes/connect.php");
$post_id = $_POST['postID'];

$sql = "
    SELECT * FROM comments
        WHERE PostID = $post_id
        ORDER BY Time DESC";
$result = $link->query($sql);

while ($row = $result->fetch_assoc()) {
  // echo html for each comment
  ?>
  <div class="comment">
    <?php 
        $userID = $row['UserID'];
        $sql = "
            SELECT Username FROM users 
                WHERE UserID = $userID";
        $result = $link->query($sql);
    ?>
    <form action="../process/processSeeFriend.php" method="post">
      <input type="hidden" name="friendID" value="<?php echo $userID; ?>">
      <button type="submit" class="profile-link"><b><?php echo $result->fetch_assoc()['Username']; ?></b></button>
    </form>
    <p><?php echo $row['Text']; ?></p>
    <p><?php echo $row['Time']; ?></p>
  </div>
<?php
  
}

?>

