<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 07 Aug, 2021 02:28PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | User actions handler
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
    $post->$key = $app->clean($value);
}
$action = $app->clean($_GET['action']);

if (empty($errors)) {
    $post->files = $_FILES;

    if($action == "details") {
        $luser = $app->user($app->clean($app->decrypt($post->user_id)));

        $userActivities = $app->userActivity($luser->id);
        if(empty($userActivities)) {
            $html = "<h5 class='text-center'>No activity</h5>";
        } else {
            $html = '<div id="accordion" class="custom-accordion">';
            $actLoop = array();
            foreach ($userActivities as $activity) {
                $actLoop[date("M d, Y", $activity->date)][] = $activity;
            }
            unset($activity);

            $count = 0;
            foreach ($actLoop as $period => $activities) {
                if ($period == date("M d, Y")) {
                    $periodText = "Today";
                } elseif ($period == date("M d, Y", strtotime("-1 days"))) {
                    $periodText = "Yesterday";
                } else {
                    $periodText = $period;
                }
                $sub = "<ul>";
                foreach ($activities as $activity) {
                    $time = date("h:ia", $activity->date);
                    $sub .= <<< HTML
                    <li>$time -> $activity->activity</li>
                    HTML;
                }
                $sub .= "</ul>";

                $count++;
                $html .= <<< HTML
                <div class="card mb-1 shadow-none">
                    <a href="#collapse$count" class="text-dark" data-toggle="collapse"
                                    aria-expanded="true"
                                    aria-controls="collapseOne">
                        <div class="card-header" id="heading$count">
                            <h6 class="m-0">
                                $periodText
                                <i class="mdi mdi-minus float-right accor-plus-icon"></i>
                            </h6>
                        </div>
                    </a>
                    <div id="collapse$count" class="collapse show"
                            aria-labelledby="heading$count" data-parent="#accordion">
                        <div class="card-body">
                            $sub
                        </div>
                    </div>
                </div>
                HTML;

                $html .= "</div>";
            }
        }
        
        $response['error'] = false;
        $response['msg'] = "Successful";
        $response['title'] = "Activities for $luser->name";
        $response['html'] = $html;
    }
    elseif ($action == "add") {
        $request = $app->addUser($post);
    } else {
        $request = $app->user_actions($post, $action);
    }
    if (!empty($request)) {
        if ($request['status'] == true) {
            $response['error'] = false;
            $response['msg'] = $request['msg'];
        } else {
            $response['msg'] = $request['msg'];
        }
    }
}