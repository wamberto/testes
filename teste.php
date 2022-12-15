<?php
/* Template Name: Programas-e-Projetos */

/**
 * @package WordPress
 * @subpackage PMJP 2019 - 24-07
 * @author Betoferreira
 */

$link_projeto = get_field('link_do_projeto');
if ($link_projeto && $link_projeto['target'] == "_redirect") {
    wp_redirect($link_projeto['link']);
}
get_header();
?>
<?php
global $post;
$url = get_permalink($post->ID);
if ($post->post_parent && $post->post_parent != 248042) {
    $post_name = get_slug_by_id($post->post_parent);
    $idpost = $post->post_parent;
} else {
    if ($wp_query) {
        $post_obj = $wp_query->get_queried_object();
        $post_ID = $post_obj->ID;
        $idpost = $post_ID;
        $post_title = $post_obj->post_title;
        $post_name = $post_obj->post_name;
    }
}

//      var_dump($post_name);
//$menu = wp_get_nav_menu_items($post_name);
//
//if ($menu == false) {
//    $post_name = 'Acesso rápido';
//}
//if (isset($post_title) && $post_title == '') {
//    $post_title = get_the_title($post->post_parent);
//}
?>
<style>
    .parallax {
        /*  background-image: url('<?php //echo $thumbnail[0];  
                                    ?>');*/
        position: relative;
        /* Set a specific height */
        height: 250px;
        /* Create the parallax scrolling effect */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: scroll;
        z-index: -2;
    }

    .parallax .overlay {
        background: rgb(0, 0, 0);
        background: linear-gradient(0deg, rgba(0, 0, 0, 1) 38%, rgba(255, 255, 255, 0) 100%);
        bottom: 0;
        left: 0;
        opacity: 0.5;
        position: absolute;
        right: 0;
        top: 0;
        z-index: -1;
    }

    .scroll-menu {
        max-height: 200px;
    }
</style>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php $style = ''; ?>
        <?php if (get_field('parallax') === 'nao') { ?>
            <?php $style = 'style="margin-top: -40px"'; ?>
            <section class="parallax" style="background: <?php echo get_field('cor_do_parallax'); ?>;">
                <div class="container text-center pt-4">
                    <?php $img = get_field('imagem_do_parallax'); ?>
                    <?php if ($img != null) { ?>
                        <img src="<?php echo $img['url']; ?>" class="img-fluid" width="720" />
                    <?php } ?>
                </div>
            </section>
        <?php } else if (get_field('parallax') == 'sim') {   ?>
            <?php $img = get_field('imagem_do_parallax'); ?>
            <?php if ($img != null) { ?>
                <section class="parallax" style="background-image: url('<?php echo $img['url']; ?>');">
                    <div class="overlay"></div>
                </section>
            <?php } ?>
        <?php } ?>
        <div class="container bg-white" <?php echo $style; ?>>
            <div class="row justify-content-between mb-5">
                <?php if (get_field('exibir-titulo')) { ?>
                    <?php foreach (get_field('exibir-titulo') as $k => $v) { ?>
                        <?php if (get_field('exibir-titulo')[$k] == 'post') { ?>
                            <div class="col-12 my-3 text-center">
                                <h1 class="text-secondary mb-0"><?php the_title(); ?></h1>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>

                <div class="col-md-3 d-none d-md-block">
                    <div class="custom-scrollbar-css">
                        <?php
                        wp_nav_menu(array(
                            'menu' => $post_name,
                            'theme_location' => 'navpage',
                            'depth'             => 0,
                            'container'         => '',
                            'container_class'   => '',
                            'container_id'      => 'bs-example-navbar-collapse-1',
                            'menu_class'        => 'nav flex-column',

                        ));
                        ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="post mt-5">
                        <div class="my-5">
                            <?php if (get_the_title() == 'Notícias') { ?>
                                <?php

                                $args = array();
                                $args['cat'] = '5162';
                                $args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;
                                $args['orderby'] = 'date';
                                $args['order'] = 'DESC';
                                $args['posts_per_page'] = 5;
                                $feed = new WP_Query($args);
                               ?>
                                <?php //$feed = new WP_Query(array('category' => 5162, 'showposts' => '10')); 
                                ?>
                                <div class="d-none d-sm-block">
                                    <?php if ($feed->have_posts()) : ?>
                                        <?php while ($feed->have_posts()) : $feed->the_post();  ?>
                                            <div class="card mb-3" style="border: none">
                                                <div class="row no-gutters">
                                                    <div class="col-12 col-lg-3 col-md-4 d-none d-md-block">
                                                        <?php the_post_thumbnail('thumb-list', array('class' => 'card-img img-fluid rounded')); ?>
                                                    </div>
                                                    <div class="col-12 col-lg-9 col-md-8">
                                                        <div class="card-body pt-0 text-secondary">
                                                            <h5 class="text-primary"><?php echo $antetitulo =  get_field('noticia-antetitulo')->name ? get_field('noticia-antetitulo')->name : get_post_meta(get_the_ID(), 'noticia-antetitulo', true); ?></h5>
                                                            <h6><a href="<?php the_permalink() ?>" class="text-secondary"><?php the_title(); ?></a></h6>
                                                            <p class="card-text">
                                                                <small class="text-muted"><i class="fa fa-calendar"></i> <?php the_time('d/m/Y'); ?> |
                                                                    <i class="fa fa-clock-o"></i> <?php the_time('H:i'); ?> |
                                                                    <i class="fa fa-eye" aria-hidden="true"></i> <?php echo chr_setPostViews(get_the_ID()); ?>
                                                                </small>
                                                            </p>
                                                            <ul class="list-group list-group-flush m-0 p-0">
                                                                <li class="list-group-item border-top m-0 pl-0 pt-2">
                                                                    <?php $args = array(
                                                                        'permalink' => get_the_permalink(),
                                                                        'title' => get_the_title(),
                                                                        'size' => '36px',
                                                                        'social_media' => array('whatsapp', 'twitter', 'facebook', 'gmail')
                                                                    ); ?>
                                                                    <?php //add_buttons($args); 
                                                                    ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile ?>
                                        <?php wp_reset_postdata(); ?>
                                        <?php echo wpse64458_pagination(); ?>
                                    <?php else : ?>
                                        <p>Nenhum post encontrado</p>
                                    <?php endif; ?>
                                </div>
                                <?php
                                /*
                                $args = array(
                                    'numberposts'    => -1,
                                    'category'        => 5162
                                );
                                $my_posts = get_posts($args);

                                if (!empty($my_posts)) {
                                    $output = '<ul>';
                                    foreach ($my_posts as $p) {
                                        $output .= '<li><a href="' . get_permalink($p->ID) . '">'
                                            . $p->post_title . '</a></li>';
                                    }
                                    $output .= '<ul>';
                                }
                                //echo $output;
*/
                                ?>
                            <?php } else { ?>
                                <?php the_content(); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php edit_post_link('editar este post', '<hr><p class="text-right">', '</p>'); ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php else : ?>
    <div class="jumbotron jumbotron-fluid p-3">
        <div class="container text-center">
            <h1 class="display-1">:(</h1>
            <h4 class="text-secondary">Nenhum registro encotrado</h4>
        </div>
    </div>
<?php endif; ?>

<div class="d-block d-sm-block d-md-none">
    <nav class="navbar fixed-bottom navbar-expand-lg navbar-light bg-light mb-0">
        <a class="navbar-brand" href="#">Menu página</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <div class="custom-scrollbar-css">
                <?php
                wp_nav_menu(array(
                    'menu' => $post_name,
                    'theme_location' => 'navpage',
                    'depth'             => 1,
                    'container'         => '',
                    'container_class'   => '',
                    'container_id'      => 'bs-example-navbar-collapse-1',
                    'menu_class'        => 'nav flex-column',
                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                    'walker'            => new WP_Bootstrap_Navwalker(),
                ));
                ?>
            </div>
        </div>
    </nav>
</div>

</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>