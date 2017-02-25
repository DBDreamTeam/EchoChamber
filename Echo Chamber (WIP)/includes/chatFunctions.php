<?php
// inserts new chat into the chat table and 
function createNewChat($chatName, $conn) {
    $chatID = 0;
    $insertChat = "INSERT into chat (ChatTitle) VALUES ('{$chatName}')";
    
    if($conn -> query($insertChat) === TRUE) {
        echo "New chat inserted into chat table successfully <br>";
        $chatID = mysqli_insert_id($conn);
    } else {
        echo "Error: ". $insertChat. "<br>" . $conn->error;
    }
    return $chatID;
}

// gets the user IDs of the members of the specified circle ID (an array) and returns an array of these IDs
function getCircleMemberIDs($circleID, $conn) {
    $circleMembers = array();
    $i = 0;
    
    for($j=0; $j<count($circleID); $j++) {
        $selectCircleIDs = "SELECT UserID FROM group_members WHERE GroupID = {$circleID[$j]}";

        $circleIDsResult = mysqli_query($conn, $selectCircleIDs);

        if(mysqli_num_rows($circleIDsResult) > 0) {
            while($row = mysqli_fetch_assoc($circleIDsResult)) {
                $circleMembers[$i] = $row["UserID"];
                $i++;
            }
        }
    }
    echo " Circle Member IDs: <br>";
    print_r($circleMembers);
    echo "<br>";
    return $circleMembers;
}

// returns an array of all members of a chat, both individual members and those of any circles included in the chat
function combineAllChatMembers($indIDs, $circleIDs, $userID) {
    $chatMembers = array();
    $i = 0;
    
    // Insert individuals into $chatMembers array
    for($i=0; $i<count($indIDs); $i++) {
        $chatMembers[$i] = $indIDs[$i];
    }
    echo "Value of counter: " . $i . "<br>";
    
    echo "Chat members after inserting individual: <br>";
    print_r($chatMembers);
    echo "<br>";
    
    // Insert members of circle into chat members array
    for($j=0; $j<count($circleIDs); $j++) {
        if(!(in_array($circleIDs[$j], $chatMembers))){
        $chatMembers[$i] = $circleIDs[$j];
        $i++;
        }
    }
    
    echo "Value of counter: " . $i . "<br>";
    
    echo "Chat Members after inserting groups: <br>";
    print_r($chatMembers);
    echo "<br>";
    
    // Insert user into chat members array
    if (!(in_array($userID, $chatMembers))) {
        $chatMembers[$i] = $userID;
    }
    
    echo "Chat Members after inserting user <br>";
    print_r($chatMembers);
    echo "<br>";

    return $chatMembers;
}

// inserts members of specified chat ID into chat_members table, WHERE $chatMemberIDs is an array
function insertChatMembers($chatID, $chatMemberIDs, $conn) {
    for($i=0; $i<count($chatMemberIDs); $i++) {
        $insertChatMembers = "INSERT INTO chat_members (ChatID, UserID) VALUES ({$chatID}, {$chatMemberIDs[$i]})";
        
        if($conn -> query($insertChatMembers) === TRUE) {
            echo "Chat members inserted into chat_members successfully <br>";
        } else { 
            echo "Error: " .$insertChatMembers . "<br>" . $conn->error;
        }
    }
}

