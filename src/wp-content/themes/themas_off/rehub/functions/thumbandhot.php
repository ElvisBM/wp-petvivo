<?php

//////////////////////////////////////////////////////////////////////////////
// Hot meter and thumbs function. It works like + and - and have overall score
//////////////////////////////////////////////////////////////////////////////

$rehub_max_temp = (rehub_option('hot_max')) ? rehub_option('hot_max') : 10;
$rehub_min_temp = (rehub_option('hot_min')) ? rehub_option('hot_min') : -10;
define('REHUB_MAX_TEMP', $rehub_max_temp); //define maximum temperature meter
define('REHUB_MIN_TEMP', $rehub_min_temp); //define minimum temperature meter under minus


add_action( 'wp_ajax_nopriv_hot-count', 'hot_count' );
add_action( 'wp_ajax_hot-count', 'hot_count' );

if (!function_exists('hot_count')){
function hot_count() {
    $nonce = $_POST['hotnonce'];
    if ( ! wp_verify_nonce( $nonce, 'hotnonce' ) )
        die ( 'Nope!' );
    
    if ( isset( $_POST['hot_count'] ) ) {   
        $post_id = $_POST['post_id']; // post id
        $posthot = get_post($post_id);
        $postauthor = $posthot->post_author; 
        $post_hot_count = get_post_meta( $post_id, "post_hot_count", true ); // post like count  
        $overall_post_likes = get_user_meta( $postauthor, "overall_post_likes", true ); // get overall post likes of user   
        if ( is_user_logged_in() ) { // user is logged in
            global $current_user;
            $user_id = $current_user->ID; // current user
            $meta_POSTS = get_user_meta( $user_id, "_liked_posts" ); // post ids from user meta
            $meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
            $liked_POSTS = ""; // setup array variable
            $liked_USERS = ""; // setup array variable          
            if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
                $liked_POSTS = $meta_POSTS[0];
            }           
            if ( !is_array( $liked_POSTS ) ) // make array just in case
                $liked_POSTS = array();             
            if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
                $liked_USERS = $meta_USERS[0];
            }       
            if ( !is_array( $liked_USERS ) ) // make array just in case
                $liked_USERS = array();             
            $liked_POSTS['post-'.$post_id] = $post_id; // Add post id to user meta array
            $liked_USERS['user-'.$user_id] = $user_id; // add user id to post meta array
            $user_likes = count( $liked_POSTS ); // count user likes

            if ($_POST['hot_count'] =='hot') {              
                if ( !AlreadyHot( $post_id ) ) {
                    update_post_meta( $post_id, "post_hot_count", ++$post_hot_count ); // +1 count post meta
                    update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Add user ID to post meta
                    update_user_meta( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
                    update_user_meta( $user_id, "_user_like_count", $user_likes ); // +1 count user meta    
                    update_user_meta( $postauthor, "overall_post_likes", ++$overall_post_likes ); // +1 count to post author overall likes             
                } 
                else {
                   // update_post_meta( $post_id, "post_hot_count", $post_hot_count+2 );
                }       
            }
            if ($_POST['hot_count'] =='cold') {
                if ( !AlreadyHot( $post_id ) ) {
                    update_post_meta( $post_id, "post_hot_count", --$post_hot_count ); // -1 count post meta
                    update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Add user ID to post meta
                    update_user_meta( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
                    update_user_meta( $user_id, "_user_like_count", $user_likes ); // +1 count user meta   
                    update_user_meta( $postauthor, "overall_post_likes", --$overall_post_likes ); // -1 count to post author overall likes                 
                } 
                else {
                    if(!empty($_POST['heart'])){
                        update_post_meta( $post_id, "post_hot_count", $post_hot_count-1 );
                        update_user_meta( $postauthor, "overall_post_likes", --$overall_post_likes );
                        update_user_meta( $user_id, "_user_like_count", $user_likes-1 );
                        
                        $userkeyip = 'user-'.$user_id;
                        unset($liked_USERS[$userkeyip]);
                        update_post_meta( $post_id, "_user_liked", $liked_USERS );

                        $postkeyip = 'post-'.$post_id;
                        unset($liked_POSTS[$postkeyip]);
                        update_post_meta( $user_id, "_liked_posts", $liked_POSTS );                        
                    }
                }                                       
            }           
            
        } else { // user is not logged in (anonymous)
            $ip = rehub_get_ip(); // user IP address
            $postidarray = array();
            $guest_likes_transient = get_transient('re_guest_likes_' . $ip);
            $meta_IPS = get_post_meta( $post_id, "_user_IP" ); // stored IP addresses
            $liked_IPS = ""; // set up array variable           
            if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
                $liked_IPS = $meta_IPS[0];
            }   
            if ( !is_array( $liked_IPS ) ) // make array just in case
                $liked_IPS = array();               
            if ( !in_array( $ip, $liked_IPS ) ) // if IP not in array
                $liked_IPS['ip-'.$ip] = $ip; // add IP to array 

            if ($_POST['hot_count'] =='hot') {              
                if ( !AlreadyHot( $post_id ) ) {
                    update_post_meta( $post_id, "post_hot_count", ++$post_hot_count ); // +1 count post meta
                    update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Add user IP to post meta  
                    update_user_meta( $postauthor, "overall_post_likes", ++$overall_post_likes ); // +1 count to post author overall likes   
                    if(empty($guest_likes_transient)) {
                        $postidarray[] = $post_id;
                        set_transient('re_guest_likes_' . $ip, $postidarray, 30 * DAY_IN_SECONDS);
                    } else {
                        if(is_array($guest_likes_transient)){
                            $guest_likes_transient[] = $post_id;
                            set_transient('re_guest_likes_' . $ip, $guest_likes_transient, 30 * DAY_IN_SECONDS);
                        }                   
                    }                                  
                } 
                else {
                    //update_post_meta( $post_id, "post_hot_count", $post_hot_count+2 );
                }       
            }
            if ($_POST['hot_count'] =='cold') {
                if ( !AlreadyHot( $post_id ) ) {
                    update_post_meta( $post_id, "post_hot_count", --$post_hot_count ); // -1 count post meta
                    update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Add user IP to post meta   
                    update_user_meta( $postauthor, "overall_post_likes", --$overall_post_likes ); // -1 count to post author overall likes                    
                } 
                else {
                    if(!empty($_POST['heart'])){
                        update_post_meta( $post_id, "post_hot_count", $post_hot_count-1 );
                        update_user_meta( $postauthor, "overall_post_likes", --$overall_post_likes );   

                        $keyip = 'ip-'.$ip;
                        unset($meta_IPS[$keyip]);
                        update_post_meta( $post_id, "_user_IP", $meta_IPS );

                        unset($guest_likes_transient[$post_id]);
                        set_transient('re_guest_likes_' . $ip, $guest_likes_transient, 30 * DAY_IN_SECONDS);

                    }
                }                                       
            }
        }
        do_action('rh_overall_post_likes_add');
    }
    exit;
}
}

if (!function_exists('AlreadyHot')){
function AlreadyHot( $post_id ) { // test if user liked before
    
    if ( is_user_logged_in() ) { // user is logged in
        global $current_user;
        $user_id = $current_user->ID; // current user
        $meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
        $liked_USERS = ""; // set up array variable     
        if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
            $liked_USERS = $meta_USERS[0];
        }       
        if( !is_array( $liked_USERS ) ) // make array just in case
            $liked_USERS = array();         
        if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
            return true;
        }
        return false;       
    } 
    else { // user is anonymous, use IP address for voting  
        $meta_IPS = get_post_meta($post_id, "_user_IP"); // get previously voted IP address
        $ip = rehub_get_ip(); // Retrieve current user IP
        $liked_IPS = ""; // set up array variable
        if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
            $liked_IPS = $meta_IPS[0];
        }
        if ( !is_array( $liked_IPS ) ) // make array just in case
            $liked_IPS = array();
        if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
            return true;
        }
        return false;
    }   
}
}

if (!function_exists('getHotLike')){
function getHotLike( $post_id ) {
    if (rehub_option('exclude_hotmeter') =='1') {
        return false;
    }   
    $max_temp= REHUB_MAX_TEMP; //max temperature
    $min_temp= REHUB_MIN_TEMP; //min temperature    
    $like_count = get_post_meta( $post_id, "post_hot_count", true ); // get post likes
    if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
        $temp = '0';
    } elseif ( $like_count && $like_count != "0" ) { // there are votes!
        $temp = esc_attr( $like_count );
    }
    if ($temp >= $max_temp){
        $icontemp = '<i class="fa fa-fire"></i> ';
    }
    elseif ($temp <= $min_temp) {
        $icontemp = '<i class="fa fa-frown-o"></i> ';
    }
    else {
        $icontemp = '';
    }
    $output = '<div class="hotmeter_wrap"><div class="hotmeter"><span class="table_cell_hot first_cell"><span id="temperatur'.$post_id.'" class="temperatur';
    if ($temp < 0) :
        $output .= ' cold_temp';
    endif;
    $output .= '">'.$icontemp.$temp.'<span class="gradus_icon"></span></span></span> ';
    $output .= '<span class="table_cell_hot cell_minus_hot">';
    if ( AlreadyHot( $post_id ) ) { // already liked, set up unlike addon
        $output .= '<button class="hotminus alreadyhot" alt="'.__('Vote down', 'rehub_framework').'" title="'.__('Vote down', 'rehub_framework').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
    } else { // normal like button
        $output .= '<button class="hotminus" alt="'.__('Vote down', 'rehub_framework').'" title="'.__('Vote down', 'rehub_framework').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
    }
    $output .= '</span><span class="table_cell_hot cell_plus_hot">';
    if ( AlreadyHot( $post_id ) ) { // already liked, set up unlike addon
        $output .= '<button class="hotplus alreadyhot" alt="'.__('Vote up', 'rehub_framework').'" title="'.__('Vote up', 'rehub_framework').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
    } else { // normal like button
        $output .= '<button class="hotplus" alt="'.__('Vote up', 'rehub_framework').'" title="'.__('Vote up', 'rehub_framework').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
    }
    $output .= '</span>';
    $output .= '<span id="textinfo'.$post_id.'" class="textinfo table_cell_hot"></span>';

    $output .= '<div class="table_cell_hot fullwidth_cell">';
    if ($temp >= $max_temp) :
        $temp = $max_temp;
    elseif ($temp <= $min_temp) :
        $temp = $min_temp;
    endif;
    $output .= '<div id="fonscale'.$post_id.'" class="fonscale">';      
    $output .= '<div id="scaleperc'.$post_id.'" class="scaleperc';
    if ($temp < 0) :
        $output .= ' cold_bar';
    endif;
    $output .= '" style="width:';
    if ($temp >= 0) :
        $output .= ''.($temp / $max_temp * 100).'%">';
    else:
        $output .= ''.($temp / $min_temp * 100).'%">';
    endif;
    $output .= '</div></div></div></div></div>';    

    return $output;
}
}

if (!function_exists('getHotIconfire')){
function getHotIconfire( $post_id ) {
    $max_temp= REHUB_MAX_TEMP; //max temperature  
    $like_count = get_post_meta( $post_id, "post_hot_count", true ); // get post likes
    if (!empty($like_count) && $like_count > $max_temp){
        return '<i class="fa fa-fire"></i> ';
    }    
}
}

if (!function_exists('getHotIconclass')){
function getHotIconclass( $post_id ) {
    $max_temp= REHUB_MAX_TEMP; //max temperature  
    $like_count = get_post_meta( $post_id, "post_hot_count", true ); // get post likes
    if (!empty($like_count) && $like_count > $max_temp){
        return 'hoticonfireclass';
    }    
}
}

if (!function_exists('getHotLikeTitle')){
function getHotLikeTitle( $post_id ) {
    $like_count = get_post_meta( $post_id, "post_hot_count", true ); // get post likes
    if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
        $temp = '0';
    } elseif ( $like_count && $like_count != "0" ) { // there are votes!
        $temp = esc_attr( $like_count );
    }
    $output = '<span id="temperatur'.$post_id.'" class="temperatur';
    if ($temp < 0) :
        $output .= ' cold_temp';
    endif;
    $output .= '">'.$temp.'<span class="gradus_icon"></span></span> ';
    return $output;
}
}

if (!function_exists('getHotThumb')){
function getHotThumb( $post_id, $comment_meta = false, $deal_score = false, $onlyone = false, $wishlistadd = '',$wishlistadded = '' ) {    
    $like_count = get_post_meta( $post_id, "post_hot_count", true ); // get post likes
    if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
        $temp = '0';
    } elseif ( $like_count && $like_count != "0" ) { // there are votes!
        $temp = esc_attr( $like_count );
    }
    $deal_score_wrap = ($deal_score == true) ? ' dealScoreWrap': '';
    $onlyonewrap = ($onlyone == true) ? ' heart_thumb_wrap' : '';
    $onlyheartclass = ($onlyone == true) ? ' heartplus' : '';
    $output = '<div class="post_thumbs_wrap'.$deal_score_wrap.$onlyonewrap.'">';
    if ($comment_meta == true){
        $output .='<span class="post_thumbs_comm"><span>'.get_comments_number().'</span></span>';
    }
    $output .= '<div class="post_thumbs_meter">';
    if ($deal_score == true) {
        $output .= '<div class="dealScore">';
        $output .='<span class="label">'.__('Deal Score', 'rehub_framework').'</span>';
        $output .='<span id="thumbscount'.$post_id.'" class="thumbscount';
        if ($temp < 0) :
            $output .= ' cold_temp';
        endif;          
        $output .= '">';
        if ($temp > 0) {
            $output .= '+';
        }        
        $output .= $temp.'</span></div>';
        
    }    
    $output .= '<span class="table_cell_thumbs">';
        if ($onlyone == false) {
            if ( AlreadyHot( $post_id ) ) { // already liked, set up unlike addon
                $output .= '<button class="thumbminus alreadyhot" alt="'.__('Vote down', 'rehub_framework').'" title="'.__('Vote down', 'rehub_framework').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
            } else { // normal like button
                $output .= '<button class="thumbminus" alt="'.__('Vote down', 'rehub_framework').'" title="'.__('Vote down', 'rehub_framework').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
            }
        }    
        if ( AlreadyHot( $post_id ) ) { // already liked, set up unlike addon
            $output .= '<button class="thumbplus alreadyhot'.$onlyheartclass.'" alt="'.__('Vote up', 'rehub_framework').'" title="'.__('Vote up', 'rehub_framework').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
        } else { // normal like button
            $output .= '<button class="thumbplus'.$onlyheartclass.'" alt="'.__('Vote up', 'rehub_framework').'" title="'.__('Vote up', 'rehub_framework').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
        }   
    $output .= '</span>';
    if ($deal_score == false) {
        $output .= '<span id="thumbscount'.$post_id.'" class="thumbscount';
        if ($temp < 0) :
            $output .= ' cold_temp';
        endif;  
        $output .= '">'.$temp.'</span> ';        
    }
    if ($wishlistadd) {
        $output .= '<span class="wishlistadd'.$post_id.'">'; 
        $output .= '">'.$wishlistadd.'</span> ';        
    }  
    if ($wishlistadded) {
        $output .= '<span class="wishlistadded'.$post_id.'">'; 
        $output .= '">'.$wishlistadded.'</span> ';        
    }      
    $output .= '</div></div>';    

    return $output;
}
}
add_shortcode('getHotThumb', 'getHotThumb');

if (!function_exists('getHotSingleButton')){
function getHotSingleButton( $post_id ) {    
    $like_count = get_post_meta( $post_id, "post_hot_count", true ); // get post likes
    if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
        $temp = '0';
    } elseif ( $like_count && $like_count != "0" ) { // there are votes!
        $temp = esc_attr( $like_count );
    }
    $output = '';
    $output .= '<span class="post_thumbs_meter">';    
    $output .= '<span class="table_cell_thumbs">';
    $alreadyhotclass = ( AlreadyHot( $post_id ) ) ? ' alreadyhot' : '';
    $output .= '<button class="thumbplus heartplus'.$alreadyhotclass.'" alt="'.__('Vote up', 'rehub_framework').'" title="'.__('Vote up', 'rehub_framework').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';   
    $output .= '</span>';
        $output .= '<span id="thumbscount'.$post_id.'" class="thumbscount';
        if ($temp < 0) :
            $output .= ' cold_temp';
        endif;  
        $output .= '">'.$temp.'</span> ';        
    $output .= '</span>';    

    return $output;
}
}

if (!function_exists('RhGetUserFavorites')){
function RhGetUserFavorites() {
    if ( is_user_logged_in() ) { // user is logged in
        global $current_user;
        $user_id = $current_user->ID; // current user
        $likedposts = get_user_meta( $user_id, "_liked_posts", true);
    }
    else{
        $ip = rehub_get_ip(); // user IP address
        $likedposts = get_transient('re_guest_likes_' . $ip);
    }
    if (!empty($likedposts)){
        $i = 1;
        echo '<ul class="re-favorites-posts">';
        foreach ( $likedposts as $key=>$pid ) :
            $title = get_the_title($pid);
            if (empty($title)){               
                continue;
            }
            echo '<li>';
            echo '<span class="fav_count_number">'.$i.'</span>';
                echo '<a href="'.get_the_permalink($pid).'" target="_blank">';
                    echo get_the_post_thumbnail($pid, array( 50, 50));
                    echo get_the_title($pid);
                echo '</a>';
            echo '</li>';
            $i++;                
        endforeach; 
        echo '</ul>';        
    }
}
add_shortcode('rh_get_user_favorites', 'RhGetUserFavorites');
}


//////USER LIKES - USE IT FOR WC VENDORS//////
add_action( 'wp_ajax_nopriv_rh-user-favor-shop', 'rh_user_favorite_shop');
add_action( 'wp_ajax_rh-user-favor-shop', 'rh_user_favorite_shop' );
if (!function_exists('rh_user_favorite_shop')){
function rh_user_favorite_shop() {
    $nonce = $_POST['favornonce'];
    if ( ! wp_verify_nonce( $nonce, 'hotnonce' ) )
        die ( 'Nope!' );
    
    if ( isset( $_POST['rh_user_favorite_shop'] ) ) {
    
        $user_id = $_POST['user_id']; // post id
        $rh_user_favorite_shop_count = get_user_meta( $user_id, "_rh_user_favorite_shop_count", true ); // post like count      
        if ( is_user_logged_in() ) { // user is logged in
            global $current_user;
            $currentuserID = $current_user->ID; // current user
            $ilike_users = get_user_meta( $currentuserID, "_i_liked_users" ); // user ids which were liked by user
            $who_like_me = get_user_meta( $user_id, "_users_who_like_me" ); // user ids which make like for user
            $ilike_USERS = ""; // setup array variable
            $users_like_ME = ""; // setup array variable
            
            if ( count( $ilike_users ) != 0 ) { // meta exists, set up values
                $ilike_USERS = $ilike_users[0];
            }
            
            if ( !is_array( $ilike_USERS ) ) // make array just in case
                $ilike_USERS = array();
                
            if ( count( $who_like_me ) != 0 ) { // meta exists, set up values
                $users_like_ME = $who_like_me[0];
            }       

            if ( !is_array( $users_like_ME ) ) // make array just in case
                $users_like_ME = array();
                
            $ilike_USERS['user-'.$user_id] = $user_id; // Add user id to user meta array of your likes
            $users_like_ME['user-'.$currentuserID] = $currentuserID; // add user id to user meta array of who liked user
    
            if ( !AlreadylikedShop($user_id) ) { // like the post
                update_user_meta( $user_id, "_users_who_like_me", $users_like_ME ); // Add current user ID array who likes
                update_user_meta( $user_id, "_rh_user_favorite_shop_count", ++$rh_user_favorite_shop_count ); // +1 count of likes
                update_user_meta( $currentuserID, "_i_liked_users", $ilike_USERS ); // Add user ID to user meta
                echo $rh_user_favorite_shop_count; // update count on front end
                
            } else { // unlike the post
                $pid_key = array_search( $user_id, $ilike_USERS ); // find the key
                $uid_key = array_search( $currentuserID, $users_like_ME ); // find the key
                unset( $ilike_USERS[$pid_key] ); // remove from array
                unset( $users_like_ME[$uid_key] ); // remove from array
                update_user_meta( $user_id, "_users_who_like_me", $users_like_ME ); // Add current user ID array who likes
                update_user_meta( $user_id, "_rh_user_favorite_shop_count", --$rh_user_favorite_shop_count ); // -1 count of likes
                update_user_meta( $currentuserID, "_i_liked_users", $ilike_USERS ); // Add post ID to user meta
                echo "already".$rh_user_favorite_shop_count; // update count on front end
                
            }           
        } 
    }   
    exit;
}
}

if (!function_exists('AlreadylikedShop')){
function AlreadylikedShop( $user_id ) { // test if user liked before
    
    if ( is_user_logged_in() ) { // user is logged in
        global $current_user;
        $currentuserID = $current_user->ID; // current user
        $who_like_me = get_user_meta($currentuserID, "_i_liked_users" ); // user ids from post meta
        $users_like_ME = ""; // set up array variable
        
        if ( count( $who_like_me ) != 0 ) { // meta exists, set up values
            $users_like_ME = $who_like_me[0];
        }
        
        if( !is_array( $users_like_ME ) ) // make array just in case
            $users_like_ME = array();
            
        if ( in_array( $user_id, $users_like_ME ) ) { // True if User ID in array
            return true;
        }
        return false;   
    }    
}
}

if (!function_exists('getShopLikeButton')){
function getShopLikeButton( $user_id ) {
    $like_count = get_user_meta( $user_id, "_rh_user_favorite_shop_count", true ); // get post likes
    if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
        $likes = '0';
    } elseif ( $like_count && $like_count != "0" ) { // there are votes!
        $likes = esc_attr( $like_count );
    }
    $alreadyclass = ( AlreadylikedShop( $user_id ) ) ? ' alreadyinfavor' : '';
    $output = '<span class="rh-user-favor-shop'.$alreadyclass.'"  data-user_id="'.$user_id.'">';
    if ( AlreadylikedShop( $user_id ) ) { // already liked, set up unlike addon
        $output .= '<span class="favorshop_like"><i class="fa fa-heart"></i></span>';
        $output .= ' <span class="count">'.$likes.'</span></span>';
    } else { // normal like button
        $output .= '<span class="favorshop_like"><i class="fa fa-heart-o"></i></span>';
        $output .= ' <span class="count">'.$likes.'</span></span>';
    }
    if (rehub_option('exclude_rh_user_favorite_shop') !='1') {
        return $output;
    }
    else {
        return false;
    }
}
}

if (!function_exists('RhGetUserFavoriteShops')){
function RhGetUserFavoriteShops() {
    if ( is_user_logged_in() ) { // user is logged in
        global $current_user;
        $user_id = $current_user->ID; // current user
        $likedposts = get_user_meta( $user_id, "_i_liked_users", true);
    }
    if (!empty($likedposts)){
        $likedposts = implode(',', $likedposts);
        return do_shortcode('[wpsm_vendorlist user_id='.$likedposts.']');       
    }
}
add_shortcode('rh_get_favorite_shops', 'RhGetUserFavoriteShops');
}