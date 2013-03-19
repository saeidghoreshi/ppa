<?
function fighterLink($in) {
  if (!empty($in['url'])) return $in['url'];
  elseif(!empty($in['fight']['url'])) return (!empty($in['fight']['url']))? $in['fight']['url']:'fighter_info.php?id='.$in['fight']['fighter_id'];
  elseif(!empty($in['fighter_id'])) return 'fighter_info.php?id='.$in['fighter_id'];
}

function managerLink($in) {
  if (!empty($in['url'])) return $in['url'];
  elseif(!empty($in['manager_id'])) return 'manager_search.php?id='.$in['manager_id'];
}

function trainerLink($in) {
  if (!empty($in['url'])) return $in['url'];
  elseif(!empty($in['trainer_id'])) return 'trainer_search.php?id='.$in['trainer_id'];
}
  
function newsLink($in) {
  if (!empty($in['url'])) return $in['url'];
  elseif(!empty($in['search'])) return 'boxing-news.php?search='.urlencode($in['search']);
}

function videoLink($in) {
  if (!empty($in['name'])) return preg_replace('/[\s\-\.]+/','-',strtolower($in['name'])).'-video.html';
  elseif (!empty($in['url'])) return $in['url'];
  elseif(!empty($in['search'])) return 'boxing-video.php?search='.urlencode($in['search']);
}

function fighter2NewsLink($in) {
  if (!empty($in['name'])) return preg_replace('/[\s\-\.]+/','-',strtolower($in['name'])).'-news.html';
  elseif (!empty($in['url'])) return preg_replace('/\.html/','-news.html',$in['url']);
  elseif(!empty($in['search'])) return 'boxing-news.php?search='.urlencode($in['search']);
  else return '#';
}

function fighter2ImageLink($in) {
  if (!empty($in['url'])) return preg_replace('/\.html/','-pictures.html',$in['url']);
  elseif (!empty($in['name'])) return preg_replace('/[\s\-\.]+/','-',strtolower($in['name'])).'-pictures.html';
  elseif(!empty($in['search'])) return 'boxing-image.php?search='.urlencode($in['search']);
  else return '#';
}

function fighter2VideoLink($in) {
  if (!empty($in['url'])) return preg_replace('/\.html/','-video.html',$in['url']);
  elseif (!empty($in['name'])) return preg_replace('/[\s\-\.]+/','-',strtolower($in['name'])).'-video.html';
  elseif(!empty($in['search'])) return 'boxing-video.php?search='.urlencode($in['search']);
  else return '#';
}

  
?>