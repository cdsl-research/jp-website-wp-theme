<?php get_header(); ?>

<div class="content-area">
<article class="post-24 page type-page status-publish hentry">

    <?php 
		$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); 
		$en_name = $curauth->first_name_en.' '.$curauth->last_name_en;
		$ja_name = $curauth->last_name.' '.$curauth->first_name;
		if (strlen($en_name) == 1){
			$header_name = $ja_name;
		}else{
			$header_name = $en_name;
		}
    ?>

    <header class="entry-header">
        <h1 class="entry-title"><?php echo $header_name; ?></h1>
    </header>

    <div class="entry-content">
        <section class="profile">
            <div class="item">
                <span>名前</span>
                <?php echo $ja_name; ?>
            </div>
            <div class="item">
                <span>好きなもの</span>
                <?php echo $curauth->favorite; ?>
            </div>
            <div class="item">
                <span>研究テーマ</span>
                <?php echo $curauth->research_area; ?>
            </div>
            <div class="item">
                <span>Web サイト</span>
                <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a>
            </div>
            <div class="item">
                <span>一言</span>
                <?php echo $curauth->freetext; ?>
            </div>
            <div class="item">
                <span>外部サービス</span>
	        <?php if(strlen($curauth->qiita) > 0): ?>
	            <a href="https://qiita.com/<?php echo $curauth->qiita ?>" class="social-link" target="_blank">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/logo-qiita.png" width="100" alt="qiita">
                    </a>
                <?php endif; ?>

	        <?php if(strlen($curauth->github) > 0): ?>
	            <a href="https://github.com/<?php echo $curauth->github ?>" class="social-link" target="_blank">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/logo-github.png" width="100" alt="github">
                    </a>
                <?php endif; ?>
            </div>
        </section>

        <?php if(strlen($curauth->description) > 0): ?>
            <h2>実績&amp;PR:</h2>
            <?php echo $curauth->description; ?>
        <?php endif; ?>

        <h2>記事:</h2>
    
        <ul>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <li>
                <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
                <?php the_title(); ?></a>,
                <?php the_time('Y年n月j日'); ?> (カテゴリー: <?php the_category('&');?>)
            </li>
        <?php endwhile; else: ?>
            <p><?php _e('投稿はありません。'); ?></p>
        <?php endif; ?>
        </ul>

    </div>

</article>
</div>

<style>
section.profile {
    display: flex;
    flex-wrap: wrap;
}
section.profile div.item {
    width: 50%;
    min-width: 270px;
    display: inline-block;
    line-height: 2.0;
    padding: 0 20px 30px 0;
}
section.profile div.item > span {
    display: block;
    font-weight: bold;
    border-bottom: solid 2px #333;
    margin: 0 0 10px;
}
section.social {
    margin: 10px 0 30px;
}
a.social-link {
    display: inline-block;
}
</style>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
