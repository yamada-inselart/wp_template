<?php

function breadcrumb(){ // パンくずリスト
	global $post;
	$str ='';
	if(is_home()) {
		$isHome = 'isHome';
	} else {
		$isHome = '';
	}
	if(!is_admin()){ /* !is_admin は管理ページ以外という条件分岐 */
		$str.= '<div id="breadcrumb" class="' . $isHome . ' inner clearfix">';
		$str.= '<ul>';
		$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/" class="home" itemprop="url" ><span itemprop="title">ホーム</span></a></li><li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. home_url('/').'"  itemprop="url" ><span itemprop="title">front</span></a></li>';

		/* 投稿のページ */
		if(is_single()){
			$categories = get_the_category($post->ID);
			$cat = $categories[0];
			if($cat -> parent != 0){
				$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
				foreach($ancestors as $ancestor){
					$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($ancestor).'"  itemprop="url" ><span itemprop="title">'. get_cat_name($ancestor). '</span></a></li>';
									}
			}
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat -> term_id). '" itemprop="url" ><span itemprop="title">'. $cat-> cat_name . '</span></a></li>';
			$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $post -> post_title .'</span></li>';
		}
		/* 固定ページ */
		elseif(is_page()){
			if($post -> post_parent != 0 ){
				$ancestors = array_reverse(get_post_ancestors( $post->ID ));
				foreach($ancestors as $ancestor){
					$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink($ancestor).'" itemprop="url" ><span itemprop="title">'. get_the_title($ancestor) .'</span></a></li>';
									}
			}
			$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $post -> post_title .'</span></li>';
		}
		/* カテゴリページ */
		elseif(is_category()) {
			$cat = get_queried_object();
			if($cat -> parent != 0){
				$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
				foreach($ancestors as $ancestor){
					$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($ancestor) .'" itemprop="url" ><span itemprop="title">'. get_cat_name($ancestor) .'</span></a></li>';
				}
			}
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $cat -> name . '</span></li>';
		}
		/* タグページ */
		elseif(is_tag()){
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. single_tag_title( '' , false ). '</span></li>';
		}
		/* 時系列アーカイブページ */
		elseif(is_date()){
			if(get_query_var('day') != 0){
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_year_link(get_query_var('year')). '" itemprop="url" ><span itemprop="title">' . get_query_var('year'). '年</span></a></li>';
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_month_link(get_query_var('year'), get_query_var('monthnum')). '" itemprop="url" ><span itemprop="title">'. get_query_var('monthnum') .'月</span></a></li>';
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('day'). '</span>日</li>';
			} elseif(get_query_var('monthnum') != 0){
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_year_link(get_query_var('year')) .'" itemprop="url" ><span itemprop="title">'. get_query_var('year') .'年</span></a></li>';
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('monthnum'). '</span>月</li>';
			} else {
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('year') .'年</span></li>';
			}
		}
		/* 投稿者ページ */
		elseif(is_author()){
			$str .='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">投稿者 : '. get_the_author_meta('display_name', get_query_var('author')).'</span></li>';
		}
		/* 添付ファイルページ */
		elseif(is_attachment()){
			if($post -> post_parent != 0 ){
				$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink($post -> post_parent).'" itemprop="url" ><span itemprop="title">'. get_the_title($post -> post_parent) .'</span></a></li>';
			}
			$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">' . $post -> post_title . '</span></li>';
		}

		/* 検索結果ページ */
		elseif(is_search()){
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">「'. get_search_query() .'」で検索した結果</span></li>';
		}
		/* 404 Not Found ページ */
		elseif(is_404()){
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">お探しの記事は見つかりませんでした。</span></li>';
		}
		/* その他のページ */
		else{
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. wp_title('', false) .'</span></li>';
		}
		$str.='</ul>';
		$str.='</div>';
	}
	echo $str;
}

?>