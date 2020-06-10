<?php
class My_Widget01 extends WP_Widget{
    /**
     * Widgetを登録する
     */
    function __construct() {
        parent::__construct(
            'my_widget01', // Base ID
            'my_widget01', // Name
            array( 'description' => 'my_widget01', ) // Args
        );
    }

    /**
     * 表側の Widget を出力する
     *
     * @param array $args      'register_sidebar'で設定した「before_title, after_title, before_widget, after_widget」が入る
     * @param array $instance  Widgetの設定項目
     */
    public function widget( $args, $instance ) {

       echo <<< EOS
	   <div></div>
EOS;

    }

    /** Widget管理画面を出力する
     *
     * @param array $instance 設定項目
     * @return string|void
     */
    public function form( $instance ){

        echo <<< EOS
        <p>
        </p>
EOS;
    }

    /** 新しい設定データが適切なデータかどうかをチェックする。
     * 必ず$instanceを返す。さもなければ設定データは保存（更新）されない。
     *
     * @param array $new_instance  form()から入力された新しい設定データ
     * @param array $old_instance  前回の設定データ
     * @return array               保存（更新）する設定データ。falseを返すと更新しない。
     */
    function update($new_instance, $old_instance) {
        $instance = array();

		return $instance;
    }
}

add_action( 'widgets_init', function () {
    register_widget( 'My_Widget01' );  //WidgetをWordPressに登録する
} );

?>