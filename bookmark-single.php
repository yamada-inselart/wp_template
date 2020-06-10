	<ul class="article_sns sns_lists">
		<li class="twitter">
			<a href="http://twitter.com/share?url=<?php echo get_the_permalink(); ?>&text=<?php echo get_the_title(); ?>">
				<i class="fa fa-twitter"></i><span class="sns_txt">Tweet</span>
			</a>
		</li>
		<li class="facebook">
			<a href="http://www.facebook.com/share.php?u=<?php echo get_the_permalink(); ?>" onclick="window.open(this.href, 'window', 'width=550, height=450,personalbar=0,toolbar=0,scrollbars=1,resizable=1'); return false;">
				<i class="fa fa-facebook"></i><span class="sns_txt">Share</span>
			</a>
		</li>
		<li class="hatebu">
			<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo get_the_permalink(); ?>&title=<?php echo get_the_title(); ?>">
				<i class="fa fa-hatebu"></i><span class="sns_txt">Hatena</span>
			</a>
		</li>
		<li class="gplus">
			<a href="https://plus.google.com/share?url=<?php echo get_the_permalink(); ?>" onclick="window.open(this.href, 'Gwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;">
				<i class="fa fa-google-plus"></i><span class="sns_txt">+1</span>
			</a>
		</li>
		<li class="pocket">
			<a href="http://getpocket.com/edit?url=<?php echo get_the_permalink(); ?>&title=<?php echo get_the_title(); ?>" onclick="window.open(this.href, 'FBwindow', 'width=550, height=350, menubar=no, toolbar=no, scrollbars=yes'); return false;">
				<i class="fa fa-get-pocket"></i><span class="sns_txt">Pocket</span>
			</a>
		</li>
	</ul>