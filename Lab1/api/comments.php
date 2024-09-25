<?php
/**
 * Author: Logan Puetz, Ryan Cook, Nathan Ensley
 * Date: 9/25/2024
 * File: comments.php
 * Description:
 */

echo "This is where we can show our comments.";
$url = $_SERVER['REQUEST_URI'];
//checking if slash is first character in route otherwise add it
if (strpos($url, "/") !== 0) {
    $url = "/$url";
}
//Connect to the database.
$dbInstance = new DB();
$dbConn = $dbInstance->connect($db);
header("Content-Type:application/json");
if ($url == '/comments' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $comments = getAllPosts($dbConn);
    echo json_encode($comments);
}
function getAllComments($db)
{
    $statement = "SELECT * FROM comments";
    $result = $db->query($statement);
    if ($result && $result->num_rows > 0) {
        $comments = array();
        while ($result_row = $result->fetch_assoc()) {
            $post = array('id' => $result_row['id'],
                'comment' => $result_row['comment'],
                'post_id' => $result_row['post_id'],
                'user_id' => $result_row['user_id']);
            $comments[] = $comment;
        }
    }
    return $comments;
}


//Create a new Comment
if ($url == '/comments' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = $_POST;
    $commentId = addComment($input, $dbConn);
    if ($commentId) {
        $input['id'] = $commentId;
        $input['link'] = "/comments/$commentId";
    }
    echo json_encode($input);
}
/**
 * Add comments
 *
 * @param $input
 * @param $db
 * @return integer
 */
function addComment($input, $db)
{
    $comment = $input['comment'];
    $post_id = $input['post_id'];
    $users_id = $input['user_id'];
    $statement = "INSERT INTO comments (comment, post_id, user_id)
VALUES ('$comment', '$post_id', $users_id)";
    $db->query($statement);
    return $db->insert_id;
}

//Get a particular comment
if(preg_match("/comments\/([0-9])+/", $url, $matches) && $_SERVER['REQUEST_METHOD']
    == 'GET'){
    $commentId = $matches[1];
    $comment = getPost($dbConn, $commentId);
    echo json_encode($comment);
}
/**
 * Get Post based on ID
 *
 * @param $db
 * @param $id
 *
 * @return Associative Array
 */
function getComment($db, $id) {
    $statement = "SELECT * FROM comments where id = " . $id;
    $result = $db->query($statement);
    $result_row = $result->fetch_assoc();
    return $result_row;
}

//Update the comment
if(preg_match("/comments\/([0-9])+/", $url, $matches) && $_SERVER['REQUEST_METHOD']
    == 'PATCH'){
    $input = $_GET;
    $commentId = $matches[1];
    echo $url;
    print_r($matches);
    updateComment($input, $dbConn, $commentId);
    $comment = getPost($dbConn, $commentId);
    echo json_encode($comment);
}
/**
 * Update Post
 *
 * @param $input
 * @param $db
 * @param $postId
 * @return integer
 */
function updateComment($input, $db, $commentId){
    $fields = getParams($input);
    $statement = "UPDATE comments
SET $fields
WHERE id = " . $commentId;
    $db->query($statement);
    return $commentId;
}
/**
 * Get fields as parameters to set in record
 *
 * @param $input
 * @return string
 */
function getParams($input) {
    $allowedFields = ['comment', 'post_id', 'user_id'];
    $filterParams = [];
    foreach($input as $param => $value){
        if(in_array($param, $allowedFields)){
            $filterParams[] = "$param='$value'";
        }
    }
    return implode(", ", $filterParams);
}
//Delete a comment from the db
if(preg_match("/comments\/([0-9])+/", $url, $matches) && $_SERVER['REQUEST_METHOD']
    == 'DELETE'){
    $commentId = $matches[1];
    deletePost($dbConn, $commentId);
    echo json_encode([
        'id'=> $commentId,
        'deleted'=> 'true'
    ]);
}
/**
 * Delete Post record based on ID
 *
 * @param $db
 * @param $id
 */
function deleteComment($db, $id) {
    $statement = "DELETE FROM comments where id = " . $id;
    $db->query($statement);
}