<?php

// クイック編集に項目を追加
function custom_quick_edit( $column_name, $post_type ) {
  // クイック編集項目と$column_nameと同じではないため一致しているないため1度だけ出力させる
  static $print_nonce = true;
  if ( $print_nonce ) {
    $print_nonce = false;

    if ( in_array( $post_type, array( 'post' ) ) ) {
		wp_nonce_field( 'quick_edit_action', $post_type . '_edit_nonce' ); //CSRF対策
?>
<fieldset class="inline-edit-col-left" style="clear:both;">
  <div class="inline-edit-col column-<?php echo $column_name; ?>">
    <div class="inline-edit-group">
      <label class="inline-edit_post_state">
        <span class="title">title</span>
		  <span class="input-text-wrap"><label><input type="checkbox" name="cf01_01" value="1" /></label></span>
      </label>
    </div>
  </div>
</fieldset>
<?php
    }
  }
}
add_action( 'quick_edit_custom_box', 'custom_quick_edit', 10, 2 );

// クイック編集用js
function custom_quick_edit_js() {
?>
<script type="text/javascript">
jQuery(document).ready(function($){
  var $wp_inline_edit = inlineEditPost.edit;
  inlineEditPost.edit = function(id) {
    $wp_inline_edit.apply(this, arguments);
    var $post_id = 0;
    if (typeof(id) == 'object') {
      $post_id = parseInt(this.getId(id));
    }
    if ($post_id > 0) {
      var $edit_row = $('#edit-' + $post_id);
      var $post_row = $('#post-' + $post_id);
      $post_row.find('.custom_quick_edit_values > div > div').each(function(){
        var key = $(this).attr('class'); //div.custom_quick_edit_values に追加されたタグのクラス。(name)	  
        var value = $(this).text(); // value
		  
		var $input = $edit_row.find('[name="' + key + '"]');
		if ($input.is('textarea')) {
		  $input.html(value);
		} else if ($input.attr('type') == 'checkbox') {
		  if (value) {
			$input.attr('checked', 'checked');
		  } else {
			$input.removeAttr('checked');
		  }
		} else {
		  $input.val(value);
		}
      });
    }
  };

<?php /* 行アクションの最後に不要な「 | 」が表示されるため削除 */  ?>
  var prev_pipe_delete =  function () {
    $('.row-actions .custom_quick_edit_values:not(.prev_pipe_deleted)').each(function(){
      var $prev = $(this).prev();
      $prev.html($prev.html().replace(/ \| $/, ''));
      $(this).addClass('prev_pipe_deleted');
    });
  };
  $('.wp-list-table').on('click', 'a.editinline', function(){
    setInterval(prev_pipe_delete, 5000);
  });
  prev_pipe_delete();
});
</script>
<style>
 .widefat th.column-post_id, .widefat td.column-post_id { padding-left:0; padding-right:0; width:2.75em; }
th.sortable.column-post_id a, th.sorted.column-post_id a { padding-left:0; padding-right:0; }
</style>
<?php
}
add_action( 'admin_footer-edit.php', 'custom_quick_edit_js' );

// クイック編集用でフォームに差し込む値
// get_inline_dataにはフィルターがないためpost_row_actionsで処理
function custom_quick_edit_values( $actions, $post ) {
	$meta_keys = array();

	// seo
    if ( in_array( $post->post_type, array( 'post' ) ) ) {
		$meta_keys = array_merge( $meta_keys, array( 'cf01_01', ) );
	}

	if ( $meta_keys ) {
		$output = '';
		foreach( $meta_keys as $meta_key ) {
			$output .= '<div class="'.esc_attr( $meta_key ).'">'.esc_html( get_post_meta( $post->ID, $meta_key, true ) ).'</div>';
		}
		if ( $output ) {
			$actions['custom_quick_edit_values'] = '<div class="hidden">'.$output.'</div>';
		}
	}

	return $actions;
}
add_action( 'post_row_actions', 'custom_quick_edit_values', 99, 2 );

// クイック編集用で設定を保存する関数
function save_custom_meta( $post_id ) { 
    $slug = 'post'; //カスタムフィールドの保存処理をしたい投稿タイプを指定
    if ( $slug !== get_post_type( $post_id ) ) { // 投稿タイプがpostでなければ、return
        return;
    }
    if ( !current_user_can( 'edit_post', $post_id ) ) { // 権限がなければ、return
        return;
    }
    $_POST += array("{$slug}_edit_nonce" => '');
    if ( !wp_verify_nonce( $_POST["{$slug}_edit_nonce"], 'quick_edit_action' ) ) { // CSRF対策
        return;
    }
	// 条件がそろえば保存する
    // カスタムフィールドの数によって以下３行を複製
    update_post_meta( $post_id, 'cf01_01', $_REQUEST['cf01_01'] );
	
}
add_action( 'save_post', 'save_custom_meta' );




// 記事一覧に追加カラムが無い場合quick_edit_custom_boxアクションが動作しないためIDカラムを追加
// function custom_quick_edit_manage_columns( $columns ) {
// 	// デフォルト以外のカラムがあれば終了
// 	$core_columns = array( 'cb' => true, 'date' => true, 'title' => true, 'categories' => true, 'tags' => true, 'comments' => true, 'author' => true );
// 	foreach ( $columns as $column_name => $column_display_name ) {
// 		if ( ! isset( $core_columns[$column_name] ) ) {
// 			return $columns;
// 		}
// 	}

// 	$new_columns = array();

// 	foreach ( $columns as $column_name => $column_display_name ) {
// 		// チェックボックスが無い場合タイトルの前にID追加
// 		if ( ! isset( $columns['cb'] ) && isset( $columns['title'] ) && $column_name == 'title') {
// 			$new_columns['post_id'] = 'ID';
// 		}

// 		$new_columns[$column_name] = $column_display_name;

// 		// チェックボックスの後ろにID追加
// 		if ( isset( $columns['cb'] ) && $column_name == 'cb' ) {
// 			$new_columns['post_id'] = 'ID';
// 		}
// 	}

// 	// IDが追加されていなければ追加
// 	if ( ! isset( $columns['post_id'] ) ) {
// 		$new_columns['post_id'] = 'ID';
// 	}

// 	return $new_columns;
// }
// function custom_quick_edit_manage_custom_column( $column_name, $post_id ) {
// 	if ( $column_name == 'post_id' ) {
// 		echo $post_id;
// 	}
// }
// add_filter( 'manage_posts_columns', 'custom_quick_edit_manage_columns', 100);
// add_filter( 'manage_pages_columns', 'custom_quick_edit_manage_columns', 100);
// add_action( 'manage_posts_custom_column', 'custom_quick_edit_manage_custom_column', 10, 2 );
// add_action( 'manage_pages_custom_column', 'custom_quick_edit_manage_custom_column', 10, 2 );

// function custom_quick_edit_sortable_columns( $sortable_columns ) {
// 	$sortable_columns['post_id'] = 'ID';
// 	return $sortable_columns;
// }
// add_filter( 'manage_edit-post_sortable_columns', 'custom_quick_edit_sortable_columns' );
// add_filter( 'manage_edit-page_sortable_columns', 'custom_quick_edit_sortable_columns' );

?>