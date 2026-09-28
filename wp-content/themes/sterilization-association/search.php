<?php get_header(); ?>

<main class="search-results-page">
    <div class="container">
        
        <header class="page-header">
            <h1 class="page-title">
                Результати пошуку для: <span>«<?php echo get_search_query(); ?>»</span>
            </h1>
        </header>

        <div class="news-grid">
            <?php if (have_posts()) : ?>
                
                <?php while (have_posts()) : the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="news-card">
                        <div class="news-card-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large'); ?>
                            <?php else : ?>
                                <div style="color: white; font-weight: bold; font-size: 24px; text-align: center; line-height: 1.2;">
                                    ВАСД
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="news-card-content">
                            <time class="news-card-date"><?php echo get_the_date('d/m/Y'); ?></time>
                            <h3 class="news-card-title"><?php the_title(); ?></h3>
                        </div>
                    </a>
                <?php endwhile; ?>

                <div class="pagination">
                    <?php the_posts_pagination(); ?>
                </div>

            <?php else : ?>
                <div class="no-results">
                    <p>На жаль, за вашим запитом нічого не знайдено. Спробуйте використати інші ключові слова.</p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php get_footer(); ?>