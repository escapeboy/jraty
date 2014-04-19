<?php namespace Escapeboy\Jraty;

class Jraty {

  public function get($item_id)
  {
    $rating = new \stdClass();
  	$this->item_id = $item_id;
  	$rating->avg = $this->get_avg();
  	$rating->votes = $this->get_votes_total();

  	if(!$rating->avg) $rating->avg = 0;

  	return $rating;
  }

  public function html($item_id, $item_name='', $item_photo='', $seo=true)
  {
    $rating = $this->get($item_id);
    if ($seo) {
         $html.= '<div id="item-rating" data-item="'.$item_id.'" data-score="'.$rating->avg.'"></div>';
         $html.= '<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">';
       if($item_name){
         $html.= '<meta itemprop="itemreviewed" content = "'.$item_name.'"> ';
       }
       if($item_photo){
         $html.= '<meta itemprop="photo" content = "'.$item_photo.'"> ';
       }
       $html.='<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';
              $html.='<meta itemprop="average" content = "'.$rating->avg.'">';
              $html.='<meta itemprop="best" content = "5">';
              $html.='<meta itemprop="votes" content = "'.$rating->votes.'">';
       $html.='</span>';
       $html.='</div>';
    }else{
       $html = '<div id="item-rating" data-item="'.$item_id.'" data-score="'.$rating->avg.'"></div>';
    }
 
    return $html;
  }

  public function add($data)
  {
  	if($data['item_id']){
  		$existing = \DB::table('item_ratings')->where('item_id', $data['item_id'])->where('ip_address', \Request::getClientIp())->first();
  		if(!$existing){
  			\DB::table('item_ratings')->insert($data);
  		}else{
  			\DB::table('item_ratings')->where('item_id', $data['item_id'])->where('ip_address', \Request::getClientIp())->update($data);
  		}
  	}
  }

  public function js()
  {
  	return '<script src="'.\URL::asset('packages/escapeboy/jraty/raty/lib/jquery.raty.min.js').'" type="text/javascript" charset="utf-8"></script>';
  }

  public function js_init($params=array())
  {
    if(!$params['score']){
      $params['score'] = 'function() { return $(this).attr(\'data-score\'); }';
    }
    if(!$params['number']){
      $params['number'] = '5';
    }
    if(!$params['click']){
      $params['click'] = 'function(score, evt) {
                $.post(\'save/item_rating\',{
                    item_id: $(\'[data-item]\').attr(\'data-item\'),
                    score: score
                });
              }';
    }
    if(!$params['path']){
      $params['path'] = '\'packages/escapeboy/jraty/raty/lib/img\'';
    }
    foreach ($params as $key => $value) {
      $options.='\''.$key.'\':'.$value.',';
    }
    $options = substr($options, 0, -1); //removing last comma
  	$code='<script type="text/javascript">
      $( document ).ready(function() {
  				$(\'#item-rating\').raty({'.$options.'});
        });
  			</script>';
     return $code;
  }

  public function delete($id)
  {
  	\DB::table('item_ratings')->where('id', $id)->delete();
  }

  private function get_avg()
  {
  	$avg = \DB::table('item_ratings')->where('item_id', $this->item_id)->avg('score');

  	return round($avg, 2);
  }

  private function get_votes_total()
  {
  	return \DB::table('item_ratings')->where('item_id', $this->item_id)->count();
  }
 
}