<?php get_header();?>
<?php if (have_posts()): while (have_posts()): the_post(); ?>
<main class="layout singleTrip">
    <h2 class="singleTrip__title"> <?= get_the_title(); ?></h2>
    <figure class="singleTrip__fig">
        <?= get_the_post_thumbnail(null, 'medium_large', ['class' => 'post__thumb', 'id' => 'test']); ?>
    </figure>
    <div class="singleTrip__content">
        <?php the_content();?>
    </div>
    <aside class="singleTrip__details">
        <h3 class="singleTrip__subtitle"></h3>
        <dl class="singleTrip__definition">
            <dt class="singleTrip__label"></dt>
            <dd class="singleTrip__data"><time class="singleTrip__time" datetime="<?= date('C', strtotime(get_field('departure_date', false, false))) ;?>">
                    <?= ucfirst(date_i18n('d ,F, Y', strtotime(get_field('departure_date', false, false)))) ;?>
                </time></dd>
            <dt class="singleTrip__label"></dt>
            <dd class="singleTrip__data">
                <?php if (get_field('return_date')):?>
                    <time class="singleTrip__time" datetime="<?= date('C', strtotime(get_field('return_date', false, false))) ;?>">
                        <?= ucfirst(date_i18n('d ,F, Y', strtotime(get_field('return_date', false, false)))) ;?>
                    </time>
                <?php else:?>
                <span class="singleTrip__empty"> Aucune date de retour</span>
                <?php endif; ?>
            </dd>
        </dl>
    </aside>
</main>
<?php endwhile; endif;?>
<?php get_footer();?>