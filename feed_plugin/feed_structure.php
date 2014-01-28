

<?php 


echo "<div class=\"fb-feed\">";

foreach($pagefeed['data'] as $post) {

    if ($post['type']== 'status' || $post['type'] == 'link' || $post['type'] == 'photo') {

        // open up an fb-update div
        echo "<div class=\"fb-update\">";

            // post the time

            // check if post type is a status
            if ($post['type'] == 'status') {
                echo "<h2>Status updated on: " . date("jS M, Y", (strtotime($post['created_time']))) . "</h2>";
                echo "<p>" . $post['message'] . "</p>";
            }

            // check if post type is a link
            if ($post['type'] == 'link') {
                echo "<h2>Link posted on: " . date("jS M, Y", (strtotime($post['created_time']))) . "</h2>";
                echo "<p>" . $post['name'] . "</p>";
                echo "<p><a href=\"" . $post['link'] . "\" target=\"_blank\">" . $post['link'] . "</a></p>";
            }

            // check if post type is a photo
            if ($post['type'] == 'photo') {
                echo "<h2>Photo posted on: " . date("jS M, Y", (strtotime($post['created_time']))) . "</h2>";
                if (empty($post['story']) === false) {
                    echo "<p>" . $post['story'] . "</p>";
                } elseif (empty($post['message']) === false) {
                    echo "<p>" . $post['message'] . "</p>";
                }
                echo "<p><a href=\"" . $post['link'] . "\" target=\"_blank\">View photo &rarr;</a></p>";
            }

        echo "</div>"; // close fb-update div

    }
} // end the foreach statement

echo "</div>";
