<?php 
    // header("Access-Control-Allow-Origin: http://localhost:8080");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    // $conn = new mysqli("localhost", "kate", "ln4h1D683DSMDrZ20m", "vue-php");
    // if($conn->connect_error){
    //     die("Connection Failed!".$conn->connect_error);
    // }
    $conn = new mysqli("localhost", "root", "root", "vue-php");
    if($conn->connect_error){
        die("Connection Failed!".$conn->connect_error);
    }
    $result = array('error'=>false);
    $action = '';

    // if(isset($_GET['action'])){
    //     $action = $_GET['action'];
    // }

    switch ($_GET['action']) {
        case 'read':
            $id = 1;

            $sql = $conn->query(
            "SELECT *
            FROM places
            LEFT JOIN users_places
            ON id = place_id
            WHERE users_places.user_id = $id");

            $places = [];
            while($row = $sql->fetch_assoc()) {
                $places[] = $row;
            }
            $result['places'] = $places;
            
            break; 
        case 'count-places':
            $id = 1;
    
            $sql = $conn->query("SELECT COUNT(place_id) AS count FROM `users_places` WHERE `user_id`='1'");
            
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }
            
            break;            
        case 'all-places':
            $sql = $conn->query("SELECT * FROM places");
            $places = [];
            while($row = $sql->fetch_assoc()) {
                $places[] = $row;
            }
            $result['places'] = $places;

            break;
        case 'count-all-places':
            $sql = $conn->query("SELECT COUNT(id) AS count FROM `places`");
           
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }
            break;
        case 'create':
            
            $name = $_POST['name'];
            $country = $_POST['country'];
            $city = $_POST['city'];
            $street = $_POST['street'];
            $building = $_POST['building'];
            $description = $_POST['description'];

            if (!empty($name)) {
                try {
                    $sql = $conn->query(
                    "INSERT INTO places (name, country, city, street, building, description, photo) 
                    VALUES('$name','$country','$city','$street','$building','$description', '')");

                    
                    $last_id = $conn->insert_id;

                    $sql = $conn->query(
                    "INSERT INTO users_places (user_id, place_id) VALUES('1','$last_id')");
                } catch (Exception $e){
                }
        
                if (isset($sql) && $sql) {
                    $result['message'] = "Place added successfully!";
                    
                } else {
                    $result['error'] = true;
                    $result['message'] = "Failed to add place!";
                } 
            } else {
                $result['message'] = "Введите имя";
            }
            
            break;
        case 'add-friend':
            $id = $_GET['id'];
            
            // try {
                $sql = $conn->query(
                "DELETE FROM `users_followers` WHERE `follower_id`=$id");

                $sql2 = $conn->query(
                "INSERT INTO users_friends (user_id,friend_id) 
                VALUES('1','$id')");

                
                // $last_id = $conn->insert_id;

                // $sql = $conn->query(
                // "INSERT INTO users_places (user_id, place_id) VALUES('1','$last_id')");
            // } catch (Exception $e){
            // }

            if (isset($sql) && $sql) {
                $result['message'] = "successfully!";
                
            } else {
                $result['error'] = true;
                $result['message'] = "error!";
            } 
            
            
            break;
        case 'delete-friend':
            $friend_id = $_GET['id'];

            $sql = $conn->query(
            "DELETE FROM users_friends (user_id,friend_id) 
            VALUES('1','$friend_id')");

            if (isset($sql) && $sql) {
                $result['message'] = "successfully!";
                
            } else {
                $result['error'] = true;
                $result['message'] = "error!";
            } 

        case 'update':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $country = $_POST['country'];
            $city = $_POST['city'];
            $street = $_POST['street'];
            $building = $_POST['building'];
            $description = $_POST['description'];
            
            $sql = $conn->query("UPDATE places SET name='$name',country='$country',city='$city',street='$street',building='$building',description='$description' WHERE id='$id'");
            
            if ($sql) {
                $result['message'] = "Place updated successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to update place!";
            }
            
            break;
        case 'delete':
            $id = $_POST['id'];
            
            $sql = $conn->query("DELETE FROM places WHERE id='$id'");

            

            $sql = $conn->query(
            "DELETE FROM users_places WHERE place_id='$id'");
            
            if ($sql) {
                $result['message'] = "Place deleted successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to delete place!";
            }

            break;
        case 'get-friends':
            $id = 1;

            $sql = $conn->query(
            "SELECT *
            FROM users
            LEFT JOIN users_friends
            ON users.id = users_friends.friend_id
            WHERE users_friends.user_id = $id");
            
            $users = [];
            while($row = $sql->fetch_assoc()) {
                $users[] = $row;
            }
            $result['users'] = $users;

            break;
        case 'get-followers': //подписчики
            $id = 1;
            $limit = 8;
            $offset = $_POST['offset'] * $limit;


            $sql = $conn->query(
            "SELECT *
            FROM users
            LEFT JOIN users_users ON users.id = users_users.user_id
            WHERE users_users.test_id = $id
            AND users.id != $id
            LIMIT $limit 
            OFFSET $offset
            ");

            $users = [];
            while($row = $sql->fetch_assoc()) {
                $users[] = $row;
            }
            $result['users'] = $users;

            break;
        case 'count-followers':
            $sql = $conn->query("SELECT COUNT(user_id) AS count FROM `users_users` WHERE test_id='1'");
        
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }

            break;
        case 'count-user-followers':
            $id = $_GET['id'];
            $sql = $conn->query("SELECT COUNT(user_id) AS count FROM `users_users` WHERE test_id=$id");
        
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }

            break;
        case 'get-subscriptions': //подписки
            $id = 1;
            $limit = 10;
            $offset = $_POST['offset'] * $limit;
            
            $sql = $conn->query(
            "SELECT *
            FROM users
            LEFT JOIN users_users
            ON users.id = users_users.test_id
            WHERE users_users.user_id = $id
            AND users.id != $id
            LIMIT $limit
            OFFSET $offset
            ");
    
            $users = [];
            while($row = $sql->fetch_assoc()) {
                $users[] = $row;
            }
            $result['users'] = $users;

            break;
        case 'get-subscriptions-aside':
            $id = 1;
            
            $sql = $conn->query(
                "SELECT *
                FROM users
                LEFT JOIN users_users
                ON users.id = users_users.test_id
                WHERE users_users.user_id = $id
                LIMIT 5");
        
                $users = [];
                while($row = $sql->fetch_assoc()) {
                    $users[] = $row;
                }
                $result['users'] = $users;
    
                break;

        case 'count-subscriptions':
            $sql = $conn->query("SELECT COUNT(test_id) AS count FROM `users_users` WHERE user_id='1'");
           
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }

            break;
        case 'count-user-susubscriptions':
            $id = $_GET['id'];
            $sql = $conn->query("SELECT COUNT(test_id) AS count FROM `users_users` WHERE user_id=$id");
           
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }

            break;

        case 'read-users':

            $limit = 10;
            $offset = $_POST['offset'] * $limit;
            
            
            $sql = $conn->query(
            "SELECT * 
            FROM users 
            WHERE id != '1'
            LIMIT $limit
            OFFSET $offset
            ");

            $users = [];
            while($row = $sql->fetch_assoc()) {
                $users[] = $row;
            }
            $result['users'] = $users;
            

            break;
        case 'count-all-users':
            $sql = $conn->query("SELECT COUNT(id) AS count FROM `users` WHERE id!='1'");

            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }
            
            break;
        case 'get-user':
            $id = $_GET['id'];

            $sql1 = $conn->query("SELECT * FROM users WHERE id='$id'");
            $users = [];
            while($row = $sql1->fetch_assoc()) {
                $users[] = $row;
            }
            $result['users'] = $users;
            
            //подписки
            $sql3 = $conn->query(
                "SELECT *
                FROM users
                LEFT JOIN users_users
                ON users.id = users_users.user_id
                WHERE users_users.test_id = $id");

            $subs = [];
            while($row = $sql3->fetch_assoc()) {
                $subs[] = $row;
            }
            $result['subs'] = $subs;
            
            if( !empty($subs) ) {
                $result['statusIn'] = "В подписках";
            } else {
                $result['statusOut'] = "Не в подписках";
            }

            //подписчики
            $sql = $conn->query(
            "SELECT *
            FROM users
            LEFT JOIN users_users
            ON users.id = users_users.user_id
            WHERE users_users.test_id = 1 AND users_users.user_id=$id");

            $fol = [];
                    
            while($row = $sql->fetch_assoc()) {
                $fol[] = $row;
            }
            $result['fol'] = $fol;

            if( !empty($fol) ) {
                $result['FolYes'] = "Подписчик";
            } 
            else {
                $result['FolNo'] = "Не подписчик";
            }
            

            break;
        case 'get-presents':

            $id = $_GET['id']; 

            $sql = $conn->query(
                "SELECT * FROM users
                LEFT JOIN i_will_present ON users.id = i_will_present.friend_id
                LEFT JOIN wish ON wish.id = i_will_present.wish_id
                AND i_will_present.wish_id=$id");
    
            $presents = [];
            while($row = $sql->fetch_assoc()) {
                $presents[] = $row;
            }
            $result['presents'] = $presents;

            if( !empty($presents) ) {
                $result['statusYes'] = "Забронировано";
            } else {
                $result['statusNo'] = "Не забронировано";
            }

            break;

        case 'get-user-places':
            $id = $_GET['id'];
            $sql2 = $conn->query(
                "SELECT *
                FROM places
                LEFT JOIN users_places
                ON id = place_id
                WHERE users_places.user_id = $id");
                $places = [];
                while($row = $sql2->fetch_assoc()) {
                    $places[] = $row;
                }
                $result['places'] = $places;
        case 'get-place-users':
            $id = $_GET['id'];
            $sql2 = $conn->query(
                "SELECT *
                FROM users
                LEFT JOIN users_places
                ON id = user_id
                WHERE users_places.place_id = $id
                AND user_id !='1'");

            $users = [];
            while($row = $sql2->fetch_assoc()) {
                $users[] = $row;
            }
           
            $result['users'] = $users;
            
            

        case 'get-user-followers':
            $id = $_GET['id'];

            $sql = $conn->query(
                "SELECT *
                FROM users
                LEFT JOIN users_users
                ON users.id = users_users.user_id
                WHERE users_users.test_id = $id
                AND users.id != $id");
    
                $followers = [];
                while($row = $sql->fetch_assoc()) {
                    $followers[] = $row;
                }
                $result['followers'] = $followers;
            break;
        case 'get-user-subs':
            $id = $_GET['id'];
            $sql = $conn->query(
                "SELECT *
                FROM users
                LEFT JOIN users_users
                ON users.id = users_users.test_id
                WHERE users_users.user_id = $id");
        
                $subs = [];
                while($row = $sql->fetch_assoc()) {
                    $subs[] = $row;
                }
                $result['subs'] = $subs;
    
                break;
            
        case 'count-user-places':
            $id = $_GET['id'];
    
            $sql = $conn->query("SELECT COUNT(place_id) AS count FROM `users_places` WHERE `user_id`=$id");
            
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }
            
            break;             
        case 'get-my-profile':
            $id = 1;

            $sql = $conn->query("SELECT * FROM users WHERE id='$id'");
            $users = [];
            while($row = $sql->fetch_assoc()) {
                $users[] = $row;
            }
            $result['users'] = $users;

            break;
        case 'add-user':
            
            
            $nickname = $_POST['nickname'];
            $password = $_POST['password'];
            
            
            try {
                
                $sql = $conn->query("INSERT INTO `users`(`nickname`,`password`) VALUES ('$nickname ','$password')");
                
            } catch (Exception $e){
            }
    
            if (isset($sql) && $sql) {
                $result['message'] = "User added successfully!";
                
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to add user!";
            }
            
           

            break;
        case 'update-user':
            $id = $_POST['id'];
            $firstName = $_POST['firstName'];
            $secondName = $_POST['secondName'];
            $nickName = $_POST['nickName'];
            $about =$_POST['about'];
            
            $sql = $conn->query("UPDATE users SET firstName='$firstName',secondName='$secondName',nickName='$nickName', about='$about' WHERE id='$id'");
            
            if ($sql) {
                $result['message'] = "User updated successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to update user!";
            }
            
            break;
        case 'delete-user':
            $id = $_POST['id'];
            
            $sql = $conn->query("DELETE FROM users WHERE id='$id'");
            
            if ($sql) {
                $result['message'] = "User deleted successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to delete user!";
            }

            break;
    
        case 'get-place':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM places WHERE id = $id");
            
            $places = [];
            while($row = $sql->fetch_assoc()) {
                $places[] = $row;
            }
            $result['places'] = $places;

            break;
        case 'get-friend':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM users WHERE id = $id");
            
            $users = [];
            while($row = $sql->fetch_assoc()) {
                $users[] = $row;
            }
            $result['users'] = $users;

            $sql = $conn->query(
            "SELECT *
            FROM places
            LEFT JOIN users_places
            ON id = place_id
            WHERE users_places.user_id = $id");

            $places = [];
            while($row = $sql->fetch_assoc()) {
                $places[] = $row;
            }
            $result['places'] = $places;

            break;
        case 'subscribe':
            // try {
                $id = $_GET['id'];
            
                $sql = $conn->query(
                    "INSERT INTO `users_users`(`user_id`, `test_id`) VALUES ('1','$id')");
    
                if ($sql) {
                    $result['message'] = "subscribe successfully!";
                } else {
                    $result['error'] = true;
                    $result['message'] = "subscribe error!";
                }
            // }
            // catch (Exception $e) {
            //     $result['message'] = "subscribe error!";
            // }
            break;
        case 'unsubscribe':
            // try {
                $id = $_GET['id'];
            
                $sql = $conn->query(
                    "DELETE FROM `users_users` WHERE `test_id`=$id");
    
                if ($sql) {
                    $result['message'] = "unsubscribe successfully!";
                } else {
                    $result['error'] = true;
                    $result['message'] = "unsubscribe error!";
                }
            // }
            // catch (Exception $e) {
            //     $result['message'] = "ERROR!";
            // }
            break;
        case 'test-get-friend':
            $id = 1;
            
            //подписки
            $sql = $conn->query(
                "SELECT *
                FROM users
                LEFT JOIN users_users
                ON users.id = users_users.test_id
                WHERE users_users.user_id = $id");

            //подписччики
            $sql = $conn->query(
                "SELECT *
                FROM users
                LEFT JOIN users_users
                ON users.id = users_users.user_id
                WHERE users_users.test_id = $id");

            
                
                $users = [];
                while($row = $sql->fetch_assoc()) {
                    $users[] = $row;
                }
                $result['users'] = $users;
    
                break;
        case 'get-sub-places':

            $id = $_POST['id'];

            $sql = $conn->query(
            "SELECT *
            FROM places
            LEFT JOIN users_places
            ON id = place_id
            WHERE users_places.user_id = $id");
            
            $places = [];
            while($row = $sql->fetch_assoc()) {
                $places[] = $row;
            }
            $result['places'] = $places;

            break;
    
        case 'add-visited':
            $id = $_GET['id'];
            
                $sql = $conn->query("INSERT INTO users_places (user_id, place_id) VALUES('1','$id')");
            
            
            break;
        case 'image-load':

            if(!empty($_FILES['file']['name'] !== '')) {
                $file = $_FILES['file'];
                $name = $file['name'];
                $pathFile = '../public/img/'.$name;
             
                if(!move_uploaded_file($file['tmp_name'], $pathFile)) {
                    echo 'Файл не смог загрузиться';
                }

                // $sql = $conn->query("INSERT INTO `photos`(`path`) VALUES ('$name')");
                $sql = $conn->query("UPDATE `users` SET `img`='$name' WHERE `id`=1");
            }
          
            break;
        case 'user-image':

            if(!empty($_FILES['file'])) {
                $file = $_FILES['file'];
                $name = $file['name'];
                $pathFile = '../public/img/'.$name;
             
                if(!move_uploaded_file($file['tmp_name'], $pathFile)) {
                    echo 'Файл не смог загрузиться';
                }

                
                $sql = $conn->query("UPDATE `users` SET `img`='$name' WHERE `id`=1");
            }
          
            $result['successMsg'] = '+++';
            
            break;
        case 'image-get':

            $sql = $conn->query(
            "SELECT * FROM `photos` WHERE user_id=1");

            $photos = [];
            while($row = $sql->fetch_assoc()) {
                $photos[] = $row;
            }
            $result['photos'] = $photos;
            
            break;
        case 'image-get-place':
            $id = $_GET['id'];

            $sql = $conn->query("SELECT * FROM `photos` WHERE `place_id`=$id AND user_id=1");

            $photos = [];
            while($row = $sql->fetch_assoc()) {
                $photos[] = $row;
            }
            $result['photos'] = $photos;
            
            break;


        case 'get-wishlist':

            
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT *
            FROM wish 

            LEFT JOIN users_wishlist ON id = wish_id
            WHERE users_wishlist.user_id = 1
            AND wish.folder_id = $id
            AND wish.done = 0
            ORDER BY wish.date DESC
            -- AND wish.wish_list = 1
            ");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;
            
            break; 
        case 'get-user-wishlist-in-folder':
            $id = $_GET['id'];
            
            $sql = $conn->query(
            "SELECT *
            FROM wish
            LEFT JOIN users_wishlist_folders ON users_wishlist_folders.folder_id  = wish.folder_id
            WHERE users_wishlist_folders.folder_id = $id");

                $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;

            break; 
        case 'get-user-bucketlist-in-folder':
            $id = $_GET['id'];
            
            $sql = $conn->query(
            "SELECT *
            FROM bucket
            LEFT JOIN users_bucketlist_folders ON users_bucketlist_folders.folder_id  = bucket.folder_id
            WHERE users_bucketlist_folders.folder_id = $id");

                $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;

            break; 

        case 'get-all-my-wishlist':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM wish 

            LEFT JOIN users_wishlist ON id = wish_id
            WHERE users_wishlist.user_id = 1
            AND wish.folder_id = $id
            ORDER BY wish.date DESC
            -- AND wish.done = 0
            -- AND wish.wish_list = 1
            ");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;
            break; 
        case 'get-all-my-bucketlist':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM bucket 

            LEFT JOIN users_bucketlist ON id = users_bucketlist.bucketlist_id
            WHERE users_bucketlist.user_id = 1
            AND bucket.folder_id = $id
            ORDER BY bucket.date DESC
            -- AND wish.done = 0
            -- AND wish.wish_list = 1
            ");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;
            break; 
        case 'get-bucketlist':

            
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM bucket 

            LEFT JOIN users_bucketlist ON bucket.id = users_bucketlist.bucketlist_id
            WHERE users_bucketlist.user_id = 1
            AND bucket.folder_id = $id
            AND bucket.done = 0
            ORDER BY bucket.date DESC
            ");


            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;


            if ($sql) {
                $result['url'] = "my-bucket-list-item";
            } else {
                $result['error'] = true;
                $result['message'] = "error!";
            }
                
            break; 
        case 'get-my-wishlist-want':
            $sql = $conn->query(
                "SELECT * FROM wish 
    
                LEFT JOIN users_wishlist ON wish.id = users_wishlist.wish_id
                WHERE users_wishlist.user_id = 1
                AND wish.done = 0
                ORDER BY wish.date DESC
                ");
    
                
        
                $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;
            
            break; 
        case 'get-my-bucketlist-want':
            $sql = $conn->query(
                "SELECT * FROM bucket 
    
                LEFT JOIN users_bucketlist ON bucket.id = users_bucketlist.bucketlist_id
                WHERE users_bucketlist.user_id = 1
                AND bucket.done = 0
                ORDER BY bucket.date DESC
                ");
    
                
        
                $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;
            
            break;
        case 'get-wishlist-item':

            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM wish 
            -- LEFT JOIN wishlist_folders ON wish.folder_id = wishlist_folders.id
            WHERE wish.id = $id");

            
            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            $sql2 = $conn->query(
            "SELECT `wishlist_folders`.`name` FROM wishlist_folders
            LEFT JOIN wish ON wishlist_folders.id = wish.folder_id
            WHERE wish.id = $id");

            $folders = [];
            while($row = $sql2->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;


            break;
        case 'test':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM wish 
            LEFT JOIN users_wishlist ON wish.id = users_wishlist.wish_id
            LEFT JOIN users ON users.id = users_wishlist.user_id
            WHERE wish.id = $id");

            


            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            break;
        case 'get-bucketlist-item':

            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM bucket WHERE id = $id");
            
            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            $sql2 = $conn->query(
                "SELECT `bucketlist_folders`.`name` FROM bucketlist_folders
                LEFT JOIN bucket ON bucketlist_folders.id = bucket.folder_id
                WHERE bucket.id = $id");
    
                $folders = [];
                while($row = $sql2->fetch_assoc()) {
                    $folders[] = $row;
                }
                $result['folders'] = $folders;

            break;

        case 'get-wishlist-folders':
            $id = 1;

            $sql = $conn->query(
            "SELECT *
            FROM wishlist_folders
            LEFT JOIN users_wishlist_folders ON wishlist_folders.id = users_wishlist_folders.folder_id
            WHERE users_wishlist_folders.user_id = $id
            ORDER BY `wishlist_folders`.`date` DESC
            ");

            $folders = [];
            while($row = $sql->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;
            
            break; 
        case 'get-user-wishlist-folders':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT *
            FROM wishlist_folders
            LEFT JOIN users_wishlist_folders ON wishlist_folders.id = users_wishlist_folders.folder_id
            WHERE users_wishlist_folders.user_id = $id
            ORDER BY `wishlist_folders`.`date` DESC
            ");

            $folders = [];
            while($row = $sql->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;
            
            break; 
        case 'get-user-bucketlist-folders':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT *
            FROM bucketlist_folders
            LEFT JOIN users_bucketlist_folders ON bucketlist_folders.id = users_bucketlist_folders.folder_id
            WHERE users_bucketlist_folders.user_id = $id
            ORDER BY `bucketlist_folders`.`date` DESC
            ");

            $folders = [];
            while($row = $sql->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;
            
            break; 
          
        case 'get-wishlist-folders-test':
            $id = 1;

            $sql = $conn->query(
            "SELECT * FROM wishlist_folders
            LEFT JOIN users_wishlist_folders ON wishlist_folders.id = users_wishlist_folders.folder_id
            LEFT JOIN users ON users.id = users_wishlist_folders.user_id
            WHERE users.id =$id
            ");

            $folders = [];
            while($row = $sql->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;
            
            break; 
        case 'get-user-wishlist-folders':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT *
            FROM wishlist_folders
            LEFT JOIN users_wishlist_folders
            ON id = folder_id
            WHERE users_wishlist_folders.user_id = $id");

            $folders = [];
            while($row = $sql->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;
            
            break; 

        case 'get-bucketlist-folders':
            $id = 1;

            $sql = $conn->query(
            "SELECT *
            FROM bucketlist_folders
            LEFT JOIN users_bucketlist_folders
            ON id = folder_id
            WHERE users_bucketlist_folders.user_id = $id
            ORDER BY `bucketlist_folders`.`date` DESC
            ");

            $folders = [];
            while($row = $sql->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;
            
            break; 
            
        
        case 'wishlist-folder':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM wishlist_folders 
            WHERE wishlist_folders.id = $id");

            
            $folders = [];
            while($row = $sql->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;

            break;
        case 'bucketlist-folder':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM bucketlist_folders
            WHERE id = $id");

            
            $folders = [];
            while($row = $sql->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;

            break;
        
        case 'ideas-wishlist':
            // $sql = $conn->query(
            //     "SELECT * FROM wish");
            
            // $wishes = [];
            //     while($row = $sql->fetch_assoc()) {
            //         $wishes[] = $row;
            //     }
            // $result['wishes'] = $wishes;

            

            $sql = $conn->query(
            "SELECT * FROM wish 

            LEFT JOIN users_wishlist ON id = wish_id
            WHERE users_wishlist.user_id != 1");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            break; 
        case 'ideas-wishlist-by-followers':
            $id = 1;


            $sql = $conn->query(
            "SELECT * FROM wish
            
            LEFT JOIN users_wishlist ON wish.id = users_wishlist.wish_id
            LEFT JOIN users_users ON users_wishlist.user_id = users_users.user_id
            -- LEFT JOIN users ON users.id = users_wishlist.user_id
            -- WHERE users_wishlist.user_id != $id
            WHERE users_users.test_id = $id
            ");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            

            break; 
        case 'ideas-bucketlist-by-followers':
            $id = 1;


            $sql = $conn->query(
            "SELECT * FROM bucket
            
            LEFT JOIN users_bucketlist ON bucket.id = users_bucketlist.bucketlist_id
            LEFT JOIN users_users ON users_bucketlist.user_id = users_users.user_id
            -- LEFT JOIN users ON users.id = users_wishlist.user_id
            -- WHERE users_wishlist.user_id != $id
            WHERE users_users.test_id = $id
            ");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            

            break; 
        case 'ideas-wishlist-by-subs':
            $id = 1;

            $sql = $conn->query(
                "SELECT * FROM wish
                
                LEFT JOIN users_wishlist ON wish.id = users_wishlist.wish_id
                LEFT JOIN users_users ON users_wishlist.user_id = users_users.test_id
                WHERE users_users.test_id != $id
                AND users_users.user_id = $id
                ");
            

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            

            break; 
        case 'ideas-bucketlist-by-subs':
            $id = 1;

            $sql = $conn->query(
                "SELECT * FROM bucket
                
                LEFT JOIN users_bucketlist ON bucket.id = users_bucketlist.bucketlist_id
                LEFT JOIN users_users ON users_bucketlist .user_id = users_users.test_id
                WHERE users_users.test_id != $id
                AND users_users.user_id = $id
                ");
            

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            

            break; 

        case 'ideas-bucketlist':
            $sql = $conn->query(
                "SELECT * FROM bucket 
    
                LEFT JOIN users_bucketlist ON bucket.id = users_bucketlist.bucketlist_id
                WHERE users_bucketlist.user_id != 1");
    
                $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;
          
        

            break;
        case 'all-wishlist':
            $sql = $conn->query(
                "SELECT * FROM wish");
            
            $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
            $result['wishes'] = $wishes;

            var_dump($wishes);

            break; 
        case 'all-bucketlist':
            $sql = $conn->query(
                "SELECT * FROM bucket");
            
            $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
            $result['wishes'] = $wishes;

            break; 
        
        case 'count-wishlist':
            $id = 1;
    
            $sql = $conn->query("SELECT COUNT(wish_id) AS count_wishlist FROM `users_wishlist` WHERE `user_id`='1'");
            
            while($row = $sql->fetch_assoc()) {
                $result['count_wishlist'] = $row['count_wishlist'];
            }
            
            break; 
        
        case 'count-user-wishlist':

            $id = $_GET['id'];
    
            $sql = $conn->query("SELECT COUNT(wish_id) AS count_wishlist FROM `users_wishlist` WHERE `user_id`=$id");
            
            while($row = $sql->fetch_assoc()) {
                $result['count_wishlist'] = $row['count_wishlist'];
            }

            break; 
        
        case 'count-all-users-wishlist':
            $id = $_POST['id'];
    
            $sql = $conn->query("SELECT COUNT(wish_id) AS count_wishlist FROM `users_wishlist` WHERE `user_id`=$id");
            
            while($row = $sql->fetch_assoc()) {
                $result['count_wishlist'] = $row['count_wishlist'];
            }
            break; 
        
        case 'count-bucketlist':
            $id = 1;
    
            $sql = $conn->query("SELECT COUNT(bucketlist_id) AS count_bucketlist FROM `users_bucketlist` WHERE `user_id`=$id");
            
            while($row = $sql->fetch_assoc()) {
                $result['count_bucketlist'] = $row['count_bucketlist'];
            }

            break; 
        
        case 'count-user-bucketlist':
            $id = $_GET['id'];

            $sql = $conn->query("SELECT COUNT(bucketlist_id) AS count_bucketlist FROM `users_bucketlist` WHERE `user_id`=$id");
            
            while($row = $sql->fetch_assoc()) {
                $result['count_bucketlist'] = $row['count_bucketlist'];
            }

            break; 
        
            break; 
        
        case 'add-wishlist':

            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $photo = $_POST['photo'];
            $link = $_POST['link'];
            $visible = $_POST['visible'];
            $folder_id = $_POST['folder_id'];
            $done = $_POST['done'];
            $wish_list = $_POST['wish_list'];
            $bucket_list = $_POST['bucket_list'];

           
            
            $sql = $conn->query("INSERT INTO `wish`(`name`, `price`, `description`, `photo`, `link`, `visible`, `folder_id`, `done`, `wish_list`, `bucket_list`) VALUES ('$name','$price','$description', '$photo', '$link','$visible','$folder_id','$done','$wish_list','$bucket_list')");
            
            $last_id = $conn->insert_id;

            $sql = $conn->query(
            "INSERT INTO users_wishlist (user_id, wish_id) VALUES('1','$last_id')");

            if ($sql) {
                $result['message'] = "Желания создано!";
            } else {
                $result['error'] = true;
                $result['message'] = "Не удалось добавить желание!";
            }
           
        
            break; 

        case 'add-wishlist-to-folder':
            
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $photo = $_POST['photo'];
            $link = $_POST['link'];
            $visible = $_POST['visible'];

            $done = $_POST['done'];
            $wish_list = 1;
            $bucket_list = 0;

            $folder_id = $_GET['id'];

            
            $sql = $conn->query("INSERT INTO `wish`(`name`, `price`, `description`, `photo`, `link`, `visible`, `folder_id`, `done`, `wish_list`, `bucket_list`) VALUES ('$name','$price','$description', '$photo', '$link','$visible','$folder_id','$done','$wish_list','$bucket_list')");
            
            $last_id = $conn->insert_id;

            $sql = $conn->query(
            "INSERT INTO users_wishlist (user_id, wish_id) VALUES('1','$last_id')");


            break; 
        case 'add-bucketlist-to-folder':
            $name = $_POST['name'];
            $description = $_POST['description'];
            $folder_id = $_GET['id'];
            $photo = $_POST['photo'];
            $link = $_POST['link'];
            $visible = $_POST['visible'];
            $price = $_POST['price'];
            $done = $_POST['done'];
            
            // echo json_encode($_POST);
            $sql = $conn->query(
             "INSERT INTO `bucket`(`name`, `price`, `description`, `photo`,  `link`, `visible`,`folder_id`, `done`) VALUES ('$name', '$price', '$description', '$photo', '$link', '$visible', '$folder_id', '$done')");

             $last_id = $conn->insert_id;

            $sql = $conn->query(
            "INSERT INTO users_bucketlist (user_id, bucketlist_id) VALUES('1','$last_id')");
            
            break;

        case 'add-bucketlist':
            $name = $_POST['name'];
            $description = $_POST['description'];
            $folder_id = $_POST['folder_id'];
            $photo = $_POST['photo'];
            $price = $_POST['price'];
            $done = $_POST['done'];
            $link = $_POST['link'];
            $visible = $_POST['visible'];
            
            $sql = $conn->query(
             "INSERT INTO `bucket`(`name`, `price`, `description`, `photo`, `folder_id`, `done`, `link`, `visible`) VALUES ('$name', '$price', '$description', '$photo', '$folder_id', '$done', '$link', '$visible')");

             $last_id = $conn->insert_id;

            $sql = $conn->query(
            "INSERT INTO users_bucketlist (user_id, bucketlist_id) VALUES('1','$last_id')");
           
        
            break; 
        case 'add-bucket-folder':
            $name = $_POST['name'];

            $sql = $conn->query(
                "INSERT INTO `bucketlist_folders`(`name`) VALUES ('$name')");
            
            $last_id = $conn->insert_id;

            $sql = $conn->query(
            "INSERT INTO users_bucketlist_folders (user_id, folder_id) VALUES('1','$last_id')");


         break; 

        case 'add-wishlist-folder':

            $name = $_POST['name'];
            $description = $_POST['description'];

            $sql = $conn->query("INSERT INTO `wishlist_folders`(`name`, `description`) VALUES ('$name', '$description')");
            
            $last_id = $conn->insert_id;

            $sql = $conn->query(
            "INSERT INTO users_wishlist_folders (user_id, folder_id) VALUES('1','$last_id')");

            break; 

        case 'get-done-wishlist':
            

            $sql = $conn->query(
            "SELECT * FROM wish 
            LEFT JOIN users_wishlist ON id = wish_id
            WHERE users_wishlist.user_id = 1
            AND wish.done = 1
            ORDER BY wish.date DESC
            ");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;
            
            break; 
        case 'get-done-wishlist-in-folder':
            $id = $_GET['id'];

            $sql = $conn->query(
               
            "SELECT * FROM wish 
            LEFT JOIN users_wishlist ON wish.id = users_wishlist.wish_id
            WHERE users_wishlist.user_id = 1
            AND wish.folder_id = $id
            AND wish.done = 1
            ORDER BY wish.date DESC
            ");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;
            
            break;
        case 'get-done-bucketlist-in-folder':
            $id = $_GET['id'];

            $sql = $conn->query(
               
            "SELECT * FROM bucket 
            LEFT JOIN users_bucketlist ON bucket.id = users_bucketlist.bucketlist_id
            WHERE users_bucketlist.user_id = 1
            AND bucket.folder_id = $id
            AND bucket.done = 1
            ORDER BY bucket.date DESC
            ");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;
            
            break; 
        case 'get-done-bucketlist':
        

            $sql = $conn->query(
            "SELECT * FROM bucket
            LEFT JOIN users_bucketlist ON bucket.id = users_bucketlist.bucketlist_id
            WHERE users_bucketlist.user_id = 1
            AND bucket.done = 1");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;
            
            break;

        case 'get-done-bucketlist-for-folder':
            

            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT COUNT(bucket.id) AS count FROM bucket 
            LEFT JOIN users_bucketlist ON bucket.id = users_bucketlist.bucketlist_id
            WHERE users_bucketlist.user_id = 1
            AND bucket.done = 1
            AND bucket.folder_id=$id
            ");
            
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }

            break;
        case 'get-done-wishlist-for-folder':
            
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT COUNT(wish.id) AS count FROM `wish` 
            LEFT JOIN users_wishlist ON wish.id = users_wishlist.wish_id
            WHERE users_wishlist.user_id = 1
            AND wish.done = 1
            AND wish.folder_id = $id
            ");
            
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }
    
            break;
        case 'get-count-done-wishlist':
        
            

            $sql = $conn->query(
            "SELECT COUNT(wish.id) AS count FROM `wish` 
            LEFT JOIN users_wishlist ON wish.id = users_wishlist.wish_id
            WHERE users_wishlist.user_id = 1
            AND wish.done = 1
            
            ");
            
            while($row = $sql->fetch_assoc()) {
                $result['count'] = $row['count'];
            }
    
            break;
        case 'get-user-wishlist':
            $id = $_GET['id'];
            
            $sql = $conn->query(
                "SELECT *
                FROM wish
                LEFT JOIN users_wishlist
                ON wish.id = users_wishlist.wish_id
                WHERE users_wishlist.user_id = $id");

                $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;

            $sql2 = $conn->query(
                "SELECT * 
                FROM users_wishlist 
                LEFT JOIN users ON users.id = users_wishlist.user_id
                WHERE users_wishlist.wish_id = $id
                ");
    
                $users = [];
                while($row = $sql2->fetch_assoc()) {
                    $users[] = $row;
                }
                $result['users'] = $users;

            break;
        case 'get-user-bucketlist':
            $id = $_GET['id'];
            
            $sql2 = $conn->query(
                "SELECT *
                FROM bucket
                LEFT JOIN users_bucketlist_folders ON users_bucketlist_folders.folder_id  = bucket.folder_id
                WHERE users_bucketlist_folders.folder_id = $id");

                $wishes = [];
                while($row = $sql2->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;

            break;
        case 'get-user-from-folder-bucketlist':
            $id = $_GET['id'];

            $sql2 = $conn->query(
            "SELECT * FROM users
            LEFT JOIN users_bucketlist_folders ON users.id = users_bucketlist_folders.user_id
            WHERE users_bucketlist_folders.folder_id = $id");

            $users = [];
                while($row = $sql2->fetch_assoc()) {
                    $users[] = $row;
                }
                $result['users'] = $users;

            break;
        case 'get-user-from-folder-wishlist':
            $id = $_GET['id'];

            $sql2 = $conn->query(
            "SELECT * FROM users
            LEFT JOIN users_wishlist_folders ON users.id = users_wishlist_folders.user_id
            WHERE users_wishlist_folders.folder_id = $id");

            $users = [];
                while($row = $sql2->fetch_assoc()) {
                    $users[] = $row;
                }
                $result['users'] = $users;

            break;

        case 'update-wishlist-item':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $visible = $_POST['visible'];
            $folder_id = $_POST['folder_id'];
            
            $sql = $conn->query("UPDATE wish SET name='$name', price='$price', description='$description', visible='$visible', folder_id='$folder_id'  WHERE id='$id'");
            
            if ($sql) {
                $result['message'] = "Данные изменены";
            } else {
                $result['error'] = true;
                $result['message'] = "Ошибка";
            }

            break;
        case 'delete-wishlist-item':
            $id = $_POST['id'];
            
            $sql = $conn->query("DELETE FROM wish WHERE id='$id'");


            $sql = $conn->query(
            "DELETE FROM users_wishlist WHERE wish_id='$id'");
            
            if ($sql) {
                $result['message'] = "Желание удалено";
            } else {
                $result['error'] = true;
                $result['message'] = "Ошибка!";
            }


            break;
        
        case 'update-bucketlist-item':
                $id = $_POST['id'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $description = $_POST['description'];
                $link = $_POST['link'];
                
                $sql = $conn->query("UPDATE bucket SET name='$name', price='$price', description='$description', link='$link' WHERE id='$id'");
                
                if ($sql) {
                    $result['message'] = "Place updated successfully!";
                } else {
                    $result['error'] = true;
                    $result['message'] = "Failed to update place!";
                }

                break;

        case 'delete-bucketlist-item':
                $id = $_POST['id'];
                
                $sql = $conn->query("DELETE FROM bucket WHERE id='$id'");
    
    
                $sql = $conn->query(
                "DELETE FROM users_bucketlist WHERE bucketlist_id='$id'");
                
                if ($sql) {
                    $result['message'] = "Place deleted successfully!";
                } else {
                    $result['error'] = true;
                    $result['message'] = "Failed to delete place!";
                }
    
    
                break;
    
        
        case 'update-wishlist-folder':
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                
                $sql = $conn->query("UPDATE wishlist_folders SET name='$name', description='$description' WHERE id='$id'");
                
                if ($sql) {
                    $result['message'] = "Updated successfully!";
                } else {
                    $result['error'] = true;
                    $result['message'] = "Failed to update!";
                }
    
                break;
        case 'delete-wishlist-folder':
                $id = $_GET['id'];
                
                $sql = $conn->query("DELETE FROM `wishlist_folders` WHERE id='$id'");

                $sql2 = $conn->query(
                    "DELETE FROM wish WHERE folder_id = $id");

                
                if ($sql & $sql2) {
                    $result['message'] = "Delete successfully!";
                } else {
                    $result['error'] = true;
                    $result['message'] = "Failed to delete!";
                }
    
            break;

        case 'update-bucketlist-folder':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            
            
            $sql = $conn->query("UPDATE bucketlist_folders SET name='$name', description='$description' WHERE id='$id'");
            
            if ($sql) {
                $result['message'] = "Updated successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to update!";
            }


            break;
        case 'delete-bucketlist-folder':
            $id = $_GET['id'];
            
            
            
            $sql = $conn->query("DELETE FROM `bucketlist_folders` WHERE id='$id'");
            $sql2 = $conn->query("DELETE FROM bucket WHERE folder_id = $id");
            
            if ($sql) {
                $result['message'] = "Delete successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to delete!";
            }

            break;
        case 'done-wishlist-item':
                $id = $_GET['id'];
                
                $sql = $conn->query("UPDATE wish SET done='1' WHERE id='$id'");
                
                if ($sql) {
                    $result['message'] = "Done!";
                } else {
                    $result['error'] = true;
                    $result['message'] = "Not done!";
                }

            break;
        case 'done-bucketlist-item':
                $id = $_GET['id'];
                
                $sql = $conn->query("UPDATE bucket SET done='1' WHERE id='$id'");
                
                if ($sql) {
                    $result['message'] = "Done!";
                } else {
                    $result['error'] = true;
                    $result['message'] = "Not done!";
                }

            break;
        // case 'get-user-wishlist-item':

        //         $id = $_GET['id'];
    
        //         $sql = $conn->query(
        //         "SELECT * FROM wish WHERE id = $id");
                
        //         $wishes = [];
        //         while($row = $sql->fetch_assoc()) {
        //             $wishes[] = $row;
        //         }
        //         $result['wishes'] = $wishes;
    
        //         break;
        case 'get-user-wishlist-item':
            // $id = $_GET['id'];
    
            // $sql = $conn->query(
            // "SELECT * FROM wish WHERE id = $id");
            
            // $wishes = [];
            // while($row = $sql->fetch_assoc()) {
            //     $wishes[] = $row;
            // }
            // $result['wishes'] = $wishes;

            // $sql2 = $conn->query(
            // "SELECT * 
            // FROM users_wishlist 
            // LEFT JOIN users ON users.id = users_wishlist.user_id
            // WHERE users_wishlist.wish_id = $id
            // ");

            

            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM wish
            WHERE wish.id = $id");

            
            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            $sql2 = $conn->query(
            "SELECT * FROM wishlist_folders
            LEFT JOIN wish ON wishlist_folders.id = wish.folder_id
            WHERE wish.id = $id");

            $folders = [];
            while($row = $sql2->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;


            $sql3 = $conn->query(
                "SELECT * 
                FROM users_wishlist 
                LEFT JOIN users ON users.id = users_wishlist.user_id
                WHERE users_wishlist.wish_id = $id
                ");

            $users = [];
            while($row = $sql3->fetch_assoc()) {
                $users[] = $row;
            }
            $result['users'] = $users;

            break;

        case 'add-userwish-to-my-wishlist':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $photo = $_POST['photo'];
            $folder_id = '1';
            $done = '0';
            
            var_dump($_POST);
            
            $sql = $conn->query(
                "INSERT INTO `wish`(`name`, `price`, `description`, `photo`, `folder_id`, `done`) VALUES ('$name', '$price', '$description', '$photo', '$folder_id', '$done')");
            
            $last_id = $conn->insert_id;

            $sql = $conn->query(
            "INSERT INTO users_wishlist (user_id, wish_id) VALUES(1,'$last_id')");
            
            if ($sql) {
                $result['message'] = "Place updated successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to update place!";
            }

            break;
        case 'get-user-bucketlist-item':
            $id = $_GET['id'];
    
                $sql = $conn->query(
                "SELECT * FROM bucket WHERE id = $id");
                
                $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;
    
                break;
        
        case 'add-userwish-to-my-bucketlist':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $photo = $_POST['photo'];
            $folder_id = '1';
            $done = '0';
            
            var_dump($_POST);
            
            $sql = $conn->query(
                "INSERT INTO `bucket`(`name`, `price`, `description`, `photo`, `folder_id`, `done`) VALUES ('$name', '$price', '$description', '$photo', '$folder_id', '$done')");
            
            $last_id = $conn->insert_id;

            $sql = $conn->query(
            "INSERT INTO users_bucketlist (user_id, bucketlist_id) VALUES(1,'$last_id')");
            
            if ($sql) {
                $result['message'] = "Place updated successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to update place!";
            }

            break;
        case 'get-i-will-present-wishes':

            $sql = $conn->query(
            "SELECT * FROM users
            LEFT JOIN i_will_present ON users.id = i_will_present.friend_id
            LEFT JOIN wish ON wish.id = i_will_present.wish_id
            WHERE i_will_present.user_id = 1");

            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;
            
            break; 
        case 'get-username':
            $sql = $conn->query(
                "SELECT nickname 
                FROM users 
    
                LEFT JOIN i_will_present
                ON id = friend_id
                WHERE user_id=1");
    
                $users = [];
                while($row = $sql->fetch_assoc()) {
                    $users[] = $row;
                }
                $result['users'] = $users;
    
            break;
       
        case 'all-wishes':
            $sql = $conn->query(
            "SELECT *
            FROM wish 

            LEFT JOIN users_wishlist
            ON id = wish_id
            WHERE users_wishlist.user_id = 1
            ");

            $sql2 = $conn->query(
            "SELECT *
            FROM bucket 

            LEFT JOIN users_bucketlist
            ON id = bucketlist_id
            WHERE users_bucketlist.user_id = 1");
    
            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            while($row = $sql2->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            break;
        case 'all-folders':
            $id = 1;

            $sql = $conn->query(
            "SELECT *
            FROM wishlist_folders
            LEFT JOIN users_wishlist_folders ON wishlist_folders.id = users_wishlist_folders.folder_id
            WHERE users_wishlist_folders.user_id = $id
            ORDER BY `wishlist_folders`.`date` DESC
            ");

            $sql2 = $conn->query(
            "SELECT *
            FROM bucketlist_folders
            LEFT JOIN users_bucketlist_folders
            ON id = folder_id
            WHERE users_bucketlist_folders.user_id = $id
            ORDER BY `bucketlist_folders`.`date` DESC
            ");

            $folders = [];
            while($row = $sql->fetch_assoc()) {
                $folders[] = $row;
            }
            while($row = $sql2->fetch_assoc()) {
                $folders[] = $row;
            }
            $result['folders'] = $folders;

            break;
        case 'get-all-wish-item':
            $id = $_GET['id'];

            $sql = $conn->query(
            "SELECT * FROM wish WHERE id = $id");
            

            $sql2 = $conn->query(
            "SELECT * FROM bucket WHERE id = $id");
            
            $wishes = [];
            while($row = $sql2->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            break;
        case 'get-all-wishlist':
            
            $sql = $conn->query(
                "SELECT * FROM wish 
    
                LEFT JOIN users_wishlist ON wish.id = users_wishlist.wish_id
                -- LEFT JOIN wishlist_folders ON wish.folder_id = wishlist_folders.id
                WHERE users_wishlist.user_id = 1
                -- AND wish.wish_list = 1
                ORDER BY wish.date DESC
                ");
    
                
        
                $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;

            // $sql = $conn->query("SELECT `name` FROM wishlist_folders "); 
    
            break;
        case 'get-all-bucketlist':
           
                $sql2 = $conn->query(
                "SELECT *
                FROM bucket 
    
                LEFT JOIN users_bucketlist
                ON id = bucketlist_id
                WHERE users_bucketlist.user_id = 1");
        
                $wishes = [];
              
                while($row = $sql2->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;
            break;
        case 'add-to-my-wishlist':
           
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $link = $_POST['link'];
            $folder_id = $_POST['folder_id'];
            
            $sql = $conn->query("INSERT INTO `wish`(`name`, `price`, `description`, `photo`, `link`, `visible`, `folder_id`, `done`) VALUES ('$name', '$price', '$description', 'landscape.png', '$link', 'только я', '$folder_id', '0')");
   
            $last_id = $conn->insert_id;
   
            $sql = $conn->query("INSERT INTO users_wishlist (user_id, wish_id) VALUES('1','$last_id')");

            if ($sql) {
                $result['message'] = "successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed!";
            }
            break;
        case 'add-to-i-will-present':
            $wish_id = $_POST['wish_id'];
            $user_id = $_POST['user_id'];

            $sql = $conn->query("INSERT INTO `i_will_present`(`user_id`, `friend_id`, `wish_id`) VALUES (1, $user_id, $wish_id)");

            if ($sql) {
                $result['message'] = "successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed!";
            }

            break;
        case 'get-i-will-present-wishlist-item':
            $id = $_GET['id'];

            $sql = $conn->query("SELECT * FROM wish WHERE id = $id");

            
            $wishes = [];
            while($row = $sql->fetch_assoc()) {
                $wishes[] = $row;
            }
            $result['wishes'] = $wishes;

            break;
        case 'get-i-will-get-wishes':
            $sql = $conn->query(
                "SELECT * FROM users
                LEFT JOIN i_will_present ON users.id = i_will_present.user_id
                LEFT JOIN wish ON wish.id = i_will_present.wish_id
                WHERE i_will_present.friend_id = 1");
    
                $wishes = [];
                while($row = $sql->fetch_assoc()) {
                    $wishes[] = $row;
                }
                $result['wishes'] = $wishes;

            break;
        case 'pagination-users':
            $sql = $conn->query(
            "SELECT * 
            FROM users
            LIMIT 10 
            OFFSET 10 
            ");


            break;
            
            default:
            # code...
            break;
    }

    
  

    $conn->close();

    echo json_encode($result);


    // if($action == 'read'){
    //     $sql = $conn->query("SELECT * FROM users");
    //     $users = [];
    //     while($row = $sql->fetch_assoc()) {
    //         // array_push($users, $row);
    //         $users[] = $row;
    //     }
    //     $result['users'] = $users;
    // }

    // if($action == 'create'){
    //     $name = $_POST['name'];
    //     $email = $_POST['email'];
    //     $phone = $_POST['phone'];

    //     try {
    //         $sql = $conn->query("INSERT INTO users (name,email,phone) VALUES('$name','$email','$phone')");
    //     } catch (Exception $e){
    //     }

    //     if(isset($sql) && $sql){
    //         $result['message'] = "User added successfully!";
    //     } else {
    //         $result['error'] = true;
    //         $result['message'] = "Failed to add user!";
    //     }
    // }

    // if($action == 'update'){
    //     $id = $_POST['id'];
    //     $name = $_POST['name'];
    //     $email = $_POST['email'];
    //     $phone = $_POST['phone'];

    //     $sql = $conn->query("UPDATE users SET name='$name',email='$email',phone='$phone' WHERE id='$id'");
        
    //     if($sql){
    //         $result['message'] = "User updated successfully!";
    //     }else {
    //         $result['error'] = true;
    //         $result['message'] = "Failed to update user!";
    //     }
    // }

    // if($action == 'delete'){
    //     $id = $_POST['id'];
        
    //     $sql = $conn->query("DELETE FROM users WHERE id='$id'");
        
    //     if($sql){
    //         $result['message'] = "User deleted successfully!";
    //     }else {
    //         $result['error'] = true;
    //         $result['message'] = "Failed to delete user!";
    //     }
    // }

    // $conn->close();

    // echo json_encode($result);

    // TODO
    // Валидация импутов
    // Свич вместо бьесконенчного иф
    // Использование PDO со встроенной фильтрацией входных данных/ относиться к 1 пункту
?>

