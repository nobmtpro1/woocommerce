<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor header Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_header_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'header';
    }
    public function get_title()
    {
        return esc_html__('header', 'elementor-header-widget');
    }
    public function get_keywords()
    {
        return ['header'];
    }

    public function wp_get_menu_array($current_menu = 'Menu 1')
    {
        // dd($current_menu . get_locale());
        $term = get_term_by('name', $current_menu, 'nav_menu');
        $menu_id = $term->term_id;
        $menu_array = wp_get_nav_menu_items($menu_id);
        if (!$menu_array) {
            return [];
        }
        // dd($menu_array);
        $menu = array();

        function populate_children($menu_array, $menu_item)
        {
            $children = array();
            if (!empty($menu_array)) {
                foreach ($menu_array as $k => $m) {
                    if ($m->menu_item_parent == $menu_item->ID) {
                        $children[$m->ID] = array();
                        $children[$m->ID]['ID'] = $m->ID;
                        $children[$m->ID]['title'] = $m->title;
                        $children[$m->ID]['url'] = $m->url;
                        unset($menu_array[$k]);
                        $children[$m->ID]['children'] = populate_children($menu_array, $m);
                    }
                }
            };
            return $children;
        }

        foreach ($menu_array as $m) {
            if (empty($m->menu_item_parent)) {
                $menu[$m->ID] = array();
                $menu[$m->ID]['ID'] = $m->ID;
                $menu[$m->ID]['title'] = $m->title;
                $menu[$m->ID]['url'] = $m->url;
                $menu[$m->ID]['children'] = populate_children($menu_array, $m);
            }
        }

        return $menu;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        global $woocommerce;
        // dd(($post));
?>
        <!-- Start Top Nav -->
        <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
            <div class="container text-light">
                <div class="w-100 d-flex justify-content-between">
                    <div>
                        <i class="fa fa-envelope mx-2"></i>
                        <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:info@company.com">info@company.com</a>
                        <i class="fa fa-phone mx-2"></i>
                        <a class="navbar-sm-brand text-light text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
                    </div>
                    <div>
                        <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                        <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                        <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                        <a class="text-light" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Close Top Nav -->


        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-light shadow">
            <div class="container d-flex justify-content-between align-items-center">

                <a class="navbar-brand text-success logo h1 align-self-center" href="<?php bloginfo('url') ?>">
                    Zay
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                    <div class="flex-fill" id="menu-header">
                        <?php wp_nav_menu([
                            'theme_location' => "header-main",
                            'container' => false,
                            'menu_id' => 'header-main',
                        ]) ?>
                        <script>
                            const menu = document.querySelector('#menu-header .menu')
                            console.log(menu)
                            menu?.classList?.add('nav', 'navbar-nav', 'd-flex', 'justify-content-between', 'mx-lg-auto')
                            menu?.querySelectorAll('li')?.forEach(e => {
                                e?.classList?.add('nav-item')
                                e?.addEventListener('mouseover', function(li) {
                                    submenu = e.querySelector('.sub-menu')
                                    if (submenu) {
                                        submenu.style.display = 'block'
                                    }
                                })
                                e?.addEventListener('mouseleave', function(li) {
                                    submenu = e.querySelector('.sub-menu')
                                    if (submenu) {
                                        submenu.style.display = 'none'
                                    }
                                })
                            })
                            menu?.querySelectorAll('a')?.forEach(e => {
                                e?.classList?.add('nav-link')
                            })
                            const subMenu = document.querySelectorAll('#menu-header .sub-menu')
                            subMenu?.forEach(e => {
                                e.style.display = 'none'

                            })
                        </script>
                        <style>
                            #menu-header li {
                                position: relative;
                            }

                            #menu-header .sub-menu {
                                position: absolute;
                                bottom: 0;
                                right: 0;
                                transform: translate(50%, 100%);
                                background: white;
                                z-index: 1;
                                list-style: none;

                            }
                        </style>
                        <!-- <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="shop.html">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact</a>
                        </li>
                    </ul> -->
                    </div>
                    <div class="navbar align-self-center d-flex">
                        <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">

                            <div class="input-group">
                                <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ...">
                                <div class="input-group-text">
                                    <i class="fa fa-fw fa-search"></i>
                                </div>
                            </div>
                        </div>
                        <a class="nav-icon d-none d-lg-inline" href="<?= bloginfo('url') ?>/cart" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                            <i class="fa fa-fw fa-search text-dark mr-2"></i>
                        </a>
                        <a id="cart" class="nav-icon position-relative text-decoration-none" href="<?= bloginfo('url') ?>/cart">
                            <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                            <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark cart-contents-count" id="mini-cart-count"><?= $woocommerce->cart->get_cart_contents_count() ?>
                            </span>
                            <div class="mini-cart" id="mini-cart">
                                <?php woocommerce_mini_cart(); ?>
                            </div>
                            <script>
                                var cart = document.querySelector("#cart")
                                var miniCart = document.querySelector('#mini-cart')
                                miniCart?.addEventListener('mouseover', function() {
                                    if (miniCart) {
                                        miniCart.style.display = 'flex'
                                    }
                                })
                                miniCart?.addEventListener('mouseleave', function() {
                                    if (miniCart) {
                                        miniCart.style.display = 'none'
                                    }
                                })
                                cart?.addEventListener('mouseover', function() {
                                    if (miniCart) {
                                        miniCart.style.display = 'flex'
                                    }
                                })
                                cart?.addEventListener('mouseleave', function() {
                                    if (miniCart) {
                                        miniCart.style.display = 'none'
                                    }
                                })
                            </script>
                        </a>
                        <a class="nav-icon position-relative text-decoration-none" href="<?= bloginfo('url') ?>/my-account">
                            <i class="fa fa-fw fa-user text-dark mr-3"></i>
                            <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"></span>
                        </a>
                    </div>
                </div>

            </div>
        </nav>
        <!-- Close Header -->

        <!-- Modal -->
        <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="w-100 pt-1 mb-5 text-right">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="get" class="modal-content modal-body border-0 p-0">
                    <div class="input-group mb-2">
                        <input type="hidden" name="post_type" value="product">
                        <input type="text" class="form-control" id="inputModalSearch" name="s" placeholder="Search ...">
                        <button type="submit" class="input-group-text bg-success text-light">
                            <i class="fa fa-fw fa-search text-white"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
