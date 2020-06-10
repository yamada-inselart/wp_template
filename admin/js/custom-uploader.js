(function ($) {

    var custom_uploader;

    $(document).on('click', 'input.media-btn', function(e) {

        var option_id = $(this).data('id');
		var target = $('#' + option_id);
			
        e.preventDefault();

        //if (custom_uploader) {

        //    custom_uploader.open();
        //    return;

        //}

        custom_uploader = wp.media({

            title: "Choose Image",

            /* ライブラリの一覧は画像のみにする */
            library: {
                type: "image"
            },

            button: {
                text: "Choose Image"
            },

            /* 選択できる画像は 1 つだけにする */
            multiple: false

        });

         custom_uploader.on("select", function() {

            var images = custom_uploader.state().get("selection");
			
            /* file の中に選択された画像の各種情報が入っている */
            images.each(function(file){
                /* テキストフォームと表示されたサムネイル画像があればクリア */
                $("input.media-url", target).val("");
                $(".media-img", target).empty();
							
                /* テキストフォームに画像の ID を表示 */
                $("input.media-url", target).val(file.attributes.sizes.full.url);

                /* プレビュー用に選択されたサムネイル画像を表示 */
                $(".media-img", target).append('<img src="'+file.attributes.sizes.full.url+'" />');
            });
        });

        custom_uploader.open();

    });

    /* クリアボタンを押した時の処理 */
    $(document).on('click', 'input.media-clear', function() {

        var option_id = $(this).data('id');
		var target = $('#' + option_id);

        $("input.media-url", target).val("");
        $(".media-img", target).empty();

    });

})(jQuery);